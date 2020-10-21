<?php
class Produto {
    public $id = 0;
    private $idTipo = NULL;
    private $nome;
    private $valor;
// contrutor vazio
    public function __construct(){}
//MÉTODOS
    public function altera(){
        $sql = '
			UPDATE "produto"
			   SET nome = ?,
			       valor = ?,
			       "idTipo" = ?
			 WHERE id = ?
		';
        $bd = new BdSQL;
        $dados = array(
            array(
                '1' => $this->nome,
                '2' => $this->valor,
                '3' => $this->idTipo,
                '4' => $this->id
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
        $sql = 'DELETE FROM "produto" WHERE id = ?';
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
            INSERT INTO "produto" (
                   nome,
                   valor,
                   "idTipo"
            ) VALUES (
                   ?,?,?
            )
        ';
        $bd = new BdSQL;
        $dados = array(
            array(
                '1' => $this->nome,
                '2' => $this->valor,
                '3' => $this->idTipo
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
            SELECT produto.*
              FROM "produto"
              JOIN "produtoTipo"
                ON "produto"."idTipo" = "produtoTipo".id
          ORDER BY tipo,
                   nome
        ';
        $resultSet = $bd->consulta( $sql );
        $resultado = array();
        $i = 0;
        $totalResultados = count($resultSet);
        for( $j=0; $j<$totalResultados; $j++ ){
            $objeto = new Produto;
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
              FROM "produto"
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

//GETTERS E SETTERS
    public function getId(){
        return $this->id;
    }
    public function setId($id){
        $this->id = $id;
    }
    public function getIdTipo()
    {
        return $this->idTipo;
    }
    public function setIdTipo($idTipo)
    {
        $this->idTipo = $idTipo;
    }
    public function getNome()
    {
        return $this->nome;
    }
    public function setNome($nome)
    {
        $this->nome = $nome;
    }
    public function getValor()
    {
        return preco($this->valor);
    }
    public function setValor($valor)
    {
        $this->valor = decimalToBase($valor);
    }
}
