<?php
include "$_SERVER[DOCUMENT_ROOT]/sistema-bd-ufsj/controller/area_controller.php";

session_start();
if((!isset ($_SESSION['cpf']) == true) and (!isset ($_SESSION['tipo_usuario']) == true)) {
    header('location: ../../index.php');
}

$areaController = new AreaController();

if($_SERVER["REQUEST_METHOD"] == "GET") {
    $ret = $areaController->removerArea($_GET['id']);
    header ('Location: table.php');
}
?>