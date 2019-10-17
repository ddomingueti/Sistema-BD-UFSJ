<?php
include "$_SERVER[DOCUMENT_ROOT]/sistema-bd-ufsj/controller/usuario_controller.php";

session_start();
if((!isset ($_SESSION['cpf']) == true) and (!isset ($_SESSION['tipo_usuario']) == true)) {
    header('location: ../../index.php');
}

$usuarioController = new UsuarioController();

if($_SERVER["REQUEST_METHOD"] == "GET") {
    $ret = $usuarioController->removerUsuario($_GET['cpf']);
    header ('Location: table.php');
}
?>