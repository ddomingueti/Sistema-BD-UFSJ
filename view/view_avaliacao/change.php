<?php

    include "$_SERVER[DOCUMENT_ROOT]/sistema-bd-ufsj/controller/usuario_controller.php";
    include "$_SERVER[DOCUMENT_ROOT]/sistema-bd-ufsj/controller/avaliacao_controller.php";
    include "$_SERVER[DOCUMENT_ROOT]/sistema-bd-ufsj/controller/view_manager.php";

    session_start();
    if((!isset ($_SESSION['cpf']) == true) and (!isset ($_SESSION['tipo_usuario']) == true)) {
        header('location: ../../index.php');
    }

    $usuarioController = new UsuarioController();
    $gerenciadorView = new GerenciadorView();
    
    $avaliacaoController = new AvaliacaoController();

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $ret = $avaliacaoController->alterarAvaliacao($_POST['id_avaliacao'], $_POST['comentario'], $_POST['nota'], $_POST['data']);
        header ('Location: table.php');
    }

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $usuario = $usuarioController->buscarUsuario($_SESSION['cpf'], true);
        $avaliacao = $avaliacaoController->buscarAvaliacao($_GET['id'], null);
    }
    
?>


<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>TreinaEnade</title>

  <!-- Custom fonts for this template-->
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Page level plugin CSS-->
  <link href="../vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="../css/sb-admin.css" rel="stylesheet">

</head>

<body id="page-top">
 
  <nav class="navbar navbar-expand navbar-dark bg-dark static-top">

    <a class="navbar-brand mr-1" href="index.php">TreinaEnade</a>

    <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
      <i class="fas fa-bars"></i>
    </button>

    <!-- Navbar Search -->
    <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
    </form>

    <!-- Navbar -->
    <ul class="navbar-nav ml-auto ml-md-0">
      <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-user-circle fa-fw"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
          <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Logout</a>
        </div>
      </li>
    </ul>
  </nav>

  <div id="wrapper">
    <!-- Sidebar -->
    <ul class="sidebar navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="<?php echo '//'.$gerenciadorView->getRaiz().'/view/index.php';?>">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Início</span>
        </a>
      </li>
      
      <?php 
        if ($_SESSION['tipo_usuario'] == 0) { //administrador
            echo $gerenciadorView->exibeSidebarRelatorio();
            echo $gerenciadorView->exibeSidebarUsuario();
            echo $gerenciadorView->exibeSidebarAvaliacao();
            echo $gerenciadorView->exibeSidebarArea();
            echo $gerenciadorView->exibeSidebarQuestao();
            echo $gerenciadorView->exibeSidebarProva();
        } else if ($_SESSION['tipo_usuario'] == 1) { //aluno
            echo $gerenciadorView->exibeSidebarProva();
        } else if ($_SESSION['tipo_usuario'] == 2) { // professor
            echo $gerenciadorView->exibeSidebarAvaliacao();
            echo $gerenciadorView->exibeSidebarQuestao();
        } else if ($_SESSION['tipo_usuario'] == 3) { //pro reitor
            echo $gerenciadorView->exibeSidebarRelatorio();
            echo $gerenciadorView->exibeSidebarAvaliacao();
        }
      ?>
    </ul>

    <div id="content-wrapper">

      <div class="container-fluid">
        <!-- EDITAR AQUI-->          

        <div class="card card-register mx-auto mt-5">
              <div class="card-header">Alterar uma avaliação</div>
              <div class="card-body">
                <div class="container text-center" style="padding-bottom:10px;">
                    Atenção: ao alterar uma avaliação, sua data será atualizada para a data de hoje automaticamente!
                </div>

                <form action="" method="POST">
                <div class="form-row" style="padding-bottom:10px;"> 
                    <label for="inputUsuario" class="col-sm-2 col-form-label">Usuário avaliado</label>
                    <div class="input-group sm-2" style="width: auto;">
                        <select class="custom-select" id="inputUsuario" name="id_usuario">
                            <?php 
                                echo '<option value="'.$usuario[0]['cpf'].'">'.$usuario[0]['nome'].'</option>';
                            ?>
                        </select>
                    </div>

                    <label for="inputNota" class="col-sm-3 col-form-label" style="padding-bottom:10px; padding-left:10px;">Nota</label>
                    <div class="col-sm-2">
                    <input type="number" class="form-control" id="inputNota" name="nota" min="0" max="5" value="<?php echo $avaliacao[0]['nota']?>">
                    </div>
                </div>


                <div class="form-row" style="padding-bottom:10px;">
                    <div class="col-md-12">
                        <div class="input-group">
                            <div class="input-group-prepend col-md-2">
                                <label for="resposta">Comentário</label>
                            </div>
                            <textarea class="form-control col-md-10" id="comentario" aria-label="Comentários" name="comentario"><?php echo $avaliacao[0]['comentario'];?></textarea>
                        </div>
                    </div>
                </div>
                
                <div class="form-group row">
                    <input type="hidden" id="data" name="data" value="<?php echo date('Y-m-d'); ?>">
                    <input type="hidden" id="id_avaliacao" name="id_avaliacao" value=<?php echo $avaliacao[0]['id']; ?>>
                </div>

                <div class="form-row" style="padding-bottom:10px;">
                    <button class="btn btn-primary btn-block" type="submit" name="cadastrar">Alterar</button>
                    <button class="btn btn-primary btn-block" href="table.php">Voltar</button>
                </div>
                  
                </form>
              </div>
            </div>

        <!-- ATÉ AQUI -->   
      </div>         
    </div>
  </div>
  <!-- /#wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Deseja Sair?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Selecione "Sair" abaixo se está pronto para sair do sistema.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
          <a class="btn btn-primary" href="<?php echo '//'.$gerenciadorView->getRaiz().'/view/logout.php';?>">Sair</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Page level plugin JavaScript-->
  <script src="../vendor/datatables/jquery.dataTables.js"></script>
  <script src="../vendor/datatables/dataTables.bootstrap4.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="../js/sb-admin.min.js"></script>

  <!-- Demo scripts for this page-->
  <script src="../js/demo/datatables-demo.js"></script>
</body>

</html>
