<?php
    include_once('inc/css.php');
    include_once('class.php');

    $Noticia = new Noticia();
    $Categoria = new Categoria();

    $id = $_GET['id'];

    $Noticia->visualizar($_SESSION['id_usuario'],$id);

    $noticia= $Noticia->mostrar($id);

    ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>WideConnections - <?php echo $noticia->titulo ?></title>
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
            <div class="row col-6 offset-3"><a href="escolar/" class="btn btn-primary">Área do Aluno</a></div>
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
    
  <div class="container">
    <div class="col-md-8 offset-md-2">
      <h1 class="mb-4 mt-3 text-start fw-bold"><i><?php echo $noticia->titulo ?></i></h1>
      <p><?php echo $noticia->descricao ?></p>
      <p class="by">Escrita Por - <?php echo $Noticia->mostrarescritor($noticia->id_usuario)->nome; ?> - Em <a class="text-primary" <?php if($noticia->id_escola == 0 AND $noticia->id_cidade == 0 AND $noticia->id_estado == 0){ ?> href="categoria.php?id=<?php echo $noticia->id_categoria;?>" <?php }else{ ?> href="escolar/categoria.php?id=<?php echo $noticia->id_subcategoria; ?>"> <?php } if($noticia->id_escola == 0 AND $noticia->id_cidade == 0 AND $noticia->id_estado == 0){echo $Noticia->mostrarcategoria($noticia->id_categoria)->categoria;}else{echo $Noticia->mostrarsubcategoria($noticia->id_subcategoria)->subcategoria;} ?></a> <br> <?php echo Helper::dataBrasil($noticia->created_at) ?>
      </p>
      <hr>
      <div class="text-start"><?php echo $noticia->conteudo ?></div>
    </div>
  </div>

</body>
</html>