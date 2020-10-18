<?php
header( 'Cache-Control: no-cache' );
header( 'Content-type: application/json; charset="utf-8"', true );
include_once("../config/includes.php");
$pessoas = array();
$resultado = Pessoa::listaAjax();
foreach($resultado as $chave => $valor){
    $pessoas[] = array(
        'idPessoa' => $valor->getIdPessoa(),
        'nome' => $valor->getNome(),
        'telefoneCelular' => $valor->getTelefoneCelular(),
        'email' => $valor->getEmail(),
        'ativo' => $valor->getAtivo()
    );
}
echo ( json_encode( $pessoas ));
