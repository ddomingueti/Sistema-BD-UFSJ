<?php
require_once "$_SERVER[DOCUMENT_ROOT]/sistema-bd-ufsj/conexao.php";

class AvaliacaoDao {

    public function adicionarAvaliacao($data) {
        $query = 'INSERT INTO avaliacao (comentario, nota, data, id_usuario) 
        VALUES (:comentario, :nota, :data, :id_usuario)';
        
        try {
            $stmt = Conexao::get_instance()->get_conexao()->prepare($query);
            $stmt->bindParam(':comentario', $data['comentario']);
            $stmt->bindParam(':nota', $data['nota']);
            $stmt->bindParam(':data', $data['data']);
            $stmt->bindParam(':id_usuario', $data['id_usuario']);
            $r = $stmt->execute();
            $result = $stmt->fetchAll();
            return $result;
        } catch (PDOEXception $e) {
            return "Erro: ".$e->getMessage();
        }
     }

    public function removerAvaliacao($data) { 
        $query = 'DELETE from avaliacao WHERE id=:id';
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

    public function alterarAvaliacao($data) { 
        $query = 'UPDATE avaliacao SET comentario=:comentario, nota=:nota, data=:data WHERE id=:id';
        try {
            $stmt = Conexao::get_instance()->get_conexao()->prepare($query);
            $stmt->bindParam(':id', $data['id']);
            $stmt->bindParam(':comentario', $data['comentario']);
            $stmt->bindParam(':nota', $data['nota']);
            $stmt->bindParam(':data', $data['data']);
            $r = $stmt->execute();
            if (!$r) {
                print_r($stmt->errorInfo());
            }
            $result = $stmt->fetchAll();
            return $result;
        } catch (PDOEXception $e) {
            return "Erro: ".$e->getMessage();
        }
    }

    public function buscarAvaliacaoUnica($data) {
        $query = 'SELECT id, comentario, nota, data 
            FROM avaliacao
            WHERE id=:id
            ORDER BY id';
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

    public function buscarAvaliacaoUsuarioUnico($data) {
        $query = 'SELECT id, comentario, nota, data, nome 
            FROM avaliacao
            WHERE id_usuario=:cpf
            ORDER BY id';
        try {
            $stmt = Conexao::get_instance()->get_conexao()->prepare($query);
            $stmt->bindParam(':cpf', $data['cpf']);
            
            $r = $stmt->execute();
            $result = $stmt->fetchAll();
            return $result;
        } catch (PDOEXception $e) {
            return "Erro: ".$e->getMessage();
        }
    }
    
    public function buscarAvaliacaoUsuarios() { 
        $query = 'SELECT id, comentario, nota, data, nome 
            FROM (avaliacao JOIN usuario ON id_usuario=cpf)
            WHERE 1 
            ORDER BY id';
        try {
            $stmt = Conexao::get_instance()->get_conexao()->prepare($query);
            $r = $stmt->execute();
            $result = $stmt->fetchAll();
            return $result;
        } catch (PDOEXception $e) {
            return "Erro: ".$e->getMessage();
        }
    }

    public function buscarAvaliacaoUsuario($data) {
        $query = 'SELECT * FROM avaliacao WHERE id_usuario=:id_usuario ORDER BY data';
        try {
            $stmt = Conexao::get_instance()->get_conexao()->prepare($query);
            $stmt->bindParam(':id_usuario', $data['id_usuario']);
            $r = $stmt->execute();
            $result = $stmt->fetchAll();
            return $result;
        } catch (PDOEXception $e) {
            return "Erro: ".$e->getMessage();
        }
    }

    public function buscarAvaliacaoData($data) {
        $query = 'SELECT * FROM avaliacao WHERE data=:data';
        try {
            $stmt = Conexao::get_instance()->get_conexao()->prepare($query);
            $stmt->bindParam('data', $data['data']);
            $r = $stmt->execute();
            $result = $stmt->fetchAll();
            return $result;
        } catch (PDOEXception $e) {
            return "Erro: ".$e->getMessage();
        }  
    }
}