<?php
    include "$_SERVER[DOCUMENT_ROOT]/sistema-bd-ufsj/controller/questao_controller.php";
    include "$_SERVER[DOCUMENT_ROOT]/sistema-bd-ufsj/controller/area_controller.php";
    
    session_start();
    if((!isset ($_SESSION['cpf']) == true) and (!isset ($_SESSION['tipo_usuario']) == true)) {
        header('location: ../../index.php');
    }
    
    $questaoController = new QuestaoController();
    $areaController = new AreaController();
    $area_nomes = null;

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        if ($_POST['tipo'] == "F" && strlen($_POST['resposta']) > 1) {
            echo "<script>window.alert('A resposta deve possuir um único caractere!')</script>";
            header ('Location: register.php');
        } else {
            $_POST['resposta'] = strtoupper($_POST['resposta']);
            $ret = $questaoController->adicionarQuestao($_POST);
            header ('Location: table.php');
        }
    } else {
        $area_nomes = $areaController->buscarArea(null, null);
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

  <title>SB Admin - Register</title>

  <!-- Custom fonts for this template-->
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Custom styles for this template-->
  <link href="../css/sb-admin.css" rel="stylesheet">

</head>

<body class="bg-dark">

  <div class="container">
    <div class="card card-register mx-auto mt-5">
      <div class="card-header">Cadastrar uma nova questão</div>
      <div class="card-body">
        <form action="" method="post">
          <div class="form-group">
            <div class="form-row" style="padding-bottom:10px;">
              <div class="col-md-12">
                <div class="input-group">
                    <div class="input-group-prepend col-md-2">
                        <label for="enunciado">Enunciado</label>
                    </div>
                        <textarea class="form-control" id="enunciado" aria-label="Enunciado" name="enunciado" required></textarea>
                </div>
              </div>
            </div>

            <div class="form-row" style="padding-bottom:10px;">
             <div class="col-md-12">
                <div class="input-group">
                    <div class="input-group-prepend col-md-2">
                        <label for="resposta">Resposta</label>
                    </div>
                        <textarea class="form-control" id="resposta" aria-label="Resposta" name="resposta" required></textarea>
                </div>
              </div>
            </div>

            <div class="form-row" style="padding-bottom:10px;">
                <label for="inputTipoQuestao" class="col-sm-2 col-form-label">Tipo da questão</label>
                <div class="input-group sm-3" style="width: auto;">
                <select class="custom-select" id="inputTipoQuestao" name="tipo">
                    <option value="A">Aberta</option>
                    <option value="F">Fechada</option>
                </select>
                </div>

                <label for="inputArea" class="col-sm-2 col-form-label">Área</label>
                <div class="input-group sm-3" style="width: auto;">
                <select class="custom-select" id="inputArea" name="id_area">
                    <?php 
                        foreach ($area_nomes as $areas) {
                            echo '<option value="'.$areas['id'].'">'.$areas['nome'].'</option>';
                        }
                    ?>
                </select>
                </div>

            </div>

            <div class="form-row" style="padding-bottom:10px;">
                <label for="inputA" class="col-sm-2 col-form-label">A</label>
                <div class="col-sm-10">
                <input type="text" class="form-control" id="inputA" name="a">
                </div>
            </div>
            
            <div class="form-row" style="padding-bottom:10px;">
                <label for="inputB" class="col-sm-2 col-form-label">B</label>
                <div class="col-sm-10">
                <input type="text" class="form-control" id="inputB" name="b">
                </div>
            </div>

            <div class="form-row" style="padding-bottom:10px;">
                <label for="inputC" class="col-sm-2 col-form-label">C</label>
                <div class="col-sm-10">
                <input type="text" class="form-control" id="inputC" name="c">
                </div>
            </div>

            <div class="form-row" style="padding-bottom:10px;">
                <label for="inputD" class="col-sm-2 col-form-label">D</label>
                <div class="col-sm-10">
                <input type="text" class="form-control" id="inputD" name="d">
                </div>
            </div>
            
            <div class="form-row" style="padding-bottom:10px;">
                <label for="inputE" class="col-sm-2 col-form-label">E</label>
                <div class="col-sm-10">
                <input type="text" class="form-control" id="inputE" name="e">
                </div>
            </div>

            <div class="form-row">
              <button class="btn btn-primary btn-block" type="submit" name="cadastrar">Cadastrar</button>
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
