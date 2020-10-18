<?php
include('../../../config/includes.php');
$usuario = unserialize($_SESSION['usuario-adm-'.SESSAOADM]);
if($_POST['pagamento'] == '' or $_POST['valor'] == ''){
    echo "<script type='text/javascript'>
        alert('O(s) seguinte(s) campos obrigatórios não foram preenchidos:";
    if ($_POST['pagamento'] == ''){
        echo "\\n - Data pagamento"; 
    }
    if ($_POST['valor'] == ''){
        echo "\\n - Valor"; 
    }
    echo "');
        history.go(-1);
     </script>";
    exit();
}
$idFatura = $_POST['idFatura'];
$pagamento = $_POST['pagamento'];
$valor = $_POST['valor'];
$valorCerto = $_POST['valorCerto'];
$idUsuario = $usuario->getIdUsuario();
$fatura = new Fatura;
$fatura->setId( $idFatura );
$fatura->setIdUsuario( $idUsuario );
$fatura->setPagamento( $pagamento );
if(decimalToBase($valorCerto) != decimalToBase($valor)){
    $diferenca =  decimalToBase($valor) - decimalToBase($valorCerto);
    $descricao = "Valor pago foi diferente do valor da fatura";
    $faturaItem = new FaturaItem;
    $faturaItem->setIdFatura( $idFatura );
    $faturaItem->setIdServico( 3 );
    $faturaItem->setIdUsuario( $idUsuario );
    $faturaItem->setValor( $diferenca );
    $faturaItem->setDescricao( $descricao );
    $insere = $faturaItem->insere();
}
if( $fatura->liquida() > 0 ){
    echo exibeAlerta("Fatura liquidada com sucesso!", "/adm/financeiro/faturaCliente");
}else{
    echo exibeAlerta("Erro ao liquidar!", "voltar");
}
