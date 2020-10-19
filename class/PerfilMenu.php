<?php
class PerfilMenu{
    private $idPerfilMenu = null;
    private $idMenu = null;
    private $idPerfil = null;
    private $nome = null;
    private $icone = null;
    private $descricao = null;

// contrutor vazio
    public function __construct(){}

//MÉTODOS
    public function altera(){
        $sql = "
            UPDATE Perfil SET
                   idMenu = ?,
                   idPerfil = ?
             WHERE idPerfilMenu = ?
        ";
        $bd = new BdSQL;
        $dados = array(
            array(
                '1' => $this->idMenu,
                '2' => $this->idPerfil,
                '3' => $this->idPerfilMenu
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
        $sql = "DELETE FROM Perfil WHERE idPerfilMenu = ?";
        $bd = new BdSQL;
        $dados = array(
            array('1'=>$this->idPerfilMenu)
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
                   idMenu,
                   idPerfil
            ) VALUES (
                   ?,?
		    )
		";
        $bd = new BdSQL;
        $dados = array(
            array(
                '1' => $this->idMenu,
                '2' => $this->idPerfil
            )
        );
        $result = $bd->insereRetornaId($sql, $dados);
        if($result > 0){
            return $result;
        }else{
            return false;
        }
    }

    public static function listaPerfilMenuFilho( $idMenuPai, $idPerfil = NULL ){
        $bd = new BdSQL;
        $sql = "
            SELECT men.idMenu,
                   men.nome,
                   (SELECT icone
                      FROM MenuIcone AS menIco
                     WHERE men.idicone = menIco.idMenuIcone
                   ) AS idicone,
                   (SELECT idPerfilMenu
                      FROM PerfilMenu AS perMen
                     WHERE perMen.idPerfil = '$idPerfil'
                       AND perMen.idMenu = men.idMenu
                   ) AS idPerfilMenu
              FROM Menu AS men
             WHERE men.idMenuPai = '$idMenuPai'
          ORDER BY men.ordem,
                   men.nome
		";
        $resultSet = $bd->consulta( $sql );
        $resultado = array();
        $i = 0;
        $totalResultados = count($resultSet);
        for( $j=0; $j<$totalResultados; $j++ ){
            $objeto = new PerfilMenu;
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

    public static function listaPerfilMenuPai( $idPerfil ){
        $bd = new BdSQL;
        $sql = "
            SELECT men.idMenu,
                   men.nome,
                   (SELECT icone
                      FROM MenuIcone AS menIco
                     WHERE men.idicone = menIco.idMenuIcone
                   ) AS idicone,
                   (SELECT idPerfilMenu
                      FROM PerfilMenu AS perMen
                     WHERE perMen.idPerfil = '$idPerfil'
                       AND perMen.idMenu = men.idMenu
                   ) AS idPerfilMenu
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
            $objeto = new PerfilMenu;
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

    public static function selecionaPerfilMenu( $idPerfil, $idMenu ){
        $bd = new BdSQL;
        $sql = "
          SELECT *
            FROM PerfilMenu
           WHERE idPerfil = '$idPerfil'
             AND idMenu = '$idMenu'
        ";
        $resultado = $bd->consulta($sql);
        if(count($resultado)>0){
            return true;
        }else{
            return false;
        }
    }

//GETTERS E SETTERS
    public function getIdPerfilMenu(){
        return $this->idPerfilMenu;
    }
    public function setIdPerfilMenu($idPerfilMenu){
        $this->idPerfilMenu = $idPerfilMenu;
    }
    public function getIdMenu(){
        return $this->idMenu;
    }
    public function setIdMenu($idMenu){
        $this->idMenu = $idMenu;
    }
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
    public function getIdicone(){
        return $this->idicone;
    }
    public function setIdicone($idicone){
        $this->idicone = $idicone;
    }
    public function getDescricao(){
        return $this->descricao;
    }
    public function setDescricao($descricao){
        $this->descricao = $descricao;
    }
}
