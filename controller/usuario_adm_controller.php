<?php
include "area_controller.php";
include "avaliacao_controller.php";
include "prova_controller.php";
include "questao_controller.php";
include "usuario_controller.php";
include "../model/usuario_adm_DAO";

class AdministradorController {

    private var $areaController = null;
    private var $avaliacaoController = null;
    private var $provaController = null;
    private var $questaoController = null;
    private var $usuarioController = null;
    private var $admDao = null;

    public function __construct() {
        $areaController = new AreaController();
        $avaliacaoController = new AvaliacaoController();
        $provaController = new ProvaController();
        $questaoController = new QuestaoController();
        $usuarioController = new UsuarioController();

    }

    public function popular_banco() { }
    //public function faztudo ();
}