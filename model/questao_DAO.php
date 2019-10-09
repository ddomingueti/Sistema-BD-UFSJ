<?php

class QuestaoDao {


    public function adicionarQuestao($data) { 
        $query = 'INSERT INTO questoes (id, id_area, tipo, enunciado, resposta, num_acertos, a, b, c, d, e) 
        VALUES (:id, :id_area, :tipo, :enunciado, :resposta, :num_acertos, :a, :b, :c, :d, :e)';

        try {
            $stmt = Conexao::get_instance()->get_conexao()->prepare($query);
            $stmt->bindParam(':id', $data['id']);
            $stmt->bindParam(':id_area', $data['id_area']);
            $stmt->bindParam(':tipo', $data['tipo']);
            $stmt->bindParam(':enunciado', $data['enunciado']);
            $stmt->bindParam(':resposta', $$data['resposta']);
            $stmt->bindParam(':num_acertos', $data['num_acertos']);
            $stmt->bindParam(':a', $data['a']);
            $stmt->bindParam(':b', $data['b']);
            $stmt->bindParam(':c', $data['c']);
            $stmt->bindParam(':d', $data['d']);
            $stmt->bindParam(':e', $data['e']);
            
            $e = $stmt->execute();
            $result = $stmt->fetchAll();

            return $result;
        } catch (PDOException $e) {
            return "Erro: ".$e->getMessage();
        }
    }

    public function removerQuestao($data) { 
        $query = 'DELETE FROM questoes WHERE id = :id';
        try {
            $stmt = Conexao::get_instance()->get_conexao()->prepare($query);
            $stmt->bindParam(':id', $data['id']);
            $e = $stmt->execute();
            $result = $stmt->fetchAll();

            return $result;
        } catch (PDOException $e) {
            return "Erro: ".$e->getMessage();
        }
    }

    public function alterarQuestao($data) { 

        $query = 'UPDATE questoes SET id=:id id_area=:id_area, tipo=:tipo, enunciado=:enunciado, resposta=:resposta, num_acertos=:num_acertos, a=:a, b=:b, c=:c, d=:d, e=:e
                    WHERE id=:id';
        try {
            $stmt = Conexao::get_instance()->get_conexao()->prepare($query);
            $stmt->bindParam(':id', $data['id']);
            $stmt->bindParam(':id_area', $data['id_area']);
            $stmt->bindParam(':tipo', $data['tipo']);
            $stmt->bindParam(':enunciado', $data['enunciado']);
            $stmt->bindParam(':resposta', $$data['resposta']);
            $stmt->bindParam(':num_acertos', $data['num_acertos']);
            $stmt->bindParam(':a', $data['a']);
            $stmt->bindParam(':b', $data['b']);
            $stmt->bindParam(':c', $data['c']);
            $stmt->bindParam(':d', $data['d']);
            $stmt->bindParam(':e', $data['e']);
            $stmt->execute();
            $result = $stmt->fetchAll();
            return $result;
        } catch (PDOEXception $e) {
            return "Erro: ".$e->getMessage();
        }
    }

    public function buscarQuestao($data) { 
        $query = 'SELECT * FROM questoes WHERE id=:id';
        if ($data['id'] == null) {
            $query = 'SELECT * FROM questoes WHERE 1';
        }

        try {
            $stmt = Conexao::get_instance()->get_conexao()->prepare($query);
            if ($cpf != null) {
                $stmt->bindParam(':id', $data['id']);
            }
            
            $stmt->execute();
            $result = $stmt->fetchAll();

            return $result;
        } catch (PDOEXception $e) {
            return "Erro: ".$e->getMessage();
        }
    }
    
    public function buscarQuestaoArea($data) {
        $query = 'SELECT * from questoes where id_area=:id_area';
        try {
            $stmt = Conexao::get_instance()->get_conexao()->prepare($query);
            $stmt->bindParam(':id_area', $data['id_area']);
            $stmt->execute();
            $result = $stmt->fetchAll();
            return $result;
        } catch (PDOException $e) {
            return "Erro: ".$e->getMessage();
        }
    }

    public function alterarNumAcertos($data) {
        $query = 'UPDATE questoes SET num_acertos=:num_acertos WHERE id=:id ORDER BY id';
        try {
            $stmt = Conexao::get_instance()->get_conexao()->prepare($query);
            $stmt->bindParam(':id', $data['id']);
            $stmt->bindParam(':num_acertos', $data['num_acertos']);
            $stmt->execute();
            $result = $stmt->fetchAll();
            return $result;
        } catch (PDOException $e) {
            return "Erro: ".$e->getMessage();
        }
    }
}