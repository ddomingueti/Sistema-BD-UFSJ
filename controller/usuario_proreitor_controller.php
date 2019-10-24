<?php
include "$_SERVER[DOCUMENT_ROOT]/sistema-bd-ufsj/model/prova_DAO.php";

class ProReitorController {

    private $estatisticasDAO = null;

    public function __construct() {
        $this->estatisticasDAO = new ProvaDao();
    }

    public function calculaMediaAreaSexo($area){ 
    	$area = ["id" => $area,];
    	$ret = $this->estatisticasDAO->calculaMediaAreaSexo($area);
    	return $ret;
    }

	public function calculaMediaAreaCota($area){
		$area = ["id" => $area,];
		$ret = $this->estatisticasDAO->calculaMediaAreaSexo($area);
		return $ret;
   	}

	public function alunosAcimaMedia($area){
		$area = ["id" => $area,];
		$ret = $this->estatisticasDAO->alunosAcimaMedia($area);
		return $ret;
	}

	public function alunosAbaixoMedia($area){ 
		$area = ["id" => $area,];
		$ret = $this->estatisticasDAO->alunosAbaixoMedia($area);
		return $ret;
	}

	public function alunosAcimaMediaSexo($area){ 
		$area = ["id" => $area,];
		$ret = $this->estatisticasDAO->alunosAcimaMediaSexo($area);
		return $ret;
	}

	public function alunosAcimaMediaCota($area){
		$area = ["id" => $area,];
		$ret = $this->estatisticasDAO->alunosAcimaMediaCota($area);
		return $ret;
	}

	public function mediaAreas(){
		$ret = $this->estatisticasDAO->mediaAreas();
		return $ret;
	}

	public function mediaTempoAreas(){
		$ret = $this->estatisticasDAO->mediaTempoAreas();
		return $ret;
	}

	public function mediaAreaAno(){ 
		$ret = $this->estatisticasDAO->mediaAreaAno();
		return $ret;
	}

	public function mediaTempoAreaAno(){ 
		$ret = $this->estatisticasDAO->mediaTempoAreaAno();
		return $ret;
	}
}