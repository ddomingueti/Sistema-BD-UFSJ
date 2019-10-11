<?php
include "$_SERVER[DOCUMENT_ROOT]/sistema-bd-ufsj/controller/questao_controller.php";
$questaoController = new QuestaoController();

if($_SERVER["REQUEST_METHOD"] == "GET") {
    var_dump($_GET);
    $ret = $questaoController->removerQuestao($_GET['id']);
    
    //header ('Location: table.php');
}
?>