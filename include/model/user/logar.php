<?php
require_once __DIR__ . '/../../database/Persistencia.php';

class Logar {

    private $conn;

    public function __construct() {
        $this->conn = new Conexao(); 
    }

    public function autenticar($email, $senha) {
        $email = $this->conn->conectar()->quote($email);

        $sql_pessoa = "SELECT id_pessoa, email, nome FROM pessoa WHERE email = $email";
        $stmt_pessoa = $this->conn->conectar()->prepare($sql_pessoa);

        $sql_usuario = "SELECT id_pessoa, senha FROM user_app WHERE id_pessoa = :id_pessoa";
        $stmt_usuario = $this->conn->conectar()->prepare($sql_usuario);
        

        try {
            $stmt_pessoa->execute();
            $pessoa = $stmt_pessoa->fetch(PDO::FETCH_ASSOC);

            if ($pessoa) {
                $stmt_usuario->bindParam(':id_pessoa', $pessoa['id_pessoa']);
                $stmt_usuario->execute();
                $usuario = $stmt_usuario->fetch(PDO::FETCH_ASSOC);

                if ($usuario && password_verify($senha, $usuario['senha'])) {
                    return $pessoa; 
                }
            }

            return false; 
        } catch (PDOException $e) {
            die("Falha no SQL: " . $e->getMessage());
        }
    }
}
?>
