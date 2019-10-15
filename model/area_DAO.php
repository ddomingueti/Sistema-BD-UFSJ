<?php
require_once "$_SERVER[DOCUMENT_ROOT]/sistema-bd-ufsj/conexao.php";
//Data Access Object de Area
//Faz a consulta na base de dados e retorna o resultado da consulta

class AreaDao {

    public function adicionarArea($data) {
        $query = 'INSERT INTO area (nome) VALUES (:nome)';
        try {
            $stmt = Conexao::get_instance()->get_conexao()->prepare($query);
            $stmt->bindParam(':nome', $data['nome']);
            $result = $stmt->execute();
            return $result;
        } catch (PDOEXception $e) {
            return "Erro: ".$e->getMessage();
        }
    }

    public function removerArea ($data) {
        $query = 'DELETE FROM area WHERE id = :id';
        try {
            $stmt = Conexao::get_instance()->get_conexao()->prepare($query);
            $stmt->bindParam(':id', $data['id']);
            $result = $stmt->fetchAll();
            return $result;
        } catch (PDOException $e) {
            return "Erro: ".$e->getMessage();
        }
    }

    public function alterarArea($data) { 
        $query = "UPDATE area SET nome =:nome_novo WHERE id=:id";
        try {
            $stmt = Conexao::get_instance()->get_conexao()->prepare($query);
            $stmt->bindParam(':nome_novo', $data['nome']);
            $stmt->bindParam(':id', $data['id']);
            $r = $stmt->execute();
            echo $r;
            $result = $stmt->fetchAll();
            return $result;
        } catch (PDOEXception $e) {
            return "Erro: ".$e->getMessage();
        }
    }

    public function buscarArea($data) { 
        $query = null;
        if ($data['id'] == null && $data['nome'] != null)
            $query = 'SELECT * FROM area WHERE nome=:nome';
        else if ($data['id'] != null)
            $query = 'SELECT * from area WHERE id=:id';
        else if ($data['id'] == null && $data['nome'] == null)
            $query = 'SELECT * FROM area WHERE 1';
        
        try {
            $stmt = Conexao::get_instance()->get_conexao()->prepare($query);
            if ($data['id'] != null)
                $stmt->bindParam(':id', $data['id']);
            else if ($data['nome'] != null)
                $stmt->bindParam(':nome', $data['nome']);
            else {
                $stmt->bindParam(':nome', $data['nome']);
                $stmt->bindParam(':id', $data['id']);
            }
            
            $stmt->execute();
            $result = $stmt->fetchAll();
            
            return $result;
        } catch (PDOEXception $e) {
            return "Erro: ".$e->getMessage();
        }
    }

    public function buscarNomeArea($data) {
        $query = null;
        if ($data['id'] == null)
            $query = 'SELECT nome from area WHERE 1 ORDER BY id';
        else
            $query = 'SELECT nome from area WHERE id=:id';
        
        try {
            $stmt = Conexao::get_instance()->get_conexao()->prepare($query);
            if ($data['id'] != null)
                $stmt->bindParam(':id', $data['id']);
            
            $stmt->execute();
            $result = $stmt->fetchAll();
            
            return $result;
        } catch (PDOEXception $e) {
            return "Erro: ".$e->getMessage();
        }
    }
}
?>
