<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WideConnections - Esqueci Minha Senha</title>
    <?php 

    include_once('inc/css.php');
    include_once('class/Conexao.php');
    include_once('class/Helper.php');
    include_once('class/Usuario.php');
    include_once('class/Escola.php');
    include_once('class/Estado.php');
    include_once('class/Cidade.php');

    $Usuario = new Usuario();

    //enviar email de recuperação de senha
    if (isset($_POST['btnEnviar'])) {
        $Usuario->recuperacaodesenha($_POST['email']);
    }

?>
</head>
<body class="bg-login">
<style>
    body{
        font-family: Arial, Helvetica, sans-serif;
    }
</style>
    
<div class="clr">
        <br>
    </div>

    <div class="hd">
        <br><br><br>
    </div>

    <div class="fullhd">
        <br><br><br>
    </div>

    <div class="col-md-4 offset-md-4">
        <!-- CARD -->
        <div class="card p-4">
            <br>
            <?php
            if(isset($_GET['s'])){
                echo '<div class="text-center"><span class="alert alert-success">Email Enviado!</span></div>';
            }
            ?>
            <?php
            if(isset($_GET['fe'])){
                echo '<div class="text-center"><span class="alert alert-danger">Erro ao enviar Email!</span></div>';
            }
            ?>
            <?php
            if(isset($_GET['f'])){
                echo '<div class="text-center"><span class="alert alert-danger">Email não encontrado!</span></div>';
            }
            ?>
            <form method="post" action="?">
                <br><br>
                <div class="text-center">
                    <h3>Recuperar Senha</h3>
                </div>
                <br>
                <div class="mb-3 text-center logo">
                    <img src="img/wideconnections.png" alt="">
                </div>
                <div class="col-md-10 offset-md-1 mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email">
                </div>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6 offset-md-1 mb-3"></div>
                        <div class="col-md-4 text-end">
                            <input class="btn btn-primary col-md-11 mt-2" type="submit" value="EnviarEmail" name="btnEnviar" id="btnEnviar">
                        </div>
                    </div>
                </div>
                <div class="offset-md-1 col-md-10">
                    <hr>
                </div>
                <div class="text-center">
                    Não precisar recuperar sua senha?&nbsp;&nbsp;&nbsp;
                    <a href="login.php" class="btn btn-dark">Logar-se</a>
                </div>
            </form>
            <br>
        </div>
        <!-- /CARD -->
    </div>


</body>