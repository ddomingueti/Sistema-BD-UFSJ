<?php
//include "$_SERVER[DOCUMENT_ROOT]/sistema-bd-ufsj/model/questao_DAO.php";

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
        $res = $this->questaoDao->alterarQuestao($data);
        return $res;
    }

    public function incrementarNumAcertos($id_questao, $num_acertos) {
        $data = ["id" => $id_questao,];
        $res = $this->questaoDao->incrementarNumAcertos($data);
        return $res;
    }

    public function buscarQuestao($id, $readble) { 
        $data = [ "id" => $id, "readble" => $readble];
        $res = $this->questaoDao->buscarQuestao($data);
        return $res;
    }

    public function buscarQuestaoArea($id_area) {
        $data = ["id_area" => $id_area, ];
        $res = $this->questaoDao->buscarQuestaoArea($data);
        return $res;
    
    }

    public function buscarRespostaQuestao($id) {
        $data = ["id" => $id,];
        $ret = $this->questaoDao->buscarRespostaQuestao($data);
        return $ret;
    }
}