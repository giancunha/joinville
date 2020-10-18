<?php
include('../../../config/includes.php');
$id = $_POST['id'];
$ativo = ($_POST['ativo'] == '1') ? '0' : '1';
$cliente = new Cliente();
$cliente->setId( $id );
$cliente->setAtivo( $ativo );
if($cliente->ativacao()){
    echo '1';
}
