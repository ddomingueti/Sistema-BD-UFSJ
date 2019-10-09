<?php
include "$_SERVER[DOCUMENT_ROOT]/sistema-bd-ufsj/controller/area_controller.php";
$areaController = new AreaController();

if($_SERVER["REQUEST_METHOD"] == "GET") {
    var_dump($_GET);
    $ret = $areaController->removerArea($_GET['id']);
    header ('Location: table.php');
}
?>