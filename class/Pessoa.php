<?php
class Pessoa{
//Atributos
    //Chaves estrangeiras
    private $idPessoa = null;
    //Dados Gerais
    private $nome = null;
    private $dataNascimento = null;
    private $sexo = null;
    private $email = null;
    private $telefoneCelular = null;
    //Outros
    private $observacoes = null;
    private $ativo;
    private $senha = null;
    private $ultimoLogin;
    //Realaçõe N-N
    private $idClientePessoa = NULL;
    private $idPessoaFuncao = NULL;
    private $funcao = NULL;
// construtor vazio
    public function __construct(){}

//MÉTODOS
    public function altera(){
        $sql = "
            UPDATE Pessoa
               SET nome = ?,
                   dataNascimento = ?,
                   sexo = ?,
                   email = ?,
                   telefoneCelular = ?,
                   observacoes = ?
             WHERE idPessoa = ?
        ";
        $bd = new BdSQL;
        $dados = array(
            array(
                '1' => $this->nome,
                '2' => $this->dataNascimento,
                '3' => $this->sexo,
                '4' => $this->email,
                '5' => $this->telefoneCelular,
                '6' => $this->observacoes,
                '7' => $this->idPessoa
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
            UPDATE Pessoa
               SET ativo = ?
             WHERE idPessoa = ?
        ";
        $bd = new BdSQL;
        $dados = array(
            array(
                '1' => $this->ativo,
                '2' => $this->idPessoa
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
        $sql = "DELETE FROM Pessoa WHERE idPessoa = ?";
        $bd = new BdSQL;
        $dados = array(
            array('1'=>$this->idPessoa)
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
            INSERT INTO Pessoa (
                   nome,
                   dataNascimento,
                   sexo,
                   email,
                   telefoneCelular,
                   observacoes
            ) VALUES (
                   ?,?,?,?,?,
                   ?
            )
        ";
        $bd = new BdSQL;
        $dados = array(
            array(
                '1' => $this->nome,
                '2' => $this->dataNascimento,
                '3' => $this->sexo,
                '4' => $this->email,
                '5' => $this->telefoneCelular,
                '6' => $this->observacoes
            )
        );
        $result = $bd->insereRetornaId($sql, $dados);
        if($result > 0){
            return $result;
        }else{
            return false;
        }
    }

    public static function listaAniversarios( $mes = NULL, $ordem = NULL ){
        if($mes){
            $mes = "AND MONTH(dataNascimento) = $mes";
        } else {
            $mesAtual = date('m');
            $mes = "AND MONTH(dataNascimento) != $mesAtual";
            if($ordem){
                $mes .= "
				AND MONTH(dataNascimento) $ordem $mesAtual";
            }
        }
        $bd = new BdSQL;
        $sql = "SELECT pac.dataNascimento, pac.nome, pac.telefoneCelular, pac.email, pac.idPessoa
 		  		  FROM Pessoa AS pac
 		  		 WHERE ativo = 1
		   		  $mes
	  		  ORDER BY MONTH(dataNascimento), DAY(dataNascimento)
		";
        $resultSet = $bd->consulta( $sql );
        $resultado = array();
        $i = 0;
        $totalResultados = count($resultSet);
        for( $j=0; $j<$totalResultados; $j++ ){
            $objeto = new Pessoa;
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

    public static function listaAniversariosSemana(  ){
        $hoje = date('Y-m-d');
        $diaLimite = date('Y-m-d', strtotime($hoje . ' + 2 days'));
        $bd = new BdSQL;
        $sql = "SELECT pac.dataNascimento, pac.nome, pac.telefoneCelular, pac.email, pac.idPessoa
 		  		  FROM Pessoa AS pac
 		  		 WHERE DATE_FORMAT(dataNascimento, '%m-%d')
 		  	   BETWEEN DATE_FORMAT(CURRENT_DATE(), '%m-%d')
 		  	       AND DATE_FORMAT('$diaLimite', '%m-%d')
 		  	  ORDER BY MONTH(dataNascimento),
 		  	           DAY(dataNascimento),
 		  	           YEAR(dataNascimento) ASC,
 		  	           pac.nome
		";
        $resultSet = $bd->consulta( $sql );
        $resultado = array();
        $i = 0;
        $totalResultados = count($resultSet);
        for( $j=0; $j<$totalResultados; $j++ ){
            $objeto = new Pessoa;
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

    public static function listaCliente( $idCliente ){
        $bd = new BdSQL;
        $sql = "
			SELECT pes.*,
			       cliPes.id AS idClientePessoa,
			       pesFun.nome AS funcao,
			       pesFun.id AS idPessoaFuncao
			  FROM Pessoa AS pes
			  JOIN ClientePessoa AS cliPes
			    ON pes.idPessoa = cliPes.idPessoa
			   AND cliPes.idCliente = '$idCliente'
			  JOIN PessoaFuncao AS pesFun
			    ON cliPes.idPessoaFuncao = pesFun.id
		  ORDER BY pes.nome ASC
		";
        $resultSet = $bd->consulta( $sql );
        $resultado = array();
        $i = 0;
        $totalResultados = count($resultSet);
        for( $j=0; $j<$totalResultados; $j++ ){
            $objeto = new Pessoa;
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

    public static function listaEnviaFatura( $idCliente ){
        $bd = new BdSQL;
        $sql = "
			SELECT pes.*
			  FROM Pessoa AS pes
			  JOIN ClientePessoa AS cliPes
			    ON pes.idPessoa = cliPes.idPessoa
			   AND cliPes.idCliente = '$idCliente'
			 WHERE cliPes.idPessoaFuncao IN (2,5,6)
		  GROUP BY pes.email
		";
        $resultSet = $bd->consulta( $sql );
        $resultado = array();
        $i = 0;
        $totalResultados = count($resultSet);
        for( $j=0; $j<$totalResultados; $j++ ){
            $objeto = new Pessoa;
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

    public static function listaEnvioParabens( ){
        $mes = date('m');
        $dia = date('d');
        $bd = new BdSQL;
        $sql = "SELECT pac.dataNascimento, pac.nome, pac.email
 		  		  FROM Pessoa AS pac
		 	     WHERE MONTH(dataNascimento) = '$mes'
		   		   AND DAY(dataNascimento) = '$dia'
		";
        $resultSet = $bd->consulta( $sql );
        $resultado = array();
        $i = 0;
        $totalResultados = count($resultSet);
        for( $j=0; $j<$totalResultados; $j++ ){
            $objeto = new Pessoa;
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

    public static function listaIdades( $ordem  = 'ASC'){
        $bd = new BdSQL;
        $sql = "
          SELECT DISTINCT(YEAR(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(dataNascimento)))) AS dataNascimento
            FROM Pessoa
           WHERE ativo = 1
             AND dataNascimento != '0000-00-00'
        ORDER BY dataNascimento $ordem
		";
        $resultSet = $bd->consulta( $sql );
        $resultado = array();
        $i = 0;
        $totalResultados = count($resultSet);
        for( $j=0; $j<$totalResultados; $j++ ){
            $objeto = new Pessoa;
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
            SELECT pac.*
              FROM Pessoa AS pac
             WHERE ativo = '1'
          ORDER BY pac.nome
        ";
        $resultSet = $bd->consulta( $sql );
        $resultado = array();
        $i = 0;
        $totalResultados = count($resultSet);
        for( $j=0; $j<$totalResultados; $j++ ){
            $objeto = new Pessoa;
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

    public static function listaSmsSmtp( $idadeMinima = NULL, $idadeMaxima = NULL, $idConvenio = NULL, $profissao = NULL, $sexo = NULL, $idSmsSmtp = NULL){
        if($idadeMinima){
            $idadeMinima = "AND YEAR(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(dataNascimento))) >= '$idadeMinima'";
        }
        if($idadeMaxima){
            $idadeMaxima= "AND YEAR(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(dataNascimento))) <= '$idadeMaxima'";
        }
        if($idConvenio){
            $idConvenio = "AND (paci.idConvenioPrincipal = '$idConvenio'
							OR paci.idConvenioSecundario = '$idConvenio')";
        }
        if($profissao){
            $profissao = "AND paci.profissao = '$profissao'";
        }
        if($sexo){
            $sexo = "AND paci.sexo = '$sexo'";
        }
        if($idSmsSmtp){
            $idSmsSmtp = "AND NOT EXISTS (SELECT 1 FROM SmsSmtpEnvio AS smsSmtEnv WHERE paci.idPessoa = smsSmtEnv.idPessoa AND smsSmtEnv.idSmsSmtp = '$idSmsSmtp')";
        }
        $bd = new BdSQL;
        $sql = "
			SELECT paci.idPessoa,
			       paci.telefoneCelular,
			       paci.email,
			       paci.nome,
			       paci.dataNascimento,
			       paci.profissao,
			       conv.nome AS idConvenioPrincipal
			  FROM Pessoa AS paci,
			  	   Convenio AS conv
			 WHERE paci.idConvenioPrincipal = conv.idConvenio
			   $idadeMinima
			   $idadeMaxima
			   $idConvenio
			   $profissao
			   $sexo
			   $idSmsSmtp 
		  ORDER BY paci.nome
		";
        $resultSet = $bd->consulta( $sql );
        $resultado = array();
        $i = 0;
        $totalResultados = count($resultSet);
        for( $j=0; $j<$totalResultados; $j++ ){
            $objeto = new Pessoa;
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
              FROM Pessoa
             WHERE idPessoa = '$this->idPessoa'
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
              FROM Pessoa
             WHERE email = '$this->email'
               AND idPessoa != '$this->idPessoa'
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

    public static function listaAjax(){
        $bd = new BdSQL;
        $sql = "
            SELECT idPessoa,
                   nome,
                   telefoneCelular,
                   email,
                   ativo
              FROM Pessoa
          ORDER BY nome
        ";
        $resultSet = $bd->consulta( $sql );
        $resultado = array();
        $i = 0;
        $totalResultados = count($resultSet);
        for( $j=0; $j<$totalResultados; $j++ ){
            $objeto = new Pessoa;
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

    public static function listaAjaxSelect($search){
        $bd = new BdSQL;
        $sql = "
            SELECT idPessoa,
                   nome,
                   email,
                   telefoneCelular
              FROM Pessoa
             WHERE ativo = 1
               AND (nome LIKE '%$search%'
                OR email LIKE '%$search%'
                OR telefoneCelular LIKE '%$search%')
          ORDER BY nome
        ";
        $resultSet = $bd->consulta( $sql );
        $resultado = array();
        $i = 0;
        $totalResultados = count($resultSet);
        for( $j=0; $j<$totalResultados; $j++ ){
            foreach($resultSet[$j] as $chave=>$valor){
                if(!is_int($chave)){
                    $resultado[$i][$chave] = $valor;
                }
            }
            $i++;
        }
        return $resultado;
    }

//GETTERS E SETTERS
    public function getIdPessoa(){
        return $this->idPessoa;
    }
    public function setIdPessoa($idPessoa){
        $this->idPessoa = $idPessoa;
    }
    public function getNome(){
        return corrigeCodificacao($this->nome);
    }
    public function setNome($nome){
        $this->nome = $nome;
    }
    public function getDataNascimento(){
        return baseToData($this->dataNascimento);
    }
    public function setDataNascimento($dataNascimento){
        $this->dataNascimento = dataToBase($dataNascimento);
    }
    public function getSexo(){
        return $this->sexo;
    }
    public function setSexo($sexo){
        $this->sexo = $sexo;
    }
    public function getEmail(){
        return $this->email;
    }
    public function setEmail($email){
        if(empty($email)){
            $email = null;
        }
        $this->email = $email;
    }
    public function getTelefoneCelular(){
        return $this->telefoneCelular;
    }
    public function setTelefoneCelular($telefoneCelular){
        if(empty($telefoneCelular)){
            $telefoneCelular = null;
        }
        $this->telefoneCelular = $telefoneCelular;
    }
    public function getObservacoes(){
        return corrigeCodificacao($this->observacoes);
    }
    public function setObservacoes($observacoes){
        if(empty($observacoes)){
            $observacoes = null;
        }
        $this->observacoes = $observacoes;
    }
    public function getAtivo(){
        return $this->ativo;
    }
    public function setAtivo($ativo){
        $this->ativo = $ativo;
    }
    public function getSenha(){
        return $this->senha;
    }
    public function setSenha($senha){
        $this->senha = $senha;
    }
    public function getUltimoLogin(){
        return $this->ultimoLogin;
    }
    public function setUltimoLogin($ultimoLogin){
        $this->ultimoLogin = $ultimoLogin;
    }
    //Realaçõe N-N
    public function getIdClientePessoa()
    {
        return $this->idClientePessoa;
    }
    public function setIdClientePessoa($idClientePessoa)
    {
        $this->idClientePessoa = $idClientePessoa;
    }
    public function getIdPessoaFuncao()
    {
        return $this->idPessoaFuncao;
    }
    public function setIdPessoaFuncao($idPessoaFuncao)
    {
        $this->idPessoaFuncao = $idPessoaFuncao;
    }
    public function getFuncao()
    {
        return $this->funcao;
    }
    public function setFuncao($funcao)
    {
        $this->funcao = $funcao;
    }
}
