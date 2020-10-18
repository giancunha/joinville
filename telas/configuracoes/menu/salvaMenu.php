<?php
include('../../../config/includes.php');
if($_POST['idMenuPai'] == '' or $_POST['nome'] == '' or $_POST['secao'] == ''){
    echo "Campo(s) obrigat&oacute;rio(s):";
    if ($_POST['idMenu'] == ''){
        echo "<br /> - Menu Pai";
    }
    if ($_POST['nome'] == ''){
        echo "<br /> - Nome";
    }
    if ($_POST['secao'] == ''){
        echo "<br /> - Secao";
    }
    exit();
}
$idMenuPai = $_POST['idMenuPai'];
$ordem  = $_POST['ordem'];
$nome = $_POST['nome'];
$descricao = $_POST['descricao'];
$secao = $_POST['secao'];
$idIcone = $_POST['idIcone'];
$menu = new Menu;
$menu->setIdMenuPai( $idMenuPai );
$menu->setOrdem( $ordem );
$menu->setNome( $nome );
$menu->setDescricao( $descricao );
$menu->setSecao( $secao );
$menu->setIdIcone( $idIcone );
$insere = $menu->insere();
if( $insere > 0 ){
    echo '1';
}
