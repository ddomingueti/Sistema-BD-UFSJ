<?php
include "$_SERVER[DOCUMENT_ROOT]/sistema-bd-ufsj/controller/avaliacao_controller.php";

session_start();
if((!isset ($_SESSION['cpf']) == true) and (!isset ($_SESSION['tipo_usuario']) == true)) {
    header('location: ../../index.php');
}

$avaliacaoController = new AvaliacaoController();

if($_SERVER["REQUEST_METHOD"] == "GET") {
    $ret = $avaliacaoController->removerAvaliacao($_GET['id']);
    header ('Location: table.php');
}
?>