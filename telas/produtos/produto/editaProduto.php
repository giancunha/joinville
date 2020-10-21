<?php
include_once("../../../config/includes.php");
$idProduto = $_REQUEST['idProduto'];
$resultado = new Produto();
$resultado->setId( $idProduto );
$resultado->seleciona();
$produto = [
    'id'=> $resultado->getId(),
    'idTipo' => $resultado->getIdTipo(),
    'nome' => $resultado->getNome(),
    'valor' => $resultado->getValor(),
];
echo json_encode( $produto );
