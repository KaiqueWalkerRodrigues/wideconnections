<?php
    include_once('inc/css.php');
    include_once('class.php');

    $Categoria = new Categoria();

    $Usuario = new Usuario();

    $usuario = $Usuario->mostrar($_GET['id']);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>WideConnections - Minha Conta</title>
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
              <?php } ?>
              <li><a class="dropdown-item" href="usuario.php?id=<?php echo $_SESSION['id_usuario']; ?>">Minha Conta</a></li>
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
          <div class="row col-6 offset-3"><a href="escolar/index.php" class="btn btn-primary">Área do Aluno</a></div>
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
        <div class="text-center">
            <h3><?php echo $_SESSION['usuario']; ?></h3>
        </div>
        <div class="col-8 offset-2">
            <hr>
            <div class="text-center"><a href="logout.php?tr" class="btn btn-primary">Trocar Senha</a></form></div>
            <hr>
        </div>
    </div>

</body>
</html>