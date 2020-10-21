<?php
include_once("../../../config/includes.php");
$resultado = new Produto();
$resultado = $resultado->listaPrincipal();
$listados = 0;
$produtos = array();
$produtoTipo = new ProdutoTipo();
foreach($resultado as $chave => $valor){
    $listados++;
    $produtoTipo->setId($valor->getIdTipo());
    $produtoTipo->seleciona();
    $imposto = decimalToBase($valor->getValor())*(decimalToBase($produtoTipo->getImposto())/100);
    $produtos[] = array(
        'id' => exibeId($valor->getId()),
        'tipo' => $produtoTipo->getTipo(),
        'nome' => $valor->getNome(),
        'valor' => $valor->getValor(),
        'imposto' => preco($imposto, 3),
    );
}
$dados["produtos"] = $produtos;
$dados["tFoot"] = exibeId($listados, 3) . ' lançamentos';
echo json_encode($dados);
