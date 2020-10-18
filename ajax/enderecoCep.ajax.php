<?php
header( 'Cache-Control: no-cache' );
header( 'Content-type: application/json; charset="utf-8"', true );
include_once("../config/includes.php");
$cep = $_REQUEST['cep'];
if(strlen($cep) == 9)
{
    $class = new Jarouche\ViaCEP\BuscaViaCEPJSON();
    $result = $class->retornaCEP($cep);
    $retorno = $class->retornaConteudoRequisicao();

} else {
    $retorno = json_encode(
        array(
            'logradouro' => 'CEP INVÁLIDO!'
        )
    );
}
echo $retorno;
