<?php
class Servico{
    private $idServico = NULL;
    private $nome = NULL;
    private $natureza = NULL;
    private $descricao = NULL;

// contrutor vazio
    public function __construct(){}

//MÉTODOS
    public function altera(){
        $sql = "
            UPDATE Servico
               SET nome = ?,
                   natureza = ?,
                   descricao = ?
             WHERE idServico = ?
        ";
        $bd = new BdSQL;
        $dados = array(
            array(
                '1' => $this->nome,
                '2' => $this->natureza,
                '3' => $this->descricao,
                '4' => $this->idServico
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
        $sql = "DELETE FROM Servico WHERE idServico = ?";
        $bd = new BdSQL;
        $dados = array(
            array('1'=>$this->idServico)
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
            INSERT INTO Servico (
                   nome,
                   natureza,
                   descricao
            ) VALUES (
                   ?,?,?
            )
        ";
        $bd = new BdSQL;
        $dados = array(
            array(
                '1' => $this->nome,
                '2' => $this->natureza,
                '3' => $this->descricao
            )
        );
        $result = $bd->insereRetornaId($sql, $dados);
        if($result > 0){
            return $result;
        }else{
            return false;
        }
    }

    public static function listaPrincipal( $natureza = NULL ){
        if($natureza){
            $natureza = "
                WHERE natureza = 'A'
                   OR natureza = '$natureza'
            ";
        }
        $bd = new BdSQL;
        $sql = "
            SELECT *
              FROM Servico
             $natureza
          ORDER BY nome
        ";
        $resultSet = $bd->consulta( $sql );
        $resultado = array();
        $i = 0;
        $totalResultados = count($resultSet);
        for( $j=0; $j<$totalResultados; $j++ ){
            $objeto = new Servico;
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
              FROM Servico
             WHERE idServico = '$this->idServico'
                OR nome = '$this->nome'
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
    public function getIdServico(){
        return $this->idServico;
    }
    public function setIdServico($idServico){
        $this->idServico = $idServico;
    }
    public function getNome(){
        return $this->nome;
    }
    public function setNome($nome){
        $this->nome = $nome;
    }
    public function getNatureza(){
        return $this->natureza;
    }
    public function setNatureza($natureza){
        $this->natureza = $natureza;
    }
    public function getDescricao()
    {
        return $this->descricao;
    }
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }
}
