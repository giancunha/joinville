<?php
include('../../../config/includes.php');
$idPerfil = $_POST['id'];
$perfil = new Perfil();
$perfil->setIdPerfil( $idPerfil );
$perfil->seleciona();
if($perfil->exclui()){
    echo '1';
}
