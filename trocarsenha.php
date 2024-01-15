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
    session_start();
    Helper::logadotrocar();

    //enviar email de recuperação de senha
    if (isset($_POST['btnTrocar'])) {
        $Usuario->trocarsenha($_SESSION['token'],$_POST['senha']);
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
            <div id="alert" class="alert alert-danger d-none"></div>
            <br>
            <?php
            if(isset($_GET['f'])){
                echo '<div class="text-center"><span class="alert alert-danger">ERRO!</span></div>';
            }
            ?>
            <form method="post" action="?">
                <br><br>
                <div class="text-center">
                    <h3>Trocar Senha</h3>
                </div>
                <br>
                <div class="mb-3 text-center logo">
                    <img src="img/wideconnections.png" alt="">
                </div>
                <div class="col-md-10 offset-md-1 mb-3">
                    <label for="senha" class="form-label">Nova Senha</label>
                    <input type="password" class="form-control" id="senha" name="senha">
                </div>
                <div class="col-md-10 offset-md-1 mb-3">
                    <label for="confirmasenha" class="form-label">Confirmar Nova Senha</label>
                    <input type="password" class="form-control" id="confirmasenha" name="confirmasenha">
                </div>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6 offset-md-1 mb-3"></div>
                        <div class="col-md-4 text-end">
                            <input class="btn btn-primary col-md-11 mt-2" type="submit" value="Trocar Senha" name="btnTrocar" id="TrocarSenha">
                        </div>
                    </div>
                </div>
            </form>
            <br>
        </div>
        <!-- /CARD -->
    </div>

    
<script>
    $('#senha').keyup(function (e) { 
        e.preventDefault();
        
        let senha = $('#senha').val();
        let confsenha = $('#confirmasenha').val();
        
        if (senha == confsenha) {
            $('#btnCadastrar').removeClass('disabled');
            $('#alert').addClass('d-none');
        }else{
            $('#btnCadastrar').addClass('disabled');
            $('#alert').removeClass('d-none');
            $('#alert').text('(!) As Senhas digitadas não coincidem, favor verifique');
        }
    });
    $('#confirmasenha').keyup(function (e) { 
        e.preventDefault();
        
        let senha = $('#senha').val();
        let confsenha = $('#confirmasenha').val();
        
        if (senha === confsenha) {
            $('#btnCadastrar').removeClass('disabled');
            $('#alert').addClass('d-none');
        }else{
            $('#btnCadastrar').addClass('disabled');
            $('#alert').removeClass('d-none');
            $('#alert').text('(!) As Senhas digitadas não coincidem, favor verifique');
        }
    });
</script>

</body>