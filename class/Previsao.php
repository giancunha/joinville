<?php
class Previsao {
    public $id;
    public $idServico;
    private $idControle = NULL;
    private $idUsuario;
    private $tipo;
    private $vencimento;
    private $valor;
    private $descricao;
// contrutor vazio
    public function __construct(){}
//MÉTODOS
    public function altera(){
        $sql = "
			UPDATE Previsao
			   SET idServico = ?,
			       idUsuario = ?,
			       tipo = ?,
			       vencimento = ?,
			       valor = ?,
			       descricao = ?
			 WHERE id = ?
		";
        $bd = new BdSQL;
        $dados = array(
            array(
                '1' => $this->idServico,
                '2' => $this->idUsuario,
                '3' => $this->tipo,
                '4' => $this->vencimento,
                '5' => $this->valor,
                '6' => $this->descricao,
                '7' => $this->id
            )
        );
        $result = $bd->altera($sql, $dados);
        if($result=='ok'){
            return true;
        }else{
            return false;
        }
    }

    private function anulaVinculo(){
        $sql = "
			UPDATE Previsao
			   SET idControle = NULL
			 WHERE idControle = ?
		";
        $bd = new BdSQL;
        $dados = array(
            array(
                '1' => $this->id
            )
        );
        $result = $bd->altera($sql, $dados);
        if($result=='ok'){
            return true;
        }else{
            return false;
        }
    }

    public function atualizaIdControle(){
        $sql = "
			UPDATE Previsao
			   SET idControle = ?
			 WHERE id = ?
		";
        $bd = new BdSQL;
        $dados = array(
            array(
                '1' => $this->idControle,
                '2' => $this->idControle
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
        if($this->id == $this->idControle){
            $this->anulaVinculo();
        }
        $sql = "DELETE FROM Previsao WHERE id = ?";
        $bd = new BdSQL;
        $dados = array(
            array('1'=>$this->id)
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
            INSERT INTO Previsao (
                   idServico,
                   idControle,
                   idUsuario,
                   tipo,
                   vencimento,
                   valor,
                   descricao
            ) VALUES (
                   ?,?,?,?,?,
                   ?,?
            )
        ";
        $bd = new BdSQL;
        $dados = array(
            array(
                '1' => $this->idServico,
                '2' => $this->idControle,
                '3' => $this->idUsuario,
                '4' => $this->tipo,
                '5' => $this->vencimento,
                '6' => $this->valor,
                '7' => $this->descricao
            )
        );
        $result = $bd->insereRetornaId($sql, $dados);
        if($result > 0){
            return $result;
        }else{
            return false;
        }
    }

    public static function listaFixas( $dataInicial, $dataFinal ){
        $dataInicial = dataToBase($dataInicial);
        $dataFinal = dataToBase($dataFinal);
        list($ano, $mes) = explode('-', date('Y-m'));
        if($dataInicial <= $dataFinal){
            $ordem = 'ASC';
        } else {
            $ordem = $dataInicial;
            $dataInicial = $dataFinal;
            $dataFinal = $ordem;
            $ordem = 'DESC';
        }
        $bd = new BdSQL;
        $sql = "
            SELECT *,
                   CONCAT('$ano','-$mes-',DAY(vencimento)) AS vencimento
              FROM Previsao
             WHERE tipo = 'F'
          ORDER BY DAY(vencimento) $ordem
        ";
        $resultSet = $bd->consulta( $sql );
        $resultado = array();
        $i = 0;
        $totalResultados = count($resultSet);
        for( $j=0; $j<$totalResultados; $j++ ){
            $objeto = new Previsao;
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

    public static function listaVariaveis( $dataInicial, $dataFinal ){
        $dataInicial = dataToBase($dataInicial);
        $dataFinal = dataToBase($dataFinal);
        if($dataInicial <= $dataFinal){
            $ordem = 'ASC';
        } else {
            $ordem = $dataInicial;
            $dataInicial = $dataFinal;
            $dataFinal = $ordem;
            $ordem = 'DESC';
        }
        $bd = new BdSQL;
        $sql = "
            SELECT *
              FROM Previsao
             WHERE vencimento BETWEEN '$dataInicial' AND '$dataFinal'
               AND tipo IN ('V','C')
          ORDER BY vencimento $ordem
        ";
        $resultSet = $bd->consulta( $sql );
        $resultado = array();
        $i = 0;
        $totalResultados = count($resultSet);
        for( $j=0; $j<$totalResultados; $j++ ){
            $objeto = new Previsao;
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
              FROM Previsao
             WHERE id = '$this->id'
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
    public function getId(){
        return $this->id;
    }
    public function setId($id){
        $this->id = $id;
    }
    public function getIdServico()
    {
        return $this->idServico;
    }
    public function setIdServico($idServico)
    {
        $this->idServico = $idServico;
    }
    public function getIdControle()
    {
        return $this->idControle;
    }
    public function setIdControle($idControle)
    {
        $this->idControle = $idControle;
    }
    public function getIdUsuario()
    {
        return $this->idUsuario;
    }
    public function setIdUsuario($idUsuario)
    {
        $this->idUsuario = $idUsuario;
    }
    public function getTipo()
    {
        return $this->tipo;
    }
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }
    public function getVencimento()
    {
        return baseToData($this->vencimento);
    }
    public function setVencimento($vencimento)
    {
        $this->vencimento = dataToBase($vencimento);
    }
    public function getValor()
    {
        return baseToDecimal($this->valor);
    }
    public function setValor($valor)
    {
        $this->valor = decimalToBase($valor);
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
