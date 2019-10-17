<?php
    include "$_SERVER[DOCUMENT_ROOT]/sistema-bd-ufsj/controller/usuario_controller.php";
    include "$_SERVER[DOCUMENT_ROOT]/sistema-bd-ufsj/controller/area_controller.php";
    $usuarioController = new UsuarioController();
    $areaController = new AreaController();
    $nome_areas = null;
    if($_SERVER["REQUEST_METHOD"] == "GET") {
        
        $cpf = $_GET['cpf'];
        $usu = $usuarioController->buscarUsuario($cpf);
        if ($usu[0]['tipo_ingresso'] == 2)
            $nome_areas = $areaController->buscarArea(null, null);
        
    }
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        var_dump($_POST);
        
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $cpf = $_POST['cpf'];
        $idade = $_POST['idade'];
        $senha = $_POST['senha'];
        $sexo = $_POST['sexo'];
        $data_nasc = $_POST['data_nasc'];
        
        $id_area = null;
        if ($_POST['id_area'] == 'Nenhum')
            $id_area = null;
        
        $tipo_ingresso = $_POST['tipo_ingresso'];
        if ($id_area == "Nenhuma") $id_area = null;
        if ($tipo_ingresso == "Nenhum") $tipo_ingresso = null;
        $tipo_ingresso = $_POST['tipo_ingresso'];
        $tipo_usuario = $_POST['tipo_usuario'];
        $ret = $usuarioController->alterarUsuario($nome, $email, $cpf, $idade, $senha, $sexo, $data_nasc, $id_area, $tipo_ingresso);
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

  <title>SB Admin - Register</title>

  <!-- Custom fonts for this template-->
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Custom styles for this template-->
  <link href="../css/sb-admin.css" rel="stylesheet">

</head>

