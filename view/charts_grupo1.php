<script>

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

  date_default_timezone_set('America/Sao_Paulo');

  $area = null;
  $areaNome = null;
  $valores = null;
  $titulo = null;
  $ano1 = null;
  $ano2 = null;
  $media = null;
  $tempo = null;
  $consulta1 = null;
  $consulta2 = null;

  if($_SERVER["REQUEST_METHOD"] == "POST") {
    $area = $_POST['area'];
    $valores = $_POST['valores'];
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
          <!-- 1ª aba: Gráfico de Linha -->
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
                <label for="inputArea" class="col-sm-2 col-form-label">Valores</label>
                <div class="input-group sm-2" style="width: auto;">
                    <select class="custom-select" id="inputTipo" name="valores">
                        <option value="N" selected>Notas</option>
                        <option value="T" selected>Tempo</option>   
                    </select>
                </div>
                <input type="submit" id="salvar" name="salvar" value="Gerar Gráficos">
              </div>
            </form>

            <!-- Controle da Entrada -->
            <?php

              if(isset($area) && isset($valores)){
              //Gráfico de linha
                $consulta1 = $prController->mediaAreaAno($area);
                $consulta2 = $prController->mediaTempoAreaAno($area);
                //$areaNome = $consulta1['nome'];

                //coloca todos os anos em uma string e separados por vírgula
                for ($i=0; $i < count($consulta1); $i++) {

                  $ano1 = $ano1 . '"'. $consulta1[$i]['YEAR(data)'].'",';
                  $ano2 = $ano2 . '"'. $consulta2[$i]['YEAR(data)'].'",';
                  $media = $media . '"'. $consulta1[$i]['AVG(prova.nota)'].'",';
                  $tempo = $tempo . '"'. $consulta2[$i]['AVG(prova.tempo)'].'",';

                }

                $ano1 = trim($ano1,",");
                $ano2 = trim($ano2,",");
                $media = trim($media,",");
                $tempo = trim($tempo,",");

                if($valores == "N"){
                  $valores = $media;
                  $titulo = "Nota Média por Ano";
                } else {
                  $valores = $tempo;
                  $titulo = "Tempo Médio por Ano";
                }

              }
            ?>

            <!-- Area Chart -->
            <div class="card mb-3">
              <div class="card-header">
                <i class="fas fa-chart-line"></i>
                <?php echo $titulo; ?></div>
              <div class="card-body">
                
                <!-- Gráfico Notas -->
                <div class="card-body">

                  <canvas id="chart"></canvas>

                  <script>

                    var ctx = document.getElementById("chart").getContext('2d');
                    var myChart = new Chart(ctx, {
                      type: 'line',
                      data: {
                        labels: [<?php echo $ano1; ?>],
                        datasets: 
                        [{
                          label: 'Valores',
                          data: [<?php echo $valores; ?>],
                          backgroundColor: 'transparent',
                          borderColor:'rgba(255,99,132)',
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
                              maxTicksLimit: 7
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
              <div class="card-footer small text-muted"><?php echo date('d/m/Y \à\s H:i:s'); ?></div>
            </div>

          </div>

        <p class="small text-center text-muted my-5">
          <em>Estatísiticas</em>
        </p>

      </div> <!--/container-fluid-->

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
