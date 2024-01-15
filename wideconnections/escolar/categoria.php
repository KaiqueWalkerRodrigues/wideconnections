<?php
  include_once('../inc/cssescolar.php');
  include_once('class.php');

    $Noticia = new Noticia();
    $Subcategoria = new Subcategoria();
    $Escola = new Escola();
    $Cidade = new Cidade();
    $Estado = new Estado();
    $Usuario = new Usuario();

    if (isset($_GET['btnCurtir'])){
      $Noticia->curtir($_SESSION['id_usuario'],$_GET['id_noticia']);  
    }

    $cat = $Subcategoria->mostrar($_GET['id']);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>WideConnections - Início</title>
  <style>
    .mensagem{
      font-size: 12px;
    }
    .autor{
      font-size: 12px;
    }
  </style>
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
          <h3 class="wide"><a href="index.php"><i>WideConnections <i class="fa-solid fa-book"></i></i></a></h3>
        </div>
          <div class="col-2 text-start mt-2">
            <a class="nav-link dropdown-toggle text-light" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fa-solid fa-user"></i>
            </a>
            <ul class="dropdown-menu menu">
              <li><a class="dropdown-item" href="#">Meu Perfil</a></li>
              <?php if($_SESSION['nv_acesso'] > 4){ ?>
              <li><a class="dropdown-item" href="../admin/">Admin</a></li>
              <li><a class="dropdown-item" href="../usuario.php?id=<?php echo $_SESSION['id_usuario']; ?>">Minha Conta</a></li>
              <?php } ?>
              <li><a class="dropdown-item" href="#">Histórico</a></li>
              <li><a class="dropdown-item" href="../logout.php">Sair</a></li>
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
          <div class="row col-6 offset-3"><a href="../" class="btn btn-dark">Área Pública</a></div>
          <hr>
          <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
            <?php foreach($Subcategoria->listar() as $categoria){ ?>
              <li class="nav-item menu">
                  <a class="nav-link text-dark" aria-current="page" href="categoria.php?id=<?php echo $categoria->id_subcategoria ?>"><?php echo $categoria->subcategoria ?></a>
              </li>
            <?php } ?>
          </ul>
        </div>
      </div>

    </div>
  </nav>

