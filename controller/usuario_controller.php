<?php
include "$_SERVER[DOCUMENT_ROOT]/sistema-bd-ufsj/model/usuario_DAO.php"

class UsuarioController {
    private var $usuarioDao = null

    public function __construct() {
        $usuarioDao = new UsuarioDAO();
    }

    public function adicionarUsuario() { }

    public function removerUsuario() { }

    public function alterarUsuario() { }

    public function buscarUsuario() { }
}