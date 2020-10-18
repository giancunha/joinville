<?php
include('../../../config/includes.php');
$idClientePessoa = $_POST['idClientePessoa'];
$idCliente = $_POST['idCliente'];
$sql = "
    DELETE FROM ClientePessoa
     WHERE id = '$idClientePessoa'
";
$cliente = new Cliente();
if ($cliente->atualizaClientePessoa($sql)) {
    echo $idCliente;
}
