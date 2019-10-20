<? php

    include "$_SERVER[DOCUMENT_ROOT]/sistema-bd-ufsj/controller/usuario_controller.php";
    include "$_SERVER[DOCUMENT_ROOT]/sistema-bd-ufsj/controller/area_controller.php";
    include "$_SERVER[DOCUMENT_ROOT]/sistema-bd-ufsj/controller/prova_controller.php";
    include "$_SERVER[DOCUMENT_ROOT]/sistema-bd-ufsj/controller/questao_controller.php";

	require_once "$_SERVER[DOCUMENT_ROOT]/sistema-bd-ufsj/conexao.php";

	class estatisticasDAO {

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

		public function alunosAcimaMediaSexo($data){;

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

			$query = 'SELECT AVG(prova.num_acertos), area.nome FROM (prova JOIN (questoes JOIN formada_por ON questoes.id = formada_por.id_questao) ON prova.id = formada_por.id_prova), area WHERE id_area = area.id GROUP BY id_area';

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

			$query = 'SELECT AVG(prova.num_acertos), area.nome, YEAR(data) FROM (prova JOIN (questoes JOIN formada_por ON questoes.id = formada_por.id_questao) ON prova.id = formada_por.id_prova), area WHERE id_area = area.id GROUP BY YEAR(data)'

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


?>