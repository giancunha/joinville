<?php
header( 'Cache-Control: no-cache' );
header( 'Content-type: application/json; charset="utf-8"', true );
include_once("../config/includes.php");
$idPais = $_REQUEST['idPais'];
$resultado = Estado::listaPorPais( $idPais );
foreach($resultado as $chave => $valor){
    $estados[] = array(
        'idEstado' => $valor->getIdEstado(),
        'estado' => $valor->getEstado(),
        'uf' => $valor->getUf()
    );
}
echo( json_encode( $estados ) );
