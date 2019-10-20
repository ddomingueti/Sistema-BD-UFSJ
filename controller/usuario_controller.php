<?php
include "$_SERVER[DOCUMENT_ROOT]/sistema-bd-ufsj/model/usuario_DAO.php";

class UsuarioController {
    private $usuarioDao = null;

    public function __construct() {
        $this->usuarioDao = new UsuarioDAO();
    }

    public function adicionarUsuario($nome, $email, $cpf, $idade, $senha, $sexo, $data_nasc, $id_area, $tipo_ingresso, $tipo_usuario) {
        $data = [
            "nome" => $nome,
            "email" => $email,
            "cpf" => $cpf,
            "idade" => $idade,
            "senha" => $senha,
            "sexo" => $sexo,
            "data_nasc" => $data_nasc,
            "id_area" => $id_area,
            "tipo_ingresso" => $tipo_ingresso,
            "tipo_usuario" => $tipo_usuario,
        ];
        
        $ret = $this->usuarioDao->adicionarUsuario($data);
        return $ret;
    }

    public function removerUsuario($cpf) {
        $data = [ "cpf" => $cpf ];
        $ret = $this->usuarioDao->removerUsuario($data);
        return $ret;
    }

    public function alterarUsuario($nome, $email, $cpf, $idade, $senha, $sexo, $data_nasc, $id_area, $tipo_ingresso) { 
        $data = [
            "nome" => $nome,
            "email" => $email,
            "cpf" => $cpf,
            "idade" => $idade,
            "senha" => $senha,
            "sexo" => $sexo,
            "data_nasc" => $data_nasc,
            "id_area" => $id_area,
            "tipo_ingresso" => $tipo_ingresso,
        ];
        $ret = $this->usuarioDao->alterarUsuario($data);
        return $ret;
    }

    public function buscarUsuario($cpf) {
        $data = [ "cpf" => $cpf, ];
        $ret = $this->usuarioDao->buscarUsuario($data);
        return $ret;
    }

    public function buscarUsuarioTipo($tipo_usuario) {
        if ($tipo_usuario == "administrador") {
            $tipo_usuario = 0;
        } else if ($tipo_usuario == "aluno") {
            $tipo_usuario = 1;
        } else if ($tipo_usuario == "professor") {
            $tipo_usuario = 2;
        } else if ($tipo_usuario == "proreitor") {
            $tipo_usuario = 3;
        }
        $data = [ "tipo_usuario" => $tipo_usuario, ];
        $res = $this->usuarioDao->buscarUsuarioTipo($data);
        return $res;
    }

    public function realizarLogin($cpf, $senha) {
        $ret = $this->buscarUsuario($cpf);
        $data = ['success' => false, 'area' => null, 'msg' => ""];
        if (count($ret) == 1) {
            $return_area = null;
            if ($senha == $ret[0]['senha']) {
                $data['success'] = true;
                $data['area'] = 'view/index.php';
                $data['msg'] = "Bem vindo!";
                $data['tipo_usuario'] = $ret[0]['tipo_usuario'];
            } else {
                $data['success'] = false;
                $data['area'] = null;
                $data['msg'] = "Senha inválida";
                $data['tipo_usuario'] = null;
            }
        } else {
            $data['msg'] = "Usuário inválido";
        }
        return $data;
    }
}