<?php
require "$_SERVER[DOCUMENT_ROOT]/sistema-bd-ufsj/conexao.php";

class ProvaDao {

    public function adicionarProva($data) {
        $query = 'INSERT INTO prova(data, finalizada, num_acertos, id_usuario) 
        VALUES (:data, :finalizada, :num_acertos, :id_usuario)';
        
        try {
            $stmt = Conexao::get_instance()->get_conexao()->prepare($query);
            $stmt->bindParam(':data', $data['data']);
            $stmt->bindParam(':finalizada', $data['finalizada']);
            $stmt->bindParam(':num_acertos', $data['num_acertos']);
            $stmt->bindParam(':id_usuario', $data['id_usuario']);
            $r1 = $stmt->execute();
            
            $id_prova = Conexao::get_instance()->get_conexao()->lastInsertId();
            foreach ($data['questoes'] as $questao) {
                $query = 'INSERT INTO formada_por(id_prova, id_questao) VALUES (:id_prova, :id_questao)';
                $stmt = Conexao::get_instance()->get_conexao()->prepare($query);
                $stmt->bindParam(':id_prova', $id_prova);
                $stmt->bindParam(':id_questao', $questao);
                $stmt->execute();
            }
        } catch (PDOEXception $e) {
            return "Erro: ".$e->getMessage();
        }
    }

    public function removerProva($data) {
        $query = 'DELETE FROM prova WHERE id=:id';
        try {
            $stmt = Conexao::get_instance()->get_conexao()->prepare($query);
            $stmt->bindParam(':id', $data['id']);
            $r = $stmt->execute();
            $result = $stmt->fetchAll();
            return $result;
        } catch (PDOEXception $e) {
            return "Erro: ".$e->getMessage();
        }
     }

    public function alterarProva($data) { 
        $query = 'UPDATE prova SET data=:data, finalizada=:finalizada, num_acertos=:num_acertos WHERE id_prova=:id_prova';
        try {
            $stmt = Conexao::get_instance()->get_conexao()->prepare($query);
            $stmt->bindParam(':data', $data['data']);
            $stmt->bindParam(':finalizada', $data['finalizada']);
            $stmt->bindParam(':num_acertos', $data['num_acertos']);
            $stmt->bindParam(':id_prova', $data['id']);
            $r = $stmt->execute();
            $result = $stmt->fetchAll();
            return $result;
        } catch (PDOEXception $e) {
            return "Erro: ".$e->getMessage();
        }

    }

    public function buscarProva($data) { 
        $query = null;
        if ($data['id'] == null) {
            $query = 'SELECT * from prova WHERE 1';
        } else {
            $query = 'SELECT * FROM prova WHERE id=:id';
        }
        try {
            $stmt = Conexao::get_instance()->get_conexao()->prepare($query);
            if ($data['id' != null])
                $stmt->bindParam(':id', $data['id']);    
            $r = $stmt->execute();
            $result = $stmt->fetchAll();
            return $result;
        } catch (PDOEXception $e) {
            return "Erro: ".$e->getMessage();
        }
    }

    public function buscarProvaAluno($data) {
        $query = 'SELECT * from prova WHERE id_usuario=:id_usuario';
        try {
            $stmt = Conexao::get_instance()->get_conexao()->prepare($query);
            $stmt->bindParam(':id_usuario', $data['id_usuario']);
            $stmt->execute();
            $result = $stmt->fetchAll();
            return $result;
        } catch (PDOEXception $e) {
            return "Erro: ".$e->getMessage();
        }
    }

}