<?php
include_once("../../../config/includes.php");
$idProdutoTipo = $_REQUEST['idProdutoTipo'];
$resultado = new ProdutoTipo();
$resultado->setId( $idProdutoTipo );
$resultado->seleciona();
$produtoTipo = [
    'id'=> $resultado->getId(),
    'idServico' => $resultado->getIdServico(),
    'tipo' => $resultado->getTipo(),
    'vencimento' => $resultado->getVencimento(),
    'valor' => $resultado->getImposto(),
    'descricao' => $resultado->getDescricao(),
];
echo json_encode( $produtoTipo );
