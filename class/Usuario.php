<?php
class Usuario{
    private $idUsuario;
    private $email;
    private $senha;
    private $nome;
    private $ativo;

// contrutor vazio
    public function __construct(){}

//MÉTODOS
    public function altera(){
        $sql = "
            UPDATE Usuario
               SET nome = ?,
                   email = ?
             WHERE idUsuario = ?
        ";
        $bd = new BdSQL;
        $dados = array(
            array(
                '1' => $this->nome,
                '2' => $this->email,
                '3' => $this->idUsuario
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
               AND email ='$this->email'
               AND senha = '" . $this->senha . "'
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

//GETTERS E SETTERS
    public function getIdUsuario(){
        return $this->idUsuario;
    }
    public function setIdUsuario($idUsuario){
        $this->idUsuario = $idUsuario;
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
    public function getnome(){
        return nomeProprio($this->nome);

    }
    public function setnome($nome){
        $this->nome = $nome;
    }
    public function getAtivo(){
        return $this->ativo;
    }
    public function setAtivo($ativo){
        $this->ativo = $ativo;
    }
}
