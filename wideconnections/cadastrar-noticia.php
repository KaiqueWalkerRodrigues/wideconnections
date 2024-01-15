<?php
    include_once('inc/css.php');
    include_once('class.php');

    if($_SESSION['nv_acesso'] < 2){
        header('location:logout.php?falha');
    }

    $Noticia = new Noticia();
    $Categoria = new Categoria();
    $Escola = new Escola();
    $Cidade = new Cidade();
    $Estado = new Estado();
    $Subcategoria = new SubCategoria();''
    ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>WideConnections - Cadastrar Noticia</title>

  <?php 
    if (isset($_POST['btnPublicar'])){
        $Noticia->cadastrar($_POST, $_FILES['capa']);
        header('location:cadastrar-noticia.php?s');
    }
  ?>
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
                <!-- /PRÉ VALORES -->

                <!-- ID_ESCOLA/ID_CIDADE/ID_ESTADO -->

                <?php if(isset($_GET['s'])){ ?>
                <div class="text-center">
                    <span class="alert alert-success col-3">Noticia Cadastrada Com Sucesso!</span>
                    <br><br>
                </div>
                <?php } ?>

                <!-- Público-Alvo -->
                    <div class="text-center mb-3">
                        <h3>Público-Alvo</h3>
                    </div>
                    <div class="col-md-6 offset-md-3">
                        <div class="row">
                            <?php if($_SESSION['nv_acesso']  == 3 OR $_SESSION['nv_acesso'] == 5){ ?>
                                <div class="col-3">
                                    <button type="button" class="btn btn-dark" id="publico">Público</button>
                                </div>
                            <?php } ?>
                                <div class="col-3">
                                    <button type="button" class="btn <?php if($_SESSION['nv_acesso']  == 3 OR $_SESSION['nv_acesso'] == 5){ ?> btn-outline-dark <?php }else{ echo 'btn-dark'; } ?>" id="escola">Escola</button>
                                </div>
                            <?php if($_SESSION['nv_acesso']  == 3 OR $_SESSION['nv_acesso'] == 5){ ?>
                            <div class="col-3">
                                <button type="button" class="btn btn-outline-dark" id="cidade">Cidade</button>
                            </div>
                            <?php } ?>
                            <?php if($_SESSION['nv_acesso']  == 3 OR $_SESSION['nv_acesso'] == 5){ ?>
                                <div class="col-3">
                                    <button type="button" class="btn btn-outline-dark" id="estado">Estado</button>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                <!-- /Público-Alvo -->

                <!-- Escola -->
                    <div id="alvoescola" <?php if($_SESSION['nv_acesso']  == 3 OR $_SESSION['nv_acesso'] == 5){ ?> class="d-none" <?php } ?>>
                        <br><br>
                        <div class="row">
                            <div class="col-md-5 offset-md-2">
                                <label for="id_escola" class="form-label">Escola *</label>
                                <select name="id_escola" id="id_escola" class="form-control">
                                        <option value="0">Escolha...</option>
                                    <?php if($_SESSION['nv_acesso'] == 5 OR $_SESSION['nv_acesso'] == 3){ foreach($Escola->listar($_SESSION['id_usuario']) as $escola){ ?>
                                        <option value="<?php echo $escola->id_escola ?>"><?php echo $escola->escola ?></option>
                                    <?php }}else{ ?>
                                    <?php foreach($Escola->listarpdiretor($_SESSION['id_usuario']) as $escola){ ?>
                                        <option value="<?php echo $escola->id_escola ?>"><?php echo $escola->escola ?></option>
                                    <?php }} ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="serie" class="form-label">Série *</label>
                                <select name="serie" id="serie" class="form-control">
                                        <option value="0">Escolha...</option>
                                        <option value="0">Todas</option>
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
                        <br><br>
                    </div>
                <!-- /Escola -->

                <!-- Cidade -->
                    <div id="alvocidade" class="d-none">
                        <br><br>
                        <div class="row">
                            <div class="col-md-6 offset-md-3">
                                <label for="id_cidade" class="form-label">Cidade</label>
                                <select name="id_cidade" id="id_cidade" class="form-control">
                                        <option value="0">Escolha...</option>
                                    <?php foreach($Cidade->listar() as $cidade){ ?>
                                        <option value="<?php echo $cidade->id_cidade ?>"><?php echo $cidade->cidade ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <br><br>
                    </div>                  
                <!-- /Cidade -->

                <!-- Estado -->
                    <div id="alvoestado" class="d-none">
                        <br><br>
                        <div class="row">
                            <div class="col-md-6 offset-md-3">
                                <label for="id_estado" class="form-label">Estado</label>
                                <select name="id_estado" id="id_estado" class="form-control">
                                    <option value="0">Escolha...</option>
                                        <?php foreach($Estado->listar() as $estado){ ?>
                                            <option value="<?php echo $estado->id_estado ?>"><?php echo $estado->estado ?></option>
                                        <?php } ?>
                                </select>
                            </div>
                        </div>
                        <br><br>
                    </div>
                <!-- /Estado -->

                <!-- ID_ESCOLA/ID_CIDADE/ID_ESTADO -->

                <br><br><br>
                <hr>
                
                <div class="row">
                    <!-- CATEGORIA -->
                        <div class="col-6" id="categoria-cadastrar">
                            <label for="id_categoria" class="form-label">Categoria *</label>
                            <select name="id_categoria" id="id_categoria" class="form-control">
                                    <option value="0">Escolha...</option>
                                <?php foreach($Categoria->listar() as $cat){ ?>
                                    <option value="<?php echo $cat->id_categoria ?>"><?php echo $cat->categoria ?></option>
                                <?php } ?>
                            </select>
                        </div>

                    <!-- /CATEGORIA -->
                    <!-- SUBCATEGORIA -->
                        <div class="col-md-6 d-none" id="subcategoria-cadastrar">
                            <label for="id_subcategoria" class="form-label">Categoria Escolar *</label>
                            <select name="id_subcategoria" id="id_subcategoria" class="form-control">
                                    <option value="0">Escolha...</option>
                                <?php if($_SESSION['nv_acesso'] < 4){ foreach($Subcategoria->listarsubcategoria($_SESSION['id_usuario']) as $cat){ ?>
                                    <option value="<?php echo $cat->id_subcategoria ?>"><?php echo $cat->subcategoria ?></option>
                                <?php }}else{ foreach($Subcategoria->listar() as $cat){ ?>
                                    <option value="<?php echo $cat->id_subcategoria ?>"><?php echo $cat->subcategoria ?></option>
                                <?php }} ?>
                            </select>
                        </div>
                    <!-- /SUBCATEGORIA -->
                <!-- LINK -->
                    <div class="col-md-6">
                        <label for="link" class="form-label">Link</label>
                        <input type="text" name="link" id="link" class="form-control">
                    </div>
                <!-- /LINK -->

                <!-- TEMPODEVIDA -->
                    <div class="col-md-6">
                        <label for="tempodevida" class="form-label">Empira em: </label>
                        <input type="date" name="tempodevida" id="tempodevida" class="form-control">
                    </div>
                <!-- /TEMPODEVIDA -->

                <!-- CAPA -->
                    <div class="col-md-6">
                        <label for="capa">Capa da Noticia *</label>
                        <input type="file" name="capa" id="capa" class="form-control" required>
                    </div>
                <!-- /CAPA -->
                <hr class="mt-4">
            </div>

                <br><br>

                <!-- TITULO -->
                    <div class="text-center">
                        <h2><b class="text-primary" id="tituloview"></b></h2>
                        <span class="descricao"> (Titulo)</span>
                    </div>
                    <br>
                    <div class="offset-md-3 col-md-6">
                        <textarea name="titulo" id="titulo" cols="30" rows="4" class="form-control" maxlength="100"></textarea>
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
                        <h5><span id="descview"></span></h5>
                        <span class="descricao">(Descrição)</span>
                    </div>
                    <br>
                    <div class="offset-md-3 col-md-6">
                        <textarea id="descricao" name="descricao" cols="30" rows="4" class="form-control" maxlength="250"></textarea>
                        <div class="text-end">
                            <span class="text-primary">Descrição</span>
                            <button type="button" class="btn btn-outline-primary" id="esconderdesc"><i class="fa-solid fa-eye-slash"></i></button>
                            <button type="button" class="btn btn-outline-primary d-none" id="mostrardesc"><i class="fa-solid fa-eye"></i></button>
                        </div>
                    </div>
                <!-- /DESCRIÇÃO -->

                <br>

                <!-- CONTEUDO -->
                    <textarea name="conteudo" id="conteudo" cols="30" rows="10" class="form-control d-none"></textarea>
                    <br><br>
                    <div class="text-center">
                        <h5><div id="contview"></div><span class="descricao">(Conteudo)</span></h5>
                    </div>
                    <textarea id="cont" cols="30" rows="10" class="form-control"></textarea>
                    <div class="text-end">
                        <button type="button" class="btn btn-dark d-none" id="esconderhtml">Esconder HTML</button>
                        <button type="button" class="btn btn-secondary" id="edita">Editar HTML</button>
                        <button type="button" class="btn btn-danger" id="limpa">Limpar Tudo</button>
                        <button type="button" class="btn btn-primary" id="add">Adicionar Paragrafo</button>
                    </div>
                <!-- /CONTEUDO -->
            
                <br><br><br>

            <div class="col-12 text-end">
                <button type="submit" name="btnPublicar" id="btnPublicar" class="btn btn-success">Publicar</button>
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

                $('#subcategoria-cadastrar').addClass('d-none')
                $('#id_subcategoria').val(0)
                $('#categoria-cadastrar').removeClass('d-none')
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

                $('#categoria-cadastrar').addClass('d-none')
                $('#id_categoria').val(0)
                $('#subcategoria-cadastrar').removeClass('d-none')
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

                $('#categoria-cadastrar').addClass('d-none')
                $('#id_categoria').val(0)
                $('#subcategoria-cadastrar').removeClass('d-none')
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

                $('#categoria-cadastrar').addClass('d-none')
                $('#id_categoria').val(0)
                $('#subcategoria-cadastrar').removeClass('d-none')
            });
        }

        //Categorias e SubCategorias
        {
            $('#categoria').click(function (e) { 
                $('#categoria').removeAttr('class')
                $('#categoria').addClass('btn btn-dark')

                $('#subcategoria').removeAttr('class')
                $('#subcategoria').addClass('btn btn-outline-dark')

                $('#id_subcategoria').val(0);

                $('#categoria-cadastrar').removeClass('d-none')
                $('#subcategoria-cadastrar').addClass('d-none')
            });

            $('#subcategoria').click(function (e) { 
                $('#subcategoria').removeAttr('class')
                $('#subcategoria').addClass('btn btn-dark')

                $('#categoria').removeAttr('class')
                $('#categoria').addClass('btn btn-outline-dark')

                $('#id_categoria').val(0);

                $('#categoria-cadastrar').addClass('d-none')
                $('#subcategoria-cadastrar').removeClass('d-none')
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

