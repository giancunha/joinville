<?php
include('../../../config/includes.php');
$idUsuario = $_POST['id'];
$ativo = ($_POST['ativo'] == 1) ? '0' : '1';
$usuario = new Usuario();
$usuario->setIdUsuario( $idUsuario );
$usuario->setAtivo( $ativo );
if($usuario->ativacao()){
    echo '1';
}
