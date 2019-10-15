<?php 
    include "$_SERVER[DOCUMENT_ROOT]/sistema-bd-ufsj/controller/questao_controller.php";
    include "$_SERVER[DOCUMENT_ROOT]/sistema-bd-ufsj/controller/prova_controller.php";

    
    $provaController = new ProvaController();
    $questaoController = new QuestaoController();

    $questao_id = false;
    $questao = false;
    $atual = false;
    $questoes = false;

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        var_dump($_POST);
        $questoes = $provaController->buscarQuestaoProva($_POST['id_prova']);
        var_dump($questoes);
        $resposta = false;
        if ($_POST['resposta_a'] != null)
            $resposta = $_POST['resposta_a'];
        else
            $resposta = $_POST['resposta_f'];

        $ret = $provaController->alterarRespostaQuestao($_POST['id_prova'], $_POST['id_questao'], $resposta);
        
        $atual = $_POST['atual'];
        $atual = $atual + 1;

        if ($atual > count($questoes)) {
            header('Location: prova_finalizada.php?id_prova='.$_POST['id_prova']);
        } else {
            header ('Location: prova_questao.php?id_prova='.$_POST['id_prova'].'&id_questao='.$questoes[$atual]['id_questao'].'&atual='.$atual);
        }

    }

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        var_dump($_GET);
        $questao_id = $_GET['id_questao'];
        $questao = $questaoController->buscarQuestao($questao_id, false);
        $atual = $_GET['atual'];

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
      <div class="card-header">Questão <?php echo $atual + 1;?></div>
      <div class="card-body">
        <div class="card-text" style="padding-bottom:10px;">
            <?php echo $questao[0]['enunciado'];?>
        </div>
        <?php
            $dir = "../../resources/".$questao[0]['id_area']."/".$questao[0]['id'];
            if (file_exists($dir)) {
                $isDirEmpty = !(new \FilesystemIterator($dir))->valid();
                if (!$isDirEmpty) {
                    $files = scandir($dir);
                    for ($i = 0; $i < count($files); $i++) {
                        if ($files[$i] != '.' && $files[$i] != '..') {
                            echo '<div><center><br><img src="'.$dir."/".$files[$i].'" class="rounded">';
                            echo '<br>Figura '.($i-1).'</center></div>';
                        }
                    }
                }
            }

        ?>

        <form action="" method="POST">
            <div class="form-row" style="padding-bottom:10px; <?php if ($questao[0]['tipo'] == "F"){?> display:none;" <?php }?>>
                <div class="col-md-12">
                    <div class="input-group">
                        <div class="input-group-prepend col-md-2">
                            <label for="resposta">Resposta</label>
                        </div>
                            <textarea class="form-control" id="resposta" aria-label="Resposta" name="resposta_a"></textarea>
                    </div>
                </div>
            </div>
            
            <div style="<?php if ($questao[0]['tipo'] == 'A'){?> display:none;" <?php } ?>>

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="resposta_f" id="altA" value="A">
                        <label class="form-check-label" for="altA">
                            <?php echo $questao[0]['a']; ?>
                        </label>
                    </div>
                
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="resposta_f" id="altB" value="B">
                        <label class="form-check-label" for="altB">
                        <?php echo $questao[0]['b']?>
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="resposta_f" id="altc" value="C">
                        <label class="form-check-label" for="altc">
                        <?php echo $questao[0]['c']?>
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="resposta_f" id="altD" value="D">
                        <label class="form-check-label" for="altD">
                        <?php echo $questao[0]['d']?>
                        </label>
                    </div>
                
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="resposta_f" id="altE" value="E">
                        <label class="form-check-label" for="altE">
                        <?php echo $questao[0]['e']?>
                        </label>
                    </div>
                
            </div>
            
            <input type="hidden" id="id_prova" name="id_prova" value="<?php echo $_GET['id_prova'];?>">
            <input type="hidden" id="id_questao" name="id_questao" value="<?php echo $_GET['id_questao'];?>">
            <input type="hidden" id="atual" name="atual" value="<?php echo $_GET['atual']?>">

            <div class="form-group row">
              <button class="btn btn-primary btn-block" type="submit" name="proxima">Próxima questão</button>
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
