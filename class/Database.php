<?php

	class Database{//classe responsável pelas operações feitas no banco de dados
		
		private $pdo;//guarda a instância de um objeto pdo da conexão com o banco de dados
		private $limite;//define a quantidade de registros que serão exibidos por página
		
		//construtor da classe
		public function __construct(){
			
			global $pdo, $limite;
			
			$limite = 5;//definindo quantidade de registros a serem exibidos por página
			
			$host = "localhost";//host do banco
			$dbname = "comercio";//nome do banco
			$user = "root";//usuário do banco
			$password = "";//senha do banco
			
			try{
			
				$pdo = new PDO('mysql:host='.$host.';dbname='.$dbname, $user, $password);//instânciando objeto pdo de conexão com banco
				
			}catch(Exception $e){
				
				echo("Erro ao conectar banco de dados!");//se não for possível conectar aparece essa mensagem de erro
				
			}
			
		}
		
		//retornando a instância pdo do banco
		public function getPdo(){
			
			global $pdo;
			
			return $pdo;
		}
		
		//retornando limite de registros exibidos por página
		public function getLimite(){
			
			global $limite;
			
			return $limite;
		}
	
		//coloca a páginação na tela marcando o número da página atual e colocando o filtro de busca
		//na url de cada página
		public function paginate($registros, $atual, $url){
			//$registros: quantidade total de linhas retornadas da consulta no banco
			//$atual: página atual de registros acessada
			//$url: url com filtro de busca
			global $limite;
            $colunas = 3;//quantidade de números de páginas a ser exibido por linha
            $paginas = ceil($registros/$limite);//quantidade de páginas a qual os registros foram divididos
            
            $linhas = ceil($paginas/$colunas);//quantidade de linhas com colunas páginas
            
            //$linha: linha em que a página atual se encontra
            if($atual <= $colunas){
                
                $linha = 1;
                
            }else{
                
                $linha = ceil($atual/$colunas);
            }
            
            $inicio = (($linha - 1) * $colunas) + 1;//número da primeira página da linha em que está a página atual
            $fim = $linha * $colunas;//número da última página da linha em que está a página atual
            
            ?>
            
            <!--definindo formatação css da páginação-->
            <style type="text/css">
				
				.selecionado{
					background-color: #D8D8D8;
				}
				
				.paginate{
					 display: inline block;
					 text-align: center;
				}
				
            </style>
            
            <!--imprimindo páginação-->
            <div class='paginate'>
				<h3>
					<?php
					
						echo("<div class='paginate'>");
					
						//se a página inicial da linha em que se encontra a página atual for maior que 1
						//o link para voltar para linha anterior será exibido
						if($inicio > 1){
							
							echo("<a href='".$url."&pagina=".($inicio - 1)."'> <<<< </a> ");
						
						}
						
						//escrevendo os números das páginas
						for($i = $inicio; $i <= $paginas; $i++){
                
							if($i == $atual){//marcando o número da página atual
                    
								echo(" <a class='selecionado' href='".$url."&pagina=".$i."'>".$i."</a> ");
                    
							}else{//desenhando número das outras páginas
                 
								echo(" <a href='".$url."&pagina=".$i."'>".$i."</a> ");
                    
							}
							
							if($i == $fim){//se essa é a última página da linha o laço é interrompido
								
								if($fim < $paginas){//se a última página da linha for menor que a quantidade total de páginas o link para próxima linha é exibido
									
									echo("<a href='".$url."&pagina=".($i + 1)."'> >>>> </a> ");
								
								}
								
								break;
								
							}
						}
				
						?>
					</div>
				</h3>	
			<?php
		}
	}

?>
