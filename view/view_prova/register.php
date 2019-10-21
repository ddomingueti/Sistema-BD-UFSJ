<?php 
    include "$_SERVER[DOCUMENT_ROOT]/sistema-bd-ufsj/controller/area_controller.php";
    include "$_SERVER[DOCUMENT_ROOT]/sistema-bd-ufsj/controller/prova_controller.php";
    include "$_SERVER[DOCUMENT_ROOT]/sistema-bd-ufsj/controller/questao_controller.php";
    session_start();
    if((!isset ($_SESSION['cpf']) == true) and (!isset ($_SESSION['tipo_usuario']) == true)) {
        header('location: ../../index.php');
    }
    
    $areaController = new AreaController();
    $nome_areas = $areaController->buscarArea(null, null);
    $provaController = new ProvaController();
    $questaoController = new QuestaoController();

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $_SESSION['start_time'] = time();
        $quantidade = $questaoController->quantidadeQuestaoArea($_POST['area']);
        $quantidade = (int)$quantidade[0][0];
        
        if ($quantidade == 0) {
            echo "<div class='container bg-warning text-center col-md-3'>Ops! Essa área não possui questões cadastradas! Regarregue a página.</div>";
            header('');
        } else if ($quantidade[0] < $_POST['quantidade']) {
            $_POST['quantidade'] = $quantidade[0];
            $res = $provaController->adicionarProva($_SESSION['cpf'], $_POST['quantidade'], $_POST['area']);
            header ('Location: prova_questao.php?id_prova='.$res['id_prova'].'&id_questao='.$res['id_questao'][0].'&atual=0&editable=true');
        }
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

  <div class="container">
    <div class="card card-register mx-auto mt-5">
      <div class="card-header">Realizar uma prova</div>
      <div class="card-body">
        <form method="POST">
            <div class="form-row" style="padding-bottom:10px;"> 
                <label for="inputArea" class="col-sm-4 col-form-label">Área de estudo</label>
                <div class="input-group sm-2" style="width: auto; padding-left:5px;">
                    <select class="custom-select" id="inputArea" name="area">
                        <?php 
                            foreach ($nome_areas as $item) {
                                echo '<option value="'.$item['id'].'">'.$item['nome'].'</option>';                   
                            }
                        ?>
                    </select>
                </div>
            </div>


            <div class="form-row" style="padding-bottom:10px;">
                <label for="inputQuantidade" class="col-sm-4 col-form-label">Quantidade</label>
                <div class="col-sm-4">
                    <input type="number" class="form-control" id="inputQuantidade" name="quantidade" min=0>
                </div>
            </div>
            
            <div class="form-row" style="padding-bottom:10px;">
                <input type="hidden" id="editable" name="editable" value="true">
                <button class="btn btn-primary btn-block" type="submit" name="iniciar">Iniciar Prova</button>
            </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

</body>

</html>
