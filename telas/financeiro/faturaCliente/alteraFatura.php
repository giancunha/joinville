<?php
include('../../../config/includes.php');
$usuario = unserialize($_SESSION['usuario-adm-'.SESSAOADM]);
if($_POST['vencimento'] == ''){
    echo "<script type='text/javascript'>
        alert('O(s) seguinte(s) campos obrigatórios não foram preenchidos:";
    if ($_POST['vencimento'] == ''){
        echo "\\n - Data vencimento";
    }
    echo "');
        history.go(-1);
     </script>";
    exit();
}

$idFatura = $_POST['idFatura'];
$vencimento = $_POST['vencimento'];
$vencimentoAntigo = $_POST['vencimentoAntigo'];
$idUsuario = $usuario->getIdUsuario();

if($vencimento != $vencimentoAntigo){
    $fatura = new Fatura;
    $fatura->setId( $idFatura );
    $fatura->setVencimento( $vencimento );
    $fatura->setIdUsuario( $idUsuario );
    $fatura->alteraVencimento();
}

$faturaItem = new FaturaItem();
$resultado = $faturaItem->listaItens( $idFatura );
foreach($resultado as $chave => $valor2){
    $idServico = $_POST['idServico'.$valor2->getId()];
    $descricao = $_POST['descricao'.$valor2->getId()];
    $valor = $_POST['valor'.$valor2->getId()];

    $faturaItem = new FaturaItem;
    $faturaItem->setId( $valor2->getId() );
    $faturaItem->setIdUsuario( $idUsuario );
    $faturaItem->setIdServico( $idServico );
    $faturaItem->setDescricao( $descricao );
    $faturaItem->setValor( $valor );

    $faturaItem->altera();
}
echo exibeAlerta("Alteração efetuada com sucesso!", "/adm/financeiro/faturaCliente");
