<?php
header( 'Cache-Control: no-cache' );
header( 'Content-type: application/json; charset="utf-8"', true );
include_once("../config/includes.php");
$idEstado = $_REQUEST['idEstado'];
$cidades = array();
$resultado = Cidade::listaPorEstado( $idEstado );
foreach($resultado as $chave => $valor){
    $cidades[] = array(
        'idCidade' => $valor->getIdCidade(),
        'cidade' => $valor->getCidade(),
    );
}
echo( json_encode( $cidades ) );
