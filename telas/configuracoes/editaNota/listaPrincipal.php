<?php
include_once("../../../config/includes.php");
$fatura = new Fatura();
$resultado = $fatura->listaNotasTrocadas();
$listados = 0;
$lancamentos = array();
foreach($resultado as $chave => $valor){
    $listados++;
    $lancamentos[] = array(
        'data' => timeStamptoData($valor->getIdBoleto(), 'datahora'),
        'responsavel' => $valor->getIdUsuario(),
        'id' => exibeId($valor->getId()),
        'cliente' => $valor->getIdCliente(),
        'servico' => $valor->getStatus(),
    );
}
$dados["listaLancamentos"] = $lancamentos;
$dados["tFootLancamentos"] = exibeId($listados, 3) . ' registros';
$dados["secaoPai"] = $gets[1];
$dados["secaoFilho"] = $gets[2];
echo json_encode($dados);
