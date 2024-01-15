<?php 
    include_once('classadmin.php');
    include_once('../inc/cssadmin.php');

    if($_SESSION['nv_acesso'] < 5){
        header('location:index.php');
    }
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
        $Estado = new Estado();

        if (isset($_POST['btnCadastrar'])){
            $Estado->cadastrar($_POST);
            header('location:estados.php');
        }

        if (isset($_POST['btnEditar'])){
            $Estado->editar($_POST);
            header('location:estados.php');
        }

        if (isset($_POST['btnExcluir'])){
            $Estado->excluir($_POST);
            header('location:estados.php');
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
            <li class="nav-item">
                <a class="nav-link" href="cidades.php">
                    <i class="fa-solid fa-map"></i>
                    <span>Cidades</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="escolas.php">
                    <i class="fa-solid fa-graduation-cap"></i>
                    <span>Escolas</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="estados.php">
                    <i class="fa-solid fa-earth-americas"></i>
                    <span>Estados</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="usuarios.php">
                <i class="fa-solid fa-users"></i>
                    <span>Usuarios</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <li class="nav-item">
                <a class="nav-link" href="categorias.php">
                <i class="fa-solid fa-list"></i>
                    <span>Categorias</span></a>
            </li>

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
                    <h1 class="h3 mb-2 text-gray-800">Lista de Estados</h1>
                    <p class="mb-4">Todos Estados Cadastrados No Sistema</p>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Lista de Estados &nbsp; | &nbsp; <button type="button" class="btn btn-dark btn-sm" data-bs-toggle="modal" data-bs-target="#criarestado">Cadastrar Novo Estado</button></h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <!-- <th>Status</th> -->
                                            <th>Estado</th>
                                            <th>UF</th>
                                            <th>Criado Em</th>
                                            <th>Editado Em</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <!-- <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Status</th>
                                            <th>Estado</th>
                                            <th>UF</th>
                                            <th>Criado Em</th>
                                            <th>Editado Em</th>
                                            <th>Ações</th>
                                        </tr>
                                    </tfoot> -->
                                    <tbody>
                                    <?php foreach($Estado->listar() as $estado){ ?>
                                        <tr>
                                            <td><?php echo $estado->id_estado ?></td>
                                            <!-- <td class="text-center"><?php // if($estado->status === '1'){echo '<b class="text-success">On</b>'; }else{echo '<b class="text-danger">Off</b>'; } ?></td> -->
                                            <td><?php echo $estado->estado ?></td>
                                            <td><?php echo $estado->uf ?></td>
                                            <td><?php echo Helper::dataBrasil($estado->created_at); ?></td>
                                            <td><?php echo Helper::dataBrasil($estado->updated_at); ?></td>
                                           <td class="text-center">
                                                <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#confestado" data-id="<?php echo $estado->id_estado ?>" data-estado="<?php echo $estado->estado ?>" data-uf="<?php echo $estado->uf ?>" data-status="<?php echo $estado->status ?>"><i class="fa-solid fa-gear"></i></button>
                                                <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#excestado" data-id="<?php echo $estado->id_estado ?>" data-estado="<?php echo $estado->estado ?>"><i class="fa-regular fa-trash-can"></i></button>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

            <!-- Modal CriarEstado -->
            <div class="modal fade" id="criarestado" tabindex="-1" aria-labelledby="criarestadoLabel" aria-hidden="true">
                <br>
                <br>
                <div class="modal-dialog">
                <div class="modal-content">
                    <form action="?" method="post">
                        <div class="modal-header">
                        <h5 class="modal-title" id="criarestadoLabel">Cadastrar Nova Escola<h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                                <div class="row">
                                    <input type="hidden" name="status" id="status" value="1">
                                    <div class="col-md-12">
                                        <label for="estado" class="form-label">Nome do Estado *</label>
                                        <input type="text" class="form-control" id="estadoform" name="estado" required>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="uf" class="form-label">UF *</label>
                                        <input type="text" class="form-control" id="ufform" name="uf" required>
                                    </div>
                                    <!-- <div class="col-md-12">
                                      <label for="status" class="form-label">Status *</label>
                                        <select class="form-control" name="status" id="statusform"> 
                                            <option value="1">Online</option>
                                            <option value="0">Offline</option>
                                        </select>  
                                    </div> -->
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

            <!-- Modal ConfEstado -->
            <div class="modal fade" id="confestado" tabindex="-1" aria-labelledby="confestadoLabel" aria-hidden="true">
                <br>
                <br>
                <div class="modal-dialog">
                <div class="modal-content">
                    <form action="?" method="post" id="editarestado">
                        <div class="modal-header">
                        <h5 class="modal-title" id="confuserLabel">Editar: <span id="editanome"></span> <h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                                <div class="row">
                                        <input type="hidden" name="id_estado" id="confestadoid">
                                        <input type="hidden" name="status" id="status" value="1">
                                    <div class="col-md-12">
                                        <label for="estado" class="form-label">Nome da Escola *</label>
                                        <input type="text" class="form-control" id="confestadonome" name="estado" required>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="uf" class="form-label">UF *</label>
                                        <input type="text" class="form-control" id="confestadouf" name="uf" required>
                                    </div>
                                    <!-- <div class="col-md-12">
                                        <label for="status" class="form-label">Status *</label>
                                        <select class="form-control" name="status"> 
                                            <option value="" id="confestadostatus"></option>
                                            <option value="1" id="on">Online</option>
                                            <option value="0" id="off">Offline</option>
                                        </select>
                                    </div> -->
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

            <!-- Modal ExcEstado -->
            <div class="modal fade" id="excestado" tabindex="-1" aria-labelledby="excuserLabel" aria-hidden="true">
                <br>
                <br>
                <div class="modal-dialog">
                <div class="modal-content">
                    <form action="?" method="post" id="excestado">
                        <div class="modal-header">
                        <h5 class="modal-title" id="excestadoLabel">Excluir: <span id="excestadonome"></span> <h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                                <div class="row">
                                    <input type="hidden" id="idexc" name="id">
                                    <b>Deseja Realmente Excluir esse Estado?</b>
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
    <<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script>
        $('#criarestado').on('show.bs.modal', function (event) {
            let button = $(event.relatedTarget)
        })

        $('#confestado').on('show.bs.modal', function (event) {
            let button = $(event.relatedTarget)
            let id = button.data('id')
            let estado = button.data('estado')
            let uf = button.data('uf')
            let status = button.data('status')
            //
            $('#editanome').text(estado)
            $('#confestadoid').val(id)
            $('#confestadonome').val(estado)
            $('#confestadouf').val(uf)
            if(status == 1)
            {
                $('#confestadostatus').text('Online')
                $('#confestadostatus').val(1)
                $('#on').addClass('d-none')
            }
            else{
                $('#confestadostatus').text('Offline')
                $('#confestadostatus').val(0)
                $('#off').addClass('d-none')
            }
        })

        $('#excestado').on('show.bs.modal', function (event) {
            let button = $(event.relatedTarget)
            let estado = button.data('estado')
            let id = button.data('id')
            //
            $('#excestadonome').text(estado)
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