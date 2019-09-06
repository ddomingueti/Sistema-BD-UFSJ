<?php

class ProReitorController {

    private var $proreitor_dao = null;
    private var $usuario_controller = null;
    private var $avaliacao_controller = null;
    public function __construct() {
        $usuario_controller = new UsuarioController();
        $avaliacao_controller = new AvaliacaoController();
    }

    public function buscarProfessor() { }

    public function adicionarAvaliacao() { }

}