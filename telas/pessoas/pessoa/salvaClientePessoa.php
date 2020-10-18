<?php
include('../../../config/includes.php');
if(
    $_POST['idPessoa'] == ''
    or $_POST['idPessoaFuncao'] == ''
){
    echo "Campo(s) obrigatório(s):";
    if ($_POST['idPessoaFuncao'] == ''){
        echo "<br /> - Função";
    }
    if ($_POST['idPessoa'] == ''){
        echo "<br /> - Pessoa";
    }
    exit();
}
$idClientePessoa = $_POST['idClientePessoa'];
$idCliente = $_POST['idCliente'];
$idPessoa = $_POST['idPessoa'];
$idPessoaFuncao = $_POST['idPessoaFuncao'];
$cliente = new Cliente();
$sql = "
    REPLACE INTO ClientePessoa (id, idCliente, idPessoa, idPessoaFuncao)
    VALUES ('$idClientePessoa', $idCliente, $idPessoa, $idPessoaFuncao);
";
if($cliente->atualizaClientePessoa($sql)){
    echo $idCliente;
}
