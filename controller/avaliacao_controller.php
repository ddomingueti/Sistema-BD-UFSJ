<?php
include "$_SERVER[DOCUMENT_ROOT]/sistema-bd-ufsj/model/avaliacao_DAO.php";

class AvaliacaoController {
    private $avaliacaoDao = null;

    public function __construct() { 
        $avaliacaoDao = new AvaliacaoDao();
    }

    public function adicionarAvaliacao($comentario, $nota, $data, $id_usuario) { 
        $data = [
            "comentario" => $comentario,
            "nota" => $nota,
            "data" => $data,
            "id_usuario" => $id_usuario,
        ];
        $ret = $this->avaliacaoDao->adicionarAvaliacao($data);
        return $ret;
    }

    public function removerAvaliacao($id) { }

    public function alterarAvaliacao($id, $comentario, $nota, $data) { 
        $data = [
            "comentario" => $comentario,
            "nota" => $nota,
            "data" => $data,
        ];
        $ret = $this->avaliacaoDao->alterarAvaliacao($data);
        return $ret;
    }

    public function buscarAvaliacao($id, $id_avaliacao) { 
        $data = [
            "id" => $id
            "id_usuario" => $id_avaliacao,
        ];
        $ret = $this->avaliacaoDao->buscarAvaliacao($data);
        return $ret;
    }

    public function buscarAvaliacaoUsuario($id_usuario) {
        $data = [ "id_usuario" => $id_usuario, ];
        $ret = $this->avaliacaoDao->buscarAvaliacaoProfessor($data);
        return $ret;
    }

    public function buscarAvaliacaoData($data) {
        $data_in = ["data" => $data, ];
        $ret = $this->avaliacaoDao->buscarAvaliacaoData($data_in);
        return $ret;
    }
}

?>