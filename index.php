<?php
    include "$_SERVER[DOCUMENT_ROOT]/sistema-bd-ufsj/controller/usuario_controller.php";
    session_start();
    $msg = false;
    $status = false;
    $area = false;
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $usuario_cont = new UsuarioController();
        if ((strlen($_POST['cpf']) != 11)  || (!is_numeric($_POST['cpf']))) {
            $msg = "Digite um número de CPF válido! <br> Exemplo: 01234567891";
        } else {
            $ret = $usuario_cont->realizarLogin($_POST['cpf'], $_POST['password']);
            if ($ret['success'] == true) {
                header ('Location: '.$ret['area']);
            } else {
                $msg = $ret['msg'];
            }
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
  <link href="view/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Custom styles for this template-->
  <link href="view/css/sb-admin.css" rel="stylesheet">

</head>

<body class="bg-dark">
  <div class="container">
    <div class="card card-login mx-auto mt-5">
      <div class="card-header">Bem vindo ao sistema de treinamento Enade!<br>Faça login para continuar.</div>
      <div class="card-body">
        <form action="" method="post">
          <div class="form-group">
            <div class="form-label-group">
              <input type="text" id="inputCpf" name="cpf" class="form-control" placeholder="CPF" required autofocus>
              <label for="inputPassword">CPF</label>
            </div>
          </div>
          <div class="form-group">
            <div class="form-label-group">
            <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Senha" required>
              <label for="inputPassword">Senha</label>
            </div>
          </div>
          <?php if (isset($msg)) echo "<div><center>".$msg."</center></div>"; ?>
          <button class="btn btn-primary btn-block" type="submit" name="login">Login</button>
        </form>
        <div class="text-center">
          <a class="d-block small mt-3">Para registrar ou recuperar sua senha contate o administrador do sistema.</a>
        </div>
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
