<?php
include "$_SERVER[DOCUMENT_ROOT]/sistema-bd-ufsj/model/avaliacao_DAO.php";

class AvaliacaoController {
    private $avaliacaoDao = null;

    public function __construct() { 
        $avaliacaoDao = new AvaliacaoDao();
    }

    public function adicionarAvaliacao($avaliacao, $professor) { }

    public function removerAvaliacao($avaliacao, $professor) { }

    public function alterarAvaliacao($avaliacao, $professor) { }

    public function buscarAvaliacao($avaliacao, $professor) { }
}

?>