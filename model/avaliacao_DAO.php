<?php
require "$_SERVER[DOCUMENT_ROOT]/sistema-bd-ufsj/conexao.php";
include "$_SERVER[DOCUMENT_ROOT]/sistema-bd-ufsj/model/usuario_dao.php";

class AvaliacaoDao {

    public function adicionarAvaliacao($data) {
        $query = 'INSERT INTO avaliacao (comentario, nota, data, id_usuario) 
        VALUES (:comentario, :nota, :data, :id_usuario)';
        
        try {
            $stmt = Conexao::get_instance()->get_conexao()->prepare($query);
            $stmt->bindParam(':comentario', $data['comentario'])
            $stmt->bindParam(':nota', $data['nota']);
            $stmt->bindParam(':data', $data['data']);
            $stmt->bindParam(':id_usuario', $data['id_usuario']);
            $r = $stmt->execute();
            var_dump($r);
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
        $query = 'UPDATE avaliacao SET comentario=:comentario, nota=:nota, data=:data) WHERE id=:id';
        try {
            $stmt = Conexao::get_instance()->get_conexao()->prepare($query);
            $stmt->bindParam(':id', $data['id_usuario']);
            $stmt->bindParam(':comentario', $data['comentario']);
            $stmt->bindParam(':nota', $data['nota']);
            $stmt->bindParam(':data', $data['data']);
            $r = $stmt->execute();
            $result = $stmt->fetchAll();
            return $result;
        } catch (PDOEXception $e) {
            return "Erro: ".$e->getMessage();
        }
    }

    public function buscarAvaliacao($data) { 
        $query = null;
        if ($data['id'] == null)
            $query = 'SELECT * FROM avaliacao WHERE 1 ORDER BY id';
        else
            $query = 'SELECT * FROM avaliacao WHERE id=:id';
        
        try {
            $stmt = Conexao::get_instance()->get_conexao()->prepare($query);
            if ($data['id'] != null)
                $stmt->bindParam(':id', $data['id']);
            
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