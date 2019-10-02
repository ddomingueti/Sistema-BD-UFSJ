<?php
include "$_SERVER[DOCUMENT_ROOT]/sistema-bd-ufsj/controller/area_controller.php";
//include "avaliacao_controller.php";
//include "prova_controller.php";
//include "questao_controller.php";
//include "usuario_controller.php";
//include "../model/usuario_DAO";

class AdministradorController {

    private $areaController;
    private $avaliacaoController = null;
    private $provaController = null;
    private $questaoController = null;
    private $usuarioController = null;
    private $admDao = null;

    public function __construct() {
        $this->areaController = new AreaController();
        //$avaliacaoController = new AvaliacaoController();
        //$provaController = new ProvaController();
        //$questaoController = new QuestaoController();
        //$usuarioController = new UsuarioController();

    }

    public function getAreaController() { return $this->areaController; }
    public function getAvaliacaoController() { return $this->avaliacaoController; }
    public function getProvaController() { return $this->provaController; }
    public function getQuestaoController() { return $this->questaoController; }
    public function getUsuarioController() { return $this->usuarioController; }

    public function popular_banco() { }
    //public function faztudo ();
}

?>