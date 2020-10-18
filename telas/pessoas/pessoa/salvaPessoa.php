<?php
include('../../../config/includes.php');
$usuario = unserialize($_SESSION['usuario-adm-'.SESSAOADM]);
if($_POST['nome'] == ''){
    echo "Campo(s) obrigatório(s):";
    if ($_POST['nome'] == ''){
        echo "<br /> - Nome";
    }
    exit();
}
//Dados Gerais
$nome = $_POST['nome'];
$dataNascimento = $_POST['dataNascimento'];
$sexo = $_POST['sexo'];
$email = $_POST['email'];
$telefoneCelular = $_POST['telefoneCelular'];
//Outros
$observacoes = $_POST['observacoes'];
$pessoa = new Pessoa;
//Chaves estrangeiras
//Dados Gerais
$pessoa->setNome( $nome );
$pessoa->setDataNascimento( $dataNascimento );
$pessoa->setSexo( $sexo );
$pessoa->setEmail( $email );
$pessoa->setTelefoneCelular( $telefoneCelular );
//Outros
$pessoa->setObservacoes( $observacoes );
if($pessoa->selecionaEmail() and (!empty($pessoa->getEmail()))){
    echo "E-mail " . $pessoa->getEmail() . " já cadastrado em pessoas!";
} else {
    $insere = $pessoa->insere();
    if( $insere > 0 ){
        $idPessoa = $insere;
        echo '1';
    } else {
        printR($pessoa);
        printR($_POST);
    }
}
