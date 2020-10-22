<?php
include_once("../../../config/includes.php");
$id_venda = $_REQUEST['id'];
$compras = $historico = array();
$vendaItem = new VendaItem();
$carrinho = $vendaItem->listaItens( $id_venda );
$listados = $totalCompra = $totalImposto = 0;
$produto = new Produto();
foreach ($carrinho as $chave => $item) {
    $listados++;
    $produto->setId( $item->getId_produto() );
    $produto->seleciona();
    $subTotal = decimalToBase($item->getValor()) * $item->getQuantidade();
    $totalCompra += $subTotal;
    $imposto = $subTotal * (decimalToBase($item->getImposto()) / 100);
    $totalImposto += $imposto;
    $compras[] = array(
        'id' => $item->getId(),
        'item' => exibeId($listados,3),
        'produto' => $produto->getNome(),
        'quantidade' => $item->getQuantidade(),
        'valor' => preco($item->getValor()),
        'subTotal' => preco($subTotal),
        'imposto' => preco($imposto, 3),
    );
}
$dados["compras"] = $compras;
$dados["totalCompra"] = preco($totalCompra);
$dados["totalImposto"] = preco($totalImposto);
$venda = new Venda();
$lista = $venda->listaPrincipal( $id_venda );
foreach ($lista as $chave => $compra) {
    $historico[] = array(
        'id' => $compra->getId(),
        'idCompra' => exibeId($compra->getId()),
        'dia' => $compra->getDia(),
        'hora' => $compra->getHora(),
        'status' => $compra->getStatus(),
        'vendedor' => $compra->getIdVendedor(),
        'valor' => preco($compra->getValor()),
    );
}
$dados["compras"] = $compras;
$dados["totalCompra"] = preco($totalCompra);
$dados["totalImposto"] = preco($totalImposto);
$dados["historico"] = $historico;

echo json_encode($dados);
