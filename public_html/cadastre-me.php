<?php
include('../include/database/conexao.php');

if (isset($_POST['email']) && isset($_POST['senha'])) {
    $email = $mysqli->real_escape_string($_POST['email']);
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

    $sql_insert_pessoa = "INSERT INTO `pessoa`(`email`) VALUES ('$email')";
    $mysqli->query($sql_insert_pessoa) or die("Falha no SQL (pessoa): " . $mysqli->error);

    $pessoa_id = $mysqli->insert_id;

    $sql_insert_user = "INSERT INTO `user_app`(`id_pessoa`, `id_pessoa_inc`, `senha`)
                        VALUES ('$pessoa_id', '$pessoa_id', '$senha')";
    $mysqli->query($sql_insert_user) or die("Falha no SQL (user): " . $mysqli->error);

    echo "Usuário cadastrado com sucesso!";
}

?>

<!-- Formulário HTML para cadastro -->
<!doctype html>
<html lang="en">
<!-- ... (cabeçalho e estilos) ... -->

<body>
    <div class="container">
        <div class="row gx-5 justify-content-center">
            <div class="col-lg-6 col-xl-6 col-xxl-6 col-12">
                <div class="card">
                    <div class="card-body">
                        <form method="POST">
                            <div class="form-group">
                                <input class="form-control form-control-lg" name="email" id="email" type="text"
                                    placeholder="E-mail" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <input class="form-control form-control-lg" name="senha" id="senha" type="password"
                                    placeholder="Senha">
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg btn-block"
                                type="submit">Cadastrar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ... (scripts e rodapé) ... -->
</body>

</html>