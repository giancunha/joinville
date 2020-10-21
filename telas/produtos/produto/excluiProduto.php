<?php
include('../../../config/includes.php');
$idProduto = $_POST['id'];
$produto = new Produto();
$produto->setId( $idProduto );
$produto->seleciona();
//todo Validar se nome não está relacionado com vendas
if($produto->exclui()){
    echo '1';
}
