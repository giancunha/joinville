<?php
include('../../../config/includes.php');
$idProduto = $_POST['id'];
$produto = new Produto();
$produto->setId( $idProduto );
$produto->seleciona();
if($produto->selecionaVenda()){
    echo "Impossível excluir produto com venda efetuada";
    exit;
}
if($produto->exclui()){
    echo '1';
}
