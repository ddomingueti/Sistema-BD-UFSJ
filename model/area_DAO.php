<?php
require "$_SERVER[DOCUMENT_ROOT]/sistema-bd-ufsj/conexao.php";
include "$_SERVER[DOCUMENT_ROOT]/sistema-bd-ufsj/model/area.php"
//Data Access Object de Area
//Faz a consulta na base de dados e retorna o resultado da consulta

class AreaDao {

    public function adicionar_area($nome_area) { 
        $query = 'INSERT INTO area (nome) VALUES (:nome)';
        try {
            $stmt = Conexao::get_instance()->get_conexao()->prepare($query);
            $stmt->bindParam(':nome', $nome_area);
            $result = $stmt->execute();
            return $result;
        } catch (PDOEXception $e) {
            return "Erro: ".$e->getMessage();
        }
    }

    public function remover_area ($area_id) {
        $query = 'DELETE FROM area WHERE id = :id';
        try {
            $stmt = Conexao::get_instance()->get_conexao()->prepare($query);
            $stmt->bindParam(':id', $area_id);
            $e = $stmt->execute();
            $result = $stmt->fetchAll();

            return $result;
        } catch (PDOException $e) {
            return "Erro: ".$e->getMessage();
        }
    }

    public function alterar_area($id, $nome_novo) { 
        $query = 'UPDATE area SET nome = :nome_novo WHERE id=:id';
        try {
            $stmt = Conexao::get_instance()->get_conexao()->prepare($query);
            $stmt->bindParam(':nome_novo', $nome_novo);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $result = $stmt->fetchAll();
            return $result;
        } catch (PDOEXception $e) {
            return "Erro: ".$e->getMessage();
        }
    }

    public function buscar_area($nome_area) { 
        $query = 'SELECT * FROM area WHERE nome=:nome';
        if ($nome_area == null) {
            $query = 'SELECT * FROM area WHERE 1';
        }
        try {
            $stmt = Conexao::get_instance()->get_conexao()->prepare($query);
            if ($nome_area != null)
                $stmt->bindParam(':nome', $nome_area);
            
            $stmt->execute();
            $result = $stmt->fetchAll();
            
            return $result;
        } catch (PDOEXception $e) {
            return "Erro: ".$e->getMessage();
        }
    }
}
?>
