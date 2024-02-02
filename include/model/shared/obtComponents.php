<?php
require_once '../../database/Persistencia.php';

class ObtSlide {
    function obterComp($pagina) {
        $conexao = new Conexao();
        $conn = $conexao->conectar();

        $sql = "SELECT * FROM app_component WHERE pagina = :pagina";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':pagina', $pagina, PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($result) {
            echo json_encode($result);
        } else {
            echo json_encode(array());
        }
    }
    
}

if (isset($_GET['pagina'])) {
    $pagina = $_GET['pagina'];
    
    $obtSlide = new ObtSlide();
    $obtSlide->obterComp($pagina);
} else {
    echo json_encode(array('erro' => 'Parâmetro "pagina" não fornecido'));
}
?>
