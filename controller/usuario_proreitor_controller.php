<?php

include "$_SERVER[DOCUMENT_ROOT]/sistema-bd-ufsj/model/prova_DAO.php";

class ProReitorController {

    private $estatisticasDAO = null;

    public function __construct() {
        $estatisticasDAO = new ProvaDAO();
    }

    public function calculaMediaAreaSexo($area){ 

    	$area = ["area" => $id,];

    	$ret = $this->estatisticasDAO->calculaMediaAreaSexo($area);
    	return $ret;

    }

	public function calculaMediaAreaCota($area){

		$area = ["area" => $id,];

		$ret = $this->estatisticasDAO->calculaMediaAreaSexo($area);
		return $ret;

   	}

	public function alunosAcimaMedia($area){

		$area = ["area" => $id,];

		$ret = $this->estatisticasDAO->alunosAcimaMedia($area);
		return $ret;

	}

	public function alunosAbaixoMedia($area){ 

		$area = ["area" => $id,];

		$ret = $this->estatisticasDAO->alunosAbaixoMedia($area);
		return $ret;

	}

	public function alunosAcimaMediaSexo($area){ 

		$area = ["area" => $id,];

		$ret = $this->estatisticasDAO->alunosAcimaMediaSexo($area);
		return $ret;

	}

	public function alunosAcimaMediaCota($area){

		$area = ["area" => $id,];

		$ret = $this->estatisticasDAO->alunosAcimaMediaCota($area);
		return $ret;

	}

	public function mediaAreas(){

		$ret = $this->estatisticasDAO->mediaAreas($area);
		return $ret;

	}

	public function mediaAreaAno(){ 

		$ret = $this->estatisticasDAO->mediaAreaAno($area);
		return $ret;

	}

}