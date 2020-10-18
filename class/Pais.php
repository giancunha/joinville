<?php
class Pais{

	private $idPais;
	private $nome;
	private $sigla;

// contrutor vazio
	public function __construct(){}

//MÉTODOS
	public static function listaPrincipal( ){
		$bd = new BdSQL;
		$consulta = "
			SELECT *
			  FROM Pais
		  ORDER BY nome
		";
		$resultSet = $bd->consulta( $consulta );
		$resultado = array();
		$i = 0;
		$totalResultados = count($resultSet);
		for( $j=0; $j<$totalResultados; $j++ ){
			$objeto = new Pais;
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
		$sql = "SELECT * FROM Pais WHERE idPais = '$this->idPais'";
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
	public function getIdPais(){
		return $this->idPais;
	}

	public function setIdPais($idPais){
		$this->idPais = $idPais;
	}

	public function getNome(){
		return utf8_encode($this->nome);
	}

	public function setNome($nome){
		$this->nome = $nome;
	}


	public function getSigla(){
		return $this->sigla;
	}

	public function setSigla($sigla){
		$this->sigla = $sigla;
	}

}
?>