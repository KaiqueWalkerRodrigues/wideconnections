<?php 
    include_once('classadmin.php');
    include_once('../inc/cssadmin.php');
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>WideConnections - Admin</title>

    <!-- Custom fonts for this template -->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
        <?php 
        $Usuario = new Usuario();
        $Escola = new Escola();

        if (isset($_POST['btnCadastrar'])){
            $Usuario->cadastraradmin($_POST);
            header('location:usuarios.php');
        }
        if (isset($_POST['btnEditar'])){
            $Usuario->editar($_POST);
            header('location:usuarios.php');
        }

        if (isset($_POST['btnExcluir'])){
            $Usuario->excluir($_POST);
            header('location:usuarios.php');
        }

        if (isset($_POST['btnLimpar'])){
            $Usuario->limpar($_POST['senhalimpar']);
        }
        ?>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i>Wc</i>
                </div>
                <div class="sidebar-brand-text mx-3"></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Painel de Controle</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Interface
            </div>

            <!-- Nav Item - Tables -->
            <?php if($_SESSION['nv_acesso'] > 4){ ?>
            <li class="nav-item">
                <a class="nav-link" href="cidades.php">
                    <i class="fa-solid fa-map"></i>
                    <span>Cidades</span></a>
            </li>
            <?php } ?>
            <li class="nav-item">
                <a class="nav-link" href="escolas.php">
                    <i class="fa-solid fa-graduation-cap"></i>
                    <span>Escolas</span></a>
            </li>
            <?php if($_SESSION['nv_acesso'] > 4){ ?>
            <li class="nav-item">
                <a class="nav-link" href="estados.php">
                    <i class="fa-solid fa-earth-americas"></i>
                    <span>Estados</span></a>
            </li>
            <?php } ?>
            <li class="nav-item active">
                <a class="nav-link" href="usuarios.php">
                <i class="fa-solid fa-users"></i>
                    <span>Usuarios</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">
            <?php if($_SESSION['nv_acesso'] > 4){ ?>
            <li class="nav-item">
                <a class="nav-link" href="categorias.php">
                <i class="fa-solid fa-list"></i>
                    <span>Categorias</span></a>
            </li>
            <?php } ?>

            <li class="nav-item">
                <a class="nav-link" href="subcategorias.php">
                <i class="fa-solid fa-list"></i>
                <span>Categorias Escolares</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="noticias.php">
                <i class="fa-solid fa-newspaper"></i>
                    <span>Noticias</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <form class="form-inline">
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3" type="button">
                            <i class="fa fa-bars"></i>
                        </button>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $_SESSION['usuario'] ?></span>
                                <i class="fa-solid fa-user"></i>
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="../index.php">
                                    <i class="bi bi-newspaper"></i>
                                    Jornal
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Configurações
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="../logout.php">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Sair
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Lista de Usuários</h1>
                    <p class="mb-4">Todos Usuários Cadastrados No Sistema</p>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Lista de Usuarios &nbsp; | &nbsp; 
                            <button type="button" class="btn btn-dark btn-sm" data-bs-toggle="modal" data-bs-target="#criaruser">Cadastrar Novo Usuario</button><?php if(isset($_GET['e'])){ echo '<div class="text-center"><span class="alert alert-danger">Erro ao enviar email ao usuario!</span></div>';}?><?php if(isset($_GET['a'])){ echo '<div class="text-center"><span class="alert alert-warning">Confirme o email cadastrado.</span></div>';}?> <?php if($_SESSION['nv_acesso'] > 4){ ?> &nbsp; | &nbsp;
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#limparbanco">Limpar Banco</button><?php }; ?>
                        </h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                            <?php if(isset($_GET['limpasucess'])){ ?>
                                <div id="alertsuccess" class="alert alert-success col-3">Sucesso ao Limpar o banco <button type="button" class="btn-close" id="fecharaviso"></button></div>
                            <?php } ?>
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                        <th>#</th>
                                            <th>Nome</th>
                                            <th>Email</th>
                                            <th>Escola</th>
                                            <th>Cidade</th>
                                            <th>Estado</th>
                                            <th>Série</th>
                                            <th>Cargo</th>
                                            <th>Auth</th>
                                            <th>Criado Em</th>
                                            <th>Editado Em</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <!-- <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Nome</th>
                                            <th>Email</th>
                                            <th>Escola</th>
                                            <th>Cidade</th>
                                            <th>Estado</th>
                                            <th>Série</th>
                                            <th>Cargo</th>
                                            <th>Auth</th>
                                            <th>Criado Em</th>
                                            <th>Editado Em</th>
                                            <th>Ações</th>
                                        </tr>
                                    </tfoot> -->
                                    <tbody>
                                        <?php if($_SESSION['nv_acesso'] > 4){ 
                                            foreach($Usuario->listar() as $usuario){ 
                                            if($usuario->nv_acesso < 5 AND $usuario->nv_acesso != 3){
                                                $id_cidade = $Usuario->encontrarcidade($usuario->id_escola);
                                                $id_estado = $Usuario->encontrarestado($id_cidade);
                                            }
                                        ?>
                                        <tr>
                                            <td><?php echo $usuario->id_usuario ?></td>
                                            <td><?php echo $usuario->nome ?></td>
                                            <td><?php echo $usuario->email ?></td>
                                            <td><?php if($usuario->nv_acesso > 4 OR $usuario->nv_acesso == 3){ echo ''; }else{ echo $Usuario->mostrarescola($usuario->id_escola)->escola;} ?></td>
                                            <td><?php if($usuario->nv_acesso > 4 OR $usuario->nv_acesso == 3){ echo ''; }else{ echo $Usuario->mostrarcidade($id_cidade)->cidade;} ?></td>
                                            <td><?php if($usuario->nv_acesso > 4 OR $usuario->nv_acesso == 3){ echo ''; }else{ echo $Usuario->mostrarestado($id_estado)->estado; } ?></td>
                                            <td><?php if($usuario->nv_acesso >= 2){ echo ''; }else{ echo $usuario->serie.'° Ano'; } ?></td>
                                            <td><?php switch ($usuario->nv_acesso) { case '1'; echo '<b class="text-dark">Aluno</b>'; break; case '2'; echo '<b class="text-primary">Professor</b>'; break; case '3'; echo '<b class="text-success">Jornalista</b>'; break; case '4'; echo '<b class="text-info">Direção</b>'; break; case '5'; echo '<b class="text-danger">Admin</b>'; break; } ?></td>
                                            <td class="text-center"><?php if($usuario->status == 1){echo '<p class="btn btn-outline-success"><i class="fa-solid fa-check"></i></p>';}else{echo '<p class="btn btn-outline-danger"><i class="fa-solid fa-x"></i></p>';} ?></td>
                                            <td><?php echo Helper::dataBrasil($usuario->created_at); ?></td>
                                            <td><?php echo Helper::dataBrasil($usuario->updated_at); ?></td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#confuser" data-id="<?php echo $usuario->id_usuario ?>" data-nome="<?php echo $usuario->nome ?>" data-email="<?php echo $usuario->email ?>" data-idescola="<?php echo $usuario->id_escola ?>" data-escola="<?php if($usuario->id_escola != 0){ echo $Usuario->mostrarescola($usuario->id_escola)->escola; }?>" data-serie="<?php echo $usuario->serie ?>" data-nv_acesso="<?php echo $usuario->nv_acesso ?>" data-cargo="<?php switch ($usuario->nv_acesso) { case '1'; echo 'Aluno'; break; case '2'; echo 'Professor'; break; case '3'; echo 'Jornalista'; break; case '4'; echo 'Direção'; break; case '5'; echo 'Admin'; break; } ?>" data-url=""><i class="fa-solid fa-gear"></i></button>
                                                <?php if($usuario->id_usuario == $_SESSION['id_usuario']){}else{ ?>
                                                <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#excuser" data-id="<?php echo $usuario->id_usuario ?>" data-nome="<?php echo $usuario->nome ?>"><i class="fa-regular fa-trash-can"></i></button>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <?php }}else{ foreach($Usuario->listarpdiretor($_SESSION['id_usuario']) as $usuario){ 
                                                if($usuario->nv_acesso < 5 AND $usuario->nv_acesso != 3){
                                                $id_cidade = $Usuario->encontrarcidade($usuario->id_escola);
                                                $id_estado = $Usuario->encontrarestado($id_cidade);
                                            } ?>
                                            <tr>
                                                <td><?php echo $usuario->id_usuario ?></td>
                                                <td><?php echo $usuario->nome ?></td>
                                                <td><?php echo $usuario->email ?></td>
                                                <td><?php if($usuario->nv_acesso > 4 OR $usuario->nv_acesso == 3){ echo ''; }else{ echo $Usuario->mostrarescola($usuario->id_escola)->escola;} ?></td>
                                                <td><?php if($usuario->nv_acesso > 4 OR $usuario->nv_acesso == 3){ echo ''; }else{ echo $Usuario->mostrarcidade($id_cidade)->cidade;} ?></td>
                                                <td><?php if($usuario->nv_acesso > 4 OR $usuario->nv_acesso == 3){ echo ''; }else{ echo $Usuario->mostrarestado($id_estado)->estado; } ?></td>
                                                <td><?php if($usuario->nv_acesso >= 2){ echo ''; }else{ echo $usuario->serie.'° Ano'; } ?></td>
                                                <td><?php switch ($usuario->nv_acesso) { case '1'; echo '<b class="text-dark">Aluno</b>'; break; case '2'; echo '<b class="text-primary">Professor</b>'; break; case '3'; echo '<b class="text-success">Jornalista</b>'; break; case '4'; echo '<b class="text-info">Direção</b>'; break; case '5'; echo '<b class="text-danger">Admin</b>'; break; } ?></td>
                                                <td class="text-center"><?php if($usuario->status == 1){echo '<p class="btn btn-outline-success"><i class="fa-solid fa-check"></i></p>';}else{echo '<p class="btn btn-outline-danger"><i class="fa-solid fa-x"></i></p>';} ?></td>
                                                <td><?php echo Helper::dataBrasil($usuario->created_at); ?></td>
                                                <td><?php echo Helper::dataBrasil($usuario->updated_at); ?></td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#confuser" data-id="<?php echo $usuario->id_usuario ?>" data-nome="<?php echo $usuario->nome ?>" data-email="<?php echo $usuario->email ?>" data-idescola="<?php echo $usuario->id_escola ?>" data-escola="<?php if($usuario->id_escola != 0){ echo $Usuario->mostrarescola($usuario->id_escola)->escola; }?>" data-serie="<?php echo $usuario->serie ?>" data-nv_acesso="<?php echo $usuario->nv_acesso ?>" data-cargo="<?php switch ($usuario->nv_acesso) { case '1'; echo 'Aluno'; break; case '2'; echo 'Professor'; break; case '3'; echo 'Jornalista'; break; case '4'; echo 'Direção'; break; case '5'; echo 'Admin'; break; } ?>" data-url=""><i class="fa-solid fa-gear"></i></button>
                                                    <?php if($usuario->id_usuario == $_SESSION['id_usuario']){}else{ ?>
                                                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#excuser" data-id="<?php echo $usuario->id_usuario ?>" data-nome="<?php echo $usuario->nome ?>"><i class="fa-regular fa-trash-can"></i></button>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                        <?php }} ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
            <!-- Modal LimparBanco -->
            <div class="modal fade" id="limparbanco" tabindex="-1" aria-labelledby="excLabel" aria-hidden="true">
                <br>
                <br>
                <div class="modal-dialog">
                <div class="modal-content">
                    <form action="?" method="post" id="excusuario">
                        <div class="modal-header">
                            <h5 class="modal-title" id="excuserLabel">Limpar Alunos, Professores e Jornalistas?<h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <label for="senhalimpar" class="form-label">Senha para Limpar:</label>
                            <input type="text" name="senhalimpar" id="senhalimpar" class="form-control">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-success" name="btnLimpar" id="btnLimpar">Limpar</button>
                        </div>
                    </form>
                </div>
                </div>
            </div>                   

            <!-- Modal CriarUser -->
            <div class="modal fade" id="criaruser" tabindex="-1" aria-labelledby="criaruserLabel" aria-hidden="true">
                <br>
                <br>
                <div class="modal-dialog">
                <div class="modal-content">
                    <form action="?" method="post">
                        <div class="modal-header">
                        <h5 class="modal-title" id="criaruserLabel">Cadastrar Novo Usuario<h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                                <div id="alert" class="alert alert-danger d-none"></div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="nome" class="form-label">Nome do Usuario *</label>
                                        <input type="text" class="form-control" name="nome" id="nome" required>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="email" class="form-label">Email *</label>
                                        <input type="text" class="form-control" id="email" name="email" required>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="senha" class="form-label">Senha *</label>
                                        <input type="password" class="form-control" id="senha" name="senha" minlength="6" maxlength="12" required>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="confirmasenha" class="form-label">Confirma Senha *</label>
                                        <input type="password" class="form-control" id="confirmasenha" minlength="6" maxlength="12" required>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="id_escola" class="form-label">Escola *</label>
                                        <select name="id_escola" id="id_escola" class="form-control">
                                            <option value="">Escolha...</option>
                                            <?php if($_SESSION['nv_acesso'] > 4){ foreach($Escola->listar() as $escola){ ?>
                                                <option value="<?php echo $escola->id_escola ?>"><?php echo $escola->escola ?></option>
                                            <?php }}else{ ?>
                                            <?php foreach($Escola->listarpdiretor($_SESSION['id_usuario']) as $escola){ ?>
                                                <option value="<?php echo $escola->id_escola ?>"><?php echo $escola->escola ?></option>
                                            <?php }} ?>
                                        </select>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="serie" class="form-label">Série (°) *</label>
                                        <select name="serie" id="serie" class="form-control">
                                        <option value="" default="default">Escolha...</option>
                                            <option value="6">6° Ano</option>
                                            <option value="7">7° Ano</option>
                                            <option value="8">8° Ano</option>
                                            <option value="9">9° Ano</option>
                                            <option value="1">1° Ano</option>
                                            <option value="2">2° Ano</option>
                                            <option value="3">3° Ano</option>
                                        </select>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="nv_acesso" class="form-label">Nível de Acesso *</label>
                                        <select name="nv_acesso" id="nv_acesso" class="form-control" required>
                                            <option value="">Escolha...</option>
                                            <option value="1">Aluno</option>
                                            <option value="2">Professor</option>
                                            <?php if($_SESSION['nv_acesso'] > 4){ ?>
                                                <option value="3">Jornalista</option>
                                                <option value="4">Direção</option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            <br>    
                        </div>  
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-success" name="btnCadastrar" id="btnCadastrar">Cadastrar</button>
                        </div>
                    </form>
                </div>
                </div>
            </div>

            <!-- Modal ConfUser -->
            <div class="modal fade" id="confuser" tabindex="-1" aria-labelledby="confuserLabel" aria-hidden="true">
                <br>
                <br>
                <div class="modal-dialog">
                <div class="modal-content">
                    <form action="?" method="post" id="editarusuario">
                        <div class="modal-header">
                        <h5 class="modal-title" id="confuserLabel">Editar: <span id="editanome"></span> <h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                                <div id="alertform" class="alert alert-danger d-none"></div>
                                <div class="row">
                                        <input type="hidden" id="idform" name="id_usuario">
                                    <div class="col-md-12">
                                        <label for="nome" class="form-label">Nome</label>
                                        <input type="text" class="form-control" id="nomeform" name="nome">
                                    </div>
                                    <div class="col-md-12">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="text" class="form-control" id="emailform" name="email">
                                    </div>
                                    <div class="col-md-12">
                                        <label for="senha" class="form-label">Senha</label>
                                        <input type="password" class="form-control" id="senhaform" minlength="6" maxlength="12" name="senha">
                                    </div>
                                    <div class="col-md-12">
                                        <label for="confirmasenha" class="form-label">Confirma Senha *</label>
                                        <input type="password" class="form-control" id="confirmasenhaform" minlength="6" maxlength="12">
                                    </div>
                                    <div class="col-md-12">
                                        <label for="serie" class="form-label">Série (°)</label>
                                        <input type="number" class="form-control" id="serieform" name="serie">
                                    </div>
                                    <div class="col-md-12">
                                        <label for="nv_acesso" class="form-label">Nível de Acesso</label>
                                        <select name="nv_acesso" id="nv_acesso" class="form-control">
                                            <option value="" id="nv"></option>
                                            <option value="2" id="nv2">Professor</option>
                                            <?php if($_SESSION['nv_acesso'] > 4){ ?>
                                            <option value="3" id="nv3">Jornalista</option>
                                            <option value="4" id="nv4">Direção</option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            <br>    
                        </div>  
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-success" name="btnEditar" id="btnEditar">Editar</button>
                        </div>
                    </form>
                </div>
                </div>
            </div>

            <!-- Modal ExcUser -->
            <div class="modal fade" id="excuser" tabindex="-1" aria-labelledby="excuserLabel" aria-hidden="true">
                <br>
                <br>
                <div class="modal-dialog">
                <div class="modal-content">
                    <form action="?" method="post" id="excusuario">
                        <div class="modal-header">
                        <h5 class="modal-title" id="excuserLabel">Excluir: <span id="excnome"></span> <h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                                <div class="row">
                                    <input type="hidden" id="idExc" name="id">
                                    <b>Deseja Realmente Excluir essa Conta?</b>
                                </div>
                        </div>  
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-danger" name="btnExcluir" id="btnExcluir">Excluir</button>
                        </div>
                    </form>
                </div>
                </div>
            </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; WideConnections 2022</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script>
        $('#fecharaviso').click(function (e) { 
            $('#alertsuccess').addClass('d-none')
        });
        $('#criaruser').on('show.bs.modal', function (event) {
            let button = $(event.relatedTarget)
        })

        $('#limparbanco').on('show.bs.modal', function (event) {
            let button = $(event.relatedTarget)
        })

        $('#confuser').on('show.bs.modal', function (event) {
            let button = $(event.relatedTarget)
            let id = button.data('id')
            let nome = button.data('nome')
            let email = button.data('email')
            let idescola = button.data('idescola')
            let escola = button.data('escola')
            let serie = button.data('serie')
            let cargo = button.data('cargo')
            let nv_acesso = button.data('nv_acesso')
            let url = button.data('url')
            // console.log(url)
            $('#editanome').empty()
            $('#editanome').append(nome)
            $('#idform').val(id)
            $('#nomeform').val(nome)
            $('#emailform').val(email)
            $('#escolaant').text(escola)
            $('#escolaant').val(idescola)
            $('#serieform').val(serie)
            $('#nv').text(cargo)
            $('#nv').val(nv_acesso)
        })
        
        $('#excuser').on('show.bs.modal', function (event) {
            let button = $(event.relatedTarget)
            let nome = button.data('nome')
            let id = button.data('id')
            let url = button.data('url')
            console.log(id)
            // console.log(url)
            $('#idExc').val(id)
            $('#excnome').empty()
            $('#excnome').append(nome)
        })

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

        $('#senhaform').keyup(function (e) { 
            e.preventDefault();
            
            let senha = $('#senhaform').val();
            let confsenha = $('#confirmasenhaform').val();
            
            if (senha == confsenha) {
                $('#btnEditar').removeClass('disabled');
                $('#alertform').addClass('d-none');
            }else{
                $('#btnEditar').addClass('disabled');
                $('#alertform').removeClass('d-none');
                $('#alertform').text('(!) As Senhas digitadas não coincidem, favor verifique');
            }
        });
        $('#confirmasenhaform').keyup(function (e) { 
            e.preventDefault();
            
            let senha = $('#senhaform').val();
            let confsenha = $('#confirmasenhaform').val();
            
            if (senha === confsenha) {
                $('#btnEditar').removeClass('disabled');
                $('#alertform').addClass('d-none');
            }else{
                $('#btnEditar').addClass('disabled');
                $('#alertform').removeClass('d-none');
                $('#alertform').text('(!) As Senhas digitadas não coincidem, favor verifique');
            }
        });
        </script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../js/demo/datatables-demo.js"></script>

</body>

</html>