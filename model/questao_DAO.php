<?php
require_once "$_SERVER[DOCUMENT_ROOT]/sistema-bd-ufsj/conexao.php";

class QuestaoDao {

    public function adicionarQuestao($data) { 
        $query = 'INSERT INTO questoes (id_area, tipo, enunciado, resposta, num_acertos, a, b, c, d, e) 
        VALUES (:id_area, :tipo, :enunciado, :resposta, :num_acertos, :a, :b, :c, :d, :e)';

        try {
            $acertos = 0;
            $stmt = Conexao::get_instance()->get_conexao()->prepare($query);
            $stmt->bindParam(':id_area', $data['id_area']);
            $stmt->bindParam(':tipo', $data['tipo']);
            $stmt->bindParam(':enunciado', $data['enunciado']);
            $stmt->bindParam(':resposta', $data['resposta']);
            $stmt->bindParam(':num_acertos', $acertos);
            $stmt->bindParam(':a', $data['a']);
            $stmt->bindParam(':b', $data['b']);
            $stmt->bindParam(':c', $data['c']);
            $stmt->bindParam(':d', $data['d']);
            $stmt->bindParam(':e', $data['e']);
            
            $e = $stmt->execute();
            $result = $stmt->fetchAll();
            if ($e) {
                $id = Conexao::get_instance()->get_conexao()->lastInsertId();
                $caminho = $_SERVER['DOCUMENT_ROOT'].'/sistema-bd-ufsj/resources/'.$data['id_area'].'/'.$id;
                mkdir($caminho, 0777, true);

                $query = 'UPDATE questoes SET caminho_imagens=:caminho WHERE id=:id';
                $stmt = Conexao::get_instance()->get_conexao()->prepare($query);
                $stmt->bindParam(':id', $id);
                $stmt->bindParam(':caminho', $caminho);
                $stmt->execute();
            }
            return $result;
        } catch (PDOException $e) {
            return "Erro: ".$e->getMessage();
        }
    }

    public function removerQuestao($data) { 
        $questao = $this->buscarQuestao($data);
        $dir = $questao[0]['caminho_imagens'];
        
        $query = 'DELETE FROM questoes WHERE id = :id';
        try {
            $stmt = Conexao::get_instance()->get_conexao()->prepare($query);
            $stmt->bindParam(':id', $data['id']);
            $e = $stmt->execute();
            $result = $stmt->fetchAll();
                    
            if (is_dir($dir)) {
                
                $objects = scandir($dir); 
                foreach ($objects as $object) { 
                    if ($object != "." && $object != "..") { 
                        if (is_dir($dir."/".$object) && !is_link($dir."/".$object))
                        rrmdir($dir."/".$object);
                        else
                        unlink($dir."/".$object); 
                    }
                }
                rmdir($dir); 
            }

            return $result;
        } catch (PDOException $e) {
            return "Erro: ".$e->getMessage();
        }
    }

    public function alterarQuestao($data) { 
        $query = 'UPDATE questoes SET id=:id, id_area=:id_area, tipo=:tipo, enunciado=:enunciado, resposta=:resposta, a=:a, b=:b, c=:c, d=:d, e=:e
                    WHERE id=:id';
        try {
            $stmt = Conexao::get_instance()->get_conexao()->prepare($query);
            $stmt->bindParam(':id', $data['id']);
            $stmt->bindParam(':id_area', $data['id_area']);
            $stmt->bindParam(':tipo', $data['tipo']);
            $stmt->bindParam(':enunciado', $data['enunciado']);
            $stmt->bindParam(':resposta', $data['resposta']);
            $stmt->bindParam(':a', $data['a']);
            $stmt->bindParam(':b', $data['b']);
            $stmt->bindParam(':c', $data['c']);
            $stmt->bindParam(':d', $data['d']);
            $stmt->bindParam(':e', $data['e']);
            $r = $stmt->execute();
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
            if ($data['id'] != null) {
                $stmt->bindParam(':id', $data['id']);
            }
            
            $stmt->execute();
            $result = $stmt->fetchAll();
            if ($data['readble']) {
                for ($i=0; $i<count($result); $i++) {
                    $query = 'SELECT nome from area WHERE id=:id_area';
                    $stmt = Conexao::get_instance()->get_conexao()->prepare($query);
                    $stmt->bindParam(':id_area', $result[$i]['id_area']);
                    $stmt->execute();
                    $res_nomes = $stmt->fetchAll();
                    $result[$i]['id_area'] = $res_nomes[0]['nome'];
                }
            }
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
    
    public function quantidadeQuestaoArea($data) {
        $query = 'SELECT COUNT(id) FROM questoes WHERE id_area=:id_area';
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

    public function incrementarNumAcertos($data) {
        $query = 'UPDATE questoes SET num_acertos=num_acertos + 1 WHERE id=:id';
        try {
            $stmt = Conexao::get_instance()->get_conexao()->prepare($query);
            $stmt->bindParam(':id', $data['id']);
            $stmt->execute();
            $result = $stmt->fetchAll();
            return $result;
        } catch (PDOException $e) {
            return "Erro: ".$e->getMessage();
        }
    }

    public function buscarRespostaQuestao($data) {
        $query = 'SELECT resposta FROM questoes WHERE id=:id';
        try {
            $stmt = Conexao::get_instance()->get_conexao()->prepare($query);
            $stmt->bindParam(':id', $data['id']);
            $stmt->execute();
            $result = $stmt->fetchAll();
            return $result;
        } catch (PDOException $e) {
            return "Erro: ".$e->getMessage();
        }
    }
}