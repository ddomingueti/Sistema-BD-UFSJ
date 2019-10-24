<?php
include "$_SERVER[DOCUMENT_ROOT]/sistema-bd-ufsj/controller/questao_controller.php";
include "$_SERVER[DOCUMENT_ROOT]/sistema-bd-ufsj/controller/area_controller.php";

$areaController = new AreaController();
$questaoController = new QuestaoController();

$folder = $_SERVER['DOCUMENT_ROOT']."/sistema-bd-ufsj/Crawler/Questoes";
$acabou = false;
$error = false;
set_time_limit(0);

if (is_dir($folder)) {
    $pastas = scandir($folder);
    $r_area = false;
    for ($i=2; $i<count($pastas); $i++) {
        $nome_area = substr($pastas[$i], 0, -5);
        $r_area = $areaController->buscarArea(null, $nome_area);
    
        if (!$r_area) {
            $r_area = $areaController->adicionarArea($nome_area);
        }
        var_dump($nome_area);

        $imagem = null;
        $resposta = null;
        $subpasta = dir($folder."/".$pastas[$i]);
        $tem_questao = false;
        while (false !== ($entry = $subpasta->read())) {
            $resposta = null;
            //salva a imagem da questao
            if (substr($entry, strlen($entry)-3) == "jpg") {
                $imagem = $folder."/".$pastas[$i]."/".$entry;
                $tem_questao = true;
            }
            var_dump($entry);
            if ($tem_questao && substr($entry, strlen($entry)-3) == "txt") {
                $r_file = fopen($folder."/".$pastas[$i]."/".$entry, "r");
                $resposta = fgets($r_file);
                if (strlen($resposta) == 1) {
                    $data = ["id_area" => $r_area[0]['id'], 
                            "tipo" => "F", 
                            "enunciado" => null,
                            "resposta" =>  $resposta,
                            "num_acertos" => 0,
                            "a" => "Alternativa A",
                            "b" => "Alternativa B",
                            "c" => "Alternativa C",
                            "d" => "Alternativa D",
                            "e" => "Alternativa E", ];
                    
                    $r = $questaoController->adicionarQuestao($data);
                    // copia a imagem para a pasta da questão
                    copy($imagem, $r['caminho']."/".substr($imagem, strlen($imagem) - 6));
                }
                $tem_questao = false;
            }
        }
    }
} else {
    $error = "Atenção!<p>Não foi identificado a pasta ../Crawler/Questoes contendo as questões obtidas! Execute o Crawler manualmente, e então atualize a página para salvar as informações no banco de dados.";
}

$acabou = true;

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
      <div class="card-header">Popular o banco de questões</div>
      <div class="card-body">
        <?php 
            if (!is_dir($folder)) {
                echo "<div class='container bg-warning text-center'>".$error."</div>";
            } else if ($acabou) {
                echo "<div class='container bg-success text-center'>As questões foram salvas na base de dados!</div>";
            }
        ?>
        
        <div class="container" style="padding-bottom=10px;">
        Instruções e informações para o uso do Crawler para popular o banco de dados:
            <ul>
                <li>Navegue até a pasta Crawler (presente no servidor) onde está localizado o arquivo para extração das questões</li>
                <li>Execute o arquivo "main.py" presente na pasta (através do comando python main.py)</li>
                <li>Aguarde o final da execução</li>
                <li>Ao terminar, visite novamente essa página para que os dados sejam atualizados no banco de dados</li>
                <li>Você pode executar o extrator de outra pasta, no entanto, o resultado obtido (pasta Questoes) deve estar presente no sistema</li>
                <li>Cada questão extraída é extraída como uma imagem logo não é feita a verificação de questões duplicadas</li>
            </ul>
        </div>

        <div class="container md-2">
            <a class="btn btn-primary btn-block" href="table.php">Voltar</a>
        </div>
      </div>
      </div>
    </div>
</div>
</body>

</html>