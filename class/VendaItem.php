<?php
class VendaItem{
    private $id;
    private $id_venda;
    private $id_produto;
    private $quantidade;
    private $valor;
    private $imposto;

// contrutor vazio
    public function __construct(){}

//MÉTODOS
    public function altera(){
        $sql = "
            UPDATE VendaItem
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
                '1' => $this->id_produto,
                '2' => $this->quantidade,
                '3' => $this->valor,
                '4' => $this->imposto,
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

    public function atualiza( $id, $quantidadeAtual ){
        $sql = '
          UPDATE "vendaItem"
             SET quantidade = ' . ($quantidadeAtual + $this->quantidade) . '
           WHERE id = ' . $id . '
        ';
        $bd = new BdSQL;
        $dados = array(
            array(
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
        $sql = 'DELETE FROM "vendaItem" WHERE id = ?';
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
        $itemAtual = $this->verificaDuplicidade();
        if($itemAtual['id'] > 0){
            $this->atualiza( $itemAtual['id'], $itemAtual['quantidade'] );
            return false;
        }
        $sql = '
            INSERT INTO "vendaItem" (
				id_venda,
				id_produto,
				quantidade,
				valor,
				imposto
			)  VALUES (
				?,?,?,?,?
			)
		';
        $bd = new BdSQL;
        $dados = array(
            array(
                '1' => $this->id_venda,
                '2' => $this->id_produto,
                '3' => $this->quantidade,
                '4' => $this->valor,
                '5' => $this->imposto
            )
        );
        $result = $bd->insereRetornaId($sql, $dados);
        if($result > 0){
            return $result;
        }else{
            return false;
        }
    }

    public function listaItens( $id_venda ){
        $bd = new BdSQL;
        $consulta = '
			SELECT "vendaItem".*,
			       produto.id AS id_produto
			  FROM "vendaItem",
			       produto
			 WHERE "vendaItem".id_venda = ' . $id_venda . '
			   AND "vendaItem".id_produto = produto.id
		  ORDER BY "vendaItem".id
		';
        $resultSet = $bd->consulta( $consulta );
        $resultado = array();
        $i = 0;
        $totalResultados = count($resultSet);
        for( $j=0; $j<$totalResultados; $j++ ){
            $objeto = new VendaItem;
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

    public function verificaDuplicidade(){
        $bd = new BdSQL;
        $sql = '
            SELECT quantidade,
                   id
              FROM "vendaItem"
             WHERE id_venda = ' . $this->id_venda . '
               AND id_produto = ' . $this->id_produto . '
        ';
        $resultado = $bd->consulta($sql);
        if(count($resultado)>0){
            $retorno['id'] = $resultado[0]['id'];
            $retorno['quantidade'] = $resultado[0]['quantidade'];
            return $retorno;
        }else{
            $retorno['id'] = '0';
            return $retorno;
        }
    }

//GETTERS E SETTERS
    public function getId(){
        return $this->id;
    }
    public function setId($id){
        $this->id = $id;
    }
    public function getId_venda(){
        return $this->id_venda;
    }
    public function setId_venda($id_venda){
        $this->id_venda = $id_venda;
    }
    public function getId_produto(){
        return $this->id_produto;
    }
    public function setId_produto($id_produto){
        $this->id_produto = $id_produto;
    }
    public function getQuantidade(){
        return $this->quantidade;
    }
    public function setQuantidade($quantidade){
        $this->quantidade = $quantidade;
    }
    public function getValor(){
        return baseToDecimal($this->valor);
    }
    public function setValor($valor){
        $this->valor = decimalToBase($valor);
    }
    public function getImposto(){
        return baseToDecimal($this->imposto);
    }
    public function setImposto($imposto){
        $this->imposto = decimalToBase($imposto);
    }
}
