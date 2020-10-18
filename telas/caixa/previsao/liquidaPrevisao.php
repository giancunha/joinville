<?php
include('../../../config/includes.php');
$usuario = unserialize($_SESSION['usuario-adm-'.SESSAOADM]);
$idPrevisao = $_POST['id'];
$idUsuario = $usuario->getIdUsuario();
$previsao = new Previsao;
$previsao->setId( $idPrevisao );
$previsao->seleciona();
$previsao->setIdUsuario( $idUsuario );
$valor = $previsao->getValor();
if($previsao->getTipo() != 'C') {
    $valor = $valor > 0 ? baseToDecimal(decimalToBase($valor) * -1) : $valor;
}
$caixa = new Caixa();
$caixa->setDia( $previsao->getVencimento() );
if($caixa->selecionaPorData()){
    $idCaixa = $caixa->getId();
} else {
    $idCaixa = $caixa->insere();
}
$caixa->setIdCaixa( $idCaixa );
$caixa->setIdServico( $previsao->getIdServico() );
$caixa->setIdUsuario( $idUsuario );
$caixa->setValor( $valor );
$caixa->setDescricao( $previsao->getDescricao() );
if( $caixa->inserePrevisao() > 0 ){
    if($previsao->getTipo() != 'F'){
        $previsao->exclui();
    }
    echo 1;
}else{
    echo "Erro ao liquidar!";
}
