<?php
include('../../../config/includes.php');
$idProdutoTipo = $_POST['id'];
$produtoTipo = new ProdutoTipo();
$produtoTipo->setId( $idProdutoTipo );
$produtoTipo->seleciona();
if($produtoTipo->selecionaProduto()){
    echo "Impossível excluir tipo com produto vinculado";
    exit;
}
if($produtoTipo->exclui()){
    echo '1';
}
