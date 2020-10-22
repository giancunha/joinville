<?php
include_once("../../../config/includes.php");
$usuario = unserialize($_SESSION['usuario-adm-'.SESSAOADM]);
$idVendedor = $usuario->getIdUsuario();
$id_venda = $_REQUEST['id_venda'];
$venda = new Venda();
$venda->setId($id_venda);
if($venda->seleciona()){
    $venda->atualiza();
} else {
    $venda->setIdVendedor( $idVendedor );
    $id_venda = $venda->insere();
}
$id_produto = $_REQUEST['id_produto'];
$produto = new Produto();
$produto->setId( $id_produto );
$produto->seleciona();
$produtoTipo = new ProdutoTipo();
$produtoTipo->setId($produto->getIdTipo());
$produtoTipo->seleciona();
$vendaItem = new VendaItem();
$vendaItem->setId_venda( $id_venda );
$vendaItem->setId_produto( $id_produto );
$vendaItem->setQuantidade( $_REQUEST['quantidade'] );
$vendaItem->setValor( $produto->getValor() );
$vendaItem->setImposto( $produtoTipo->getImposto() );
$vendaItem->insere();
$dados["id_venda"] = $id_venda;
echo json_encode( $dados );
