<?php
include('../../../config/includes.php');
$idProdutoTipo = $_POST['id'];
$produtoTipo = new ProdutoTipo();
$produtoTipo->setId( $idProdutoTipo );
$produtoTipo->seleciona();
//todo Validar se tipo não está relacionado com produtos
if($produtoTipo->exclui()){
    echo '1';
}
