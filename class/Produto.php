<?php

	include_once('Database.php');

	class Produto{
		
		private $database, $pdo;//objetos derivados da conexão com o banco
		private $codigo, $nome, $categoria, $pagina;//atributos de filtragem de consulta
		private $linhas;//número total de registros retornados em uma consulta
		
		//construtor da classe
		public function __construct(){
			
			global $pdo, $database;
			
			$database = new Database();//objeto da classe Database
			
			$pdo = $database->getPdo();//instância pdo da conexão com o banco
		}
		
		//função que retorna os registros do banco de acordo com os parâmetros de consulta
		public function exibir($codigo, $nome, $categoria, $pagina){
			
			global $pdo, $database;
			
			$query = "SELECT * FROM vw_produtos";//instrução a ser enviada para o banco
			
			$clausula[] = array();//armazena as clausulas de consulta
			$clausulas = 0;
			
			//para filtrar pelo código ele precisa ser diferente de null e de 0
			if($codigo != null && $codigo != "0"){
				$codigo = (int) $codigo;
				$clausula[$clausulas] = "codigo = ".$codigo;
				$clausulas++;
			}
			
			//para filtrar pelo nome ele precisa ser diferente de null 
			if($nome != null){
				$clausula[$clausulas] = "produto LIKE '%".$nome."%'";
				$clausulas++;
			}
			
			//para filtrar pela categoria seu id precisa ser diferente de 0
			if($categoria != "0"){
				$categoria = (int) $categoria;
				$clausula[$clausulas] = "categoria_id = ".$categoria;
				$clausulas++;
			}
			
			//adicionando as cláusulas de consulta a query
			for($i = 0; $i < $clausulas; $i++){
				if($i == 0){
					$query .= " WHERE ".$clausula[$i];
				}else{
					$query .= " AND ".$clausula[$i];
				}
			}
			
			//setando os filtros da páginação
			$this->setPaginate($codigo, $nome, $categoria, $pagina, $query);
			
			//se a página for diferente de 0 o banco irá retornar somente essa página dos registros
			if($pagina != "0"){
				$pagina = (int) $pagina;
				$limite = $database->getLimite();
				$query .= " LIMIT ".(($pagina - 1) * $limite).",".$limite;
			}
			
			$sql = $pdo->prepare($query);//enviando a instrução para o banco
			
			$sql->execute();//executando instrução
			
			return $sql;//retornando registros
			
		}
		
		//função que retorna as categorias dos produtos do banco
		public function categorias(){
			
			global $pdo;
			
			$sql = $pdo->prepare("SELECT * FROM categorias");
			
			$sql->execute();
			
			return $sql;
			
		}
		
		//função que seta os filtros da paginação
		public function setPaginate($codigo_prod, $nome_prod, $categoria_prod, $page, $query){
			
			global $codigo, $nome, $categoria, $pagina, $pdo, $linhas;
			
			$codigo = $codigo_prod;
			$nome = $nome_prod;
			$categoria = $categoria_prod;
			$pagina = $page;
			
			$sql = $pdo->prepare($query);
			$sql->execute();
			$linhas = $sql->rowCount();//pegando a quantidade total de registros retornados pelo banco
			
		}
		
		//função que imprime a paginação dos produtos
		public function paginate(){
			
			global $codigo, $nome, $categoria, $pagina, $database, $linhas;
			
			$url = "index.php?codigo=".$codigo."&produto=".$nome."&categoria=".$categoria;//montando url com filtro de busca
			
			$database->paginate($linhas, $pagina, $url);//imprimindo paginação
			
		}
		
	}

?>
