<?php
class Cliente{
//Atributos
    //Chaves estrangeiras
    private $id = null;
    private $idPais = null;
    private $idAdministradora = null;
    private $idEstado = null;
    private $idCidade = null;
    //Dados Gerais
    private $latitude = NULL;
    private $longitude = NULL;
    private $nomeFantasia = null;
    private $dataFundacao = null;
    private $cnpjCpf = null;
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
    private $enviaNota = 1;
    private $vencimentoFatura = 10;

// construtor vazio
    public function __construct(){}

//MÉTODOS
    public function altera(){
        $sql = "
            UPDATE Cliente
               SET idPais = ?,
                   idEstado = ?,
                   idCidade = ?,
                   nomeFantasia = ?,
                   dataFundacao = ?,
                   cnpjCpf = ?,
                   telefone = ?,
                   razaoSocial = ?,
                   cep = ?,
                   endereco = ?,
                   numero = ?,
                   complemento = ?,
                   bairro = ?,
                   observacoes = ?,
                   latitude = ?,
                   longitude = ?,
                   vencimentoFatura = ?,
                   idAdministradora = ?,
                   enviaNota = ?
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
                '6' => $this->cnpjCpf,
                '7' => $this->telefone,
                '8' => $this->razaoSocial,
                '9' => $this->cep,
                '10' => $this->endereco,
                '11' => $this->numero,
                '12' => $this->complemento,
                '13' => $this->bairro,
                '14' => $this->observacoes,
                '15' => $this->latitude,
                '16' => $this->longitude,
                '17' => $this->vencimentoFatura,
                '18' => $this->idAdministradora,
                '19' => $this->enviaNota,
                '20' => $this->id
            )
        );

        $result = $bd->altera($sql, $dados);
        if($result=='ok'){
            return true;
        }else{
            return false;
        }
    }

    public function atualizaClientePessoa( $stringSQL ){
        $bd = new BdSQL;
        try {
            $bd->consulta( $stringSQL );
            return true;
        }catch(Exception $e){
            return $e->getMessage();
        }
    }

    public function ativacao(){
        $sql = "
            UPDATE Cliente
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
        $sql = "
            INSERT INTO Cliente (
                   idPais,
                   idEstado,
                   idCidade,
                   nomeFantasia,
                   dataFundacao,
                   cnpjCpf,
                   telefone,
                   razaoSocial,
                   cep,
                   endereco,
                   numero,
                   complemento,
                   bairro,
                   observacoes,
                   latitude,
                   longitude,
                   vencimentoFatura,
                   idAdministradora,
                   enviaNota
            ) VALUES (
                   ?,?,?,?,?,
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
                '6' => $this->cnpjCpf,
                '7' => $this->telefone,
                '8' => $this->razaoSocial,
                '9' => $this->cep,
                '10' => $this->endereco,
                '11' => $this->numero,
                '12' => $this->complemento,
                '13' => $this->bairro,
                '14' => $this->observacoes,
                '15' => $this->latitude,
                '16' => $this->longitude,
                '17' => $this->vencimentoFatura,
                '18' => $this->idAdministradora,
                '19' => $this->enviaNota
            )
        );
        $result = $bd->insereRetornaId($sql, $dados);
        if($result > 0){
            return $result;
        }else{
            return false;
        }
    }

    public static function listaFaturasManutencao( ){
        $bd = new BdSQL;
        $sql = "
            SELECT cli.*,
                   (
                   SELECT COUNT(fatIte.id)
                     FROM Fatura AS fat,
                          FaturaItem AS fatIte
                    WHERE fat.id = fatIte.idFatura                    
                      AND fat.idCliente = cli.id
                      AND fat.status = 'A'
                      AND fatIte.idServico = '1'
                 GROUP BY fat.idCliente
                   ) AS observacoes,
                   fat.vencimento AS vencimentoFatura,
                   adm.nomeFantasia AS idAdministradora
              FROM Cliente AS cli
         LEFT JOIN Administradora AS adm ON cli.idAdministradora = adm.id
         LEFT JOIN Fatura AS fat ON cli.id = fat.idCliente
               AND fat.status = 'A'
          GROUP BY cli.id
          ORDER BY observacoes,
                   fat.vencimento ASC,
                   adm.nomeFantasia,
                   cli.nomeFantasia
		";
        $resultSet = $bd->consulta( $sql );
        $resultado = array();
        $i = 0;
        $totalResultados = count($resultSet);
        for( $j=0; $j<$totalResultados; $j++ ){
            $objeto = new Cliente;
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

    public static function listaPessoaClientes( $idPessoa ){
        $bd = new BdSQL;
        $sql = "
            SELECT cli.*,
                   adm.nomeFantasia AS idAdministradora,
			       pesFun.nome AS observacoes
			  FROM Cliente AS cli
         LEFT JOIN Administradora AS adm
                ON cli.idAdministradora = adm.id
			  JOIN ClientePessoa AS cliPes
			    ON cli.id = cliPes.idCliente
			   AND cliPes.idPessoa = '$idPessoa'
			  JOIN PessoaFuncao AS pesFun
			    ON cliPes.idPessoaFuncao = pesFun.id
		  ORDER BY cli.ativo DESC,
                   adm.nomeFantasia,
                   cli.nomeFantasia
		";
        $resultSet = $bd->consulta( $sql );
        $resultado = array();
        $i = 0;
        $totalResultados = count($resultSet);
        for( $j=0; $j<$totalResultados; $j++ ){
            $objeto = new Cliente;
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

    public static function listaPrincipal( ){
        $bd = new BdSQL;
        $sql = "
            SELECT cli.*,
                   adm.nomeFantasia AS idAdministradora
              FROM Cliente AS cli
         LEFT JOIN Administradora AS adm ON cli.idAdministradora = adm.id 
          ORDER BY cli.ativo DESC,
                   adm.nomeFantasia,
                   cli.nomeFantasia
		";
        $resultSet = $bd->consulta( $sql );
        $resultado = array();
        $i = 0;
        $totalResultados = count($resultSet);
        for( $j=0; $j<$totalResultados; $j++ ){
            $objeto = new Cliente;
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
              FROM Cliente
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

    public function selecionaCnpjCpf(){
        $bd = new BdSQL;
        $sql = "
            SELECT cnpjCpf
              FROM Cliente
             WHERE cnpjCpf = '$this->cnpjCpf'
               AND cnpjCpf IS NOT NULL
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
    public function getIdAdministradora(){
        return $this->idAdministradora;
    }
    public function setIdAdministradora($idAdministradora){
        $this->idAdministradora = $idAdministradora;
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
    public function getLatitude()
    {
        return $this->latitude;
    }
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }
    public function getLongitude()
    {
        return $this->longitude;
    }
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
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
    public function getCnpjCpf(){
        return mascaraDocumento($this->cnpjCpf);
    }
    public function setCnpjCpf($cnpjCpf){
        $this->cnpjCpf = soNumero($cnpjCpf);
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
    public function getEnviaNota()
    {
        return $this->enviaNota;
    }
    public function setEnviaNota($enviaNota)
    {
        $this->enviaNota = $enviaNota;
    }
    public function getVencimentoFatura()
    {
        return $this->vencimentoFatura;
    }
    public function setVencimentoFatura($vencimentoFatura)
    {
        $this->vencimentoFatura = $vencimentoFatura;
    }
}
