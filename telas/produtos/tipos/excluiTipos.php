<?php
include('../../../config/includes.php');
$idProdutoTipo = $_POST['id'];
$produtoTipo = new ProdutoTipo();
$produtoTipo->setId( $idProdutoTipo );
$produtoTipo->seleciona();
if($produtoTipo->exclui()){
    echo '1';
}
