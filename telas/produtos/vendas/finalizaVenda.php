<?php
include('../../../config/includes.php');
$id_venda = $_REQUEST['id_venda'];
$venda = new Venda();
$venda->setId( $id_venda );
if($venda->finaliza()) {
    echo 1;
} else {
    printR($venda);
}
