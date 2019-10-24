<?php
  include "$_SERVER[DOCUMENT_ROOT]/sistema-bd-ufsj/controller/usuario_controller.php";
  include "$_SERVER[DOCUMENT_ROOT]/sistema-bd-ufsj/controller/usuario_proreitor_controller.php";
  include "$_SERVER[DOCUMENT_ROOT]/sistema-bd-ufsj/controller/area_controller.php";

  $prController = new ProReitorController();

  $areaController = new AreaController();
  $nome_areas = $areaController->buscarArea(null, null);
  $msg = false;

  date_default_timezone_set('America/Sao_Paulo');

  $area = null;
  $grupo = null;
  $sexos = null;
  $cotas = null;
  $notasS = null;
  $notasC = null;
  $grupos = null;
  $valores = null;
  $titulo = null;
  $acima = null;
  $abaixo = null;
  $numAlunosS = null;
  $numAlunosC = null;
  $numAlunos = null;

  $consulta1 = null;
  $consulta2 = null;
  $consulta3 = null;
  $consulta4 = null;
  $consulta5 = null;
  $consulta6 = null;

  if($_SERVER["REQUEST_METHOD"] == "POST") {
    $area = $_POST['area'];
    $grupo = $_POST['grupo'];
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <script src="js/jquery-3.1.1.min.js" type="text/javascript"></script>
  <script src="js/charts.js" type="text/javascript"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.min.js"></script>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>SB Admin - Charts</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Page level plugin CSS-->
  <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">

</head>

<body id="page-top">

  <nav class="navbar navbar-expand navbar-dark bg-dark static-top">

    <a class="navbar-brand mr-1" href="index.html">Start Bootstrap</a>

    <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
      <i class="fas fa-bars"></i>
    </button>

    <!-- Navbar Search -->
    <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
      <div class="input-group">
        <input type="text" class="form-control" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
        <div class="input-group-append">
          <button class="btn btn-primary" type="button">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>

    <!-- Navbar -->
    <ul class="navbar-nav ml-auto ml-md-0">
      <li class="nav-item dropdown no-arrow mx-1">
        <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-bell fa-fw"></i>
          <span class="badge badge-danger">9+</span>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="alertsDropdown">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li>
      <li class="nav-item dropdown no-arrow mx-1">
        <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-envelope fa-fw"></i>
          <span class="badge badge-danger">7</span>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="messagesDropdown">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li>
      <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-user-circle fa-fw"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
          <a class="dropdown-item" href="#">Settings</a>
          <a class="dropdown-item" href="#">Activity Log</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Logout</a>
        </div>
      </li>
    </ul>

  </nav>

  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="sidebar navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="index.html">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span>
        </a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-fw fa-folder"></i>
          <span>Pages</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
          <h6 class="dropdown-header">Login Screens:</h6>
          <a class="dropdown-item" href="login.html">Login</a>
          <a class="dropdown-item" href="register.html">Register</a>
          <a class="dropdown-item" href="forgot-password.html">Forgot Password</a>
          <div class="dropdown-divider"></div>
          <h6 class="dropdown-header">Other Pages:</h6>
          <a class="dropdown-item" href="404.html">404 Page</a>
          <a class="dropdown-item" href="blank.html">Blank Page</a>
        </div>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="charts.html">
          <i class="fas fa-fw fa-chart-area"></i>
          <span>Charts</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="tables.html">
          <i class="fas fa-fw fa-table"></i>
          <span>Tables</span></a>
      </li>
    </ul>

      <!-- Conteúdo -->
      <div id="content-wrapper">

        <div class="container-fluid">

            <!-- Breadcrumbs-->
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="#">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Charts</li>
          </ol>

          <!-- 2ª aba: Gráfico de Barras e Pizza -->
          <div>

            <!-- Pesquisa -->
            <form id="formulario" method = "post">
                <div class="input-group sm-3" style="width: auto;">
                  <label for="inputArea" class="col-sm-2 col-form-label">Área</label>
                  <div class="input-group sm-2" style="width: auto;">
                    <select class="custom-select" id="inputArea" name="area">
                      <?php 
                      foreach ($nome_areas as $item) {
                        echo '<option value="'.$item['id'].'">'.$item['nome'].'</option>';                   
                      }
                      ?>
                    </select>
                  </div>
                  <label for="inputArea" class="col-sm-2 col-form-label">Grupos</label>
                  <div class="input-group sm-2" style="width: auto;">
                    <select class="custom-select" id="inputGrupos" name="grupo">
                      <option value="S" selected>Sexo</option>
                      <option value="C" selected>Cotas</option>
                    </select>
                  </div>
                  <input type="submit" id="salvar" name="salvar" value="Gerar Gráficos">
                </div>
            </form>

            <!-- Controle da Entrada -->
            <?php

                if(isset($area) && isset($grupo)){
                  //Gráficos de barra
                  $consulta1 = $prController->calculaMediaAreaSexo($area);
                  $consulta2 = $prController->calculaMediaAreaCota($area);

                  $consulta3 = $prController->alunosAcimaMediaSexo($area);
                  $consulta4 = $prController->alunosAcimaMediaCota($area);

                  //Gráficos de pizza
                  $consulta5 = $prController->alunosAcimaMedia($area);
                  $consulta6 = $prController->alunosAbaixoMedia($area);

                  for ($i=0; $i < count($consulta1); $i++) {

                    $sexos = $sexos . '"'. $consulta1[$i]['sexo'].'",';
                    $notasS = $notasS . '"'. $consulta1[$i]['AVG(prova.nota)'].'",';

                  }

                  for ($i=0; $i < count($consulta2); $i++) {

                    $cotas = $cotas . '"'. $consulta2[$i]['tipo_ingresso'].'",';
                    $notasC = $notasC . '"'. $consulta2[$i]['AVG(prova.nota)'].'",';

                  }

                  for ($i=0; $i < count($consulta3); $i++) {

                    $numAlunosS = $numAlunosS . '"'. $consulta3[$i]['COUNT(id_usuario)'].'",';

                  }

                  for ($i=0; $i < count($consulta3); $i++) {

                    $numAlunosC = $numAlunosC . '"'. $consulta4[$i]['COUNT(id_usuario)'].'",';

                  }

                  $acima = $consulta5[0]['COUNT(id_usuario)']; 
                  $abaixo = $consulta6[0]['COUNT(id_usuario)'];

                  $sexos = trim($sexos,",");
                  $cotas = trim($cotas,",");
                  $notasS = trim($notasS,",");
                  $notasC = trim($notasC,",");
                  $numAlunosS = trim($numAlunosS,",");
                  $numAlunosC = trim($numAlunosC,",");

                  if($grupo == "S"){
                    $grupos = $sexos;
                    $valores = $notasS;
                    $numAlunos = $numAlunosS;
                    $titulo = "Nota Média por Sexo";
                  } else if ($grupo == "C"){
                    $grupos = $cotas;
                    $valores = $notasC;
                    $numAlunos = $numAlunosC;
                    $titulo = "Nota Média por Cotas";
                  }

                }
            ?>

            <!-- Gráficos de Barra -->
            <div class="row">

              <!-- G1 -->
              <div class="col-lg-6">

                  <!-- Notas -->
                  <div class="card mb-3">
                    <div class="card-header">
                      <i class="fas fa-chart-line"></i>
                      <?php echo $titulo; ?></div>
                    <div class="card-body">

                      <!-- Gráfico -->
                      <div class="card-body">

                          <canvas id="chart" width="100%" height="100"></canvas>

                          <script>

                            var chart1 = document.getElementById("chart").getContext('2d');
                            var barChart = new Chart(chart1, {
                              type: 'bar',
                              data: {
                                labels: [<?php echo $grupos; ?>],
                                datasets:[{

                                  label: 'Valores',
                                  data: [<?php echo $valores; ?>],
                                  backgroundColor: ['#ff6384','#00FFFF'],
                                  borderColor: ['#ff6384','#00FFFF'],
                                  borderWidth: 3
                                }]
                              },

                              options: {
                                scales: {
                                  xAxes: [{
                                    time: {
                                      unit: 'date'
                                    },
                                    gridLines: {
                                      display: false
                                    },
                                    ticks: {
                                      maxTicksLimit: 15
                                    }
                                  }],
                                  yAxes: [{
                                    ticks: {
                                      min: 0,
                                      max: 100,
                                      maxTicksLimit: 5
                                    },
                                    gridLines: {
                                      color: "rgba(0, 0, 0, .125)",
                                    }
                                  }],
                                },
                                legend: {
                                  display: false
                                }
                              }
                            });
                          </script>
                      </div>

                    </div>
                    <div class="card-footer small text-muted">Média x Grupo</div>
                  </div>
              </div>

              <!-- G2 -->
              <div class = "col-lg-6">

                  <!-- % Acima da Média -->
                  <div class="card mb-3">
                    <div class="card-header">
                      <i class="fas fa-chart-line"></i>
                      Alunos Acima da Média</div>
                    <div class="card-body">

                      <div class="card-body">

                          <canvas id="chart1" width="100%" height="100"></canvas>

                          <script>

                            var ctx = document.getElementById("chart1").getContext('2d');
                            var barChart1 = new Chart(ctx, {
                              type: 'bar',
                              data: {
                                labels: [<?php echo $grupos; ?>],
                                datasets: 
                                [{
                                  label: 'Data 1',
                                  data: [<?php echo $numAlunos; ?>],
                                  backgroundColor:  ['#ff6384','#00FFFF'],
                                  borderColor: ['#ff6384','#00FFFF'],
                                  borderWidth: 3
                                }]
                              },

                              options: {
                                scales: {
                                  xAxes: [{
                                    time: {
                                      unit: 'date'
                                    },
                                    gridLines: {
                                      display: false
                                    },
                                    ticks: {
                                      maxTicksLimit: 20
                                    }
                                  }],
                                  yAxes: [{
                                    ticks: {
                                      min: 0,
                                      maxTicksLimit: 5
                                    },
                                    gridLines: {
                                      color: "rgba(0, 0, 0, .125)",
                                    }
                                  }],
                                },
                                legend: {
                                  display: false
                                }
                              }
                            });

                          </script>
                      </div>

                    </div>
                    <div class="card-footer small text-muted">Numero de Alunos x Grupo</div>
                  </div>
              </div>  
            </div>

            <!-- Gráfico Pizza -->
            <div class>

                <div class="card mb-3">
                  <div class="card-header">
                    <i class="fas fa-chart-line"></i>
                    Todal de Alunos Acima e Abaixo da Média </div>
                  <div class="card-body">

                    <!-- Gráfico -->
                    <div class="card-body">

                        <canvas id="chart2"></canvas>

                        <script>

                          var ctx = document.getElementById("chart2").getContext('2d');
                          var pieChart = new Chart(ctx, {
                            type: 'pie',
                            data: {
                              labels: ["Acima da Média", "Abaixo da Média"],
                              datasets: 
                              [{
                                label: 'Data 1',
                                data: [<?php echo $acima; ?>, <?php echo $abaixo; ?>],
                                backgroundColor: ['#ff6384','#00FFFF'],
                              }]
                            },
                          });

                        </script>
                    </div>

                  </div>
                </div>
            </div>

            <p class="small text-center text-muted my-5">
              <em>Atualizado em: <?php echo date('d/m/Y \à\s H:i:s'); ?></em>
            </p>
          </div> <!--/container-fluid-->
        </div>
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
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="login.html">Logout</a>
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


</body>

</html>
