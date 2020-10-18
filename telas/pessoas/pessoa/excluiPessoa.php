<?php
include('../../../config/includes.php');
$idPessoa = $_POST['id'];
$pessoa = new Pessoa();
$pessoa->setIdPessoa( $idPessoa );
$pessoa->seleciona();
if($pessoa->exclui()){
    echo '1';
}
