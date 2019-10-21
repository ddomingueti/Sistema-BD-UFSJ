<?php
require_once "$_SERVER[DOCUMENT_ROOT]/sistema-bd-ufsj/conexao.php";

class ProvaDao {

    public function adicionarProva($data) {
        $query = 'INSERT INTO prova(data, finalizada, num_acertos, id_usuario) 
        VALUES (:data, :finalizada, :num_acertos, :id_usuario)';
        try {
            $stmt = Conexao::get_instance()->get_conexao()->prepare($query);
            $stmt->bindParam(':data', $data['data']);
            $stmt->bindParam(':finalizada', $data['finalizada'], PDO::PARAM_BOOL);
            $stmt->bindParam(':num_acertos', $data['num_acertos']);
            $stmt->bindParam(':id_usuario', $data['id_usuario']);
            $r1 = $stmt->execute();
            $id_prova = Conexao::get_instance()->get_conexao()->lastInsertId();

            for ($i = 0; $i <count($data['questoes']); $i++) {
                $query = 'INSERT INTO formada_por(id_prova, id_questao) VALUES (:id_prova, :id_questao)';
                $stmt = Conexao::get_instance()->get_conexao()->prepare($query);
                $stmt->bindParam(':id_prova', $id_prova);
                $stmt->bindParam(':id_questao', $data['questoes'][$i]);
                $r2 = $stmt->execute();
            }
            return [ "success" => true, "id_prova" => $id_prova, "id_questao" => $data['questoes']];
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
        $query = 'UPDATE prova SET finalizada=:finalizada, num_acertos=:num_acertos, nota=:nota, tempo=:tempo WHERE id=:id_prova';
        try {
            $stmt = Conexao::get_instance()->get_conexao()->prepare($query);
            $stmt->bindParam(':finalizada', $data['finalizada'], PDO::PARAM_BOOL);
            $stmt->bindParam(':num_acertos', $data['num_acertos']);
            $stmt->bindParam(':nota', $data['nota']);
            $stmt->bindParam(':tempo', $data['tempo']);
            $stmt->bindParam(':id_prova', $data['id']);
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

    public function buscarProva($data) { 
        $query = null;
        if ($data['id'] == null) {
            $query = 'SELECT * from prova WHERE 1';
        } else {
            $query = 'SELECT * FROM prova WHERE id=:id';
        }
        try {
            $stmt = Conexao::get_instance()->get_conexao()->prepare($query);
            if ($data['id'] != null)
                $stmt->bindParam(':id', $data['id']);    
            $r = $stmt->execute();
            $result = $stmt->fetchAll();
            for ($i = 0; $i < count($result); $i++) {
                $query = 'SELECT COUNT(formada_por.id_questao) FROM formada_por
                WHERE formada_por.id_prova = '.$result[$i]['id'];
                $stmt = $stmt = Conexao::get_instance()->get_conexao()->prepare($query);
                $stmt->bindParam(':id', $data['id']);    
                $stmt->execute();
                $num_questoes = $stmt->fetchAll();
                $formated = [ 'num_questoes' => $num_questoes[0][0]];
                $result[$i] += $formated;
            }
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
            for ($i = 0; $i < count($result); $i++) {
                $query = 'SELECT COUNT(formada_por.id_questao) FROM formada_por
                WHERE formada_por.id_prova = '.$result[$i]['id'];
                $stmt = $stmt = Conexao::get_instance()->get_conexao()->prepare($query);
                $stmt->bindParam(':id', $data['id']);    
                $stmt->execute();
                $num_questoes = $stmt->fetchAll();
                $formated = [ 'num_questoes' => $num_questoes[0][0]];
                $result[$i] += $formated;
            }
            return $result;
        } catch (PDOEXception $e) {
            return "Erro: ".$e->getMessage();
        }
    }

    public function buscarQuestaoProva($data) {
        $query = 'SELECT questoes.id, questoes.tipo, questoes.resposta, formada_por.resposta_usuario FROM (formada_por JOIN questoes ON id_questao = questoes.id) WHERE id_prova =:id_prova ORDER BY questoes.id';
        try {
            $stmt = Conexao::get_instance()->get_conexao()->prepare($query);
            $stmt->bindParam(':id_prova', $data['id_prova']);
            $stmt->execute();
            $result = $stmt->fetchAll();
            return $result;
        } catch (PDOEXception $e) {
            return "Erro: ".$e->getMessage();
        }
    }

    public function buscarRespostaUsuQuestao($data) {
        $query = 'SELECT resposta_usuario FROM formada_por WHERE (id_prova=:id_prova AND id_questao=:id_questao)';
        try {
            $stmt = Conexao::get_instance()->get_conexao()->prepare($query);
            $stmt->bindParam(':id_prova', $data['id_prova']);
            $stmt->bindParam(':id_questao', $data['id_questao']);
            $stmt->execute();
            $result = $stmt->fetchAll();
            return $result;
        } catch (PDOEXception $e) {
            return "Erro: ".$e->getMessage();
        }
    }

    public function alterarRespostaQuestao($data) {
        $query = 'UPDATE formada_por SET resposta_usuario=:resposta WHERE (id_prova=:id_prova AND id_questao=:id_questao)';
        try {
            $stmt = Conexao::get_instance()->get_conexao()->prepare($query);
            $stmt->bindParam(':resposta', $data['resposta']);
            $stmt->bindParam(':id_prova', $data['id_prova']);
            $stmt->bindParam(':id_questao', $data['id_questao']);
            if (!$stmt->execute()) {
                print_r($stmt->errorInfo());
            }
            $result = $stmt->fetchAll();
            return $result;
        } catch (PDOEXception $e) {
            return "Erro: ".$e->getMessage();
        }   
    }

    //Estatisticas Gerais
    
    public function calculaMediaAreaSexo($data){ 

        $query = 'SELECT AVG(prova.num_acertos) FROM ((prova JOIN (questoes JOIN formada_por ON questoes.id = formada_por.id_questao) ON id_area = :id AND prova.id = formada_por.id_prova) JOIN usuario ON prova.id_usuario = usuario.cpf) GROUP BY usuario.sexo ';

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

    public function calculaMediaAreaCota($data){ 

        $query = 'SELECT AVG(prova.num_acertos) FROM ((prova JOIN (questoes JOIN formada_por ON questoes.id = formada_por.id_questao) ON id_area = :id AND prova.id = formada_por.id_prova) JOIN usuario ON prova.id_usuario = usuario.cpf) GROUP BY usuario.tipo_ingresso';

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

    public function alunosAcimaMedia($data){

        $query = 'SELECT COUNT(id_usuario) FROM prova WHERE num_acertos > (SELECT AVG(prova.num_acertos) FROM (prova JOIN (questoes JOIN formada_por ON questoes.id = formada_por.id_questao) ON id_area = :id AND prova.id = formada_por.id_prova)';

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

    public function alunosAbaixoMedia($data){


        $query = 'SELECT COUNT(id_usuario) FROM prova WHERE num_acertos < (SELECT AVG(prova.num_acertos) FROM (prova JOIN (questoes JOIN formada_por ON questoes.id = formada_por.id_questao) ON id_area = :id AND prova.id = formada_por.id_prova)';

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

    public function alunosAcimaMediaSexo($data){

        $query = 'SELECT COUNT(id_usuario), usuario.sexo FROM (prova JOIN usuario ON prova.id_usuario = usuario.cpf) WHERE num_acertos >= (SELECT AVG(prova.num_acertos) FROM (prova JOIN (questoes JOIN formada_por ON questoes.id = formada_por.id_questao ) ON id_area = :id AND prova.id = formada_por.id_prova ) ) GROUP BY usuario.sexo';

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

    public function alunosAcimaMediaCota($data){

        $areaController = new AreaController();
        $area = $areaController->buscarArea(null, $data);
        $msg = false;

        $query = 'SELECT COUNT(id_usuario), usuario.tipo_ingresso FROM (prova JOIN usuario ON prova.id_usuario = usuario.cpf) WHERE num_acertos >= (SELECT AVG(prova.num_acertos) FROM (prova JOIN (questoes JOIN formada_por ON questoes.id = formada_por.id_questao ) ON id_area = :id AND prova.id = formada_por.id_prova ) ) GROUP BY usuario.tipo_ingresso';

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

    public function mediaAreas(){

        $query = 'SELECT  id_area, area.nome, AVG(prova.num_acertos) FROM (prova JOIN (questoes JOIN formada_por ON questoes.id = formada_por.id_questao) ON prova.id = formada_por.id_prova), area WHERE id_area = area.id GROUP BY id_area';

        try {
            $stmt = Conexao::get_instance()->get_conexao()->prepare($query);
                                
                $stmt->execute();
                $result = $stmt->fetchAll();
                
            return $result;
        } catch (PDOEXception $e) {
            return "Erro: ".$e->getMessage();
        }

    }

    public function mediaAreaAno(){

        $query = 'SELECT AVG(prova.num_acertos), area.nome, YEAR(data) FROM (prova JOIN (questoes JOIN formada_por ON questoes.id = formada_por.id_questao) ON prova.id = formada_por.id_prova), area WHERE id_area = area.id GROUP BY YEAR(data)';

        try {
            $stmt = Conexao::get_instance()->get_conexao()->prepare($query);
                               
            $stmt->execute();
            $result = $stmt->fetchAll();
               
            return $result;
        } catch (PDOEXception $e) {
            return "Erro: ".$e->getMessage();
        }
    }
}