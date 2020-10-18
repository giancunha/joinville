<?php
class FaturaItem{
    private $id;
    private $idFatura;
    private $idServico;
    private $idUsuario;
    private $alterada;
    private $valor;
    private $descricao;
    private $descricaoServico;

// contrutor vazio
    public function __construct(){}

//MÉTODOS
    public function altera(){
        $sql = "
            UPDATE FaturaItem
               SET idServico = ?,
                   idUsuario = ?,
                   alterada = NOW(),
                   valor = ?,
                   descricao = ?
             WHERE id = ?
        ";
        $bd = new BdSQL;
        $dados = array(
            array(
                '1' => $this->idServico,
                '2' => $this->idUsuario,
                '3' => $this->valor,
                '4' => $this->descricao,
                '5' => $this->id
            )
        );
        $result = $bd->altera($sql, $dados);
        if($result=='ok'){
            return true;
        }else{
            return false;
        }
    }

    public function insere(){
        $insere = "
            INSERT INTO FaturaItem (
				idFatura,
				idServico,
				idUsuario,
				valor,
				descricao
			)  VALUES (
				?,?,?,?,?
			)
		";
        $bd = new BdSQL;
        $dados = array(
            array(
                '1' => $this->idFatura,
                '2' => $this->idServico,
                '3' => $this->idUsuario,
                '4' => $this->valor,
                '5' => $this->descricao
            )
        );
        $result = $bd->insereRetornaId($insere, $dados);
        if($result > 0){
            return $result;
        }else{
            return false;
        }
    }

    public function listaItens( $idFatura ){
        $bd = new BdSQL;
        $consulta = "
			SELECT FatIte.*,
			       ser.nome AS idServico,
			       ser.descricao AS descricaoServico
			  FROM FaturaItem AS FatIte,
			       Servico AS ser
			 WHERE FatIte.idFatura = '$idFatura'
			   AND FatIte.idServico = ser.idServico
		  ORDER BY ser.nome
		";
        $resultSet = $bd->consulta( $consulta );
        $resultado = array();
        $i = 0;
        $totalResultados = count($resultSet);
        for( $j=0; $j<$totalResultados; $j++ ){
            $objeto = new FaturaItem;
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

//GETTERS E SETTERS
    public function getId(){
        return $this->id;
    }
    public function setId($id){
        $this->id = $id;
    }
    public function getIdFatura(){
        return $this->idFatura;
    }
    public function setIdFatura($idFatura){
        $this->idFatura = $idFatura;
    }
    public function getIdServico(){
        return $this->idServico;
    }
    public function setIdServico($idServico){
        $this->idServico = $idServico;
    }
    public function getIdUsuario(){
        return $this->idUsuario;
    }
    public function setIdUsuario($idUsuario){
        $this->idUsuario = $idUsuario;
    }
    public function getAlterada(){
        return $this->alterada;
    }
    public function setAlterada($alterada){
        $this->alterada = $alterada;
    }
    public function getValor(){
        return baseToDecimal($this->valor);
    }
    public function setValor($valor){
        $this->valor = decimalToBase($valor);
    }
    public function getDescricao(){
        return $this->descricao;
    }
    public function setDescricao($descricao){
        $this->descricao = $descricao;
    }
    public function getDescricaoServico()
    {
        return $this->descricaoServico;
    }
    public function setDescricaoServico($descricaoServico)
    {
        $this->descricaoServico = $descricaoServico;
    }
}
