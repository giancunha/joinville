<?php
include('../../../config/includes.php');
$id = $_POST['id'];
$pessoaFuncao = new PessoaFuncao();
$pessoaFuncao->setId( $id );
$pessoaFuncao->seleciona();
if($pessoaFuncao->exclui()){
	echo '1';
}
?>
