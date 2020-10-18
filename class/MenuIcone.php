<?php
class MenuIcone{
    private $idMenuIcone = null;
    private $icone = null;

// contrutor vazio
    public function __construct(){}

//MÉTODOS
    public function altera(){
        $sql = "
			UPDATE MenuIcone
			   SET icone = ?
			 WHERE idMenuIcone = ?
		";
        $bd = new BdSQL;
        $dados = array(
            array(
                '1' => $this->icone,
                '2' => $this->idMenuIcone
            )
        );
        $result = $bd->altera($sql, $dados);
        if($result=='ok'){
            return true;
        }else{
            return false;
        }
    }

    public function exclui(){
        $sql = "DELETE FROM MenuIcone WHERE idMenuIcone = ?";
        $bd = new BdSQL;
        $dados = array(
            array('1'=>$this->idMenuIcone)
        );
        $result = $bd->deleta($sql, $dados);
        if($result=='ok'){
            return true;
        }else{
            return false;
        }
    }

    public function insere(){
        $insere = "
			INSERT INTO MenuIcone (
				icone
			) VALUES (
				?
			)
		";
        $bd = new BdSQL;
        $dados = array(
            array('1' => $this->icone
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
			SELECT MenuIcone.*
			  FROM MenuIcone
		";
        $resultSet = $bd->consulta( $sql );
        $resultado = array();
        $i = 0;
        $totalResultados = count($resultSet);
        for( $j=0; $j<$totalResultados; $j++ ){
            $objeto = new MenuIcone;
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
			  FROM MenuIcone
			 WHERE idMenuIcone = '$this->idMenuIcone'
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

    public function selecionaIcone(){
        $bd = new BdSQL;
        $sql = "
			SELECT *
			  FROM MenuIcone
			 WHERE icone = '$this->icone'
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
    public function getIdMenuIcone(){
        return $this->idMenuIcone;
    }
    public function setIdMenuIcone($idMenuIcone){
        $this->idMenuIcone = $idMenuIcone;
    }
    public function getIcone(){
        return $this->icone;
    }
    public function setIcone($icone){
        $this->icone = $icone;
    }
}
