<?php
include('../../../config/includes.php');
if(
    $_POST['nome'] == ''
    or $_POST['valor'] == ''
    or $_POST['idTipo'] == ''
){
    echo "Campo(s) obrigatório(s):";
    if ($_POST['nome'] == ''){
        echo "<br> - Nome";
    }
    if ($_POST['valor'] == ''){
        echo "<br> - Valor";
    }
    if ($_POST['idTipo'] == ''){
        echo "<br> - Tipo";
    }
    exit();
}
$idProduto = $_POST['idProduto'];
$nome = $_POST['nome'];
$valor = $_POST['valor'];
$idTipo = $_POST['idTipo'];
$produto = new Produto;
$produto->setId( $idProduto );
$produto->setNome( $nome );
$produto->setValor( $valor );
$produto->setIdTipo( $idTipo );
$produto->altera();
echo 1;
