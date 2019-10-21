<?php
$caminho = '//'.$_SERVER['SERVER_NAME'].'/sistema-bd-ufsj/resources/script.py';
$command = escapeshellcmd('python '.$caminho);
$output = false;
$output = shell_exec($command);

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
      <div class="card-header">Executar o crawler ... </div>
      <div class="card-body">
        Script em execução ....
      </div>
      </div>
    </div>
</div>
</body>

</html>