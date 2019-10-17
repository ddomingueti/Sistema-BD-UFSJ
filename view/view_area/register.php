<?php
    include "$_SERVER[DOCUMENT_ROOT]/sistema-bd-ufsj/controller/area_controller.php";
    session_start();
    if((!isset ($_SESSION['cpf']) == true) and (!isset ($_SESSION['tipo_usuario']) == true)) {
        header('location: ../../index.php');
    }
    
    $areaController = new AreaController();

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $ret = $areaController->adicionarArea($_POST['nome']);
        if ($ret == true) {
            header ('Location: table.php');
        } else {
         echo $ret;   
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

  <title>SB Admin - Register</title>

  <!-- Custom fonts for this template-->
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Custom styles for this template-->
  <link href="../css/sb-admin.css" rel="stylesheet">

</head>

<body class="bg-dark">

  <div class="container">
    <div class="card card-register mx-auto mt-5">
      <div class="card-header">Cadastrar uma nova área</div>
      <div class="card-body">
        <form action="" method="post">
            <div class="form-row" style="padding-bottom:10px;">
                <label for="inputArea" class="col-sm-3 col-form-label">Nome da área</label>
                <div class="col-sm-9">
                <input type="text" class="form-control" id="inputArea" name="nome">
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
