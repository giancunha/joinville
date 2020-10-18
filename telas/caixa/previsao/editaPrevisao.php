<?php
include_once("../../../config/includes.php");
$idPrevisao = $_REQUEST['idPrevisao'];
$resultado = new Previsao();
$resultado->setId( $idPrevisao );
$resultado->seleciona();
$previsao = [
    'id'=> $resultado->getId(),
    'idServico' => $resultado->getIdServico(),
    'tipo' => $resultado->getTipo(),
    'vencimento' => $resultado->getVencimento(),
    'valor' => $resultado->getValor(),
    'descricao' => $resultado->getDescricao(),
];
echo json_encode( $previsao );
