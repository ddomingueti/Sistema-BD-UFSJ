<?php
include "$_SERVER[DOCUMENT_ROOT]/sistema-bd-ufsj/model/usuario_aluno_dao.php";

class AlunoController {

    private var $areas_avaliacao = null;
    private var $num_questoes = null;
    private var $aluno_dao = null;
    private var $prova_controller = null;

    public function __construct() { 
        $aluno_dao = new AlunoDao();
    }

    public function criarSimulado() { 
        //...
        $prova_controller.adicionarProva();
    }

    public function configurarAmbiente() { }

    public function alterar_senha() { }
    

}