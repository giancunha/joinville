<?php
include('../../../config/includes.php');
$usuario = unserialize($_SESSION['usuario-adm-'.SESSAOADM]);
if($_POST['vencimento'] == ''
    or $_POST['tipoPagamento'] == ''
    or $_POST['idServico'] == ''
    or $_POST['descricao'] == ''
    or $_POST['valor'] == ''
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
    exit();
}
$idServico = $_POST['idServico'];
$idUsuario = $usuario->getIdUsuario();
$idPrevisao = $_POST['idPrevisao'];
$tipo = $_POST['tipoPagamento'];
$vencimento = $_POST['vencimento'];
$valor = $_POST['valor'] > 0 ? baseToDecimal(decimalToBase($_POST['valor']) * -1) : $_POST['valor'];
$descricao = $_POST['descricao'];
$previsao = new Previsao;
$previsao->setId( $idPrevisao );
$previsao->setIdServico( $idServico );
$previsao->setIdUsuario( $idUsuario );
$previsao->setTipo( $tipo );
$previsao->setVencimento( $vencimento );
$previsao->setValor( $valor );
$previsao->setDescricao( $descricao );
$idPrevisao = $previsao->altera();
echo 1;
