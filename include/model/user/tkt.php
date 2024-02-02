<?php
// Inicie a sessão no início do arquivo
session_start();

class Token {
    private $segredo = 'plataformaBit';

    public function gerarToken($idUser, $senha) {
        $dadosParaHash = $idUser . $senha;
        $token = hash_hmac('sha256', $dadosParaHash, $this->segredo);
        return $token;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json = file_get_contents('php://input');
    $dados = json_decode($json, true);

    if (isset($dados['id']) && isset($dados['email'])) {
        $token = new Token();
        $responsetoken = $token->gerarToken($dados['id'], $dados['email']);
        
        echo json_encode(['success' => true, 'token' => $responsetoken]);
    } else {
        echo json_encode(['error' => 'Parâmetros inválidos']);
    }
} else {
    echo json_encode(['error' => 'Método não permitido']);
}
?>
