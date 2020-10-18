<?php
class Administradora{
//Atributos
    //Chaves estrangeiras
    private $id = null;
    private $idPais = null;
    private $idEstado = null;
    private $idCidade = null;
    //Dados Gerais
    private $nomeFantasia = null;
    private $dataFundacao = null;
    private $cnpj = null;
    private $telefone = null;
    private $razaoSocial = null;
    //Endereço
    private $cep = null;
    private $endereco = null;
    private $numero = null;
    private $complemento = null;
    private $bairro = null;
    //Outros
    private $observacoes = null;
    private $ativo;

// construtor vazio
    public function __construct(){}

//MÉTODOS
    public function altera(){
        $this->alteraDocumentoVazioParaNulo();
        $sql = "
            UPDATE Administradora
               SET idPais = ?,
                   idEstado = ?,
                   idCidade = ?,
                   nomeFantasia = ?,
                   dataFundacao = ?,
                   cnpj = ?,
                   telefone = ?,
                   razaoSocial = ?,
                   cep = ?,
                   endereco = ?,
                   numero = ?,
                   complemento = ?,
                   bairro = ?,
                   observacoes = ?
             WHERE id = ?
        ";
        $bd = new BdSQL;
        $dados = array(
            array(
                '1' => $this->idPais,
                '2' => $this->idEstado,
                '3' => $this->idCidade,
                '4' => $this->nomeFantasia,
                '5' => $this->dataFundacao,
                '6' => $this->cnpj,
                '7' => $this->telefone,
                '8' => $this->razaoSocial,
                '9' => $this->cep,
                '10' => $this->endereco,
                '11' => $this->numero,
                '12' => $this->complemento,
                '13' => $this->bairro,
                '14' => $this->observacoes,
                '15' => $this->id
            )
        );

        $result = $bd->altera($sql, $dados);
        if($result=='ok'){
            return true;
        }else{
            return false;
        }
    }

    private function alteraDocumentoVazioParaNulo(){
        $sql = "
          UPDATE Administradora
             SET cnpj = NULL
           WHERE cnpj = ?
        ";
        $bd = new BdSQL;
        $dados = array(
            array(
                '1' => 0
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
            UPDATE Administradora
               SET ativo = ?
             WHERE id = ?
        ";
        $bd = new BdSQL;
        $dados = array(
            array(
                '1' => $this->ativo,
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

    public function insere(){
        $this->alteraDocumentoVazioParaNulo();
        $sql = "
            INSERT INTO Administradora (
                   idPais,
                   idEstado,
                   idCidade,
                   nomeFantasia,
                   dataFundacao,
                   cnpj,
                   telefone,
                   razaoSocial,
                   cep,
                   endereco,
                   numero,
                   complemento,
                   bairro,
                   observacoes
            ) VALUES (
                   ?,?,?,?,?,
                   ?,?,?,?,?,
                   ?,?,?,?
            )
        ";
        $bd = new BdSQL;
        $dados = array(
            array(
                '1' => $this->idPais,
                '2' => $this->idEstado,
                '3' => $this->idCidade,
                '4' => $this->nomeFantasia,
                '5' => $this->dataFundacao,
                '6' => $this->cnpj,
                '7' => $this->telefone,
                '8' => $this->razaoSocial,
                '9' => $this->cep,
                '10' => $this->endereco,
                '11' => $this->numero,
                '12' => $this->complemento,
                '13' => $this->bairro,
                '14' => $this->observacoes
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
        $sql = "
            SELECT adm.*
              FROM Administradora AS adm
          ORDER BY adm.nomeFantasia
		";
        $resultSet = $bd->consulta( $sql );
        $resultado = array();
        $i = 0;
        $totalResultados = count($resultSet);
        for( $j=0; $j<$totalResultados; $j++ ){
            $objeto = new Administradora;
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
              FROM Administradora
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

    public function selecionaCnpj(){
        $bd = new BdSQL;
        $sql = "
            SELECT cnpj
              FROM Administradora
             WHERE cnpj = '$this->cnpj'
               AND id != '$this->id'
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
    public function getIdPais(){
        return $this->idPais;
    }
    public function setIdPais($idPais){
        $this->idPais = $idPais;
    }
    public function getIdEstado(){
        return $this->idEstado;
    }
    public function setIdEstado($idEstado){
        $this->idEstado = $idEstado;
    }
    public function getIdCidade(){
        return $this->idCidade;
    }
    public function setIdCidade($idCidade){
        $this->idCidade = $idCidade;
    }
    public function getNomeFantasia(){
        return corrigeCodificacao($this->nomeFantasia);
    }
    public function setNomeFantasia($nomeFantasia){
        $this->nomeFantasia = $nomeFantasia;
    }
    public function getDataFundacao(){
        return baseToData($this->dataFundacao);
    }
    public function setDataFundacao($dataFundacao){
        $this->dataFundacao = dataToBase($dataFundacao);
    }
    public function getCnpj(){
        return mascaraDocumento($this->cnpj);
    }
    public function setCnpj($cnpj){
        $this->cnpj = soNumero($cnpj);
    }
    public function getTelefone(){
        return mascaraTelefone($this->telefone);
    }
    public function setTelefone($telefone){
        $this->telefone = soNumero($telefone);
    }
    public function getRazaoSocial(){
        return corrigeCodificacao($this->razaoSocial);
    }
    public function setRazaoSocial($razaoSocial){
        $this->razaoSocial = $razaoSocial;
    }
    public function getCep(){
        return $this->cep;
    }
    public function setCep($cep){
        $this->cep = $cep;
    }
    public function getEndereco(){
        return corrigeCodificacao($this->endereco);
    }
    public function setEndereco($endereco){
        $this->endereco = $endereco;
    }
    public function getNumero(){
        return $this->numero;
    }
    public function setNumero($numero){
        $this->numero = $numero;
    }
    public function getComplemento(){
        return $this->complemento;
    }
    public function setComplemento($complemento){
        $this->complemento = $complemento;
    }
    public function getBairro(){
        return corrigeCodificacao($this->bairro);
    }
    public function setBairro($bairro){
        $this->bairro = $bairro;
    }
    public function getObservacoes(){
        return corrigeCodificacao($this->observacoes);
    }
    public function setObservacoes($observacoes){
        $this->observacoes = $observacoes;
    }
    public function getAtivo(){
        return $this->ativo;
    }
    public function setAtivo($ativo){
        $this->ativo = $ativo;
    }
}
