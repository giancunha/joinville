<?php
include_once("../../../config/includes.php");
$idProdutoTipo = $_REQUEST['idProdutoTipo'];
$resultado = new ProdutoTipo();
$resultado->setId( $idProdutoTipo );
$resultado->seleciona();
$produtoTipo = [
    'id'=> $resultado->getId(),
    'tipo' => $resultado->getTipo(),
    'imposto' => $resultado->getImposto(),
];
echo json_encode( $produtoTipo );
