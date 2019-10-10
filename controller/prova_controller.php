<?php
include "$_SERVER[DOCUMENT_ROOT]/sistema-bd-ufsj/model/prova_DAO.php";

class ProvaController {

    private $provaDao = null;

    public function adicionarProva($data, $finalizada, $num_acertos, $id_usuario, $questoes) { 

        $dataP = [
            "data" => $data,
            "finalizada" => $finalizada,
            "num_acertos" => $num_acertos,
            "id_usuario" => $id_usuario,
            "num_questoes" => $total_questoes,
            "questoes" => $questoes,
        ];
    }

    public function removerProva($id_prova) { 
        $data = [
            "id_prova" => $id_prova,
        ]
        $ret = $this->provaDao->removerProva($data);
        return $ret;
    }

    public function buscarProva($id_prova) { 
        $data = [
            "id_prova" => $id_prova,
        ]
        $ret = $this->provaDao->buscarProva($data);
        return $ret;
    }

    public function buscarProvaAluno($id_usuario) {
        $data =[ "id_usuario" => $id_usuario, ];
        $ret = $this->provaDao->buscarProvaAluno($data);
        return $ret;
    }
}


?>