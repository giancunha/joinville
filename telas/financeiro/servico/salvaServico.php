<?php
include('../../../config/includes.php');
if($_POST['nome'] == '' or $_POST['natureza'] == ''){
    echo "Campo(s) obrigatório(s):";
    if ($_POST['nome'] == ''){
        echo "<br /> - Nome";
    }
    if ($_POST['natureza'] == ''){
        echo "<br /> - Natureza";
    }
    exit();
}
$nome = $_POST['nome'];
$natureza = $_POST['natureza'];
$descricao = $_POST['descricao'];
$servico = new Servico;
$servico->setNome( $nome );
$servico->setNatureza( $natureza );
$servico->setDescricao( $descricao );
$insere = $servico->insere();
if( $insere > 0 ){
    echo '1';
}
