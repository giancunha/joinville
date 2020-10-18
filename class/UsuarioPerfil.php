<?php
class UsuarioPerfil{
	private $idUsuarioPerfil = null;
	private $idPerfil = null;
	private $idUsuario = null;

	private $nome = null;
	private $descricao = null;

// contrutor vazio
	public function __construct(){}

//MÉTODOS
	public function altera(){
		$sql = "
			UPDATE UsuarioPerfil
			   SET idPerfil = ?,
			   	   idUsuario = ?
			 WHERE idUsuarioPerfil = ?
		";
		$bd = new BdSQL;
		$dados = array(
			array(
				'1' => $this->idPerfil,
				'2' => $this->idUsuario,
				'3' => $this->idUsuarioPerfil
			)
		);
		$result = $bd->altera($sql, $dados);
		if($result=='ok'){
			return true;
		}else{
			return false;
		}
	}

	public function atualizaUsuarioPerfil( $stringSQL ){
		$bd = new BdSQL;
		$bd->consulta( $stringSQL );
	}

	public function insere(){
		$sql = "
			INSERT INTO UsuarioPerfil (
				idPerfil,
				idUsuario
			) VALUES (
				?,?
			)
		";
		$bd = new BdSQL;
		$dados = array(
			array(
				'1' => $this->idPerfil,
				'2' => $this->idUsuario
			)
		);
		$result = $bd->insereRetornaId($sql, $dados);
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
			  FROM UsuarioPerfil
		  ORDER BY idPerfil
		";
		$resultSet = $bd->consulta( $sql );
		$resultado = array();
		$i = 0;
		$totalResultados = count($resultSet);
		for( $j=0; $j<$totalResultados; $j++ ){
			$objeto = new UsuarioPerfil;
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
			  FROM UsuarioPerfil
			 WHERE idUsuarioPerfil = '$this->idUsuarioPerfil'
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
	public function getIdUsuarioPerfil(){
		return $this->idUsuarioPerfil;
	}
	public function setIdUsuarioPerfil($idUsuarioPerfil){
		$this->idUsuarioPerfil = $idUsuarioPerfil;
	}
	public function getIdPerfil(){
		return $this->idPerfil;
	}
	public function setIdPerfil($idPerfil){
		$this->idPerfil = $idPerfil;
	}
	public function getIdUsuario(){
		return $this->idUsuario;
	}
	public function setIdUsuario($idUsuario){
		$this->idUsuario = $idUsuario;
	}
	public function getNome(){
		return $this->nome;
	}
	public function setNome($nome){
		$this->nome = $nome;
	}
	public function getDescricao(){
		return $this->descricao;
	}
	public function setDescricao($descricao){
		$this->descricao = $descricao;
	}
}
