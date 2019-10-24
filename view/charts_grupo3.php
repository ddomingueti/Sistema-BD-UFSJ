<script>

  Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
  Chart.defaults.global.defaultFontColor = '#292b2c';

  $(document).ready(function (){
    $("#salvar").click(function (){
      var form = new FormData($("#formulario")[0]);
      $.ajax({
        url: 'recebeDados.php',
        type: 'post',
        dataType: 'json',
        cache: false,
        processData: false,
        contentType: false,
        data: form,
        timeout: 8000,
        success: function(resultado){
          $("#resposta").html(resultado);
        }
      });
    });
  });

</script>

<?php
    include "$_SERVER[DOCUMENT_ROOT]/sistema-bd-ufsj/controller/usuario_controller.php";
    include "$_SERVER[DOCUMENT_ROOT]/sistema-bd-ufsj/controller/usuario_proreitor_controller.php";
    include "$_SERVER[DOCUMENT_ROOT]/sistema-bd-ufsj/controller/area_controller.php";
    include "$_SERVER[DOCUMENT_ROOT]/sistema-bd-ufsj/controller/view_manager.php";

    session_start();
    if((!isset ($_SESSION['cpf']) == true) and (!isset ($_SESSION['tipo_usuario']) == true)) {
        header('location: ../../index.php');
    }

    $gerenciadorView = new GerenciadorView();
    $prController = new ProReitorController();

    $areaController = new AreaController();
    $nome_areas = $areaController->buscarArea(null, null);
    $msg = false;
    
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
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Page level plugin CSS-->
  <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">

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

    <!-- Conteúdo -->
    <div id="content-wrapper">

      <div class="container-fluid">

        <!-- Tabela 2 -->
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th class="text-center">Id</th>
                  <th class="text-center">Área</th>
                  <th class="text-center">Nota Média</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th class="text-center">Id</th>
                  <th class="text-center">Área</th>
                  <th class="text-center">Nota Média</th>
                </tr>
              </tfoot>
              <tbody>
                <?php

                  $ret = $prController->mediaAreas();
                  for ($i=0; $i < count($ret); $i++) {
                    echo "<tr>";
                    echo "<td><center>".$ret[$i]['id_area']."</center></td>";
                    echo "<td><center>".$ret[$i]['nome']."</center></td>";
                    echo "<td><center>".$ret[$i]['AVG(prova.nota)']."</center></td>";
                    echo "</tr>";
                  }
    
                ?>
              </tbody>
            </table>
          </div>
        </div> 

        <!-- Tabela 2 -->
        <div class="card-body">
          <div class="table-responsive" id = "respostaT">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th class="text-center">Id</th>
                  <th class="text-center">Área</th>
                  <th class="text-center">Tempo Médio</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th class="text-center">Id</th>
                  <th class="text-center">Área</th>
                  <th class="text-center">Tempo Médio</th>
                </tr>
              </tfoot>
              <tbody>
              <?php

                $ret = $prController->mediaTempoAreas();
                for ($i=0; $i < count($ret); $i++) {
                  echo "<tr>";
                  echo "<td><center>".$ret[$i]['id_area']."</center></td>";
                  echo "<td><center>".$ret[$i]['nome']."</center></td>";
                  echo "<td><center>".$ret[$i]['AVG(prova.tempo)']."</center></td>";
                  echo "</tr>";
                }
          
              ?>
              </tbody>
            </table>
          </div>
        </div>

        <p class="small text-center text-muted my-5">
          <em>Estatísiticas</em>
        </p>

      </div> <!--/container-fluid-->

    </div>
  </div>
  <!-- ss/#wrapper -->

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
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Page level plugin JavaScript-->
  <script src="vendor/chart.js/Chart.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin.min.js"></script>

  <!-- Demo scripts for this page-->
  <script src="js/demo/chart-area-demo.js"></script>
  <script src="js/demo/chart-bar-demo.js"></script>
  <script src="js/demo/chart-pie-demo.js"></script>

</body>

</html>
