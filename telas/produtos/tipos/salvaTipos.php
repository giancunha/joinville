<?php
include('../../../config/includes.php');
$usuario = unserialize($_SESSION['usuario-adm-'.SESSAOADM]);
if($_POST['vencimento'] == ''
    or $_POST['tipoPagamento'] == ''
    or $_POST['idServico'] == ''
    or $_POST['descricao'] == ''
    or $_POST['valor'] == ''
    or $_POST['lancamentos'] == ''
    or ($_POST['lancamentos'] > 1 and $_POST['periodicidade'] == '')
    or ($_POST['tipoPagamento'] == 'V' and $_POST['lancamentos'] == '')
){
    echo "Campo(s) obrigatório(s):";
    if ($_POST['vencimento'] == ''){
        echo "<br> - Data vencimento";
    }
    if ($_POST['tipoPagamento'] == ''){
        echo "<br> - Tipo de Pagamento";
    }
    if ($_POST['idServico'] == ''){
        echo "<br> - Serviço";
    }
    if ($_POST['descricao'] == ''){
        echo "<br> - Descrição";
    }
    if ($_POST['valor'] == ''){
        echo "<br> - Valor";
    }
    if ($_POST['tipoPagamento'] == 'V' and $_POST['lancamentos'] == ''){
        echo "<br> - Quantidade de Lançamentos";
    }
    if ($_POST['lancamentos'] > 1 and $_POST['periodicidade'] == ''){
        echo "<br> - Periodicidade";
    }
    exit();
}
$idServico = $_POST['idServico'];
$idUsuario = $usuario->getIdUsuario();
$tipo = $_POST['tipoPagamento'];
$vencimento = $_POST['vencimento'];
$valor = $_POST['valor'];
$valor = $valor > 0 ? baseToDecimal(decimalToBase($valor) * -1) : $valor;
$descricao = $_POST['descricao'];
$lancamentos = $_POST['lancamentos'];
$periodicidade = $_POST['periodicidade'];
$idControle = NULL;
for ($i = $lancamentos; $i > 0; $i--) {
    $produtoTipo = new ProdutoTipo;
    $produtoTipo->setIdServico( $idServico );
    $produtoTipo->setIdControle( $idControle );
    $produtoTipo->setIdUsuario( $idUsuario );
    $produtoTipo->setTipo( $tipo );
    $produtoTipo->setVencimento( $vencimento );
    $produtoTipo->setImposto( $valor );
    $produtoTipo->setDescricao( $descricao );
    $idProdutoTipo = $produtoTipo->insere();
    if(empty($idControle)){
        $idControle = $idProdutoTipo;
        $produtoTipo->setIdControle( $idControle );
        $produtoTipo->atualizaIdControle();
    }
    $vencimento = date('d/m/Y', strtotime(dataToBase($vencimento) . '+' . $periodicidade));
}
echo 1;
