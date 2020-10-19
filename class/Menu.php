<?php
class Menu{
    private $idmenu = null;
    private $idmenupai = null;
    private $idicone = null;
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
                   idmenupai = ?,
                   idicone = ?,
                   ordem = ?,
                   descricao = ?,
                   secao = ?
             WHERE idmenu = ?
        ";
        $bd = new BdSQL;
        $dados = array(
            array(
                '1' => $this->nome,
                '2' => $this->idmenupai,
                '3' => $this->idicone,
                '4' => $this->ordem,
                '5' => $this->descricao,
                '6' => $this->secao,
                '7' => $this->idmenu
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
        $sql = "DELETE FROM Menu WHERE idmenu = ?";
        $bd = new BdSQL;
        $dados = array(
            array('1'=>$this->idmenu)
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
                   idmenupai,
                   idicone,
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
                '2' => $this->idmenupai,
                '3' => $this->idicone,
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
				     WHERE men.idmenupai = men2.idmenu
				   ) AS idmenupai
			  FROM Menu AS men
			 WHERE men.idmenupai = '$idMenuPai'
			   AND men.idmenu != men.idmenupai
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
				     WHERE men.idmenupai = men2.idmenu
				   ) AS idmenupai
			  FROM Menu AS men
			 WHERE men.idmenupai = '$idMenuPai'
			   AND men.idmenu != men.idmenupai
			   AND EXISTS (
			       SELECT idmenu
			         FROM UsuarioPerfil AS usuPer,
			              PerfilMenu AS perMen
			        WHERE usuPer.idPerfil = perMen.idPerfil
			          AND perMen.idmenu = men.idmenu
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
				     WHERE men.idicone = menIco.idMenuIcone
				   ) AS idicone
			  FROM Menu AS men
			 WHERE men.idmenupai = 1
			   AND men.idmenu != 1
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
				      FROM Menuicone AS menIco
				     WHERE men.idicone = menIco.idmenuicone
				   ) AS idicone
			  FROM Menu AS men
			 WHERE men.idmenupai = 1
			   AND men.idmenu != 1
			   AND EXISTS (
			       SELECT idmenu
			         FROM UsuarioPerfil AS usuPer,
			              PerfilMenu AS perMen
			        WHERE usuPer.idPerfil = perMen.idPerfil
			          AND perMen.idmenu = men.idmenu
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
				      FROM Menuicone AS menIco
				     WHERE men.idicone = menIco.idmenuicone
				   ) AS idicone
			  FROM Menu AS men,
			       PerfilMenu AS perMen
			 WHERE men.idmenu = perMen.idmenu
			   AND perMen.idPerfil = '$idPerfil'
			   AND men.idmenupai = 1
			   AND men.idmenu != 1
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

    public static function listaMenuPerfisFilhos( $idPerfil, $idmenupai ){
        $bd = new BdSQL;
        $sql = "
			SELECT men.*,
				   (SELECT icone
				      FROM Menuicone AS menIco
				     WHERE men.idicone = menIco.idmenuicone
				   ) AS idicone
			  FROM Menu AS men,
			       PerfilMenu AS perMen
			 WHERE men.idmenu = perMen.idmenu
			   AND perMen.idPerfil = '$idPerfil'
			   AND men.idmenupai = '$idmenupai'
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
             WHERE idmenu = '$this->idmenu'
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
             WHERE men.idmenu = (SELECT men2.idmenupai
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
    public function getIdmenu(){
        return $this->idmenu;
    }
    public function setIdmenu($idmenu){
        $this->idmenu = $idmenu;
    }
    public function getIdmenupai(){
        return $this->idmenupai;
    }
    public function setIdmenupai($idmenupai){
        $this->idmenupai = $idmenupai;
    }
    public function getIdicone(){
        return $this->idicone;
    }
    public function setIdicone($idicone){
        $this->idicone = $idicone;
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
