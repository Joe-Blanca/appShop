<?php
require_once '/../../database/Persistencia.php';

class Novo {

    public function gerarSF($idPedido, $idPdv, $idPessoa, $idPessoaPedido, $idPessoaPDV, $idPessoaSF, $idCategoria, $descricao, $tipo, $valor) {
        $conn = new Conexao(); 

        $sql = "INSERT INTO `sf`(
                                `ID_PEDIDO`,
                                `ID_PDV`,
                                `ID_PESSOA_INC`,
                                `ID_PESSOA_PEDIDO`,
                                `ID_PESSOA_PDV`,
                                `ID_PESSOA_SF`,
                                `ID_CATEGORIA_SF`,
                                `DT_INC`,
                                `DESCRICAO`,
                                `TIPO`,
                                `VALOR`
                            )
            VALUES (:idPedido, :idPdv, :idPessoa, :idPessoaPedido, :idPessoaPDV, :idPessoaSF, :idCategoria, NOW(), :descricao, :tipo, :valor)";

        $stmt = $conn->conectar()->prepare($sql);

        $stmt->bindParam(':idPedido', $idPedido, PDO::PARAM_INT);
        $stmt->bindParam(':idPdv', $idPdv, PDO::PARAM_INT);
        $stmt->bindParam(':idPessoa', $idPessoa, PDO::PARAM_INT);
        $stmt->bindParam(':idPessoaPedido', $idPessoaPedido, PDO::PARAM_INT);
        $stmt->bindParam(':idPessoaPDV', $idPessoaPDV, PDO::PARAM_INT);
        $stmt->bindParam(':idPessoaSF', $idPessoaSF, PDO::PARAM_INT);
        $stmt->bindParam(':idCategoria', $idCategoria, PDO::PARAM_INT);
        $stmt->bindParam(':descricao', $descricao, PDO::PARAM_STR);
        $stmt->bindParam(':tipo', $tipo, PDO::PARAM_STR);
        $stmt->bindParam(':valor', $valor, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return $conn->conectar()->lastInsertId();  // Retorna o ID_SF inserido
        } else {
            return false;
        }
    }

    public function gerarParcelas($idSF, $valor, $qtdeParcelas, $frequencia, $vencimento, $idPessoa) {
        $conn = new Conexao();
    
        $valorParcela = ($valor == 1 && ($frequencia === 0 || $frequencia === null)) ? $valor : $valor / $qtdeParcelas;
    
        // Se for à vista, insere apenas uma parcela
        if ($valorParcela == $valor) {
            $sql = "INSERT INTO `sf_parcela` (
                        `ID_SF`,
                        `VALOR`,
                        `DT_INC`,
                        `DT_ATU`,
                        `ID_PESSOA_INC`,
                        `ID_PESSOA_ATU`,
                        `DT_VENC`
                    )
                    VALUES (
                        :idSF,
                        :valor,
                        NOW(),
                        NOW(),
                        :idPessoa,
                        :idPessoa,
                        :vencimento
                    )";
    
            $stmt = $conn->conectar()->prepare($sql);
            $stmt->bindParam(':idSF', $idSF, PDO::PARAM_INT);
            $stmt->bindParam(':valor', $valorParcela, PDO::PARAM_STR);
            $stmt->bindParam(':idPessoa', $idPessoa, PDO::PARAM_INT);
            $stmt->bindParam(':vencimento', $vencimento, PDO::PARAM_STR);
    
            if (!$stmt->execute()) {
                echo 'Erro: Falha ao inserir transação à vista';
                return false;
            }
        } else {
            $interval = $this->calcularIntervalo($frequencia);
    
            for ($i = 0; $i < $qtdeParcelas; $i++) {
                $dtVencimento = date('Y-m-d', strtotime("+$i $interval", strtotime($vencimento)));
    
                $sql = "INSERT INTO `sf_parcela` (
                            `ID_SF`,
                            `VALOR`,
                            `DT_INC`,
                            `DT_ATU`,
                            `ID_PESSOA_INC`,
                            `ID_PESSOA_ATU`,
                            `DT_VENC`
                        )
                        VALUES (
                            :idSF,
                            :valorParcela,
                            NOW(),
                            NOW(),
                            :idPessoa,
                            :idPessoa,
                            :dtVencimento
                        )";
    
                $stmt = $conn->conectar()->prepare($sql);
    
                $stmt->bindParam(':idSF', $idSF, PDO::PARAM_INT);
                $stmt->bindParam(':valorParcela', $valorParcela, PDO::PARAM_STR);
                $stmt->bindParam(':idPessoa', $idPessoa, PDO::PARAM_INT);
                $stmt->bindParam(':dtVencimento', $dtVencimento, PDO::PARAM_STR);
    
                if (!$stmt->execute()) {
                    echo 'Erro: Falha ao inserir parcela';
                    return false;
                }
            }
        }
    
        return true;
    }
    
    private function calcularIntervalo($frequencia) {
        switch ($frequencia) {
            case 1: return '1 week';       // Semanal
            case 2: return '2 weeks';      // Quinzenal
            case 3: return '1 month';      // Mensal
            case 4: return '3 months';     // Trimestral
            case 5: return '6 months';     // Semestral
            case 6: return '1 year';       // Anual
            default: return '1 month';      // Intervalo padrão mensal
        }
    }
    
}

$idPessoa = isset($_SESSION['ID_PESSOA']) ? $_SESSION['ID_PESSOA'] : null;
$idPedido = filter_input(INPUT_POST, 'idPedido', FILTER_VALIDATE_INT);
$idPdv = filter_input(INPUT_POST, 'idPdv', FILTER_VALIDATE_INT);
$idPessoaPedido = filter_input(INPUT_POST, 'idPessoaPedido', FILTER_VALIDATE_INT);
$idPessoaPDV = filter_input(INPUT_POST, 'idPessoaPDV', FILTER_VALIDATE_INT);
$idPessoaSF = filter_input(INPUT_POST, 'idPessoaSF', FILTER_VALIDATE_INT);
$idCategoria = filter_input(INPUT_POST, 'idCategoria', FILTER_VALIDATE_INT);
$descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_STRING);
$tipo = filter_input(INPUT_POST, 'tipo', FILTER_SANITIZE_STRING);
$valor = filter_input(INPUT_POST, 'valor', FILTER_VALIDATE_FLOAT);
$qtdeParcelas = filter_input(INPUT_POST, 'qtdeParcelas', FILTER_VALIDATE_INT);
$frequencia = filter_input(INPUT_POST, 'frequencia', FILTER_SANITIZE_STRING);
$vencimento = filter_input(INPUT_POST, 'vencimento', FILTER_SANITIZE_STRING);

$novo = new Novo();

$idSF = $novo->gerarSF($idPedido, $idPdv, $idPessoa, $idPessoaPedido, $idPessoaPDV, $idPessoaSF, $idCategoria, $descricao, $tipo, $valor);

if ($idSF) {
    if ($novo->gerarParcelas($idSF, $valor, $qtdeParcelas, $frequencia, $vencimento, $idPessoa)) {
        echo 'Sucesso: SF e parcelas inseridos com êxito';
    } else {
        echo 'Erro: Falha ao inserir parcelas';
    }
} else {
    echo 'Erro: Falha ao inserir SF';
}
?>


verificar pessoa inc que não esta dando certo
verificar valor pago e inserir na sf_mov