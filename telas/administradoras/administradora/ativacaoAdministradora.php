<?php
include('../../../config/includes.php');
$id = $_POST['id'];
$ativo = ($_POST['ativo'] == '1') ? '0' : '1';
$administradora = new Administradora();
$administradora->setId( $id );
$administradora->setAtivo( $ativo );
if($administradora->ativacao()){
    echo '1';
}
