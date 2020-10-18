<?php
include('../../../config/includes.php');
if($_POST['nome'] == '' or $_POST['natureza'] == ''){
    echo "Campo(s) obrigat&oacute;rio(s):";
    if ($_POST['nome'] == ''){
        echo "<br /> - Nome";
    }
    if ($_POST['natureza'] == ''){
        echo "<br /> - Natureza";
    }
    exit();
}
$idServico = $_POST['idServico'];
$nome = $_POST['nome'];
$natureza = $_POST['natureza'];
$descricao = $_POST['descricao'];
$servico = new Servico;
$servico->setIdServico( $idServico );
$servico->setNome( $nome );
$servico->setNatureza( $natureza );
$servico->setDescricao( $descricao );
$altera = $servico->altera();
if( $altera > 0 ){
    echo '1';
}
