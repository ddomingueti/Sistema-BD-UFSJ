<?php
require "$_SERVER[DOCUMENT_ROOT]/sistema-bd-ufsj/conexao.php";

class UsuarioDao {

    public function adicionarUsuario($nome, $email, $cpf, $idade, $senha, $sexo, $data_nasc, $id_area, $tipo_ingresso) { 
        $query = 'INSERT INTO usuario (nome, email, cpf, idade, senha, sexo, data_nasc, id_area, tipo_ingresso) 
        VALUES (:nome, :email, :cpf, :idade, :senha, :sexo, :data_nasc, :id_area, tipo_ingresso)';
        
        try {
            $stmt = Conexao::get_instance()->get_conexao()->prepare($query);
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':cpf', $cpf);
            $stmt->bindParam(':senha', $senha);
            $stmt->bindParam(':sexo', $sexo);
            $stmt->bindParam(':idade', $idade);
            $stmt->bindParam(':data_nasc', $data_nasc);
            $stmt->bindParam(':id_area', $id_area);
            $stmt->bindParam(':tipo_ingresso', $tipo_ingresso);
            
            $result = $stmt->execute();
            return $result;
        } catch (PDOEXception $e) {
            return "Erro: ".$e->getMessage();
        }
    }

    public function removerUsuario($cpf) {
        $query = 'DELETE FROM usuario WHERE cpf = :cpf';
        try {
            $stmt = Conexao::get_instance()->get_conexao()->prepare($query);
            $stmt->bindParam(':cpf', $cpf);
            $e = $stmt->execute();
            $result = $stmt->fetchAll();
            return $result;
        } catch (PDOException $e) {
            return "Erro: ".$e->getMessage();
        }
    }

    public function alterarUsuario($nome, $email, $cpf, $idade, $senha, $sexo, $data_nasc, $id_area, $tipo_ingresso) {
        $query = 'UPDATE usuario SET nome=:nome, email=:email, senha:senha, sexo:sexo, data_nasc:data_nasc, id_area:id_area, tipo_ingresso:tipo_ing) 
                    WHERE cpf=:cpf';
        try {
            $stmt = Conexao::get_instance()->get_conexao()->prepare($query);
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':cpf', $cpf);
            $stmt->bindParam(':senha', $senha);
            $stmt->bindParam(':sexo', $sexo);
            $stmt->bindParam(':idade', $idade);
            $stmt->bindParam(':data_nasc', $data_nasc);
            $stmt->bindParam(':id_area', $id_area);
            $stmt->bindParam(':tipo_ingresso', $tipo_ingresso);
            
            $stmt->execute();
            $result = $stmt->fetchAll();
            return $result;
        } catch (PDOEXception $e) {
            return "Erro: ".$e->getMessage();
        }
        
    }

    public function buscarUsuario($cpf, $senha) {         
        $query = 'SELECT * FROM usuario WHERE cpf=:cpf and senha=:senha';
        if ($cpf == null and $senha == null) {
            $query = 'SELECT * FROM usuario WHERE 1';
        }
        try {
            $stmt = Conexao::get_instance()->get_conexao()->prepare($query);
            if ($cpf != null and $senha != null) {
                $stmt->bindParam(':cpf', $cpf);
                $stmt->bindParam(':senha', $senha);
            }
            
            $stmt->execute();
            $result = $stmt->fetchAll();

            return $result;
        } catch (PDOEXception $e) {
            return "Erro: ".$e->getMessage();
        }
    }

}