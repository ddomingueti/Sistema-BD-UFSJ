<?php
include "$_SERVER[DOCUMENT_ROOT]/sistema-bd-ufsj/model/avaliacao_DAO.php";

class AvaliacaoController {
    private $avaliacaoDao;

    public function __construct() { 
        $this->avaliacaoDao = new AvaliacaoDao();
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

    public function removerAvaliacao($id) {
        $data = [ "id" => $id, ];
        $ret = $this->avaliacaoDao->removerAvaliacao($data);
        return $ret;
     }

    public function alterarAvaliacao($id, $comentario, $nota, $data) { 
        $data = [
            "comentario" => $comentario,
            "nota" => $nota,
            "data" => $data,
            "id" => $id,
        ];
        var_dump($data);
        $ret = $this->avaliacaoDao->alterarAvaliacao($data);
        return $ret;
    }

    public function buscarAvaliacao($id_avaliacao, $id_usuario) { 
        $data = null;
        $ret = null;

        if ($id_avaliacao == null && $id_usuario != null) {
            $data = ["cpf" => $id_usuario, ];
            $ret = $this->avaliacaoDao->buscarAvaliacaoUsuarioUnico($data);
        } else if ($id_avaliacao != null && $id_usuario == null) {
            $data = ["id" => $id_avaliacao, ];
            $ret = $this->avaliacaoDao->buscarAvaliacaoUnica($data);
        } else {
            $ret = $this->avaliacaoDao->buscarAvaliacaoUsuarios();
        }

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