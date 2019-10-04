<?php

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
            
            $stmt->execute();
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
                    WHERE cpf=:cpf';
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
            $stmt->bindParam(':tipo_ing', $data['tipo_ingresso']);
            
            $s = $stmt->execute();
            var_dump($s); 
            $result = $stmt->fetchAll();
            return $result;
        } catch (PDOEXception $e) {
            return "Erro: ".$e->getMessage();
        }
        
    }

    public function buscarUsuario($data) {         
        $query = 'SELECT * FROM usuario WHERE cpf=:cpf';
        if ($cpf == null) {
            $query = 'SELECT * FROM usuario WHERE 1';
        }
        try {
            $stmt = Conexao::get_instance()->get_conexao()->prepare($query);
            if ($cpf != null) {
                $stmt->bindParam(':cpf', $data['cpf']);
            }
            
            $stmt->execute();
            $result = $stmt->fetchAll();

            return $result;
        } catch (PDOEXception $e) {
            return "Erro: ".$e->getMessage();
        }
    }

}