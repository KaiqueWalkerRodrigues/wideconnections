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
        $Noticia = new Noticia();
        $Escola = new Escola();
        $Cidade = new Cidade();
        $Estado = new Estado();
        $Categoria = new Categoria();
        $Subcategoria = new Subcategoria();


        if (isset($_POST['btnEditar'])){
            $Noticia->editar($_POST);
            header('location:noticias.php');
        }

        if (isset($_POST['btnExcluir'])){
            $Noticia->excluir($_POST);
            header('location:noticias.php');
        }

        if (isset($_POST['btnExcExpiradas'])){
            $Noticia->excExpiradas();
            header('location:noticias.php');
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
            <li class="nav-item">
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

            <li class="nav-item active">
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
                    <h1 class="h3 mb-2 text-gray-800">Lista de Noticias</h1>
                    <p class="mb-4">Todos Noticias Cadastrados No Sistema</p>

                    <!-- DataTales -->
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary"><form action="?" method="POST"> Lista de Noticias &nbsp; |
                                    &nbsp; <a href="../cadastrar-noticia.php" target="_blank" class="btn btn-success">Cadastrar Nova Noticia</a> <?php if($_SESSION['nv_acesso'] > 4){ ?> &nbsp; |
                                    &nbsp; <button type="submit" name="btnExcExpiradas" id="btnExcExpiradas" class="btn btn-danger">Excluir Notícias Expiradas</button></form><?php } ?>
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Titulo</th>
                                                <th>Info</th>
                                                <th>Capa</th>
                                                <th>Escritor</th>
                                                <th>Categoria</th>
                                                <th>Cat&nbsp;Escolar</th>
                                                <th>Escola</th>
                                                <th>Serie</th>
                                                <th>Cidade</th>
                                                <th>Estado</th>
                                                <th>Expira Em</th>
                                                <th>Criado Em</th>
                                                <th>Editado Em</th>
                                                <th>Ações</th>
                                            </tr>
                                        </thead>
                                        <!-- <tfoot>
                                            <tr>
                                                <th>#</th>
                                                <th>Info</th>
                                                <th>Capa</th>
                                                <th>Escritor</th>
                                                <th>Categoria</th>
                                                <th>Escola</th>
                                                <th>Serie</th>
                                                <th>Cidade</th>
                                                <th>Estado</th>
                                                <th>Descrição e Conteudo</th>
                                                <th>Criado Em</th>
                                                <th>Editado Em</th>
                                                <th>Ações</th>
                                            </tr>
                                        </tfoot> -->
                                        <tbody>
                                        <?php if($_SESSION['nv_acesso'] > 4){foreach($Noticia->listar() as $noticia){ ?>
                                            <tr>
                                                <td><?php echo $noticia->id_noticia ?></td>
                                                <td><?php echo $noticia->titulo ?></td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#verconteudo" 
                                                        data-titulo="<?php echo $noticia->titulo ?>" 
                                                        data-descricao="<?php echo $noticia->descricao ?>" 
                                                        data-likes="<?php echo $Noticia->contarlikes($noticia->id_noticia); ?>"
                                                        data-views="<?php echo $Noticia->contarviews($noticia->id_noticia); ?>">
                                                        <i class="fa-solid fa-eye"></i>
                                                    </button>
                                                </td>
                                                <td class="text-center"><button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#vercapa" data-titulo="<?php echo $noticia->titulo ?>" data-capa="<?php echo $noticia->capa ?>"><i class="fa-solid fa-image"></i></button></td>
                                                <td><?php echo $Noticia->mostrarescritor($noticia->id_usuario)->nome; ?></td>
                                                <td><?php if($Categoria->verificarcategoria($noticia->id_categoria) > 0){ echo $Noticia->mostrarcategoria($noticia->id_categoria)->categoria; }else{echo '';}?></td>
                                                <td><?php if($Subcategoria->verificarcategoria($noticia->id_subcategoria) > 0){ echo $Noticia->mostrarsubcategoria($noticia->id_subcategoria)->subcategoria; }else{echo '';}?></td>
                                                <td><?php if($noticia->id_escola == 0){ echo ''; }else{ echo $Noticia->mostrarescola($noticia->id_escola)->escola; } ?></td>
                                                <td><?php if($noticia->serie > 0){ echo $noticia->serie.'° Ano'; } ?></td>
                                                <td><?php if($noticia->id_escola == 0){ if($noticia->id_cidade == 0){ echo ''; }else{ echo $Noticia->mostrarcidade($noticia->id_cidade)->cidade; }}else{ $noticia->id_cidade = $Escola->encontrarcidade($noticia->id_escola); echo $Noticia->mostrarcidade($noticia->id_cidade)->cidade; } ?></td>
                                                <td><?php if($noticia->id_cidade == 0){ if($noticia->id_estado == 0){ echo ''; }else{ echo $Noticia->mostrarestado($noticia->id_estado)->estado; }}else{ $id_estado = $Escola->encontrarestado($noticia->id_cidade); echo  $Noticia->mostrarestado($Escola->encontrarestado($id_estado))->estado; } ?></td>
                                                <td><?php if($noticia->tempodevida != '0000-00-00'){ echo Helper::diaBrasil($noticia->tempodevida); } ?></td>
                                                <td><?php echo Helper::dataBrasil($noticia->created_at); ?></td>
                                                <td><?php echo Helper::dataBrasil($noticia->updated_at); ?></td>
                                                <td class="text-center">
                                                    <a class="btn btn-secondary" href="../editar-noticia.php?id=<?php echo $noticia->id_noticia; ?>">
                                                        <i class="fa-solid fa-gear"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#excnoticia" 
                                                        data-id="<?php echo $noticia->id_noticia ?>" 
                                                        data-titulo="<?php echo $noticia->titulo ?>">
                                                        <i class="fa-regular fa-trash-can"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php }}else{ foreach($Noticia->listarpdiretor($_SESSION['id_usuario']) as $noticia){  ?>
                                            <tr>
                                                <td><?php echo $noticia->id_noticia ?></td>
                                                <td class="text-center"><?php if($noticia->status === '1'){echo '<b class="text-success">On</b>'; }else{echo '<b class="text-danger">Off</b>'; } ?></td>
                                                <td><?php echo $noticia->titulo ?></td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#verconteudo" 
                                                        data-titulo="<?php echo $noticia->titulo ?>" 
                                                        data-descricao="<?php echo $noticia->descricao ?>" 
                                                        data-likes="<?php echo $Noticia->contarlikes($noticia->id_noticia); ?>"
                                                        data-views="<?php echo $Noticia->contarviews($noticia->id_noticia); ?>">
                                                        <i class="fa-solid fa-eye"></i>
                                                    </button>
                                                </td>
                                                <td class="text-center"><button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#vercapa" data-titulo="<?php echo $noticia->titulo ?>" data-capa="<?php echo $noticia->capa ?>"><i class="fa-solid fa-image"></i></button></td>
                                                <td><?php echo $Noticia->mostrarescritor($noticia->id_usuario)->nome; ?></td>
                                                <td><?php if($Categoria->verificarcategoria($noticia->id_categoria) > 0){ echo $Noticia->mostrarcategoria($noticia->id_categoria)->categoria; }else{echo '<b class="text-danger">Error</b>';}?></td>
                                                <td><?php if($Subcategoria->verificarcategoria($noticia->id_subcategoria) > 0){ echo $Noticia->mostrarsubcategoria($noticia->id_subcategoria)->subcategoria; }else{echo '';}?></td>
                                                <td><?php if($noticia->id_escola == 0){ echo ''; }else{ echo $Noticia->mostrarescola($noticia->id_escola)->escola; } ?></td>
                                                <td><?php if($noticia->serie > 0){ echo $noticia->serie.'° Ano'; } ?></td>
                                                <td><?php if($noticia->id_escola == 0){ if($noticia->id_cidade == 0){ echo ''; }else{ echo $Noticia->mostrarcidade($noticia->id_cidade)->cidade; }}else{ $noticia->id_cidade = $Escola->encontrarcidade($noticia->id_escola); echo $Noticia->mostrarcidade($noticia->id_cidade)->cidade; } ?></td>
                                                <td><?php if($noticia->id_cidade == 0){ if($noticia->id_estado == 0){ echo ''; }else{ echo $Noticia->mostrarestado($noticia->id_estado)->estado; }}else{ $id_estado = $Escola->encontrarestado($noticia->id_cidade); echo  $Noticia->mostrarestado($Escola->encontrarestado($id_estado))->estado; } ?></td>
                                                <td><?php echo $noticia->tempodevida ?> dias</td>
                                                <td><?php echo Helper::dataBrasil($noticia->created_at); ?></td>
                                                <td><?php echo Helper::dataBrasil($noticia->updated_at); ?></td>
                                                <td class="text-center">
                                                    <a class="btn btn-secondary" href="../editar-noticia.php?id=<?php echo $noticia->id_noticia; ?>">
                                                        <i class="fa-solid fa-gear"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#excnoticia" 
                                                        data-id="<?php echo $noticia->id_noticia ?>" 
                                                        data-titulo="<?php echo $noticia->titulo ?>">
                                                        <i class="fa-regular fa-trash-can"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php }} ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    <!-- /DataTable -->

            <style>
                .capa{
                width: 300px;
                height: 168px;
                }
            </style>

            <!-- Modal Verconteudo -->
                <div class="modal fade" id="verconteudo" tabindex="-1" aria-labelledby="criarnoticiaLabel" aria-hidden="true">
                    <div class="modal-dialog">
                    <div class="modal-content">  
                        <div class="modal-header">
                            <h5 class="modal-title" id="verconteudoLabel"><h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                    <div class="modal-body">
                        <b>Descrição</b>
                        <p id="seedescricao"></p>
                    </div>
                        <div class="modal-footer">
                            <button class="btn btn-outline-info"><i class="fa-regular fa-thumbs-up"></i> <span id="seelikes"></span></button>
                            <button class="btn btn-outline-dark"><i class="fa-solid fa-eye"></i> <span id="seeviews"></span></button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        </div>
                    </div>
                    </div>
                </div>
            <!-- /Modal Verconteudo -->

            <!-- Modal VerCapa -->
                <div class="modal fade" id="vercapa" tabindex="-1" aria-labelledby="criarnoticiaLabel" aria-hidden="true">
                    <div class="modal-dialog">
                    <div class="modal-content">  
                        <div class="modal-header">
                            <h5 class="modal-title" id="vercapaLabel"><h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                    <div class="modal-body">
                        <div id="capa" class="text-center"></div>
                    </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        </div>
                    </div>
                    </div>
                </div>
            <!-- /Modal VerCapa -->

            <!-- Modal CriarNoticia -->
                <div class="modal fade" id="criarnoticia" tabindex="-1" aria-labelledby="criarnoticiaLabel" aria-hidden="true">
                    <br>
                    <br>
                    <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="?" method="post" enctype="multipart/form-data">
                            <div class="modal-header">
                            <h5 class="modal-title" id="criarnoticiaLabel">Cadastrar Nova Noticia<h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                    <div class="row">
                                        <input type="hidden" name="id_usuario" value="<?php echo $_SESSION['id_usuario'] ?>">
                                        <input type="hidden" name="status" value="1">
                                        <div class="col-md-12">
                                            <label for="titulo" class="form-label">Titulo *</label>
                                            <input type="text" class="form-control" name="titulo" maxlength="100">
                                        </div>
                                        <div class="col-md-12">
                                            <label for="id_categoria" class="form-label">Categoria *</label>
                                            <select name="id_categoria" id="id_categoria" class="form-control" required>
                                                <option value="">Escolha...</option>
                                                <?php 
                                                    foreach($Categoria->listar() as $categoria){
                                                ?>
                                                    <option value="<?php echo $categoria->id_categoria ?>"><?php echo $categoria->categoria ?></option>
                                                <?php       
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <hr>
                                        <div class="btn-group" role="group" aria-label="Basic outlined example">
                                            <button type="button" class="btn btn-outline-dark" id="none-select"><i class="fa-solid fa-users"></i></button>
                                            <button type="button" class="btn btn-outline-dark" id="escola-select"><i class="fa-solid fa-graduation-cap"></i></button>
                                            <button type="button" class="btn btn-outline-dark" id="cidade-select"><i class="fa-solid fa-map"></i></button>
                                            <button type="button" class="btn btn-outline-dark" id="estado-select"><i class="fa-solid fa-earth-americas"></i></button>
                                        </div>
                                        <div class="col-md-12 d-none" id="escola-criar">
                                            <label for="id_escola" class="form-label">Escola (#)</label>
                                            <select name="id_escola" id="id_escola" class="form-control">
                                                <option value="0">Escolha...</option>
                                                <?php foreach($Escola->listar() as $escola){ ?>
                                                    <option value="<?php echo $escola->id_escola ?>"><?php echo $escola->escola ?></option>
                                                <?php } ?>
                                            </select>
                                            <label for="serie" class="form-label">Serie *</label>
                                            <select name="serie" id="seriee" class="form-control">
                                                <option value="">Escolha...</option>
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
                                        <div class="col-md-12 d-none" id="cidade-criar">
                                            <label for="id_cidade" class="form-label">Cidade (#)</label>
                                            <select name="id_cidade" id="id_cidade" class="form-control">
                                                <option value="0">Escolha...</option>
                                                <?php foreach($Cidade->listar() as $cidade){ ?>
                                                    <option value="<?php echo $cidade->id_cidade ?>"><?php echo $cidade->cidade ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-12 d-none" id="estado-criar">
                                            <label for="id_estado" class="form-label">Estado (#)</label>
                                            <select name="id_estado" id="id_estado" class="form-control">
                                                <option value="0">Escolha...</option>
                                                <?php foreach($Estado->listar() as $estado){ ?>
                                                    <option value="<?php echo $estado->id_estado ?>"><?php echo $estado->estado ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <hr>
                                        <div class="col-md-12">
                                            <label for="capa">Capa *</label>
                                            <input type="file" name="capa" id="capa" class="form-control">
                                        </div>
                                        <div class="col-md-12">
                                            <label for="descricao" class="form-label">Descrição *</label>
                                            <textarea name="descricao" id="descricao" cols="30" rows="2" class="form-control" maxlength="100"></textarea>
                                        </div>
                                        <div class="col-md-12">
                                            <label for="conteudo" class="form-label">Conteudo *</label>
                                            <textarea name="conteudo" id="conteudo" cols="30" rows="5" class="form-control"></textarea>
                                        </div>
                                        <div class="col-md-12">
                                            <label for="tempodevida" class="form-label">Tempo de Vida * (Dias)</label>
                                            <input type="number" name="tempodevida" class="form-control">
                                        </div>
                                        <div class="col-md-12">
                                            <label for="link" class="form-label">Link</label>
                                            <input type="text" name="link" class="form-control">
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
            <!-- /Modal CriarNoticia -->

            <!-- Modal ConfNoticia -->
                <div class="modal fade" id="confnoticia" tabindex="-1" aria-labelledby="confnoticiaLabel" aria-hidden="true">
                    <br>
                    <br>
                    <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="?" method="post" id="editarnoticia" enctype="multipart/form-data">
                            <div class="modal-header">
                            <h5 class="modal-title" id="confuserLabel">Editar: <span id="editanome"></span> <h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <input type="hidden" name="id_noticia" id="id_noticia" value="">
                                    <input type="hidden" name="id_usuario" value="<?php echo $_SESSION['id_usuario'] ?>">
                                    <input type="hidden" name="capa_atual" id="capa_atual">
                                    <div class="col-md-12">
                                        <label for="titulo" class="form-label">Titulo *</label>
                                        <input type="text" class="form-control" name="titulo" id="noticiatitulo" maxlength="60">
                                    </div>
                                    <div class="col-md-12">
                                        <label for="status" class="form-label">Status *</label>
                                        <select name="status" id="status" class="form-control">
                                            <option value="" id="noticiastatus"></option>
                                            <option value="1" id="on">Online</option>
                                            <option value="0" id="off">Offline</option>
                                        </select>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="id_categoria" class="form-label">Categoria *</label>
                                        <select name="id_categoria" id="id_categoria" class="form-control" required>
                                            <option value="" id="categoria"></option>
                                            <?php 
                                                    foreach($Categoria->listar() as $categoria){
                                                ?>
                                                    <option value="<?php echo $categoria->id_categoria ?>"><?php echo $categoria->categoria ?></option>
                                                <?php       
                                                    }
                                                ?>
                                        </select>
                                    </div>
                                    <!--
                                    <div class="col-md-12">
                                        <label for="id_escola" class="form-label">Escola *</label>
                                        <select name="id_escola" id="id_escola" class="form-control">
                                            <option value="" id="escola"></option>
                                            <?php foreach($Escola->listar() as $escola){ ?>
                                                <option value="<?php echo $escola->id_escola ?>"><?php echo $escola->escola ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="id_cidade" class="form-label">Cidade *</label>
                                        <select name="id_cidade" id="id_cidade" class="form-control">
                                            <option value="" id="cidade"></option>
                                            <?php foreach($Cidade->listar() as $cidade){ ?>
                                                <option value="<?php echo $cidade->id_cidade ?>"><?php echo $cidade->cidade ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="id_estado" class="form-label">Estado *</label>
                                        <select name="id_estado" id="id_estado" class="form-control">
                                            <option value="" id="estado"></option>
                                            <?php foreach($Estado->listar() as $estado){ ?>
                                                <option value="<?php echo $estado->id_estado ?>"><?php echo $estado->estado ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    -->
                                    <!-- <div class="col-md-12">
                                        <label for="capa_nova">Nova Capa</label>
                                        <input type="file" name="capa_nova" id="capa_nova" class="form-control">
                                    </div> -->
                                    <div class="col-md-12">
                                        <label for="descricao" class="form-label">Descrição *</label>
                                        <textarea name="descricao" id="confdescricao" cols="30" rows="2" class="form-control" maxlength="80"></textarea>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="serie" class="form-label">Serie *</label>
                                        <select name="serie" id="confserie" class="form-control">
                                            <option value="" id="serie"></option>
                                            <option value="0">Todas</option>
                                            <option value="6">6°</option>
                                            <option value="7">7°</option>
                                            <option value="8">8°</option>
                                            <option value="9">9°</option>
                                            <option value="1">1°</option>
                                            <option value="2">2°</option>
                                            <option value="3">3°</option>
                                        </select>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="tempodevida" class="form-label">Tempo de Vida * (Dias)</label>
                                        <input type="number" name="tempodevida" id="tempodevida" class="form-control">
                                    </div>
                                    <div class="col-md-12">
                                        <label for="link" class="form-label">Link</label>
                                        <input type="text" name="link" id="link" class="form-control">
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
            <!-- /Modal ConfNoticia -->

            <!-- Modal ExcNoticia -->
                <div class="modal fade" id="excnoticia" tabindex="-1" aria-labelledby="excnoticiaLabel" aria-hidden="true">
                    <br>
                    <br>
                    <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="?" method="post" id="excnoticia">
                            <div class="modal-header">
                            <h5 class="modal-title" id="excnoticiaLabel">Excluir: <span id="excnoticianome"></span> <h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                    <div class="row">
                                        <input type="hidden" id="idexc" name="id">
                                        <b>Deseja Realmente Excluir essa Noticia?</b>
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
            <!-- /Modal ExcNoticia -->

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
        // Botões
            $('#none-select').click(function (e) { 
                $('#escola-criar').addClass('d-none')
                $('#cidade-criar').addClass('d-none')
                $('#estado-criar').addClass('d-none')

                $('#id_escola').val(0)
                $('#seriee').val('')
                $('#id_cidade').val(0)
                $('#id_estado').val(0)
            });
            $('#escola-select').click(function (e) { 
                $('#escola-criar').removeClass('d-none')
                $('#cidade-criar').addClass('d-none')
                $('#estado-criar').addClass('d-none')

                
                $('#id_cidade').val(0)
                $('#id_estado').val(0)
            });
            $('#cidade-select').click(function (e) { 
                $('#escola-criar').addClass('d-none')
                $('#cidade-criar').removeClass('d-none')
                $('#estado-criar').addClass('d-none')

                $('#id_escola').val(0)
                $('#seriee').val('')
                $('#id_estado').val(0)
            });
            $('#estado-select').click(function (e) { 
                $('#escola-criar').addClass('d-none')
                $('#cidade-criar').addClass('d-none')
                $('#estado-criar').removeClass('d-none')

                $('#id_escola').val(0)
                $('#seriee').val('')
                $('#id_cidade').val(0)
            });
        // /Botões
        $('#verconteudo').on('show.bs.modal', function (event) {
            let button = $(event.relatedTarget)
            let titulo = button.data('titulo')
            let conteudo = button.data('conteudo')
            let descricao = button.data('descricao')
            let likes = button.data('likes')
            let views = button.data('views')

            $('#verconteudoLabel').text('Conteudo da Noticia: '+titulo)
            $('#seeconteudo').text(conteudo)
            $('#seedescricao').text(descricao)
            $('#seelikes').text(likes)
            $('#seeviews').text(views)
        })

        $('#vercapa').on('show.bs.modal', function (event) {
            let button = $(event.relatedTarget)
            let titulo = button.data('titulo')
            let capa = button.data('capa')

            $('#vercapaLabel').text('Capa da Noticia: '+titulo)
            $('#capa').empty()
            $('#capa').append('<img class="capa" src="../imagens/'+capa+'">')
        })

        $('#criarnoticia').on('show.bs.modal', function (event) {
            let button = $(event.relatedTarget)
        })

        $('#confnoticia').on('show.bs.modal', function (event) {
            let button = $(event.relatedTarget)
            let id = button.data('id')
            let titulo = button.data('titulo')
            let descricao = button.data('descricao')
            let conteudo = button.data('conteudo')
            let status = button.data('status')
            let cat = button.data('cat')
            let idcat = button.data('idcat')
            let escola = button.data('escola')
            let idescola = button.data('idescola')
            let cidade = button.data('cidade')
            let idcidade = button.data('idcidade')
            let estado = button.data('estado')
            let idestado = button.data('idestado')
            let serie = button.data('serie')
            let tdv = button.data('tdv')
            let link = button.data('link')
            let capa = button.data('capa')
            //
            $('#editanome').text(titulo)
            $('#id_noticia').val(id)
            $('#noticiatitulo').val(titulo)
            $('#confdescricao').text(descricao)
            $('#confconteudo').text(conteudo)
            $('#categoria').val(idcat)
            $('#categoria').text(cat)
            $('#escola').val(idescola)
            $('#escola').text(escola)
            $('#cidade').val(idcidade)
            $('#cidade').text(cidade)
            $('#estado').val(idestado)
            $('#estado').text(estado)
            $('#serie').val(serie)
            $('#serie').text(serie+'°')
            $('#tempodevida').val(tdv)
            $('#link').val(link)
            $('#capa_atual').val(capa)
            if(status == 1)
            {
                $('#noticiastatus').text('Online')
                $('#noticiastatus').val(1)
                $('#on').addClass('d-none')
            }
            else{
                $('#noticiastatus').text('Offline')
                $('#noticiastatus').val(0)
                $('#off').addClass('d-none')
            }
        })

        $('#excnoticia').on('show.bs.modal', function (event) {
            let button = $(event.relatedTarget)
            let titulo = button.data('titulo')
            let id = button.data('id')
            //
            $('#excnoticianome').text(titulo)
            $('#idexc').val(id)
        })
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