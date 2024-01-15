<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WideConnections - Início</title>
    <?php 

    include_once('inc/css.php');
    include_once('class/Conexao.php');
    include_once('class/Helper.php');
    include_once('class/Usuario.php');
    include_once('class/Escola.php');
    include_once('class/Estado.php');
    include_once('class/Cidade.php');

    //verificar se o produto foi cadastrado
    if (isset($_POST['btnCadastrar'])) {
        $Usuario = New Usuario;
        $id_usuario = $Usuario->Cadastrar($_POST);
    }

    ?>

</head>
<body class="bg-login">

    <div class="clr">
        <br>
    </div>

    <div class="hd">
        <br>
    </div>

    <div class="fullhd">
        <br><br><br><br>
    </div>

    <style>
        @media(max-width: 425px) {
            .card{
                margin-top: -144px
            }
        }
        @media(min-width: 768px) {
            .card{
                margin-top: -50px
            }
        }
        @media(min-width: 1920px) {
            .card{
                margin-top: 4%;
            }
        }
    </style>

    <div class="col-md-6 offset-md-3">
        <!-- CARD -->
        <div class="card p-4">
            <div id="alert" class="alert alert-danger d-none"></div>
            <form method="post" action="?">
                <div class="row">
                    <div class="mb-3 text-center">
                        <img src="img/wideconnections.png" alt="">
                    </div>

                        <?php
                            if(isset($_GET['ce'])){
                            echo '<div class="text-center"><span class="alert alert-danger">Código de Escola Incorreto.</span></div>';
                            }
                        ?>
                        
                    <div class="col-md-9 offset-md-1 mb-3">
                        <label for="nome" class="form-label">Nome Completo *</label>
                        <input type="nome" class="form-control" name="nome" id="nome" required>
                    </div>
                    <div class="col-md-2"></div>

                    <div class="col-md-8 offset-md-1 mb-3">
                        <label for="email" class="form-label">Email *</label>
                        <input type="email" class="form-control" name="email" id="email" required>
                    </div>
                    <div class="col-md-3"></div>

                    <div class="col-md-5 offset-md-1 mb-3">
                        <label for="senha" class="form-label">Senha *</label>
                        <input type="password" class="form-control" name="senha" id="senha" minlength="6" maxlength="12" required>
                    </div>
                    <div class="col-md-5 mb-3">
                        <label for="confirmasenha" class="form-label">Confirma Senha *</label>
                        <input type="password" class="form-control" id="confirmasenha" minlength="6" maxlength="12" required>
                    </div>
                    <div class="col-md-2"></div>

                    <div class="col-md-3 offset-md-1 mb-3">
                        <label for="codigo" class="form-label">Código da Escola *</label>
                        <input type="text" class="form-control" name="codigo" id="codigo" placeholder="Ex. ABC-123" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="serie" class="form-label">Série *</label>
                        <select name="serie" id="serie" class="form-control">
                            <option value="" default="default" require>Escolha...</option>
                            <option value="6">6° Ano</option>
                            <option value="7">7° Ano</option>
                            <option value="8">8° Ano</option>
                            <option value="9">9° Ano</option>
                            <option value="1">1° Ano</option>
                            <option value="2">2° Ano</option>
                            <option value="3">3° Ano</option>
                        </select>
                    </div>
                </div>
                    <div class="col-md-4 offset-md-4 text-center">
                        <br>
                        <input class="btn btn-outline-dark btn-lg disabled" type="submit" value="Cadastrar" name="btnCadastrar" id="btnCadastrar">
                    </div>

                    <div class="offset-md-1 col-md-10">
                        <br>
                        <hr>
                    </div>
                    <div class="text-center">
                        Já Possui uma conta?&nbsp;
                        <a href="login.php" class="text-decoration-none text-primary">Logar-se</a>
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
</html>