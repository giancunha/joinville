<?php
include('../../../config/includes.php');
$id = $_POST['id'];
$vendaItem = new VendaItem();
$vendaItem->setId( $id );
if($vendaItem->exclui()){
    echo '1';
}
