<?php
include "../model/Uusuario_DAO.php"

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