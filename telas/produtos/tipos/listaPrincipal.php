<?php
include_once("../../../config/includes.php");
$resultado = new ProdutoTipo();
$resultado = $resultado->listaPrincipal();
$listados = $totalFaturas = 0;
$produtos = $produtosFixas = array();
foreach($resultado as $chave => $valor){
    $listados++;
    $produtos[] = array(
        'id' => exibeId($valor->getId()),
        'tipo' => $valor->getTipo(),
        'imposto' => $valor->getImposto(),
    );
}
$dados["produtos"] = $produtos;
$dados["tFoot"] = exibeId($listados, 3) . ' lançamentos';
$dados["secaoPai"] = $gets[1];
$dados["secaoFilho"] = $gets[2];
echo json_encode($dados);
