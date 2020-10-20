<?php
include('../../../config/includes.php');
if(
    $_POST['tipo'] == ''
    or $_POST['imposto'] == ''
){
    echo "Campo(s) obrigatório(s):";
    if ($_POST['tipo'] == ''){
        echo "<br> - Nome Tipo";
    }
    if ($_POST['imposto'] == ''){
        echo "<br> - Imposto";
    }
    exit();
}
$tipo = $_POST['tipo'];
$imposto = $_POST['imposto'];
$produtoTipo = new ProdutoTipo;
$produtoTipo->setTipo( $tipo );
$produtoTipo->setImposto( $imposto );
if($produtoTipo->selecionaTipo()){
    echo "Tipo $tipo já cadastrado!";
    exit;
}
$insere = $produtoTipo->insere();
if($insere > 0) {
    echo 1;
} else {
    printR($insere);
}
