<?php
include "$_SERVER[DOCUMENT_ROOT]/sistema-bd-ufsj/model/questao_DAO.php";

class QuestaoController {
    private var $questaoDao = null;

    public function __construct() {
        $questaoDao = new QuestaoDao();
    }
    public function adicionarQuestao() { }

    public function removerQuestao() { }

    public function alterarQuestao() { }

    public function buscarQuestao() { }
}