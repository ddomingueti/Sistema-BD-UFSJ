<?php
include "$_SERVER[DOCUMENT_ROOT]/sistema-bd-ufsj/controller/usuario_controller.php";
$usuarioController = new UsuarioController();
if($_SERVER["REQUEST_METHOD"] == "GET") {
    var_dump($_GET);
    $ret = $usuarioController->removerUsuario($_GET['cpf']);
    header ('Location: table.php');
}
?>