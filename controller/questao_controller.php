<?php
include "$_SERVER[DOCUMENT_ROOT]/sistema-bd-ufsj/model/questao_DAO.php";

class QuestaoController {
    private $questaoDao = null;

    public function __construct() {
        $this->questaoDao = new QuestaoDao();
    }

    public function adicionarQuestao($id, $id_area, $enunciado, $tipo, $resposta, $a, $b, $c, $d, $e, $caminho_imagens) { 
        $data = [
            "id" => $id,
            "id_area" => $id_area,
            "enunciado" => $enunciado,
            "tipo" => $tipo,
            "resposta" => $resposta,
            "a" => $a,
            "b" => $b,
            "c" => $c,
            "d" => $d,
            "e" => $e,
            "caminho_imagens" => $caminho_imagens,
        ];
        $res = $this->questaoDao->adicionarQuestao($data);
        return $res;

    }

    public function removerQuestao($id) { 
        $data = [ "id" => $id, ];
        $res = $this->questaoDao->removerQuestao($data);
        return $res;
    }

    public function alterarQuestao($id, $id_area, $enunciado, $tipo, $resposta, $a, $b, $c, $d, $e, $caminho_imagens) { 
        $data = [
            "id" => $id,
            "id_area" => $id_area,
            "enunciado" => $enunciado,
            "tipo" => $tipo,
            "resposta" => $resposta,
            "a" => $a,
            "b" => $b,
            "c" => $c,
            "d" => $d,
            "e" => $e,
            "caminho_imagens" => $caminho_imagens,
        ];
        $res = $this->alterarQuestao($data);
        return $res;
    }

    public function buscarQuestao($id) { 
        $data = [ "id" => $id, ];
        $res = $this->questaoDao->buscarQuestao($data);
    }
}