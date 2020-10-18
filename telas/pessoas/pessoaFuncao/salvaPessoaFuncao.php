<?php
include('../../../config/includes.php');
if($_POST['nome'] == ''){
    echo "Campo obrigatório:";
    if ($_POST['nome'] == ''){
        echo "<br /> - Nome";
    }
    exit();
}
$nome = $_POST['nome'];
$pessoaFuncao = new PessoaFuncao;
$pessoaFuncao->setNome( $nome );
$insere = $pessoaFuncao->insere();
if( $insere > 0 ){
    echo '1';
}