<body>
<br>

    <div class="container">
  <?php if($_SESSION['nv_acesso'] > 1){ ?>
  <div class="text-center">
    <a class="btn btn-success" href="../cadastrar-noticia.php">Publicar Nova Notícia</a>
  </div>
  <?php } ?>
    <br>

  <h5 class="text-center mt-3 mb-2">Sua Escola</h5>
    <div class="col-10 offset-1 pc">
      <div class="row">
        <hr>  
    <?php foreach($Noticia->listarnoticiasescolaescolar($_SESSION['id_usuario'],$cat->id_subcategoria) as $noticia){ ?>
      <div class="col-12 noticia">
        <div class="row mb-3 hd">
          <div class="col-5">
            <a <?php if($noticia->conteudo != ''){ echo 'href="../noticia.php?id='.$noticia->id_noticia.'"'; }else{ if($noticia->link != ''){ echo 'href="'.$noticia->link.'"target="_blank"'; } }?>><img src="../imagens/<?php echo $noticia->capa ?>" alt="capa da noticia"></a>
          </div>
          <div class="col-7">
            <span>Em <a class="text-primary" href="<?php echo 'categoria.php?id='.$noticia->id_subcategoria; ?>"><?php echo $Noticia->mostrarsubcategoria($noticia->id_subcategoria)->subcategoria ?></a></span> - <?php echo '( '.$Escola->mostrar($noticia->id_escola)->escola.' )'; ?>
            <h4 class="titulo"><a <?php if($noticia->conteudo != ''){ echo 'href="../noticia.php?id='.$noticia->id_noticia.'"'; }else{ if($noticia->link != ''){ echo 'href="'.$noticia->link.'"target="_blank"'; } }?>" class="titulo"><?php echo $noticia->titulo; ?></a></h4>
            <p>
              <?php $desc =substr($noticia->titulo,0,250).'...'; echo $desc ?>
              <br>
              <p class="text-secondary"><?php echo Helper::data($noticia->created_at) ?></p>
              <form action="?" method="get">
                <input type="hidden" name="id_noticia" id="id_noticia" value="<?php echo $noticia->id_noticia ?>">
                <button type="submit" name="btnCurtir" id="btnCurtir" class="btn <?php if($Noticia->verificarlike($noticia->id_noticia,$_SESSION['id_usuario']) == 0){ echo 'btn-outline-success'; }else{ echo 'btn-success'; }; ?>"><i class="fa-solid fa-thumbs-up"></i></button>
                <?php if($_SESSION['nv_acesso'] > 2 OR $_SESSION['id_usuario'] == $noticia->id_usuario){ ?><a href="../editar-noticia.php?id=<?php echo $noticia->id_noticia ?>" class="btn btn-secondary"><i class="fa-solid fa-gear"></i></a><?php } ?>
              </form>
              <br><span class="autor">Escrita Por > <?php echo $Usuario->mostrar($noticia->id_usuario)->nome ?></span> <br> <span class="mensagem">(!) Essa Notícia não representa a visão do WideConnections, apenas do Autor Dela.</span>
            </p>
          </div>
        </div>
        <div class="row mb-3 fhd">
          <div class="col-5">
            <a <?php if($noticia->conteudo != ''){ echo 'href="../noticia.php?id='.$noticia->id_noticia.'"'; }else{ if($noticia->link != ''){ echo 'href="'.$noticia->link.'"target="_blank"'; } }?>><img src="../imagens/<?php echo $noticia->capa ?>" alt="capa da noticia"></a>
          </div>
          <div class="col-7">
            <span>Em <a class="text-primary" href="<?php echo 'categoria.php?id='.$noticia->id_subcategoria; ?>"><?php echo $Noticia->mostrarsubcategoria($noticia->id_subcategoria)->subcategoria ?></a></span> - <?php echo '( '.$Escola->mostrar($noticia->id_escola)->escola.' )'; ?>
            <h4 class="titulo"><a <?php if($noticia->conteudo != ''){ echo 'href="../noticia.php?id='.$noticia->id_noticia.'"'; }else{ if($noticia->link != ''){ echo 'href="'.$noticia->link.'"target="_blank"'; } }?>" class="titulo"><?php echo $noticia->titulo; ?></a></h4>
            <p>
              <?php $desc =substr($noticia->titulo,0,250).'...'; echo $desc ?>
              <br>
              <p class="text-secondary"><?php echo Helper::data($noticia->created_at) ?></p>
              <form action="?" method="get">
                <input type="hidden" name="id_noticia" id="id_noticia" value="<?php echo $noticia->id_noticia ?>">
                <button type="submit" name="btnCurtir" id="btnCurtir" class="btn <?php if($Noticia->verificarlike($noticia->id_noticia,$_SESSION['id_usuario']) == 0){ echo 'btn-outline-success'; }else{ echo 'btn-success'; }; ?>"><i class="fa-solid fa-thumbs-up"></i></button>
                <?php if($_SESSION['nv_acesso'] > 2 OR $_SESSION['id_usuario'] == $noticia->id_usuario){ ?><a href="../editar-noticia.php?id=<?php echo $noticia->id_noticia ?>" class="btn btn-secondary"><i class="fa-solid fa-gear"></i></a><?php } ?>
              </form>
              <br><span class="autor">Escrita Por > <?php echo $Usuario->mostrar($noticia->id_usuario)->nome ?></span> <br> <span class="mensagem">(!) Essa Notícia não representa a visão do WideConnections, apenas do Autor Dela.</span>
            </p>
          </div>
        </div>
        <div class="row mb-3 clr">
          <div class="col-8 mb-2">
            <a <?php if($noticia->conteudo != ''){ echo 'href="../noticia.php?id='.$noticia->id_noticia.'"'; }else{ if($noticia->link != ''){ echo 'href="'.$noticia->link.'"target="_blank"'; } }?>><img src="../imagens/<?php echo $noticia->capa ?>" alt="capa da noticia"></a>
          </div>
          <div class="col-12">
            <span>Em <a class="text-primary" href="<?php echo 'categoria.php?id='.$noticia->id_subcategoria; ?>"><?php echo $Noticia->mostrarsubcategoria($noticia->id_subcategoria)->subcategoria ?></a></span> - <?php echo '( '.$Escola->mostrar($noticia->id_escola)->escola.' )'; ?>
            <h4 class="titulo"><a <?php if($noticia->conteudo != ''){ echo 'href="../noticia.php?id='.$noticia->id_noticia.'"'; }else{ if($noticia->link != ''){ echo 'href="'.$noticia->link.'"target="_blank"'; } }?>" class="titulo"><?php echo $noticia->titulo; ?></a></h4>
            <p>
              <p class="text-secondary"><?php echo Helper::data($noticia->created_at) ?></p>
              <form action="?" method="get">
                <input type="hidden" name="id_noticia" id="id_noticia" value="<?php echo $noticia->id_noticia ?>">
                <button type="submit" name="btnCurtir" id="btnCurtir" class="btn <?php if($Noticia->verificarlike($noticia->id_noticia,$_SESSION['id_usuario']) == 0){ echo 'btn-outline-success'; }else{ echo 'btn-success'; }; ?>"><i class="fa-solid fa-thumbs-up"></i></button>
                <?php if($_SESSION['nv_acesso'] > 2 OR $_SESSION['id_usuario'] == $noticia->id_usuario){ ?><a href="../editar-noticia.php?id=<?php echo $noticia->id_noticia ?>" class="btn btn-secondary"><i class="fa-solid fa-gear"></i></a><?php } ?>
              </form>
              <br><span class="autor">Escrita Por > <?php echo $Usuario->mostrar($noticia->id_usuario)->nome ?></span> <br> <span class="mensagem">(!) Essa Notícia não representa a visão do WideConnections, apenas do Autor Dela.</span>
            </p>
          </div>
        </div>
        <div class="row mb-3 tablet">
          <div class="col-8 offset-2 mb-2">
            <a <?php if($noticia->conteudo != ''){ echo 'href="../noticia.php?id='.$noticia->id_noticia.'"'; }else{ if($noticia->link != ''){ echo 'href="'.$noticia->link.'"target="_blank"'; } }?>><img src="../imagens/<?php echo $noticia->capa ?>" alt="capa da noticia"></a>
          </div>
          <div class="col-12">
            <span>Em <a class="text-primary" href="<?php echo 'categoria.php?id='.$noticia->id_subcategoria; ?>"><?php echo $Noticia->mostrarsubcategoria($noticia->id_subcategoria)->subcategoria ?></a></span> - <?php echo '( '.$Escola->mostrar($noticia->id_escola)->escola.' )'; ?>
            <h4 class="titulo"><a <?php if($noticia->conteudo != ''){ echo 'href="../noticia.php?id='.$noticia->id_noticia.'"'; }else{ if($noticia->link != ''){ echo 'href="'.$noticia->link.'"target="_blank"'; } }?>" class="titulo"><?php echo $noticia->titulo; ?></a></h4>
            <p>
              <p class="text-secondary"><?php echo Helper::data($noticia->created_at) ?></p>
              <form action="?" method="get">
                <input type="hidden" name="id_noticia" id="id_noticia" value="<?php echo $noticia->id_noticia ?>">
                <button type="submit" name="btnCurtir" id="btnCurtir" class="btn <?php if($Noticia->verificarlike($noticia->id_noticia,$_SESSION['id_usuario']) == 0){ echo 'btn-outline-success'; }else{ echo 'btn-success'; }; ?>"><i class="fa-solid fa-thumbs-up"></i></button>
                <?php if($_SESSION['nv_acesso'] > 2 OR $_SESSION['id_usuario'] == $noticia->id_usuario){ ?><a href="../editar-noticia.php?id=<?php echo $noticia->id_noticia ?>" class="btn btn-secondary"><i class="fa-solid fa-gear"></i></a><?php } ?>
              </form>
              <br><span class="autor">Escrita Por > <?php echo $Usuario->mostrar($noticia->id_usuario)->nome ?></span> <br> <span class="mensagem">(!) Essa Notícia não representa a visão do WideConnections, apenas do Autor Dela.</span>
            </p>
          </div>
        </div>
      </div>
      <hr>
    <?php } ?>
      </div>
    </div>

  <br>

  <h5 class="text-center mt-3 mb-2">Sua Cidade</h5>
    <div class="col-10 offset-1 pc">
      <div class="row">
        <hr>  
    <?php foreach($Noticia->listarnoticiascidadeescolar($_SESSION['id_usuario'], $cat->id_subcategoria) as $noticia){ ?>
      <div class="col-12 noticia">
        <div class="row mb-3 hd">
          <div class="col-6">
            <a <?php if($noticia->conteudo != ''){ echo 'href="../noticia.php?id='.$noticia->id_noticia.'"'; }else{ if($noticia->link != ''){ echo 'href="'.$noticia->link.'"target="_blank"'; } }?>><img src="../imagens/<?php echo $noticia->capa ?>" alt="capa da noticia"></a>
          </div>
          <div class="col-6">
            <span>Em <a class="text-primary" href="<?php echo 'categoria.php?id='.$noticia->id_subcategoria; ?>"><?php echo $Noticia->mostrarsubcategoria($noticia->id_subcategoria)->subcategoria ?></a></span> - <?php echo '( '.$Cidade->mostrar($noticia->id_cidade)->cidade.' )'; ?>
            <h4 class="titulo"><a <?php if($noticia->conteudo != ''){ echo 'href="../noticia.php?id='.$noticia->id_noticia.'"'; }else{ if($noticia->link != ''){ echo 'href="'.$noticia->link.'"target="_blank"'; } }?>" class="titulo"><?php echo $noticia->titulo; ?></a></h4>
            <p>
              <?php $desc =substr($noticia->titulo,0,250).'...'; echo $desc ?>
              <br>
              <p class="text-secondary"><?php echo Helper::data($noticia->created_at) ?></p>
              <form action="?" method="get">
                <input type="hidden" name="id_noticia" id="id_noticia" value="<?php echo $noticia->id_noticia ?>">
                <button type="submit" name="btnCurtir" id="btnCurtir" class="btn <?php if($Noticia->verificarlike($noticia->id_noticia,$_SESSION['id_usuario']) == 0){ echo 'btn-outline-success'; }else{ echo 'btn-success'; }; ?>"><i class="fa-solid fa-thumbs-up"></i></button>
                <?php if($_SESSION['nv_acesso'] > 2 AND $_SESSION['nv_acesso'] != 4){ ?><a href="../editar-noticia.php?id=<?php echo $noticia->id_noticia ?>" class="btn btn-secondary"><i class="fa-solid fa-gear"></i></a><?php } ?>
              </form>
              <br><span class="autor">Escrita Por > <?php echo $Usuario->mostrar($noticia->id_usuario)->nome ?></span> <br> <span class="mensagem">(!) Essa Notícia não representa a visão do WideConnections, apenas do Autor Dela.</span>
            </p>
          </div>
        </div>
        <div class="row mb-3 fhd">
          <div class="col-5">
            <a <?php if($noticia->conteudo != ''){ echo 'href="../noticia.php?id='.$noticia->id_noticia.'"'; }else{ if($noticia->link != ''){ echo 'href="'.$noticia->link.'"target="_blank"'; } }?>><img src="../imagens/<?php echo $noticia->capa ?>" alt="capa da noticia"></a>
          </div>
          <div class="col-7">
            <span>Em <a class="text-primary" href="<?php echo 'categoria.php?id='.$noticia->id_subcategoria; ?>"><?php echo $Noticia->mostrarsubcategoria($noticia->id_subcategoria)->subcategoria ?></a></span> - <?php echo '( '.$Cidade->mostrar($noticia->id_cidade)->cidade.' )'; ?>
            <h4 class="titulo"><a <?php if($noticia->conteudo != ''){ echo 'href="../noticia.php?id='.$noticia->id_noticia.'"'; }else{ if($noticia->link != ''){ echo 'href="'.$noticia->link.'"target="_blank"'; } }?>" class="titulo"><?php echo $noticia->titulo; ?></a></h4>
            <p>
              <?php $desc =substr($noticia->titulo,0,250).'...'; echo $desc ?>
              <br>
              <p class="text-secondary"><?php echo Helper::data($noticia->created_at) ?></p>
              <form action="?" method="get">
                <input type="hidden" name="id_noticia" id="id_noticia" value="<?php echo $noticia->id_noticia ?>">
                <button type="submit" name="btnCurtir" id="btnCurtir" class="btn <?php if($Noticia->verificarlike($noticia->id_noticia,$_SESSION['id_usuario']) == 0){ echo 'btn-outline-success'; }else{ echo 'btn-success'; }; ?>"><i class="fa-solid fa-thumbs-up"></i></button>
                <?php if($_SESSION['nv_acesso'] > 2 AND $_SESSION['nv_acesso'] != 4){ ?><a href="../editar-noticia.php?id=<?php echo $noticia->id_noticia ?>" class="btn btn-secondary"><i class="fa-solid fa-gear"></i></a><?php } ?>
              </form>
              <br><span class="autor">Escrita Por > <?php echo $Usuario->mostrar($noticia->id_usuario)->nome ?></span> <br> <span class="mensagem">(!) Essa Notícia não representa a visão do WideConnections, apenas do Autor Dela.</span>
            </p>
          </div>
        </div>
        <div class="row mb-3 clr">
          <div class="col-8 mb-2">
            <a <?php if($noticia->conteudo != ''){ echo 'href="../noticia.php?id='.$noticia->id_noticia.'"'; }else{ if($noticia->link != ''){ echo 'href="'.$noticia->link.'"target="_blank"'; } }?>><img src="../imagens/<?php echo $noticia->capa ?>" alt="capa da noticia"></a>
          </div>
          <div class="col-12">
            <span>Em <a class="text-primary" href="<?php echo 'categoria.php?id='.$noticia->id_subcategoria; ?>"><?php echo $Noticia->mostrarsubcategoria($noticia->id_subcategoria)->subcategoria ?></a></span> - <?php echo '( '.$Cidade->mostrar($noticia->id_cidade)->cidade.' )'; ?>
            <h4 class="titulo"><a <?php if($noticia->conteudo != ''){ echo 'href="../noticia.php?id='.$noticia->id_noticia.'"'; }else{ if($noticia->link != ''){ echo 'href="'.$noticia->link.'"target="_blank"'; } }?>" class="titulo"><?php echo $noticia->titulo; ?></a></h4>
            <p>
              <p class="text-secondary"><?php echo Helper::data($noticia->created_at) ?></p>
              <form action="?" method="get">
                <input type="hidden" name="id_noticia" id="id_noticia" value="<?php echo $noticia->id_noticia ?>">
                <button type="submit" name="btnCurtir" id="btnCurtir" class="btn <?php if($Noticia->verificarlike($noticia->id_noticia,$_SESSION['id_usuario']) == 0){ echo 'btn-outline-success'; }else{ echo 'btn-success'; }; ?>"><i class="fa-solid fa-thumbs-up"></i></button>
                <?php if($_SESSION['nv_acesso'] > 2 AND $_SESSION['nv_acesso'] != 4){ ?><a href="../editar-noticia.php?id=<?php echo $noticia->id_noticia ?>" class="btn btn-secondary"><i class="fa-solid fa-gear"></i></a><?php } ?>
              </form>
              <br><span class="autor">Escrita Por > <?php echo $Usuario->mostrar($noticia->id_usuario)->nome ?></span> <br> <span class="mensagem">(!) Essa Notícia não representa a visão do WideConnections, apenas do Autor Dela.</span>
            </p>
          </div>
        </div>
        <div class="row mb-3 tablet">
          <div class="col-8 offset-2 mb-2">
            <a <?php if($noticia->conteudo != ''){ echo 'href="../noticia.php?id='.$noticia->id_noticia.'"'; }else{ if($noticia->link != ''){ echo 'href="'.$noticia->link.'"target="_blank"'; } }?>><img src="../imagens/<?php echo $noticia->capa ?>" alt="capa da noticia"></a>
          </div>
          <div class="col-12">
            <span>Em <a class="text-primary" href="<?php echo 'categoria.php?id='.$noticia->id_subcategoria; ?>"><?php echo $Noticia->mostrarsubcategoria($noticia->id_subcategoria)->subcategoria ?></a></span> - <?php echo '( '.$Cidade->mostrar($noticia->id_cidade)->cidade.' )'; ?>
            <h4 class="titulo"><a <?php if($noticia->conteudo != ''){ echo 'href="../noticia.php?id='.$noticia->id_noticia.'"'; }else{ if($noticia->link != ''){ echo 'href="'.$noticia->link.'"target="_blank"'; } }?>" class="titulo"><?php echo $noticia->titulo; ?></a></h4>
            <p>
              <p class="text-secondary"><?php echo Helper::data($noticia->created_at) ?></p>
              <form action="?" method="get">
                <input type="hidden" name="id_noticia" id="id_noticia" value="<?php echo $noticia->id_noticia ?>">
                <button type="submit" name="btnCurtir" id="btnCurtir" class="btn <?php if($Noticia->verificarlike($noticia->id_noticia,$_SESSION['id_usuario']) == 0){ echo 'btn-outline-success'; }else{ echo 'btn-success'; }; ?>"><i class="fa-solid fa-thumbs-up"></i></button>
                <?php if($_SESSION['nv_acesso'] > 2 AND $_SESSION['nv_acesso'] != 4){ ?><a href="../editar-noticia.php?id=<?php echo $noticia->id_noticia ?>" class="btn btn-secondary"><i class="fa-solid fa-gear"></i></a><?php } ?>
              </form>
              <br><span class="autor">Escrita Por > <?php echo $Usuario->mostrar($noticia->id_usuario)->nome ?></span> <br> <span class="mensagem">(!) Essa Notícia não representa a visão do WideConnections, apenas do Autor Dela.</span>
            </p>
          </div>
        </div>
      </div>
      <hr>
    <?php } ?>
      </div>
    </div>

  <br>

  <h5 class="text-center mt-3 mb-2">Seu Estado</h5>
    <div class="col-10 offset-1 pc">
      <div class="row">
        <hr> 
    <?php foreach($Noticia->listarnoticiasestadoescolar($_SESSION['id_usuario'], $cat->id_subcategoria) as $noticia){ ?>
      <div class="col-12 noticia">
        <div class="row mb-3 hd">
          <div class="col-6">
            <a <?php if($noticia->conteudo != ''){ echo 'href="../noticia.php?id='.$noticia->id_noticia.'"'; }else{ if($noticia->link != ''){ echo 'href="'.$noticia->link.'"target="_blank"'; } }?>><img src="../imagens/<?php echo $noticia->capa ?>" alt="capa da noticia"></a>
          </div>
          <div class="col-6">
            <span>Em <a class="text-primary" href="<?php echo 'categoria.php?id='.$noticia->id_subcategoria; ?>"><?php echo $Noticia->mostrarsubcategoria($noticia->id_subcategoria)->subcategoria ?></a></span> - <?php echo '( '.$Estado->mostrar($noticia->id_estado)->estado.' )'; ?>
            <h4 class="titulo"><a <?php if($noticia->conteudo != ''){ echo 'href="../noticia.php?id='.$noticia->id_noticia.'"'; }else{ if($noticia->link != ''){ echo 'href="'.$noticia->link.'"target="_blank"'; } }?>" class="titulo"><?php echo $noticia->titulo; ?></a></h4>
            <p>
              <?php $desc =substr($noticia->titulo,0,250).'...'; echo $desc ?>
              <br>
              <p class="text-secondary"><?php echo Helper::data($noticia->created_at) ?></p>
              <form action="?" method="get">
                <input type="hidden" name="id_noticia" id="id_noticia" value="<?php echo $noticia->id_noticia ?>">
                <button type="submit" name="btnCurtir" id="btnCurtir" class="btn <?php if($Noticia->verificarlike($noticia->id_noticia,$_SESSION['id_usuario']) == 0){ echo 'btn-outline-success'; }else{ echo 'btn-success'; }; ?>"><i class="fa-solid fa-thumbs-up"></i></button>
                <?php if($_SESSION['nv_acesso'] > 2 AND $_SESSION['nv_acesso'] != 4){ ?><a href="../editar-noticia.php?id=<?php echo $noticia->id_noticia ?>" class="btn btn-secondary"><i class="fa-solid fa-gear"></i></a><?php } ?>
              </form>
              <br><span class="autor">Escrita Por > <?php echo $Usuario->mostrar($noticia->id_usuario)->nome ?></span> <br> <span class="mensagem">(!) Essa Notícia não representa a visão do WideConnections, apenas do Autor Dela.</span>
            </p>
          </div>
        </div>
        <div class="row mb-3 fhd">
          <div class="col-5">
            <a <?php if($noticia->conteudo != ''){ echo 'href="../noticia.php?id='.$noticia->id_noticia.'"'; }else{ if($noticia->link != ''){ echo 'href="'.$noticia->link.'"target="_blank"'; } }?>><img src="../imagens/<?php echo $noticia->capa ?>" alt="capa da noticia"></a>
          </div>
          <div class="col-7">
            <span>Em <a class="text-primary" href="<?php echo 'categoria.php?id='.$noticia->id_subcategoria; ?>"><?php echo $Noticia->mostrarsubcategoria($noticia->id_subcategoria)->subcategoria ?></a></span> - <?php echo '( '.$Estado->mostrar($noticia->id_estado)->estado.' )'; ?>
            <h4 class="titulo"><a <?php if($noticia->conteudo != ''){ echo 'href="../noticia.php?id='.$noticia->id_noticia.'"'; }else{ if($noticia->link != ''){ echo 'href="'.$noticia->link.'"target="_blank"'; } }?>" class="titulo"><?php echo $noticia->titulo; ?></a></h4>
            <p>
              <?php $desc =substr($noticia->titulo,0,250).'...'; echo $desc ?>
              <br>
              <p class="text-secondary"><?php echo Helper::data($noticia->created_at) ?></p>
              <form action="?" method="get">
                <input type="hidden" name="id_noticia" id="id_noticia" value="<?php echo $noticia->id_noticia ?>">
                <button type="submit" name="btnCurtir" id="btnCurtir" class="btn <?php if($Noticia->verificarlike($noticia->id_noticia,$_SESSION['id_usuario']) == 0){ echo 'btn-outline-success'; }else{ echo 'btn-success'; }; ?>"><i class="fa-solid fa-thumbs-up"></i></button>
                <?php if($_SESSION['nv_acesso'] > 2 AND $_SESSION['nv_acesso'] != 4){ ?><a href="../editar-noticia.php?id=<?php echo $noticia->id_noticia ?>" class="btn btn-secondary"><i class="fa-solid fa-gear"></i></a><?php } ?>
              </form>
              <br><span class="autor">Escrita Por > <?php echo $Usuario->mostrar($noticia->id_usuario)->nome ?></span> <br> <span class="mensagem">(!) Essa Notícia não representa a visão do WideConnections, apenas do Autor Dela.</span>
            </p>
          </div>
        </div>
        <div class="row mb-3 clr">
          <div class="col-8 mb-2">
            <a <?php if($noticia->conteudo != ''){ echo 'href="../noticia.php?id='.$noticia->id_noticia.'"'; }else{ if($noticia->link != ''){ echo 'href="'.$noticia->link.'"target="_blank"'; } }?>><img src="../imagens/<?php echo $noticia->capa ?>" alt="capa da noticia"></a>
          </div>
          <div class="col-12">
            <span>Em <a class="text-primary" href="<?php echo 'categoria.php?id='.$noticia->id_subcategoria; ?>"><?php echo $Noticia->mostrarsubcategoria($noticia->id_subcategoria)->subcategoria ?></a></span> - <?php echo '( '.$Estado->mostrar($noticia->id_estado)->estado.' )'; ?>
            <h4 class="titulo"><a <?php if($noticia->conteudo != ''){ echo 'href="../noticia.php?id='.$noticia->id_noticia.'"'; }else{ if($noticia->link != ''){ echo 'href="'.$noticia->link.'"target="_blank"'; } }?>" class="titulo"><?php echo $noticia->titulo; ?></a></h4>
            <p>
              <p class="text-secondary"><?php echo Helper::data($noticia->created_at) ?></p>
              <form action="?" method="get">
                <input type="hidden" name="id_noticia" id="id_noticia" value="<?php echo $noticia->id_noticia ?>">
                <button type="submit" name="btnCurtir" id="btnCurtir" class="btn <?php if($Noticia->verificarlike($noticia->id_noticia,$_SESSION['id_usuario']) == 0){ echo 'btn-outline-success'; }else{ echo 'btn-success'; }; ?>"><i class="fa-solid fa-thumbs-up"></i></button>
                <?php if($_SESSION['nv_acesso'] > 2 AND $_SESSION['nv_acesso'] != 4){ ?><a href="../editar-noticia.php?id=<?php echo $noticia->id_noticia ?>" class="btn btn-secondary"><i class="fa-solid fa-gear"></i></a><?php } ?>
              </form>
              <br><span class="autor">Escrita Por > <?php echo $Usuario->mostrar($noticia->id_usuario)->nome ?></span> <br> <span class="mensagem">(!) Essa Notícia não representa a visão do WideConnections, apenas do Autor Dela.</span>
            </p>
          </div>
        </div>
        <div class="row mb-3 tablet">
          <div class="col-8 offset-2 mb-2">
            <a <?php if($noticia->conteudo != ''){ echo 'href="../noticia.php?id='.$noticia->id_noticia.'"'; }else{ if($noticia->link != ''){ echo 'href="'.$noticia->link.'"target="_blank"'; } }?>><img src="../imagens/<?php echo $noticia->capa ?>" alt="capa da noticia"></a>
          </div>
          <div class="col-12">
            <span>Em <a class="text-primary" href="<?php echo 'categoria.php?id='.$noticia->id_subcategoria; ?>"><?php echo $Noticia->mostrarsubcategoria($noticia->id_subcategoria)->subcategoria ?></a></span> - <?php echo '( '.$Estado->mostrar($noticia->id_estado)->estado.' )'; ?>
            <h4 class="titulo"><a <?php if($noticia->conteudo != ''){ echo 'href="../noticia.php?id='.$noticia->id_noticia.'"'; }else{ if($noticia->link != ''){ echo 'href="'.$noticia->link.'"target="_blank"'; } }?>" class="titulo"><?php echo $noticia->titulo; ?></a></h4>
            <p>
              <p class="text-secondary"><?php echo Helper::data($noticia->created_at) ?></p>
              <form action="?" method="get">
                <input type="hidden" name="id_noticia" id="id_noticia" value="<?php echo $noticia->id_noticia ?>">
                <button type="submit" name="btnCurtir" id="btnCurtir" class="btn <?php if($Noticia->verificarlike($noticia->id_noticia,$_SESSION['id_usuario']) == 0){ echo 'btn-outline-success'; }else{ echo 'btn-success'; }; ?>"><i class="fa-solid fa-thumbs-up"></i></button>
                <?php if($_SESSION['nv_acesso'] > 2 AND $_SESSION['nv_acesso'] != 4){ ?><a href="../editar-noticia.php?id=<?php echo $noticia->id_noticia ?>" class="btn btn-secondary"><i class="fa-solid fa-gear"></i></a><?php } ?>
              </form>
              <br><span class="autor">Escrita Por > <?php echo $Usuario->mostrar($noticia->id_usuario)->nome ?></span> <br> <span class="mensagem">(!) Essa Notícia não representa a visão do WideConnections, apenas do Autor Dela.</span>
            </p>
          </div>
        </div>
      </div>
      <hr>
    <?php } ?>
      </div>
    </div>
</div>

</div>  
  
</body>
</html>