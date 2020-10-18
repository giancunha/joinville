<?php
class PessoaFuncao{
	private $id;
	private $nome;

// contrutor vazio
	public function __construct(){}

//MÉTODOS
	public function altera(){
		$altera = "
			UPDATE PessoaFuncao
			   SET nome = ?
			 WHERE id = ?
		";
		$bd = new BdSQL;
		$dados = array(
					array(
						'1' => $this->nome,
						  '2' => $this->id
						  )
				);
		$result = $bd->altera($altera, $dados);
		if($result=='ok'){
			return true;
		}else{
			return false;
		}		
	}

	public function exclui(){
		$exclui = "DELETE FROM PessoaFuncao WHERE id = ?";
		$bd = new BdSQL;	
		$dados = array(
					array('1'=>$this->id)
				);
		$result = $bd->deleta($exclui, $dados);
		if($result=='ok'){
			return true;
		}else{
			return false;
		}	
	}

	public function insere(){
		$insere = "INSERT INTO PessoaFuncao (
				nome
			)  VALUES (
				?
			)
		";
		$bd = new BdSQL;
		$dados = array(
					array('1' => $this->nome
						  )
				);
		$result = $bd->insereRetornaId($insere, $dados);
		if($result > 0){
			return $result;
		}else{
			return false;
		}		
	}

	public static function listaPrincipal( ){
		$bd = new BdSQL;
		$sql = "
			SELECT *
			  FROM PessoaFuncao
		  ORDER BY nome
		";
		$resultSet = $bd->consulta( $sql );
		$resultado = array();
		$i = 0;
		$totalResultados = count($resultSet);
		for( $j=0; $j<$totalResultados; $j++ ){
			$objeto = new PessoaFuncao;
			foreach($resultSet[$j] as $chave=>$valor){		
				if(!is_int($chave)){
					$set = "set".ucfirst( $chave );
					$objeto->$set( $valor );
				}
			}
			$resultado[$i] = $objeto;
			$i++;
		}
		return $resultado;
	}

	public function seleciona(){
		$bd = new BdSQL;
		$seleciona = "SELECT *
					    FROM PessoaFuncao
					   WHERE id = " . $this->id;
		$resultado = $bd->consulta($seleciona);
		if(count($resultado)==1){
			foreach( $resultado[0] as $chave=>$valor ){
				if(!is_int($chave)){
					$this->$chave = $valor;
				}
			}
			return true;
		}else{
			return false;
		}
	}

//GETTERS E SETTERS
	public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
	}

	public function getNome(){
		return $this->nome;
	}

	public function setNome($nome){
		$this->nome = $nome;
	}

}
?>
