<?php
include "$_SERVER[DOCUMENT_ROOT]/sistema-bd-ufsj/model/avaliacao_controller.php";
include "$_SERVER[DOCUMENT_ROOT]/sistema-bd-ufsj/model/usuario_controller.php";

class ProfessorController {

    private var $avaliacoesController = null;
    private var $usuarioController = null;

    public function __construct() { 
        $avaliacoesController = new AvaliacaoController();
        $usuarioController = new UsuarioController();
    }

    public function buscarAvaliacao($avaliacao) {
        $avaliacoesController.buscarAvaliacao($avaliacao);
    }

    public function adicionarAvaliacao() {
        $avaliacoesController.adicionarAvaliacao();
    }
}

