<?php
class Venda{
    private $id;
    private $idVendedor = NULL;
    private $status = 'A';
    private $dia = NULL;
    private $hora = NULL;
    private $valor;

// contrutor vazio
    public function __construct(){}

//MÉTODOS
    public function altera(){
        $sql = "
          UPDATE Venda
             SET vencimento = ?
           WHERE id = ?
        ";
        $bd = new BdSQL;
        $dados = array(
            array(
                '1' => $this->vencimento,
                '2' => $this->id
            )
        );
        $result = $bd->altera($sql, $dados);
        if($result=='ok'){
            return true;
        }else{
            return false;
        }
    }

    public function atualiza(){
        $sql = "
          UPDATE Venda
             SET dia = current_timestamp,
                 hora = current_timestamp
           WHERE id = ?
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

    public function finaliza(){
        $sql = "
            UPDATE Venda
               SET dia = current_timestamp,
                   status = 'F',
                   hora = current_timestamp
             WHERE id = ?
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

    public function insere(){
        $sql = "
            INSERT INTO Venda (
                   id_vendedor,
                   dia,
                   hora
            ) VALUES (
                   ?,
                   current_timestamp,
                   current_timestamp
            )
        ";
        $bd = new BdSQL;
        $dados = array(
            array(
                '1' => $this->idVendedor
            )
        );
        $result = $bd->insereRetornaId($sql, $dados);
        if($result > 0){
            return $result;
        }else{
            return false;
        }
    }

    public function listaPrincipal(){
        $bd = new BdSQL;
        $sql = '
            SELECT venda.id,
                   venda.dia,
                   TO_CHAR(venda.hora, \'HH24:MI\') AS hora,
                   SUM("vendaItem".valor * "vendaItem".quantidade) AS valor,
                   usuario.nome AS "idVendedor",
              CASE status
                   WHEN \'A\' THEN \'Aberta\'
                   WHEN \'F\' THEN \'Finalizada\'
               END status
              FROM Venda,
                   "vendaItem",
                   usuario
             WHERE venda.id = "vendaItem".id_venda
               AND id_vendedor = usuario."idUsuario"
          GROUP BY venda.id,
                   usuario.nome
          ORDER BY dia DESC,
                   hora DESC
		';
        $resultSet = $bd->consulta( $sql );
        $resultado = array();
        $i = 0;
        $totalResultados = count($resultSet);
        for( $j=0; $j<$totalResultados; $j++ ){
            $objeto = new Venda;
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
              FROM Venda
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

    public function selecionaVendaAtual(){
        $bd = new BdSQL;
        $sql = '
            SELECT id
              FROM venda
             WHERE id_vendedor = ' . $this->idVendedor . '
               AND status = \'A\'
          ORDER BY id
             LIMIT 1
        ';
        $resultado = $bd->consulta($sql);
        if(count($resultado)==1){
            return $resultado[0]['id'];
        }else{
            return 0;
        }
    }

//GETTERS E SETTERS
    public function getId(){
        return $this->id;
    }
    public function setId($id){
        $this->id = $id;
    }
    public function getIdVendedor(){
        return $this->idVendedor;
    }
    public function setIdVendedor($idVendedor){
        $this->idVendedor = $idVendedor;
    }
    public function getStatus(){
        return $this->status;
    }
    public function setStatus($status){
        $this->status = $status;
    }
    public function getDia(){
        return baseToData($this->dia);
    }
    public function setDia($dia){
        $this->dia = dataToBase($dia);
    }
    public function getHora()
    {
        return $this->hora;
    }
    public function setHora($hora)
    {
        $this->hora = $hora;
    }
    public function getValor(){
        return baseToDecimal($this->valor);
    }
    public function setValor($valor){
        $this->valor = decimalToBase($valor);
    }
    public function getNumeroNota()
    {
        return $this->numeroNota;
    }
    public function setNumeroNota($numeroNota)
    {
        $this->numeroNota = $numeroNota;
    }
}
