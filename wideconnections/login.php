<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WideConnections - Login</title>
    <?php 

    session_start();
    session_destroy();

    include_once('inc/css.php');
    include_once('class/Conexao.php');
    include_once('class/Helper.php');
    include_once('class/Usuario.php');
    include_once('class/Escola.php');
    include_once('class/Estado.php');
    include_once('class/Cidade.php');

    $Usuario = new Usuario();

    
    //verificar se o produto foi cadastrado
    if (isset($_POST['btnLogar'])) {
        $Usuario->logar($_POST['email'],$_POST['senha']);
    }
    
    ?>
</head>
<body class="bg-login">
<style>
    .forget{
        margin-bottom: 15px;
    }
    .forget a{
        text-decoration: none;
        color: black;
        font-size: 14px;
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
            if(isset($_GET['e'])){
                echo '<div class="text-center"><span class="alert alert-danger">Email ou Senha ínvalido!</span></div>';
            }
            ?>
            <?php
            if(isset($_GET['f'])){
                echo '<div class="text-center"><span class="alert alert-danger">Falha ao encontrar Usuario!</span></div>';
            }
            ?>
            <?php
            if(isset($_GET['a'])){
                echo '<div class="text-center"><span class="alert alert-danger">Verifique seu email para logar</span></div>';
            }
            ?>
            <?php
            if(isset($_GET['falha'])){
                echo '<div class="text-center"><span class="alert alert-danger">Logue-se Para Acessar!</span></div>';
            }
            ?>
            <?php
            if(isset($_GET['s'])){
                echo '<div class="text-center"><span class="alert alert-success">Conta ativada com sucesso!</span></div>';
            }
            ?>
            <?php
            if(isset($_GET['ex'])){
                echo '<div class="text-center"><span class="alert alert-danger">Sua Escola não possui assinatura!</span></div>';
            }
            ?>
            <?php
            if(isset($_GET['ts'])){
                echo '<div class="text-center"><span class="alert alert-success">Senha alterada com sucesso!!</span></div>';
            }
            ?>
            <form method="post" action="?">
                <br><br>
                <div class="mb-3 text-center logo">
                    <img src="img/wideconnections.png" alt="">
                </div>
                <div class="col-md-10 offset-md-1 mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email">
                </div>
                <div class="col-md-10 offset-md-1 mb-1">
                    <label for="senha" class="form-label">Senha</label>
                    <input type="password" class="form-control" id="senha" name="senha">
                    <div class="forget text-end"><a href="esqueciminhasenha.php">Esqueceu sua senha?</a></div>
                </div>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6 offset-md-1 mb-3"></div>
                        <div class="col-md-4 text-end">
                            <input class="btn btn-outline-primary col-md-11 mt-2" type="submit" value="Entrar" name="btnLogar" id="btnLogar">
                        </div>
                    </div>
                </div>
                <div class="offset-md-1 col-md-10">
                    <hr>
                </div>
                <div class="text-center">
                    Deseja cadastrar uma nova conta?&nbsp;&nbsp;&nbsp;
                    <a href="register.php" class="btn btn-dark">Cadastrar-se</a>
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
</html>