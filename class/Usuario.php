<?php
class Usuario{
    private $idUsuario;
    private $idFacebook = NULL;
    private $email;
    private $senha;
    private $ultimoLogin;
    private $nome;
    private $cpf;
    private $sexo;
    private $telefone;
    private $fax;
    private $celular;
    private $ativo;

    private $idTipoUsuario;

// contrutor vazio
    public function __construct(){}

//MÉTODOS
    public function altera(){
        $sql = "
            UPDATE Usuario
               SET nome = ?,
                   email = ?,
                   telefone = ?,
                   cpf = ?,
                   sexo = ?,
                   fax = ?,
                   celular = ?
             WHERE idUsuario = ?
        ";
        $bd = new BdSQL;
        $dados = array(
            array(
                '1' => $this->nome,
                '2' => $this->email,
                '3' => $this->telefone,
                '4' => $this->cpf,
                '5' => $this->sexo,
                '6' => $this->fax,
                '7' => $this->celular,
                '8' => $this->idUsuario
            )
        );
        $result = $bd->altera($sql, $dados);
        if($result=='ok'){
            return true;
        }else{
            return false;
        }
    }

    public function alteraSenha(){
        $sql = "
            UPDATE Usuario
               SET senha = ?
             WHERE email = ?
        ";
        $bd = new BdSQL;
        $dados = array(
            array(
                '1' => $this->senha,
                '2' => $this->email
            )
        );
        $result = $bd->altera($sql, $dados);
        if($result=='ok'){
            return true;
        }else{
            return false;
        }
    }

    public function ativacao(){
        $sql = "
            UPDATE Usuario
               SET ativo = ?
             WHERE idUsuario = ?
        ";
        $bd = new BdSQL;
        $dados = array(
            array(
                '1' => $this->ativo,
                '2' => $this->idUsuario
            )
        );
        $result = $bd->altera($sql, $dados);
        if($result=='ok'){
            return true;
        }else{
            return false;
        }
    }

    public function atualizaUsuarioMenu( $stringSQL ){
        $bd = new BdSQL;
        $bd->consulta( $stringSQL );
    }

    public function atualizaUsuarioPerfil( $stringSQL ){
        $bd = new BdSQL;
        $bd->consulta( $stringSQL );
    }

