<?php 
    include "$_SERVER[DOCUMENT_ROOT]/sistema-bd-ufsj/controller/questao_controller.php";
    include "$_SERVER[DOCUMENT_ROOT]/sistema-bd-ufsj/controller/prova_controller.php";
    
    session_start();
    if((!isset ($_SESSION['cpf']) == true) and (!isset ($_SESSION['tipo_usuario']) == true)) {
        header('location: ../../index.php');
    }
    
    $provaController = new ProvaController();
    $questaoController = new QuestaoController();
    $finalizaada = null;
    $tempoFinal = null;
    $tempoTotal = null;

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        if (isset($_GET['finalizada'])) {
            $tempoFinal = time();
            $finalizada = ($_GET['finalizada'] === 'true');
            $inicial = $_SESSION['start_time'];
            $editable = $_GET['editable'] === 'true';
            $tempoTotal = 0;
            if ($editable) {
                $tempoTotal = $tempoFinal - $inicial;
            }
        } else {
            $finalizada = null;
        }
        $editable = ($_GET['finalizada'] === 'true');
        $ret = $provaController->calculaResultadoProva($_GET['id_prova'], $finalizada, $tempoTotal, $editable);
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

  <!-- Custom styles for this template-->
  <link href="../css/sb-admin.css" rel="stylesheet">

</head>

<body class="bg-dark">

<div id="content-wrapper">

  <div class="container">
    <div class="card card-register mx-auto mt-5">
      <div class="card-header">Resultados da prova</div>
      <div class="card-body">
      <span class="label">Atenção! Apenas questões fechadas são validadas pelo sistema!</span>
        <div class="card-text" style="padding-bottom:10px;">
            <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th class="text-center">Questão</th>
                    <th class="text-center">Resposta dada</th>
                    <th class="text-center">Gabarito</th>
                    <th class="text-center">Visuaizar Questao </th>
                  </tr>
                </thead>
                <tbody>
                <?php
                    for ($i=0; $i < sizeof($ret['num_questao']); $i++) {
                        echo "<tr>";
                        echo "<td><center>".$ret['num_questao'][$i]."</center></td>";
                        echo "<td><center>".$ret['resposta_usuario'][$i]."</center></td>";
                        echo "<td><center>".$ret['gabarito'][$i]."</center></td>";
                        echo "<td><center><a href='prova_questao.php?id_prova=".$_GET['id_prova']."&id_questao=".$ret['id_questao'][$i]."&editable=false&atual=0' target='_blank'>Visualizar</a></center></td>";
                        echo "</tr>";
                    }
                ?>
                </tbody>
              </table>
            </div>
            
            <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <tbody>
                        <tr>
                            <td>Nota final</td>
                            <td><?php echo $ret['nota'];?></td>
                        </tr>
                        <tr>
                            <td>Tempo Decorrido</td>
                            <td><?php echo $tempoTotal;?></td>
                    </tbody>
              </table>
            </div>

            <?php 
                if (!$editable) {
                    echo '<a class="btn btn-primary btn-block" href="javascript:window.close();">Voltar</a>';
                } else {
                    echo '<a class="btn btn-primary btn-block" href="table.php">Voltar</a>';
                }
            ?>
        </div>
        </div>
    </div>

    
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

</body>

</html>
