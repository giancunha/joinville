<?php
class ProdutoTipo {
    public $id = 0;
    private $tipo;
    private $imposto;
// contrutor vazio
    public function __construct(){}
//MÉTODOS
    public function altera(){
        $sql = '
			UPDATE "produtoTipo"
			   SET tipo = ?,
			       imposto = ?
			 WHERE id = ?
		';
        $bd = new BdSQL;
        $dados = array(
            array(
                '1' => $this->tipo,
                '2' => $this->imposto,
                '3' => $this->id
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
        $sql = 'DELETE FROM "produtoTipo" WHERE id = ?';
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
        $sql = '
            INSERT INTO "produtoTipo" (
                   tipo,
                   imposto
            ) VALUES (
                   ?,?
            )
        ';
        $bd = new BdSQL;
        $dados = array(
            array(
                '1' => $this->tipo,
                '2' => $this->imposto
            )
        );
        $result = $bd->insereRetornaId($sql, $dados);
        if($result > 0){
            return $result;
        }else{
            return false;
        }
    }

    public static function listaPrincipal( ){
        $bd = new BdSQL;
        $sql = '
            SELECT *
              FROM "produtoTipo"
          ORDER BY tipo
        ';
        $resultSet = $bd->consulta( $sql );
        $resultado = array();
        $i = 0;
        $totalResultados = count($resultSet);
        for( $j=0; $j<$totalResultados; $j++ ){
            $objeto = new ProdutoTipo;
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
        $sql = '
            SELECT *
              FROM "produtoTipo"
             WHERE id = ' . $this->id . '
        ';
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

    public function selecionaProduto(){
        $bd = new BdSQL;
        $sql = '
            SELECT 1
              FROM produto
             WHERE "idTipo" = ' . $this->id . '
             LIMIT 1
        ';
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

    public function selecionaTipo(){
        $bd = new BdSQL;
        $sql = '
            SELECT id
              FROM "produtoTipo"
             WHERE tipo = \'' . $this->tipo . '\'
               AND id != ' . $this->id . '
        ';
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
    public function getTipo()
    {
        return $this->tipo;
    }
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }
    public function getImposto()
    {
        return preco($this->imposto);
    }
    public function setImposto($imposto)
    {
        $this->imposto = decimalToBase($imposto);
    }
}
