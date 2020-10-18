<?php
include('../../../config/includes.php');
if($_POST['idFacebook'] == ''
    or $_POST['idMedico'] == ''
){
    echo "Campo(s) obrigat&oacute;rio(s):";
    if ($_POST['idFacebook'] == ''){
        echo "<br /> - Aprovação Facebook";
    }
    if ($_POST['idMedico'] == ''){
        echo "<br /> - Estar logado no sistema";
    }
    exit();
}
$idMedico = $_POST['idMedico'];
$idFacebook = $_POST['idFacebook'];
$usuario = new Usuario;
$usuario->setidUsuario( $idMedico );
$usuario->seleciona();
if($usuario->getIdFacebook() > 0){
    unlink(CAMINHOABSOLUTO . '/' . IMAGENSFACE . $usuario->getIdFacebook() . ".jpg");
    $usuario->setIdFacebook( NULL );
} else {
    $usuario->setIdFacebook( $idFacebook );
}
$insere = $usuario->insereIdFacebook();
if( $insere > 0 ){
    echo '1';
}
