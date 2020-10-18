<?php
class Perfil{
    private $idPerfil = null;
    private $nome = null;
    private $descricao = null;
    private $idUsuarioPerfil = null;

// contrutor vazio
    public function __construct(){}

//MÉTODOS
    public function altera(){
        $sql = "
          UPDATE Perfil SET
                 nome = ?,
                 descricao = ?
           WHERE idPerfil = ?
        ";
        $bd = new BdSQL;
        $dados = array(
            array(
                '1' => $this->nome,
                '2' => $this->descricao,
                '3' => $this->idPerfil
            )
        );
        $result = $bd->altera($sql, $dados);
        if($result=='ok'){
            return true;
        }else{
            return false;
        }
    }

    public function atualizaPerfilMenu( $stringSQL ){
        $bd = new BdSQL;
        $bd->consulta( $stringSQL );
    }

    public function exclui(){
        $sql = "DELETE FROM Perfil WHERE idPerfil = ?";
        $bd = new BdSQL;
        $dados = array(
            array('1'=>$this->idPerfil)
        );
        $result = $bd->deleta($sql, $dados);
        if($result=='ok'){
            return true;
        }else{
            return false;
        }
    }

    public function insere(){
        $sql = "
          INSERT INTO Perfil (
                 nome,
                 descricao
          ) VALUES (
                 ?,?
          )
		";
        $bd = new BdSQL;
        $dados = array(
            array(
                '1' => $this->nome,
                '2' => $this->descricao
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
			  FROM Perfil
		  ORDER BY nome
		";
        $resultSet = $bd->consulta( $sql );
        $resultado = array();
        $i = 0;
        $totalResultados = count($resultSet);
        for( $j=0; $j<$totalResultados; $j++ ){
            $objeto = new Perfil;
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

    public static function listaUsuarioPerfil( $idUsuario ){
        $bd = new BdSQL;
        $sql = "
			SELECT per.idPerfil,
			       per.nome,
			       per.descricao,
			       (SELECT idUsuarioPerfil
			          FROM UsuarioPerfil AS usuPer
			         WHERE usuPer.idPerfil = per.idPerfil
			           AND usuPer.idUsuario = '$idUsuario'
			       ) AS idUsuarioPerfil
              FROM Perfil AS per
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
            FROM Perfil
           WHERE idPerfil = '$this->idPerfil'
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

    public function selecionaNome(){
        $bd = new BdSQL;
        $sql = "
          SELECT *
            FROM Perfil
           WHERE nome = '$this->nome'
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
    public function getIdPerfil(){
        return $this->idPerfil;
    }
    public function setIdPerfil($idPerfil){
        $this->idPerfil = $idPerfil;
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
    public function getIdUsuarioPerfil(){
        return $this->idUsuarioPerfil;
    }
    public function setIdUsuarioPerfil($idUsuarioPerfil){
        $this->idUsuarioPerfil = $idUsuarioPerfil;
    }
}
