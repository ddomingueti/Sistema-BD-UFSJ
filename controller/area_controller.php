<?php
include "../model/area_DAO.php";

class AreaController {
    var $areaDao = null;

    public function __construct() {
        $areaDao = new AreaDao();
    }

    public function adicionarArea() { }

    public function removerArea($area) { }

    public function alterarArea($area) { }

    public function buscarArea($area) { }

}
?>