<?php

require_once '../../database/Persistencia.php';

use PDO;

class Token {

    public function atualizaToken($token, $idPessoa) {
        $conn = new Conexao(); 

        $sql = "UPDATE
                    `user_app`
                SET
                    `token` = :token,
                    `dt_atu` = NOW()
                WHERE id_pessoa = :idPessoa";  

        $stmt = $conn->conectar()->prepare($sql);

        $stmt->bindParam(':idPessoa', $idPessoa, PDO::PARAM_INT);
        $stmt->bindParam(':token', $token, PDO::PARAM_STR);
        $stmt->execute();
    }
    
}

session_start();
if (isset($_POST['token'])) {
    $token = $_POST['token'];
    $_SESSION['token'] = $token;
    echo json_encode(['success' => true, 'message' => $_POST['token'] . ' tkt ss']);

    $idPessoa = isset($_SESSION['id_pessoa']) ? $_SESSION['id_pessoa'] : null;

    $ctoken = new Token();
    $ctoken->atualizaToken($token, $idPessoa);

} else {
    echo json_encode(['success' => false, 'message' => 'tkt nss']);
}

?>
