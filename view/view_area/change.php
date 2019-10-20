<?php
include "$_SERVER[DOCUMENT_ROOT]/sistema-bd-ufsj/controller/area_controller.php";

session_start();
if((!isset ($_SESSION['cpf']) == true) and (!isset ($_SESSION['tipo_usuario']) == true)) {
    header('location: ../../index.php');
}

$areaController = new AreaController();
$nome = false;
$id = false;
if($_SERVER["REQUEST_METHOD"] == "GET") {
    $nome = $_GET['nome'];
    $id = $_GET['id'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ret = $areaController->alterarArea($_POST['id'], $_POST['nome']);
    header ('Location: table.php');    
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
      <div class="card-header">Alterar área existente</div>
      <div class="card-body">
      <form action="" method="POST">
        <div class="form-group">
            <div class="form-row">
                <label for="staticEmail" class="col-sm-2 col-form-label">ID</label>
                <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" name="id" value="<?php echo $id?>">
                </div>
            </div>
            <div class="form-row">
                <label for="inputArea" class="col-sm-2 col-form-label">Nome da área</label>
                <div class="col-sm-10">
                <input type="text" class="form-control" id="inputArea" name="nome" value="<?php echo $nome?>">
                </div>
            </div>
            <div class="form-row">
                <button class="btn btn-primary btn-block" type="submit" name="alterar">Alterar</button>
                <button class="btn btn-primary btn-block" href="table.php">Voltar</button>
            </div>
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
