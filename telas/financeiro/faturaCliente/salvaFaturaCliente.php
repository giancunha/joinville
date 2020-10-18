<?php
include('../../../config/includes.php');
$usuario = unserialize($_SESSION['usuario-adm-'.SESSAOADM]);
if($_POST['diaVencimento'] == ''
    or $_POST['mesVencimento'] == ''
    or $_POST['anoVencimento'] == ''
    or $_POST['idServico'] == ''
    or $_POST['descricao'] == ''
    or $_POST['valor'] == ''
    or $_POST['lancamentos'] == ''
    or $_POST['periodicidade'] == ''){
    echo "Campo(s) obrigat&oacute;rio(s):";
    if ($_POST['diaVencimento'] == '' or $_POST['mesVencimento'] == '' or $_POST['anoVencimento'] == ''){
        echo "<br> - Data vencimento";
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
    if ($_POST['lancamentos'] == ''){
        echo "<br> - Quantidade de Lançamentos";
    }
    if ($_POST['periodicidade'] == ''){
        echo "<br> - Periodicidade";
    }
    exit();
}

$idCliente = $_POST['idCliente'];
$diaVencimento = $_POST['diaVencimento'];
$mesVencimento = $_POST['mesVencimento'];
$anoVencimento = $_POST['anoVencimento'];
$idServico = $_POST['idServico'];
$descricao = $_POST['descricao'];
$valor = $_POST['valor'];
$lancamentos = $_POST['lancamentos'];
$periodicidade = $_POST['periodicidade'];
$idUsuario = $usuario->getIdUsuario();
$idControle = NULL;
for ($i = $lancamentos; $i > 0; $i--) {
    if($mesVencimento > 12){
        $anoVencimento++;
        $mesVencimento = $mesVencimento - 12;
    }
    $fatura = new Fatura;
    $fatura->setIdCliente( $idCliente );
    $fatura->setIdControle( $idControle );
    $fatura->setVencimento( $diaVencimento . '/' . $mesVencimento . '/' . $anoVencimento );
    $fatura->setIdUsuario( $idUsuario );
    $idFatura = $fatura->insere();
    if(empty($idControle)){
        $idControle = $idFatura;
        $fatura->setIdControle( $idControle );
        $fatura->atualizaIdControle();
    }
    $faturaItem = new FaturaItem;
    $faturaItem->setIdFatura( $idFatura );
    $faturaItem->setIdServico( $idServico );
    $faturaItem->setIdUsuario( $idUsuario );
    $faturaItem->setValor( $valor );
    $faturaItem->setDescricao( $descricao );

    $insere = $faturaItem->insere();
    $mesVencimento = $mesVencimento + $periodicidade;
}
if( $insere > 0 ){
    echo 1;
}
