<?php
class Estado{
    private $idEstado;
    private $estado;
    private $uf;
    private $idPais = 1;

// contrutor vazio
    public function __construct(){}

//MÉTODOS
    public static function listaPrincipal( ){
        $bd = new BdSQL;
        $sql = "SELECT *
			     FROM Estado
		     ORDER BY estado
		";
        $resultSet = $bd->consulta( $sql );
        $resultado = array();
        $i = 0;
        $totalResultados = count($resultSet);
        for( $j=0; $j<$totalResultados; $j++ ){
            $objeto = new Estado;
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

    public static function listaPorPais( $idPais ){
        $bd = new BdSQL;
        $sql = "SELECT *
			      FROM Estado
                 WHERE idPais = '$idPais'
		      ORDER BY estado
		";
        $resultSet = $bd->consulta( $sql );
        $resultado = array();
        $i = 0;
        $totalResultados = count($resultSet);
        for( $j=0; $j<$totalResultados; $j++ ){
            $objeto = new Estado;
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
        $sql = "SELECT * FROM Estado WHERE idEstado = '$this->idEstado'";
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

    public function selecionaPorUF( $uf ){
        $bd = new BdSQL;
        $sql = "SELECT * FROM Estado WHERE uf = '" . $this->uf . "'";
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
    public function getIdEstado(){
        return $this->idEstado;
    }
    public function setIdEstado($idEstado){
        $this->idEstado = $idEstado;
    }
    public function getEstado(){
        return corrigeCodificacao($this->estado);
    }
    public function setEstado($estado){
        $this->estado = $estado;
    }
    public function getUf(){
        return $this->uf;
    }
    public function setUf($uf){
        $this->uf = $uf;
    }
    public function getIdPais(){
        return $this->idPais;
    }
    public function setIdPais($idPais){
        $this->idPais = $idPais;
    }
}
