<?php
class Cidade{
	private $idCidade;
	private $cidade;
	private $idEstado;

// contrutor vazio
	public function __construct(){}

//MÉTODOS
	public static function listaPorEstado( $idEstado ){
		$bd = new BdSQL;
		$sql = "SELECT *
				  FROM Cidade
			 	 WHERE idEstado = '$idEstado'
			  ORDER BY cidade
		";
		$resultSet = $bd->consulta( $sql );
		$resultado = array();
		$i = 0;
		$totalResultados = count($resultSet);
		for( $j=0; $j<$totalResultados; $j++ ){
			$objeto = new Cidade;
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

	public static function listaPrincipal( ){
		$bd = new BdSQL;
		$sql = "
			SELECT *
			  FROM Cidade
		  ORDER BY idCidade
		";
		$resultSet = $bd->consulta( $sql );
		$resultado = array();
		$i = 0;
		$totalResultados = count($resultSet);
		for( $j=0; $j<$totalResultados; $j++ ){
			$objeto = new Cidade;
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
			$sql = "
				SELECT *
				  FROM Cidade
				 WHERE idCidade = '$this->idCidade'
			";
			$resultado = $bd->consulta($sql);
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
	public function getIdCidade(){
		return $this->idCidade;
	}

	public function setIdCidade($idCidade){
		$this->idCidade = $idCidade;
	}

	public function getCidade(){
		return corrigeCodificacao($this->cidade);
	}

	public function setCidade($cidade){
		$this->cidade = $cidade;
	}

	public function getIdEstado(){
		return $this->idEstado;
	}

	public function setIdEstado($idEstado){
		$this->idEstado = $idEstado;
	}

}
?>
