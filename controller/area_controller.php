<?php
include "$_SERVER[DOCUMENT_ROOT]/sistema-bd-ufsj/model/area_DAO.php";

class AreaController {
    private $areaDao;
    private $result;

    public function __construct() {
        $this->areaDao = new AreaDao();
    }

    public function adicionarArea($nome_area) {
        $result = $this->areaDao->adicionarArea($nome_area);
        return $result;
    }

    public function removerArea($nome_area) { 
        $result = $this->areaDao->removerArea($nome_area);
        return $result;
    }

    public function alterarArea($id, $nome_area_alterado) {
        $result = $this->areaDao->alterarArea($id, $nome_area_alterado);
        return $result;
    }

    public function buscarArea($area) {
        $result = $this->areaDao->buscarArea($area);
        return $result;
    }
}
?>