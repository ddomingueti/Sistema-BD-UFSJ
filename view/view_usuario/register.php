<?php

    include "$_SERVER[DOCUMENT_ROOT]/sistema-bd-ufsj/controller/usuario_controller.php";
    include "$_SERVER[DOCUMENT_ROOT]/sistema-bd-ufsj/controller/area_controller.php";
    include "$_SERVER[DOCUMENT_ROOT]/sistema-bd-ufsj/controller/prova_controller.php";
    include "$_SERVER[DOCUMENT_ROOT]/sistema-bd-ufsj/controller/view_manager.php";

    session_start();
    if((!isset ($_SESSION['cpf']) == true) and (!isset ($_SESSION['tipo_usuario']) == true)) {
        header('location: ../../index.php');
    }

    $usuarioController = new UsuarioController();
    $areaController = new AreaController();
    $nome_areas = $areaController->buscarArea(null, null);
    $gerenciadorView = new GerenciadorView();
    $provaController = new ProvaController();

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $cpf = $_POST['cpf'];
        $idade = $_POST['idade'];
        $senha = $_POST['senha'];
        $sexo = $_POST['sexo'];
        $data_nasc = $_POST['data_nasc'];
        $id_area = $_POST['area'];
        $tipo_ingresso = $_POST['tipo_ingresso'];
        $tipo_usuario = $_POST['tipo_usuario'];

        if ($tipo_ingresso == 'N')
            $tipo_ingresso = null;
        
        if ($tipo_usuario == 'N')
            $tipo_usuario = null;

        if ($id_area == 'N')
            $id_area = null;
        

        if ((strlen($_POST['cpf']) != 11)  || (!is_numeric($_POST['cpf']))) {
            $msg = "Digite um número de CPF válido (11 dígitos)! Exemplo: 01234567891";
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $msg = "Formato de email inválido!";
        } else if (strlen($senha) > 20 && strlen($senha < 6)) {
            $msg = "A senha deve possuir entre 6 e 20 caracteres";
        } else if ($tipo_usuario != 1 && $tipo_ingresso != null) {
            $msg = "Apenas o usuário aluno deve preencher o campo Tipo de Ingresso!";
        } else if ($tipo_usuario != 2 && $id_area != null) {
            $msg = "Apenas o usuário professor deve preencher o campo Área de Atuação!";
        } else {
            $ret = $usuarioController->adicionarUsuario($nome, $email, $cpf, $idade, $senha, $sexo, $data_nasc, $id_area, $tipo_ingresso, $tipo_usuario);
            header ('Location: table.php');
        }
        echo "<script>window.alert('".$msg."')</script>";
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

  <!-- Page level plugin CSS-->
  <link href="../vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="../css/sb-admin.css" rel="stylesheet">

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

    <div id="content-wrapper">

      <div class="container-fluid">
        <!-- EDITAR AQUI-->          

        <div class="card card-register mx-auto mt-5">
          <div class="card-header">Cadastrar um novo usuário</div>
          <div class="card-body">
            <form action="" method="POST">
              <div class="form-group">
                <div class="form-row" style="padding-bottom:10px;">
                  <label for="inputCpf" class="col-sm-2 col-form-label">CPF</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputCpf" name="cpf">
                  </div>
                </div>
                <div class="form-row" style="padding-bottom:10px;">
                  <label for="inputNome" class="col-sm-2 col-form-label">Nome</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputNome" name="nome">
                  </div>
                </div>
                <div class="form-row" style="padding-bottom:10px;">
                      <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                      <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputEmail" name="email">
                      </div>
                </div>
                <div class="form-row" style="padding-bottom:10px;">
                      <label for="inputIdade" class="col-sm-2 col-form-label">Idade</label>
                      <div class="col-sm-2">
                      <input type="text" class="form-control" id="inputIdade" name="idade">
                      </div>
                      
                      <label for="inputDataNasc" class="col-sm-4 col-form-label">Data de Nascimento</label>
                      <div class="col-sm-4">
                      <input type="date" class="form-control" id="inputDataNasc" name="data_nasc">
                      </div>
                </div>

                <div class="form-row" style="padding-bottom:10px;"> 
                  <label for="inputSexo" class="col-sm-2 col-form-label">Sexo</label>
                  <div class="input-group sm-3" style="width: auto;">
                    <select class="custom-select" id="inputSexo" name="sexo">
                      <option value="M">Masculino</option>
                      <option value="F">Feminino</option>
                    </select>
                  </div>

                  <label for="inputTipoUsuario" class="col-sm-3 col-form-label">Tipo de usuário</label>
                  <div class="input-group sm-3" style="width: auto;">
                    <select class="custom-select" id="inputTipoUsuario" name="tipo_usuario">
                      <option value="0">Administrador</option>
                      <option value="1">Aluno</option>
                      <option value="2">Professor</option>
                      <option value="3">Pró-Reitor</option>
                    </select>
                  </div>
                </div>

                <div class="form-row" style="padding-bottom:10px;"> 
                  <label for="inputSenha" class="col-sm-2 col-form-label">Senha</label>
                  <div class="col-sm-10">
                  <input type="password" class="form-control" id="inputSenha" name="senha">
                  </div>
                </div>

                <div class="form-row" style="padding-bottom:10px;">
                  <label for="inputTipoIngresso" class="col-sm-2 col-form-label">Tipo de Ingresso</label>
                  <div class="input-group sm-3" style="width: auto;">
                    <select class="custom-select" id="inputTipoUsuario" name="tipo_ingresso">
                      <option value="N" selected>Nenhum</option>    
                      <option value="A">A</option>
                      <option value="A1">A1</option>
                      <option value="B">B</option>
                      <option value="B1">B1</option>
                      <option value="C">C</option>
                      <option value="D">D</option>
                      <option value="D1">D1</option>
                      <option value="E">E</option>
                      <option value="E1">E1</option>
                      <option value="F">E</option>
                      </select>
                  </div>
                </div>

                <div class="form-row" style="padding-bottom:10px;"> 
                  <label for="inputArea" class="col-sm-2 col-form-label">Área de atuação</label>
                  <div class="input-group sm-2" style="width: auto;">
                    <select class="custom-select" id="inputArea" name="area">
                      <option value="N" selected>Nenhuma</option>
                      <?php 
                        foreach ($nome_areas as $item) {
                          echo '<option value="'.$item['id'].'">'.$item['nome'].'</option>';                   
                        }
                      ?>
                    </select>
                  </div>
                </div>

                <div class="form-row" style="padding-bottom:10px;">
                  <button class="btn btn-primary btn-block" type="submit" name="cadastrar">Cadastrar</button>
                </div>
              </div>
            </form> 
          </div>
        </div>
        <!-- ATÉ AQUI -->   
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
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Page level plugin JavaScript-->
  <script src="../vendor/datatables/jquery.dataTables.js"></script>
  <script src="../vendor/datatables/dataTables.bootstrap4.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="../js/sb-admin.min.js"></script>

  <!-- Demo scripts for this page-->
  <script src="../js/demo/datatables-demo.js"></script>
</body>

</html>
