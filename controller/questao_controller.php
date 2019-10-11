<?php
include "$_SERVER[DOCUMENT_ROOT]/sistema-bd-ufsj/model/questao_DAO.php";

class QuestaoController {
    private $questaoDao = null;

    public function __construct() {
        $this->questaoDao = new QuestaoDao();
    }

    public function adicionarQuestao($data) { 
        $res = $this->questaoDao->adicionarQuestao($data);
        return $res;

    }

    public function removerQuestao($id) { 
        $data = [ "id" => $id, ];
        $res = $this->questaoDao->removerQuestao($data);
        return $res;
    }

    public function alterarQuestao($data) { 
        $res = $this->alterarQuestao($data);
        return $res;
    }

    public function buscarQuestao($id) { 
        $data = [ "id" => $id, ];
        $res = $this->questaoDao->buscarQuestao($data);
        return $res;
    }
}