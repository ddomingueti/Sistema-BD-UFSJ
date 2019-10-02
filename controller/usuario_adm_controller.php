<?php
include "$_SERVER[DOCUMENT_ROOT]/sistema-bd-ufsj/controller/area_controller.php";
include "$_SERVER[DOCUMENT_ROOT]/sistema-bd-ufsj/controller/avaliacao_controller.php";
include "$_SERVER[DOCUMENT_ROOT]/sistema-bd-ufsj/controller/prova_controller.php";
include "$_SERVER[DOCUMENT_ROOT]/sistema-bd-ufsj/controller/questao_controller.php";
include "$_SERVER[DOCUMENT_ROOT]/sistema-bd-ufsj/controller/usuario_controller.php";

class AdministradorController {

    private $areaController;
    private $avaliacaoController = null;
    private $provaController = null;
    private $questaoController = null;
    private $usuarioController = null;
    private $admDao = null;

    public function __construct() {
        $this->areaController = new AreaController();
        $this->avaliacaoController = new AvaliacaoController();
        $this->provaController = new ProvaController();
        $this->questaoController = new QuestaoController();
        $this->usuarioController = new UsuarioController();

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