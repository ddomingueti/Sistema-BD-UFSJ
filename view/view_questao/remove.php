<?php
include "$_SERVER[DOCUMENT_ROOT]/sistema-bd-ufsj/controller/questao_controller.php";
$questaoController = new QuestaoController();

session_start();
if((!isset ($_SESSION['cpf']) == true) and (!isset ($_SESSION['tipo_usuario']) == true)) {
    header('location: ../../index.php');
}

if($_SERVER["REQUEST_METHOD"] == "GET") {
    $ret = $questaoController->removerQuestao($_GET['id']);
    header ('Location: table.php');
}
?>