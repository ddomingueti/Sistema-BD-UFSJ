<?php
include "$_SERVER[DOCUMENT_ROOT]/sistema-bd-ufsj/model/area_DAO.php";

class AreaController {
    private $areaDao;
    private $result;

    public function __construct() {
        $this->areaDao = new AreaDao();
    }

    public function adicionarArea($nome_area) {
        $result = $this->areaDao->adicionar_area($nome_area);
        return $result;
    }

    public function remover_area($nome_area) { 
        $result = $this->areaDao->remover_area($nome_area);
        return $result;
    }

    public function alterar_area($id, $nome_area_alterado) {
        $result = $this->areaDao->alterar_area($id, $nome_area_alterado);
        return $result;
    }

    public function buscar_area($area) {
        $result = $this->areaDao->buscar_area($area);
        return $result;
    }
}
?>