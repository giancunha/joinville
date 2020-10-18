<?php
include('../../../config/includes.php');
$usuario = unserialize($_SESSION['usuario-adm-'.SESSAOADM]);
if(
    $_POST['nomeFantasia'] == ''
    or $_POST['idCidade'] == ''
    or ($_POST['cnpj'] != '' and !validaDocumento($_POST['cnpj']))
    or $_POST['razaoSocial'] == ''
){
    echo "Campo(s) obrigatório(s):";
    if ($_POST['nomeFantasia'] == ''){
        echo "<br /> - NomeFantasia";
    }
    if ($_POST['cnpj'] != '' and !validaDocumento($_POST['cnpj'])){
        echo "<br /> - CNPJ Inválido";
    }
    if ($_POST['razaoSocial'] == ''){
        echo "<br /> - Razão Social";
    }
    if ($_POST['idCidade'] == ''){
        echo "<br /> - Cidade";
    }
    exit();
}
$id = $_POST['id'];
//Chaves estrangeiras
$idPais = $idEstado = $idCidade = $cnpj = NULL;
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
$nomeFantasia = $_POST['nomeFantasia'];
$dataFundacao = $_POST['dataFundacao'];
if($_POST['cnpj'] > 1){
    $cnpj = $_POST['cnpj'];
}
$telefone = $_POST['telefone'];
$razaoSocial = $_POST['razaoSocial'];
//Endereço
$cep = $_POST['cep'];
$endereco = $_POST['endereco'];
$numero = $_POST['numero'];
$complemento = $_POST['complemento'];
$bairro = $_POST['bairro'];
//Outros
$observacoes = $_POST['observacoes'];

$administradora = new Administradora;
$administradora->setId( $id );
//Chaves estrangeiras
$administradora->setIdPais( $idPais );
$administradora->setIdEstado( $idEstado );
$administradora->setIdCidade( $idCidade );
//Dados Gerais
$administradora->setNomeFantasia( $nomeFantasia );
$administradora->setDataFundacao( $dataFundacao );
$administradora->setCnpj( $cnpj );
$administradora->setTelefone( $telefone );
$administradora->setRazaoSocial( $razaoSocial );
//Endereço
$administradora->setCep( $cep );
$administradora->setEndereco( $endereco );
$administradora->setNumero( $numero );
$administradora->setComplemento( $complemento );
$administradora->setBairro( $bairro);
//Outros
$administradora->setObservacoes( $observacoes );

if($administradora->selecionaCnpj() and $cnpj != NULL){
    echo "CNPJ " . $administradora->getCnpj() . " já cadastrado em administradoras!";
} else {
    $altera = $administradora->altera();
    if( $altera > 0 ){
        echo '1';
    } else {
        printR($administradora);
    }
}
