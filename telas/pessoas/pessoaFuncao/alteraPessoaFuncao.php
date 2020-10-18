<?php
include('../../../config/includes.php');
if($_POST['nome'] == ''){
    echo "Campo obrigatório:";
    if ($_POST['nome'] == ''){
        echo "<br /> - Nome";
    }
    exit();
}
$id = $_POST['id'];
$nome = $_POST['nome'];
$pessoaFuncao = new PessoaFuncao;
$pessoaFuncao->setId( $id );
$pessoaFuncao->setNome( $nome );
$altera = $pessoaFuncao->altera();
if( $altera > 0 ){
    echo '1';
}