<body id="page-top">

  <nav class="navbar navbar-expand navbar-dark bg-dark static-top">

    <a class="navbar-brand mr-1" href="index.html">Simulador ENADE</a>

    <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
      <i class="fas fa-bars"></i>
    </button>

    <!-- Navbar Search -->
    <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
      <div class="input-group">
        <input type="text" class="form-control" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
        <div class="input-group-append">
          <button class="btn btn-primary" type="button">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>

    <!-- Navbar -->
    <ul class="navbar-nav ml-auto ml-md-0">
      <li class="nav-item dropdown no-arrow mx-1">
        <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-bell fa-fw"></i>
          <span class="badge badge-danger">9+</span>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="alertsDropdown">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li>
      <li class="nav-item dropdown no-arrow mx-1">
        <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-envelope fa-fw"></i>
          <span class="badge badge-danger">7</span>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="messagesDropdown">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li>
      <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-user-circle fa-fw"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
          <a class="dropdown-item" href="#">Settings</a>
          <a class="dropdown-item" href="#">Activity Log</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Logout</a>
        </div>
      </li>
    </ul>

  </nav>

  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="sidebar navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="index.html">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span>
        </a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-fw fa-folder"></i>
          <span>Pages</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
          <h6 class="dropdown-header">Login Screens:</h6>
          <a class="dropdown-item" href="login.html">Login</a>
          <a class="dropdown-item" href="register.html">Register</a>
          <a class="dropdown-item" href="forgot-password.html">Forgot Password</a>
          <div class="dropdown-divider"></div>
          <h6 class="dropdown-header">Other Pages:</h6>
          <a class="dropdown-item" href="404.html">404 Page</a>
          <a class="dropdown-item" href="blank.html">Blank Page</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="charts.html">
          <i class="fas fa-fw fa-chart-area"></i>
          <span>Charts</span></a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="tables.html">
          <i class="fas fa-fw fa-table"></i>
          <span>Tables</span></a>
      </li>
    </ul>

    <div id="content-wrapper">

      <div class="container-fluid">
        <div class="card mb-3">
          <div class="card-header">
            <i class="fas fa-table"></i>
            Tabela de Usuários<br>
            </button>
        </div>

          <div class="card-body">

            <div class="container">
    <div class="card card-register mx-auto mt-5">
      <div class="card-header">Alterar área existente</div>
      <div class="card-body">
      <form action="" method="POST">
        <div class="form-group">
            <div class="form-row" style="padding-bottom:10px;">
                <label for="inputCpf" class="col-sm-2 col-form-label">CPF</label>
                <div class="col-sm-10">
                <input type="text" readonly class="form-control" id="inputCpf" name="cpf" value="<?php echo $usu[0]['cpf']; ?>">
                </div>
            </div>
            <div class="form-row" style="padding-bottom:10px;">
                <label for="inputNome" class="col-sm-2 col-form-label">Nome</label>
                <div class="col-sm-10">
                <input type="text" class="form-control" id="inputNome" name="nome" value="<?php echo $usu[0]['nome']; ?>">
                </div>
            </div>
            <div class="form-row" style="padding-bottom:10px;">
                <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                <input type="text" class="form-control" id="inputEmail" name="email" value="<?php echo $usu[0]['email']; ?>">
                </div>
            </div>
            <div class="form-row" style="padding-bottom:10px;">
                <label for="inputIdade" class="col-sm-2 col-form-label">Idade</label>
                <div class="col-sm-2">
                <input type="text" class="form-control" id="inputIdade" name="idade" value="<?php echo $usu[0]['idade']?>">
                </div>
                
                <label for="inputDataNasc" class="col-sm-4 col-form-label">Data de Nascimento</label>
                <div class="col-sm-4">
                <input type="date" class="form-control" id="inputDataNasc" name="data_nasc" value="<?php echo $usu[0]['data_nasc']?>">
                </div>
                </div>
            </div>
            <div class="form-row" style="padding-bottom:10px;"> 
                <label for="inputSexo" class="col-sm-2 col-form-label">Sexo</label>
                <div class="input-group sm-3" style="width: auto;">
                <select class="custom-select" id="inputSexo" name="sexo">
                    <?php
                        if ($usu[0]['sexo'] == "M") {
                            echo '<option selected value="M">Masculino</option>';
                            echo '<option value="F">Feminino</option>';
                        } else {
                            echo '<option selected value="F">Feminino</option>';
                            echo '<option value="M">Masculino</option>';
                        }
                    ?>
                </select>
                </div>
                    
                <label for="inputTipoUsuario" class="col-sm-3 col-form-label">Tipo de usuário</label>
                <div class="input-group sm-3" style="width: auto;">
                <?php 
                    switch ($usu[0]['tipo_usuario']) {
                        case 0:
                            echo '<input type="text" readonly class="form-control" id="inputTipoUsuario" name="tipo_usuario" value="Administrador">';
                            break;
                        case 1:
                            echo '<input type="text" readonly class="form-control" id="inputTipoUsuario" name="tipo_usuario" value="Aluno">';
                            break;
                        case 2:
                            echo '<input type="text" readonly class="form-control" id="inputTipoUsuario" name="tipo_usuario" value="Professor">';
                            break;
                        case 3:
                            echo '<input type="text" readonly class="form-control" id="inputTipoUsuario" name="tipo_usuario" value="Pró-Reitor">';
                            break;
                    }
                ?>
                </div>
            </div>

            <div class="form-row" style="padding-bottom:10px;"> 
                <label for="inputSenha" class="col-sm-2 col-form-label">Senha</label>
                <div class="col-sm-10">
                <input type="password" class="form-control" id="inputSenha" name="senha" value="<?php echo $usu[0]['senha'];?>">
                </div>
            </div>

            <div class="form-row" style="padding-bottom:10px;">
            <label for="inputTipoIngresso" class="col-sm-2 col-form-label">Tipo de Ingresso</label>
                <div class="input-group sm-3" style="width: auto;">
                <select class="custom-select" id="inputTipoUsuario" name="tipo_ingresso">
                    <?php 
                    $ingresso = ["A", "A1", "B", "B1", "C", "D", "D1", "E", "E1", "F"];
                    $index = array_search($usu[0]['tipo_ingresso'], $ingresso);
                    if ($index !== false) {
                        unset($ingresso[$index]);
                    }
                    echo '<option selected value="'.$usu[0]['tipo_ingresso'].'">'.$usu[0]['tipo_ingresso'].'</option>';
                    foreach ($ingresso as $ing) {
                        echo '<option value="'.$ing.'">'.$ing.'</option>';
                    }
                    ?>
                </select>
                </div>
            </div>

            <div class="form-row" style="padding-bottom:10px;">
                <label for="inputArea" class="col-sm-2 col-form-label">Área de atuação</label>
                <div class="input-group sm-2" style="width: auto;">
                <?php
                    if ($usu[0]['id_area'] == '-')
                        echo '<input type="text" readonly class="form-control" id="inputArea" name="area" value="Nenhum">';
                    else {
                        echo '<select class="custom-select" id="inputArea" name="id_area">';
                        foreach ($nome_areas as $item) {
                            echo '<option value="'.$item['id'].'">'.$item['nome'].'</option>';                   
                        }
                        echo '</select>';
                    }
                ?>
                </div>
            </div>

            <div class="form-row" style="padding-bottom:10px;">
                <button class="btn btn-primary btn-block" type="submit" name="alterar">Alterar Cadastro</button>
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