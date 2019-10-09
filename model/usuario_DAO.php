<?php

include "$_SERVER[DOCUMENT_ROOT]/sistema-bd-ufsj/conexao.php";

class UsuarioDao {

    public function adicionarUsuario($data) { 
        $query = 'INSERT INTO usuario (nome, email, cpf, idade, senha, sexo, data_nasc, id_area, tipo_ingresso, tipo_usuario) 
        VALUES (:nome, :email, :cpf, :idade, :senha, :sexo, :data_nasc, :id_area, :tipo_ingresso, :tipo_usuario)';
        
        try {
            $stmt = Conexao::get_instance()->get_conexao()->prepare($query);
            $stmt->bindParam(':nome', $data['nome']);
            $stmt->bindParam(':email', $data['email']);
            $stmt->bindParam(':cpf', $data['cpf']);
            $stmt->bindParam(':senha', $data['senha']);
            $stmt->bindParam(':sexo', $data['sexo']);
            $stmt->bindParam(':idade', $data['idade']);
            $stmt->bindParam(':data_nasc', $data['data_nasc']);
            $stmt->bindParam(':id_area', $data['id_area']);
            $stmt->bindParam(':tipo_ingresso', $data['tipo_ingresso']);
            $stmt->bindParam(':tipo_usuario', $data['tipo_usuario']);
            
            $r = $stmt->execute();
            var_dump($r);
            $result = $stmt->fetchAll();
            return $result;
        } catch (PDOEXception $e) {
            return "Erro: ".$e->getMessage();
        }
    }

    public function removerUsuario($data) {
        $query = 'DELETE FROM usuario WHERE cpf = :cpf';
        try {
            $stmt = Conexao::get_instance()->get_conexao()->prepare($query);
            $stmt->bindParam(':cpf', $data['cpf']);
            $e = $stmt->execute();
            $result = $stmt->fetchAll();
            return $result;
        } catch (PDOException $e) {
            return "Erro: ".$e->getMessage();
        }
    }

    public function alterarUsuario($data) {
        $query = 'UPDATE usuario SET nome=:nome, email=:email, idade=:idade, senha=:senha, sexo=:sexo, data_nasc=:data_nasc, id_area=:id_area, tipo_ingresso=:tipo_ing 
                    WHERE cpf=:cpf ORDER BY cpf';
        try {
            if ($data['id_area'] == '-')
                $data['id_area'] = null;
            $stmt = Conexao::get_instance()->get_conexao()->prepare($query);
            $stmt->bindParam(':nome', $data['nome']);
            $stmt->bindParam(':email', $data['email']);
            $stmt->bindParam(':cpf', $data['cpf']);
            $stmt->bindParam(':senha', $data['senha']);
            $stmt->bindParam(':sexo', $data['sexo']);
            $stmt->bindParam(':idade', $data['idade']);
            $stmt->bindParam(':data_nasc', $data['data_nasc']);
            $stmt->bindParam(':id_area', $data['id_area']);
            $stmt->bindParam(':tipo_ing', $data['tipo_ingresso']);
            
            $s = $stmt->execute();
            $result = $stmt->fetchAll();
            return $result;
        } catch (PDOEXception $e) {
            return "Erro: ".$e->getMessage();
        }
        
    }

    public function buscarUsuario($data) {         
        $query = 'SELECT * FROM usuario WHERE cpf=:cpf';
        if ($data['cpf'] == null) {
            $query = 'SELECT * FROM usuario WHERE 1';
        }
        try {
            $stmt = Conexao::get_instance()->get_conexao()->prepare($query);
            if ($data['cpf'] != null) {
                $stmt->bindParam(':cpf', $data['cpf']);
            }
            
            $stmt->execute();
            $result = $stmt->fetchAll();

            for ($i=0; $i<count($result); $i++) {
                if ($result[$i]['id_area'] != null) {
                    $query = 'SELECT nome from area WHERE id=:id';
                    $stmt = Conexao::get_instance()->get_conexao()->prepare($query);
                    $stmt->bindParam('id', $result[$i]['id_area']);
                    $stmt->execute();
                    $res_nomes = $stmt->fetchAll();
                    $result[$i]['id_area'] = $res_nomes[0]['nome'];
                } else {
                    $result[$i]['id_area'] = '-';
                }
            }

            return $result;
        } catch (PDOEXception $e) {
            return "Erro: ".$e->getMessage();
        }
    }
}