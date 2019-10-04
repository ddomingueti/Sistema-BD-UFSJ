<?php
include "$_SERVER[DOCUMENT_ROOT]/sistema-bd-ufsj/model/area_DAO.php";

class AreaController {
    private $areaDao;

    public function __construct() {
        $this->areaDao = new AreaDao();
    }

    public function adicionarArea($nome_area) {
        $data = [ "nome" => $nome_area, ];
        $result = $this->areaDao->adicionarArea($data);
        return $result;
    }

    public function removerArea($id) { 
        $data = [ "id" => $id, ];
        $result = $this->areaDao->removerArea($data);
        return $result;
    }

    public function alterarArea($id, $nome_area_alterado) {
        $data = [ "id" => $id, "nome_area" => $nome_area_alterado, ];
        $result = $this->areaDao->alterarArea($data);
        return $result;
    }

    public function buscarArea($id, $nome) {
        $data = ["nome" => $nome, "id" => $id, ];
        $result = $this->areaDao->buscarArea($data);
        return $result;
    }
}
?>