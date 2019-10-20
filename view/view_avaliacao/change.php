<?php
    include "$_SERVER[DOCUMENT_ROOT]/sistema-bd-ufsj/controller/usuario_controller.php";
    include "$_SERVER[DOCUMENT_ROOT]/sistema-bd-ufsj/controller/avaliacao_controller.php";

    session_start();
    if((!isset ($_SESSION['cpf']) == true) and (!isset ($_SESSION['tipo_usuario']) == true)) {
        header('location: ../../index.php');
    }
    $avaliacaoController = new AvaliacaoController();
    $usuarioController = new UsuarioController();

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $ret = $avaliacaoController->alterarAvaliacao($_POST['id_avaliacao'], $_POST['comentario'], $_POST['nota'], $_POST['data']);
        header ('Location: table.php');
    }

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $usuario = $usuarioController->buscarUsuario($_SESSION['cpf']);
        $avaliacao = $avaliacaoController->buscarAvaliacao($_GET['id'], null);
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
      <div class="card-header">Alterar uma avaliação</div>
      <div class="card-body">
        <div class="container text-center" style="padding-bottom:10px;">
            Atenção: ao alterar uma avaliação, sua data será atualizada para a data de hoje automaticamente!
        </div>

        <form action="" method="POST">
        <div class="form-row" style="padding-bottom:10px;"> 
            <label for="inputUsuario" class="col-sm-2 col-form-label">Usuário avaliado</label>
            <div class="input-group sm-2" style="width: auto;">
                <select class="custom-select" id="inputUsuario" name="id_usuario">
                    <?php 
                        echo '<option value="'.$usuario[0]['cpf'].'">'.$usuario[0]['nome'].'</option>';
                    ?>
                </select>
            </div>

            <label for="inputNota" class="col-sm-3 col-form-label" style="padding-bottom:10px; padding-left:10px;">Nota</label>
            <div class="col-sm-2">
            <input type="number" class="form-control" id="inputNota" name="nota" min="0" max="5" value="<?php echo $avaliacao[0]['nota']?>">
            </div>
        </div>


        <div class="form-row" style="padding-bottom:10px;">
            <div class="col-md-12">
                <div class="input-group">
                    <div class="input-group-prepend col-md-2">
                        <label for="resposta">Comentário</label>
                    </div>
                    <textarea class="form-control col-md-10" id="comentario" aria-label="Comentários" name="comentario"><?php echo $avaliacao[0]['comentario'];?></textarea>
                </div>
            </div>
        </div>
        
        <div class="form-group row">
            <input type="hidden" id="data" name="data" value="<?php echo date('Y-m-d'); ?>">
            <input type="hidden" id="id_avaliacao" name="id_avaliacao" value=<?php echo $avaliacao[0]['id']; ?>>
        </div>

        <div class="form-row" style="padding-bottom:10px;">
            <button class="btn btn-primary btn-block" type="submit" name="cadastrar">Alterar</button>
            <button class="btn btn-primary btn-block" href="table.php">Voltar</button>
        </div>
          
        </form>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

</body>

</html>
