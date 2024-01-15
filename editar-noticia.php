<?php
    include_once('inc/css.php');
    include_once('class.php');

    $Noticia = new Noticia();
    $Categoria = new Categoria();
    $Subcategoria = new Subcategoria();
    $Escola = new Escola();
    $Cidade = new Cidade();
    $Estado = new Estado();

    if($_SESSION['nv_acesso'] < 2){
        header('location:logout.php?falha');
    }

    if (isset($_POST['btnEditar'])){
        $Noticia->editar($_POST,$_FILES['capa_nova']);
        header('location:admin/noticias.php');
    }

    $id = $_GET['id'];

    $noticia = $Noticia->mostrar($id);
    ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>WideConnections - Início</title>
</head>
<body>

  <nav class="bg-blue fixed-top">
    <div class="container-fluid">
      <div class="row">
        <div class="col-2 mt-1 text-end">
          <button class="btn text-light" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
            <i class="fa-solid fa-bars phone"></i> 
          </button>
        </div>
        <div class="col-8 mt-1 text-center">
          <h3 class="wide"><a href="index.php"><i>WideConnections</i></a></h3>
        </div>
          <div class="col-2 text-start mt-2">
            <a class="nav-link dropdown-toggle text-light" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fa-solid fa-user"></i>
            </a>
            <ul class="dropdown-menu menu">
              <?php if($_SESSION['nv_acesso'] > 4){ ?>
              <li><a class="dropdown-item" href="admin/">Admin</a></li>
              <li><a class="dropdown-item" href="usuario.php?id=<?php echo $_SESSION['id_usuario']; ?>">Minha Conta</a></li>
              <?php } ?>
              <li><a class="dropdown-item" href="logout.php">Sair</a></li>
            </ul>
          </div>
      </div>

      <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
        <div class="offcanvas-header">
          <h5 class="offcanvas-title" id="offcanvasNavbarLabel">WideConnections</h5>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
          <hr>
          <div class="row col-6 offset-3"><a href="escolar.php" class="btn btn-primary">Área do Aluno</a></div>
          <hr>
          <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
            <?php foreach($Categoria->listar() as $categoria){ ?>
              <li class="nav-item menu">
                  <a class="nav-link text-dark" aria-current="page" href="categoria.php?id=<?php echo $categoria->id_categoria ?>"><?php echo $categoria->categoria ?></a>
              </li>
            <?php } ?>
          </ul>
        </div>
      </div>

    </div>
  </nav>

