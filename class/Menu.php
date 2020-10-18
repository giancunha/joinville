<?php
class Menu{
    private $idMenu = null;
    private $idMenuPai = null;
    private $idIcone = null;
    private $ordem = null;
    private $nome = null;
    private $descricao = null;
    private $secao = null;
    private $idPerfilMenu = null;

// contrutor vazio
    public function __construct(){}

//MÉTODOS
    public function altera(){
        $sql = "
            UPDATE Menu
               SET nome = ?,
                   idMenuPai = ?,
                   idIcone = ?,
                   ordem = ?,
                   descricao = ?,
                   secao = ?
             WHERE idMenu = ?
        ";
        $bd = new BdSQL;
        $dados = array(
            array(
                '1' => $this->nome,
                '2' => $this->idMenuPai,
                '3' => $this->idIcone,
                '4' => $this->ordem,
                '5' => $this->descricao,
                '6' => $this->secao,
                '7' => $this->idMenu
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
        $sql = "DELETE FROM Menu WHERE idMenu = ?";
        $bd = new BdSQL;
        $dados = array(
            array('1'=>$this->idMenu)
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
            INSERT INTO Menu (
                   nome,
                   idMenuPai,
                   idIcone,
                   ordem,
                   descricao,
                   secao
            ) VALUES (
                   ?,?,?,?,?,
                   ?
            )
        ";
        $bd = new BdSQL;
        $dados = array(
            array(
                '1' => $this->nome,
                '2' => $this->idMenuPai,
                '3' => $this->idIcone,
                '4' => $this->ordem,
                '5' => $this->descricao,
                '6' => $this->secao
            )
        );
        $result = $bd->insereRetornaId($sql, $dados);
        if($result > 0){
            return $result;
        }else{
            return false;
        }
    }

    public static function listaMenuFilhos( $idMenuPai ){
        $bd = new BdSQL;
        $sql = "
			SELECT men.*,
				   (SELECT nome
				      FROM Menu AS men2
				     WHERE men.idMenuPai = men2.idMenu
				   ) AS idMenuPai
			  FROM Menu AS men
			 WHERE men.idMenuPai = '$idMenuPai'
			   AND men.idMenu != men.idMenuPai
		  ORDER BY men.ordem,
		           men.nome
		";
        $resultSet = $bd->consulta( $sql );
        $resultado = array();
        $i = 0;
        $totalResultados = count($resultSet);
        for( $j=0; $j<$totalResultados; $j++ ){
            $objeto = new Menu;
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

    public static function listaMenuFilhosPorPerfil( $idMenuPai, $idUsuario ){
        $bd = new BdSQL;
        $sql = "
			SELECT men.*,
				   (SELECT nome
				      FROM Menu AS men2
				     WHERE men.idMenuPai = men2.idMenu
				   ) AS idMenuPai
			  FROM Menu AS men
			 WHERE men.idMenuPai = '$idMenuPai'
			   AND men.idMenu != men.idMenuPai
			   AND EXISTS (
			       SELECT idMenu
			         FROM UsuarioPerfil AS usuPer,
			              PerfilMenu AS perMen
			        WHERE usuPer.idPerfil = perMen.idPerfil
			          AND perMen.idMenu = men.idMenu
			          AND usuPer.idUsuario = '$idUsuario'
			       )
		  ORDER BY men.ordem,
		           men.nome
		";
        $resultSet = $bd->consulta( $sql );
        $resultado = array();
        $i = 0;
        $totalResultados = count($resultSet);
        for( $j=0; $j<$totalResultados; $j++ ){
            $objeto = new Menu;
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

    public static function listaMenuPais( ){
        $bd = new BdSQL;
        $sql = "
			SELECT men.*,
				   (SELECT icone
				      FROM MenuIcone AS menIco
				     WHERE men.idIcone = menIco.idMenuIcone
				   ) AS idIcone
			  FROM Menu AS men
			 WHERE men.idMenuPai = 1
			   AND men.idMenu != 1
		  ORDER BY men.ordem,
		           men.nome
		";
        $resultSet = $bd->consulta( $sql );
        $resultado = array();
        $i = 0;
        $totalResultados = count($resultSet);
        for( $j=0; $j<$totalResultados; $j++ ){
            $objeto = new Menu;
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

    public static function listaMenuPaisPorPerfil( $idUsuario ){
        $bd = new BdSQL;
        $sql = "
			SELECT men.*,
				   (SELECT icone
				      FROM MenuIcone AS menIco
				     WHERE men.idIcone = menIco.idMenuIcone
				   ) AS idIcone
			  FROM Menu AS men
			 WHERE men.idMenuPai = 1
			   AND men.idMenu != 1
			   AND EXISTS (
			       SELECT idMenu
			         FROM UsuarioPerfil AS usuPer,
			              PerfilMenu AS perMen
			        WHERE usuPer.idPerfil = perMen.idPerfil
			          AND perMen.idMenu = men.idMenu
			          AND usuPer.idUsuario = '$idUsuario'
				   )
		  ORDER BY men.ordem,
		           men.nome
		";
        $resultSet = $bd->consulta( $sql );
        $resultado = array();
        $i = 0;
        $totalResultados = count($resultSet);
        for( $j=0; $j<$totalResultados; $j++ ){
            $objeto = new Menu;
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

    public static function listaMenuPerfisPais( $idPerfil ){
        $bd = new BdSQL;
        $sql = "
			SELECT men.*,
				   (SELECT icone
				      FROM MenuIcone AS menIco
				     WHERE men.idIcone = menIco.idMenuIcone
				   ) AS idIcone
			  FROM Menu AS men,
			       PerfilMenu AS perMen
			 WHERE men.idMenu = perMen.idMenu
			   AND perMen.idPerfil = '$idPerfil'
			   AND men.idMenuPai = 1
			   AND men.idMenu != 1
		  ORDER BY men.ordem,
		           men.nome
		";
        $resultSet = $bd->consulta( $sql );
        $resultado = array();
        $i = 0;
        $totalResultados = count($resultSet);
        for( $j=0; $j<$totalResultados; $j++ ){
            $objeto = new Menu;
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

    public static function listaMenuPerfisFilhos( $idPerfil, $idMenuPai ){
        $bd = new BdSQL;
        $sql = "
			SELECT men.*,
				   (SELECT icone
				      FROM MenuIcone AS menIco
				     WHERE men.idIcone = menIco.idMenuIcone
				   ) AS idIcone
			  FROM Menu AS men,
			       PerfilMenu AS perMen
			 WHERE men.idMenu = perMen.idMenu
			   AND perMen.idPerfil = '$idPerfil'
			   AND men.idMenuPai = '$idMenuPai'
		  ORDER BY men.ordem,
		           men.nome
		";
        $resultSet = $bd->consulta( $sql );
        $resultado = array();
        $i = 0;
        $totalResultados = count($resultSet);
        for( $j=0; $j<$totalResultados; $j++ ){
            $objeto = new Menu;
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
			  FROM Menu AS men
		  ORDER BY men.ordem,
		           men.nome
		";
        $resultSet = $bd->consulta( $sql );
        $resultado = array();
        $i = 0;
        $totalResultados = count($resultSet);
        for( $j=0; $j<$totalResultados; $j++ ){
            $objeto = new Menu;
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
              FROM Menu
             WHERE idMenu = '$this->idMenu'
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

    public function selecionaFilho( ){
        $bd = new BdSQL;
        $sql = "
            SELECT men.*
              FROM Menu AS men
             WHERE secao = '$this->secao'
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

    public function selecionaPai( ){
        $bd = new BdSQL;
        $sql = "
            SELECT men.*
              FROM Menu AS men
             WHERE men.idMenu = (SELECT men2.idMenuPai
                                   FROM Menu AS men2
                                  WHERE men2.secao = '$this->secao'
                                )
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
    public function getIdMenu(){
        return $this->idMenu;
    }
    public function setIdMenu($idMenu){
        $this->idMenu = $idMenu;
    }
    public function getIdMenuPai(){
        return $this->idMenuPai;
    }
    public function setIdMenuPai($idMenuPai){
        $this->idMenuPai = $idMenuPai;
    }
    public function getIdIcone(){
        return $this->idIcone;
    }
    public function setIdIcone($idIcone){
        $this->idIcone = $idIcone;
    }
    public function getOrdem(){
        return $this->ordem;
    }
    public function setOrdem($ordem){
        $this->ordem = $ordem;
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
    public function getSecao(){
        return $this->secao;
    }
    public function setSecao($secao){
        $this->secao = $secao;
    }
    public function getIdPerfilMenu(){
        return $this->idPerfilMenu;
    }
    public function setIdPerfilMenu($idPerfilMenu){
        $this->idPerfilMenu = $idPerfilMenu;
    }
}
