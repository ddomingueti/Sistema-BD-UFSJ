<?php
include "$_SERVER[DOCUMENT_ROOT]/sistema-bd-ufsj/model/prova_DAO.php";
include_once "$_SERVER[DOCUMENT_ROOT]/sistema-bd-ufsj/model/questao_DAO.php";

class ProvaController {

    private $provaDao = null;
    private $questaoDao = null;

    public function __construct() {
        $this->provaDao = new ProvaDao();
        $this->questaoDao = new QuestaoDao();
    }

    public function adicionarProva($id_usuario, $num_questoes, $id_area) { 
        $data_entrada = date("Y-m-d");
        $finalizada = false;
        $data = ["id_area" => $id_area, ];
        $questoesArea = $this->questaoDao->buscarQuestaoArea($data);
        $questoes = [];
        $num_acertos = 0;
        if (count($questoesArea) < $num_questoes) {
            $num_questoes = count($questoesArea);
            for ($i=0; i<count($questoesArea); $i++) {
                $array_push($questoes, $questoesArea[$i]['id']);
            }
        } else {
            for ($i = 0; $i < $num_questoes; $i++) {
                $id = rand(0, count($questoesArea) - 1);
                array_push($questoes, $questoesArea[$id]['id']);
                unset($questoesArea[$id]);
                $questoesArea = array_values($questoesArea);
            }

            $data = ["data" => $data_entrada, 
            "id_usuario" => $id_usuario,    
            "finalizada" => $finalizada,
            "questoes" => $questoes,
            "num_acertos" => $num_acertos,
        ];

            $res = $this->provaDao->adicionarProva($data);
            return $res;
        }
    }

    public function removerProva($id_prova) { 
        $data = [
            "id" => $id_prova,
        ];
        $ret = $this->provaDao->removerProva($data);
        return $ret;
    }

    public function buscarProva($id_prova) { 
        $data = [
            "id" => $id_prova,
        ];
        $ret = $this->provaDao->buscarProva($data);
        return $ret;
    }

    public function buscarProvaAluno($id_usuario) {
        $data =[ "id_usuario" => $id_usuario, ];
        $ret = $this->provaDao->buscarProvaAluno($data);
        return $ret;
    }

    public function buscarQuestaoProva($id_prova) {
        $data = ["id_prova" => $id_prova, ];
        $ret = $this->provaDao->buscarQuestaoProva($data);
        return $ret;
    }
    
    // Relacao Formada_Por
    
    public function buscarRespostaUsuQuestao($id_prova, $id_questao) {
        $data = [ "id_prova" => $id_prova, "id_questao" => $id_questao,];
        $ret = $this->provaDao->buscarRespostaUsuQuestao($data);
        return $ret;
    }

    public function alterarRespostaQuestao($id_prova, $id_questao, $resposta) {
        $data = [ "id_prova" => $id_prova, "id_questao" => $id_questao, "resposta" => $resposta,];
        $ret = $this->provaDao->alterarRespostaQuestao($data);
        return $ret;
    }

    public function calculaResultadoProva($id_prova) {
        $questoes = $this->buscarQuestaoProva($id_prova);
        $notaUsuario = 0;
        $totalQuestoes = 1;
        
        $numQuestoes = array_fill(0, sizeof($questoes), 0);
        $idQuestoes = array_fill(0, sizeof($questoes), 0);
        $respostasUsuario = array_fill(0, sizeof($questoes), 0);
        $gabarito = array_fill(0, sizeof($questoes), 0);

        for ($i=0; $i<sizeof($questoes); $i++) {
            $resposta = $questoes[$i]['resposta_usuario'];
            if (($questoes[$i]['tipo'] == "F") && ($questoes[$i]['resposta'] == $questoes[$i]['resposta_usuario'])) {
                $notaUsuario = $notaUsuario + 1;
            }
            
            $idQuestoes[$i] = $questoes[$i]['id'];
            $numQuestoes[$i] = $totalQuestoes;
            $respostasUsuario[$i] = $questoes[$i]['resposta_usuario'];
            $gabarito[$i] = $questoes[$i]['resposta'];
            $totalQuestoes = $totalQuestoes + 1;
        }

        $tabelaResultados = [
            "num_questao" => $numQuestoes,
            "id_questao" => $idQuestoes,
            "resposta_usuario" => $respostasUsuario,
            "gabarito" => $gabarito,
            "nota" => $notaUsuario,
        ];
        
        return $tabelaResultados;
    }
}


?>