    public function exclui(){
        $sql = "DELETE FROM Usuario WHERE idUsuario = ?";
        $bd = new BdSQL;
        $dados = array(
            array('1'=>$this->idUsuario)
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
            INSERT INTO Usuario (
                   nome,
                   email,
                   senha,
                   telefone,
                   cpf,
                   sexo,
                   fax,
                   celular
            ) VALUES (
                   ?,?,?,?,?,
                   ?,?,?
			)
		";
        $bd = new BdSQL;
        $dados = array(
            array(
                '1' => $this->nome,
                '2' => $this->email,
                '3' => $this->senha,
                '4' => $this->telefone,
                '5' => $this->cpf,
                '6' => $this->sexo,
                '7' => $this->fax,
                '8' => $this->celular
            )
        );
        $result = $bd->insereRetornaId($sql, $dados);
        if($result > 0){
            return $result;
        }else{
            return false;
        }
    }

    public function insereIdFacebook(){
        $sql = "
            UPDATE Usuario
               SET idFacebook = ?
             WHERE idUsuario = ?
        ";
        $bd = new BdSQL;
        $dados = array(
            array(
                '1' => $this->idFacebook,
                '2' => $this->idUsuario
            )
        );
        $result = $bd->altera($sql, $dados);
        if($result=='ok'){
            return true;
        }else{
            return false;
        }
    }

    public static function listaPrincipal( $palavraChave = NULL ){
        if($palavraChave){
            $palavraChave = "AND nome LIKE '%$palavraChave%' OR email LIKE '%$palavraChave%' ";
        }
        $bd = new BdSQL;
        $sql = "
            SELECT *
              FROM Usuario
             WHERE idUsuario > 0
             $palavraChave
          ORDER BY nome
        ";
        $resultSet = $bd->consulta( $sql );
        $resultado = array();
        $i = 0;
        $totalResultados = count($resultSet);
        for( $j=0; $j<$totalResultados; $j++ ){
            $objeto = new Usuario;
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

    public function login(){
        $bd = new BdSQL;
        $sql = "
            SELECT *
              FROM Usuario
             WHERE ativo = '1'
               AND (
                   (email ='$this->email'
               AND senha = '" . $this->senha . "')
                OR (idFacebook > 0
               AND idFacebook = '$this->idFacebook')
               )
        ";
        $resultado = $bd->consulta($sql);
        if(count($resultado)==1){
            foreach( $resultado[0] as $chave=>$valor ){
                if(!is_int($chave)){
                    $this->$chave = $valor;
                }
            }
            $this->ultimoLogin();
            return true;
        }else{
            return false;
        }
    }

    public function seleciona(){
        $bd = new BdSQL;
        $sql = "
            SELECT *
              FROM Usuario
             WHERE idUsuario = '$this->idUsuario'
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

    public function selecionaEmail(){
        $bd = new BdSQL;
        $sql = "
            SELECT *
              FROM Usuario
             WHERE email = '$this->email'
               AND idUsuario != '$this->idUsuario'
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

    public static function selecionaPorPerfil( $idPerfil ){
        $bd = new BdSQL;
        $sql = "
            SELECT usu.nome
              FROM Usuario AS usu,
                   UsuarioPerfil AS usuPer
             WHERE usu.idUsuario = usuPer.idUsuario
               AND usuPer.idPerfil = '$idPerfil'
               AND usu.ativo = '1'
          ORDER BY nome
        ";
        $resultSet = $bd->consulta( $sql );
        $usuarios = $virgula = NULL;
        foreach($resultSet as $chave => $valor){
            $usuarios .= $virgula . nomeProprio($valor['0']);
            $virgula = ', ';
        }
        return $usuarios;
    }

    public function ultimoLogin(){
        $sql = "
            UPDATE Usuario
               SET ultimoLogin = NOW()
             WHERE idUsuario = ?
        ";
        $bd = new BdSQL;
        $dados = array(
            array('1'=>$this->getIdUsuario())
        );
        $result = $bd->altera($sql, $dados);
        if($result=='ok'){
            return true;
        }else{
            return false;
        }
    }

//GETTERS E SETTERS
    public function getIdUsuario(){
        return $this->idUsuario;
    }
    public function setIdUsuario($idUsuario){
        $this->idUsuario = $idUsuario;
    }
    public function getIdFacebook()
    {
        return $this->idFacebook;
    }
    public function setIdFacebook($idFacebook)
    {
        $this->idFacebook = $idFacebook;
    }
    public function getEmail(){
        return $this->email;
    }
    public function setEmail($email){
        $this->email = $email;
    }
    public function getSenha(){
        return $this->senha;
    }
    public function setSenha($senha){
        $this->senha = encriptaSenha($senha);
    }
    public function getultimoLogin(){
        return $this->ultimoLogin;
    }
    public function setultimoLogin($ultimoLogin){
        $this->ultimoLogin = $ultimoLogin;
    }
    public function getnome(){
        return nomeProprio($this->nome);

    }
    public function setnome($nome){
        $this->nome = $nome;
    }
    public function getIdTipoUsuario(){
        return $this->idTipoUsuario;
    }
    public function setIdTipoUsuario($idTipoUsuario){
        $this->idTipoUsuario = $idTipoUsuario;
    }
    public function getCpf(){
        return $this->cpf;
    }
    public function setCpf($cpf){
        $this->cpf = $cpf;
    }
    public function getSexo(){
        return $this->sexo;
    }
    public function setSexo($sexo){
        $this->sexo = $sexo;
    }
    public function getTelefone(){
        return $this->telefone;
    }
    public function setTelefone($telefone){
        $this->telefone = $telefone;
    }
    public function getFax(){
        return $this->fax;
    }
    public function setFax($fax){
        $this->fax = $fax;
    }
    public function getCelular(){
        return $this->celular;
    }
    public function setCelular($celular){
        $this->celular = $celular;
    }
    public function getAtivo(){
        return $this->ativo;
    }
    public function setAtivo($ativo){
        $this->ativo = $ativo;
    }
}
