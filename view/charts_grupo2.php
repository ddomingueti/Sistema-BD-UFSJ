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

<head>

	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.min.js"></script>
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

		<!-- 2ª aba: Gráfico de Barras e Pizza -->
		<div>

			<!-- Pesquisa -->
						<form id="formulario" method = "post">

							<div class="input-group sm-3" style="width: auto;">

								<div class="input-group mb-3">
								  	<div class="input-group-prepend">
								    	<label class="input-group-text" for="inputGroupSelect01">Áreas</label>
								  	</div>
								  	<select class="custom-select" id="inputArea" name="area">
								  		<option selected>Escolha...</option>
										<?php 
										foreach ($nome_areas as $item) {
											echo '<option value="'.$item['id'].'">'.$item['nome'].'</option>';                   
										}
										?>
									</select>
								</div>
								
								<div class="input-group mb-3">
								  	<div class="input-group-prepend">
								    	<label class="input-group-text" for="inputGroupSelect01">Valores</label>
								  	</div>
									<select class="custom-select" id="inputTipo" name="grupo">
										<option selected>Escolha...</option>
										<option value="C" selected>Cotas</option>
										<option value="S" selected>Sexo</option>   
									</select>
								</div>
								<input type="submit" class="btn btn-info" style = "margin-bottom: 1%;" id="salvar" name="salvar" value="Gerar Gráficos">
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
						Total de Alunos Acima e Abaixo da Média </div>
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
