<?php
include('../../../config/includes.php');
$usuario = unserialize($_SESSION['usuario-adm-'.SESSAOADM]);
if(
    $_POST['nomeFantasia'] == ''
    or $_POST['idAdministradora'] == ''
    or $_POST['idCidade'] == ''
    or ($_POST['cnpjCpf'] != '' and !validaDocumento($_POST['cnpjCpf']))
    or $_POST['razaoSocial'] == ''
){
    echo "Campo(s) obrigatório(s):";
    if ($_POST['idAdministradora'] == ''){
        echo "<br /> - Administradora";
    }
    if ($_POST['nomeFantasia'] == ''){
        echo "<br /> - Nome Fantasia";
    }
    if ($_POST['cnpjCpf'] != '' and !validaDocumento($_POST['cnpjCpf'])){
        echo "<br /> - CnpjCpf Inválido";
    }
    if ($_POST['razaoSocial]'] == ''){
        echo "<br /> - Razão Social";
    }
    if ($_POST['idCidade'] == ''){
        echo "<br /> - Cidade";
    }
    exit();
}
//Chaves estrangeiras
$idPais = $idEstado = $idCidade = $cnpjCpf = NULL;
if($_POST['idPais'] > 0){
    $idPais = $_POST['idPais'];
}
if($_POST['idEstado'] > 0){
    $idEstado = $_POST['idEstado'];
}
if($_POST['idCidade'] > 0){
    $idCidade = $_POST['idCidade'];
}
//Dados Gerais
$idAdministradora = $_POST['idAdministradora'];
$latitude = $_POST['latitude'];
$longitude = $_POST['longitude'];
$nomeFantasia = $_POST['nomeFantasia'];
$dataFundacao = $_POST['dataFundacao'];
if($_POST['cnpjCpf'] != ''){
    $cnpjCpf = $_POST['cnpjCpf'];
}
$telefone = $_POST['telefone'];
$razaoSocial = $_POST['razaoSocial'];
$vencimentoFatura = $_POST['vencimentoFatura'];
//Endereço
$cep = $_POST['cep'];
$endereco = $_POST['endereco'];
$numero = $_POST['numero'];
$complemento = $_POST['complemento'];
$bairro = $_POST['bairro'];
//Outros
$enviaNota = $_POST['enviaNota'];
$observacoes = $_POST['observacoes'];

$cliente = new Cliente;
//Chaves estrangeiras
$cliente->setIdAdministradora( $idAdministradora );
$cliente->setIdPais( $idPais );
$cliente->setIdEstado( $idEstado );
$cliente->setIdCidade( $idCidade );
//Dados Gerais
$cliente->setLatitude( $latitude );
$cliente->setLongitude( $longitude );
$cliente->setNomeFantasia( $nomeFantasia );
$cliente->setDataFundacao( $dataFundacao );
$cliente->setCnpjCpf( $cnpjCpf );
$cliente->setTelefone( $telefone );
$cliente->setRazaoSocial( $razaoSocial );
$cliente->setVencimentoFatura( $vencimentoFatura );
//Endereço
$cliente->setCep( $cep );
$cliente->setEndereco( $endereco );
$cliente->setNumero( $numero );
$cliente->setComplemento( $complemento );
$cliente->setBairro( $bairro);
//Outros
$cliente->setEnviaNota( $enviaNota );
$cliente->setObservacoes( $observacoes );

if($cliente->selecionaCnpjCpf()){
    echo "Documento " . $cliente->getCnpjCpf() . " já cadastrado em clientes!";
} else {
    $insere = $cliente->insere();
    if( $insere > 0 ){
        $idCliente = $insere;
        $sql = null;
        foreach($_POST["idPessoaFuncao"] as $posicao => $idPessoaFuncao) {
            $idPessoa = $_POST["idPessoa"][$posicao];
            if($idPessoaFuncao > 0 and $idPessoa > 0){
                $sql .= "INSERT INTO ClientePessoa (idCliente, idPessoa, idPessoaFuncao) VALUES ($idCliente, $idPessoa, $idPessoaFuncao);" . PHP_EOL;
            }
        }
        if(!empty($sql)){
            $cliente->atualizaClientePessoa($sql);
        }
        echo '1';
    } else {
        printR($cliente);
        printR($_POST);
    }
}
