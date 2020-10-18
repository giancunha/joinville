<?php
include_once("../../../config/includes.php");
$dataInicial = $dataFinal = NULL;
if(isset($_REQUEST['dataInicial'])){
    $dataInicial = $_REQUEST['dataInicial'];
} else {
    $dataInicial = date("01/m/Y");
}
if(isset($_REQUEST['dataFinal'])){
    $dataFinal = $_REQUEST['dataFinal'];
} else {
    $ultimoDia = date("t", mktime(0, 0, 0, date('m'), '01', date('Y')));
    $dataFinal = date($ultimoDia . "/m/Y");
}
$resultado = new Previsao();
$resultado = $resultado->listaVariaveis( $dataInicial, $dataFinal );
$listados = $totalFaturas = 0;
$previsoesVariaveis = $previsoesFixas = array();
foreach($resultado as $chave => $valor){
    $totalFaturas+= decimalToBase($valor->getValor());
    $listados++;
    $servico = new Servico();
    $servico->setIdServico( $valor->getIdServico() );
    $servico->seleciona();
    $previsoesVariaveis[] = array(
        'id' => $valor->getId(),
        'idControle' => $valor->getIdControle(),
        'vencimento' => $valor->getVencimento(),
        'faltam' => diasVencimento($valor->getVencimento()),
        'categoria' => $servico->getNome(),
        'descricao' => $valor->getDescricao(),
        'valor' => $valor->getValor(),
    );
}
$dados["previsoesVariaveis"] = $previsoesVariaveis;
$dados["tFootVariaveis"] = exibeId($listados, 3) . ' lançamentos totalizando R$ ' . preco($totalFaturas);
$resultado = new Previsao();
$resultado = $resultado->listaFixas( $dataInicial, $dataFinal );
$listados = $totalFaturas = 0;
foreach($resultado as $chave => $valor){
    $totalFaturas+= decimalToBase($valor->getValor());
    $listados++;
    $servico = new Servico();
    $servico->setIdServico( $valor->getIdServico() );
    $servico->seleciona();
    $previsoesFixas[] = array(
        'id' => $valor->getId(),
        'idControle' => $valor->getIdControle(),
        'vencimento' => exibeId(explode('/', $valor->getVencimento())[0], 2),
        'categoria' => $servico->getNome(),
        'descricao' => $valor->getDescricao(),
        'valor' => $valor->getValor(),
    );
}
$dados["previsoesFixas"] = $previsoesFixas;
$dados["tFootFixas"] = exibeId($listados, 3) . ' lançamentos  totalizando R$ ' . preco($totalFaturas);
$dados["secaoPai"] = $gets[1];
$dados["secaoFilho"] = $gets[2];
echo json_encode($dados);