<body>
<br>

    <style>
        .descricao{
            font-size: 10px;
            color: grey;
        }
    </style>

    <div class="container">
        <form action="?" method="POST" enctype="multipart/form-data">
            <div class="row">
                <!-- PRÉ VALORES -->
                    <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $_SESSION['id_usuario'] ?>">
                    <input type="hidden" name="status" id="status" value="1">
                    <input type="hidden" name="id_noticia" id="id_noticia" value="<?php echo $id; ?>">
                    <input type="hidden" name="capa_atual" id="capa_atual" value="<?php echo $noticia->capa; ?>">
                <!-- /PRÉ VALORES -->

                <!-- ID_ESCOLA/ID_CIDADE/ID_ESTADO -->

                <!-- Público-Alvo -->
                <!-- /Público-Alvo -->

                <!-- Escola -->
                    <input type="hidden" name="id_escola" id="id_escola" value="<?php echo $noticia->id_escola; ?>">
                    <input type="hidden" name="serie" id="serie" value="<?php echo $noticia->serie; ?>">
                <!-- /Escola -->

                <!-- Cidade -->
                    <input type="hidden" name="id_cidade" id="id_cidade" value="<?php echo $noticia->id_cidade; ?>">   
                <!-- /Cidade -->

                <!-- Estado -->
                    <input type="hidden" name="id_estado" id="id_estado" value="<?php echo $noticia->id_estado; ?>">
                <!-- /Estado -->

                <!-- ID_ESCOLA/ID_CIDADE/ID_ESTADO -->

                <br>
                
                <!-- CATEGORIA -->
                    <?php if($noticia->id_categoria != 0){ ?>
                        <div class="col-md-6">
                            <label for="id_categoria" class="form-label">Categoria *</label>
                            <select name="id_categoria" id="id_categoria" class="form-control" required>
                                    <option value="<?php if(!isset($Noticia->mostrarcategoria($noticia->id_categoria)->categoria)){ echo ''; }else{ echo $noticia->id_categoria; } ?>"><?php if(!isset($Noticia->mostrarcategoria($noticia->id_categoria)->categoria)){ echo 'Erro'; }else{ echo $Noticia->mostrarcategoria($noticia->id_categoria)->categoria; } ?></option>
                                <?php foreach($Categoria->listarmenos($noticia->id_categoria) as $cat){ ?>
                                    <option value="<?php echo $cat->id_categoria ?>"><?php echo $cat->categoria ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    <?php }else{ ?>
                        <div class="col-md-6">
                            <label for="id_subcategoria" class="form-label">Categoria Escolar *</label>
                            <select name="id_subcategoria" id="id_subcategoria" class="form-control" required>
                                    <option value="<?php if(!isset($Noticia->mostrarsubcategoria($noticia->id_subcategoria)->subcategoria)){ echo ''; }else{ echo $noticia->id_subcategoria; } ?>"><?php if(!isset($Noticia->mostrarsubcategoria($noticia->id_subcategoria)->subcategoria)){ echo 'Erro'; }else{ echo $Noticia->mostrarsubcategoria($noticia->id_subcategoria)->subcategoria; } ?></option>
                                <?php foreach($Subcategoria->listarmenos($noticia->id_subcategoria) as $cat){ ?>
                                    <option value="<?php echo $cat->id_subcategoria ?>"><?php echo $cat->subcategoria ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    <?php } ?>
                <!-- /CATEGORIA -->

                <!-- LINK -->
                    <div class="col-md-6">
                        <label for="link" class="form-label">Link</label>
                        <input type="text" name="link" id="link" class="form-control" value="<?php echo $noticia->link; ?>">
                    </div>
                <!-- /LINK -->

                <!-- TEMPODEVIDA -->
                    <div class="col-md-6">
                        <label for="tempodevida" class="form-label">Expira em: </label>
                        <input type="date" name="tempodevida" id="tempodevida" class="form-control" value="<?php echo $noticia->tempodevida; ?>">
                    </div>
                <!-- /TEMPODEVIDA -->

                <!-- CAPA -->
                    <div class="col-md-6">
                        <label for="capa_nova">Nova Capa *</label>
                        <input type="file" name="capa_nova" id="capa_nova" class="form-control">
                    </div>
                <!-- /CAPA -->
            </div>

                <br><br>

                <!-- TITULO -->
                    <div class="text-center">
                        <h2><b class="text-primary" id="tituloview"><?php echo $noticia->titulo; ?></b></h2>
                        <span class="descricao"> (Titulo)</span>
                    </div>
                    <br>
                    <div class="offset-md-3 col-md-6">
                        <textarea name="titulo" id="titulo" cols="30" rows="4" class="form-control" maxlength="100"><?php echo $noticia->titulo; ?></textarea>
                        <div class="text-end">
                            <span class="text-primary">Título</span>
                            <button type="button" class="btn btn-outline-primary" id="escondertitulo"><i class="fa-solid fa-eye-slash"></i></button>
                            <button type="button" class="btn btn-outline-primary d-none" id="mostrartitulo"><i class="fa-solid fa-eye"></i></button>
                        </div>
                    </div>
                <!-- /TITULO -->

                <br>

                <!-- DESCRIÇÃO -->
                    <div class="text-center">
                        <h5><span id="descview"><?php echo $noticia->descricao ?></span></h5>
                        <span class="descricao">(Descrição)</span>
                    </div>
                    <br>
                    <div class="offset-md-3 col-md-6">
                        <textarea id="descricao" name="descricao" cols="30" rows="4" class="form-control" maxlength="250"><?php echo $noticia->descricao ?></textarea>
                        <div class="text-end">
                            <span class="text-primary">Descrição</span>
                            <button type="button" class="btn btn-outline-primary" id="esconderdesc"><i class="fa-solid fa-eye-slash"></i></button>
                            <button type="button" class="btn btn-outline-primary d-none" id="mostrardesc"><i class="fa-solid fa-eye"></i></button>
                        </div>
                    </div>
                <!-- /DESCRIÇÃO -->

                <br>

                <!-- CONTEUDO -->
                    
                    <div class="text-center">
                        <h5><div id="contview"><?php echo $noticia->conteudo ?></div><span class="descricao">(Conteudo)</span></h5>
                    </div>
                    <textarea name="conteudo" id="conteudo" cols="30" rows="10" class="form-control d-none"><?php echo $noticia->conteudo ?></textarea>
                    <br>
                    <textarea id="cont" cols="30" rows="10" class="form-control"></textarea>
                    <div class="text-end">
                        <a href="guiapublicar.php" target="_blank" class="btn btn-dark">GUÍA</a>
                        <button type="button" class="btn btn-dark d-none" id="esconderhtml">Esconder HTML</button>
                        <button type="button" class="btn btn-secondary" id="edita">Editar HTML</button>
                        <button type="button" class="btn btn-danger" id="limpa">Limpar Tudo</button>
                        <button type="button" class="btn btn-primary" id="add">Adicionar Paragrafo</button>
                    </div>
                <!-- /CONTEUDO -->
            
                <br><br><br>

            <div class="col-12 text-end">
                <button type="submit" name="btnEditar" id="btnEditar" class="btn btn-success">Editar</button>
            </div>
        </form>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        //Alvo
        {
            $('#publico').click(function (e) { 
                $('#publico').removeAttr('class')
                $('#publico').addClass('btn btn-dark')

                $('#escola').removeAttr('class')
                $('#escola').addClass('btn btn-outline-dark')

                $('#cidade').removeAttr('class')
                $('#cidade').addClass('btn btn-outline-dark')

                $('#estado').removeAttr('class')
                $('#estado').addClass('btn btn-outline-dark')

                $('#id_escola').val(0)
                $('#serie').val('')
                $('#id_cidade').val(0)
                $('#id_estado').val(0)

                $('#alvoescola').addClass('d-none')
                $('#alvocidade').addClass('d-none')
                $('#alvoestado').addClass('d-none')
            });

            $('#escola').click(function (e) { 
                $('#escola').removeAttr('class')
                $('#escola').addClass('btn btn-dark')

                $('#publico').removeAttr('class')
                $('#publico').addClass('btn btn-outline-dark')

                $('#cidade').removeAttr('class')
                $('#cidade').addClass('btn btn-outline-dark')

                $('#estado').removeAttr('class')
                $('#estado').addClass('btn btn-outline-dark')

                $('#id_cidade').val(0)
                $('#id_estado').val(0)

                $('#alvoescola').removeClass('d-none')
                $('#alvocidade').addClass('d-none')
                $('#alvoestado').addClass('d-none')
            });

            $('#cidade').click(function (e) { 
                $('#cidade').removeAttr('class')
                $('#cidade').addClass('btn btn-dark')

                $('#publico').removeAttr('class')
                $('#publico').addClass('btn btn-outline-dark')

                $('#escola').removeAttr('class')
                $('#escola').addClass('btn btn-outline-dark')

                $('#estado').removeAttr('class')
                $('#estado').addClass('btn btn-outline-dark')

                $('#id_escola').val(0)
                $('#serie').val('')
                $('#id_estado').val(0)

                $('#alvoescola').addClass('d-none')
                $('#alvocidade').removeClass('d-none')
                $('#alvoestado').addClass('d-none')
            });

            $('#estado').click(function (e) { 
                $('#estado').removeAttr('class')
                $('#estado').addClass('btn btn-dark')

                $('#publico').removeAttr('class')
                $('#publico').addClass('btn btn-outline-dark')

                $('#escola').removeAttr('class')
                $('#escola').addClass('btn btn-outline-dark')

                $('#cidade').removeAttr('class')
                $('#cidade').addClass('btn btn-outline-dark')

                $('#id_escola').val(0)
                $('#serie').val('')
                $('#id_cidade').val(0)
                
                $('#alvoescola').addClass('d-none')
                $('#alvocidade').addClass('d-none')
                $('#alvoestado').removeClass('d-none')
            });
        }

        // Conteudo
        {
            $('#add').click(function (e) { 
                cont = $('#contview').html()
                let conteudo = $('#cont').val()
                $('#cont').val('')
                $('#contview').html(cont+'<p>'+conteudo+'</p><br>')
                $('#conteudo').val(cont+'<p>'+conteudo+'</p><br>')
            });

            $('#limpa').click(function (e) { 
                $('#contview').html('')
                $('#conteudo').val('')
            });

            $('#edita').click(function (e) { 
                $('#conteudo').removeClass('d-none')
                $('#esconderhtml').removeClass('d-none')
                $('#edita').addClass('d-none')
            });

            $('#esconderhtml').click(function (e) { 
                $('#conteudo').addClass('d-none')
                $('#esconderhtml').addClass('d-none')
                $('#edita').removeClass('d-none')
            });

            $('#conteudo').keyup(function (e) { 
                let conteudo = $('#conteudo').val()
                $('#contview').html(conteudo)
            });
        }

        // Titulo
        {
            $('#titulo').keyup(function (e) { 
                let titulo = $('#titulo').val()
                $('#tituloview').text(titulo)
            });
            $('#escondertitulo').click(function (e) { 
                $('#titulo').addClass('d-none')
                $('#escondertitulo').addClass('d-none')
                $('#mostrartitulo').removeClass('d-none')
            });
            $('#mostrartitulo').click(function (e) { 
                $('#titulo').removeClass('d-none')
                $('#escondertitulo').removeClass('d-none')
                $('#mostrartitulo').addClass('d-none')
            });
        }

        // Descrição
        {
            $('#esconderdesc').click(function (e) {
                $('#descricao').addClass('d-none')
                $('#esconderdesc').addClass('d-none')
                $('#mostrardesc').removeClass('d-none')
            });

            $('#mostrardesc').click(function (e) { 
                $('#descricao').removeClass('d-none')
                $('#mostrardesc').addClass('d-none')
                $('#esconderdesc').removeClass('d-none')
            });

            $('#descricao').keyup(function (e) { 
                let descricao = $('#descricao').val()
                $('#descview').text(descricao)
            });
        }
    </script>
    
</body>
</html>

