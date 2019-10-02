<?php
include "$_SERVER[DOCUMENT_ROOT]/sistema-bd-ufsj/model//model/avaliacao_DAO.php";
include "usuario_controller.php";

class AvaliacaoController {
    private $avaliacaoDao = null;
    private $usuario_controller = null;

    public function __construct() { 
        $avaliacaoDao = new AvaliacaoDao();
        $professorDao = new ProfessorDao();
        $usuario_controller = new UsuarioController();
    }

    public function adicionarAvaliacao($avaliacao, $professor) { }

    public function removerAvaliacao($avaliacao, $professor) { }

    public function alterarAvaliacao($avaliacao, $professor) { }

    public function buscarAvaliacao($avaliacao, $professor) { }
}

?>