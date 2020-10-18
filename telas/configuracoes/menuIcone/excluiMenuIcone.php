<?php
include('../../../config/includes.php');
$idIcone = $_POST['id'];
$icone = new MenuIcone();
$icone->setIdMenuIcone( $idIcone );
$icone->seleciona();
if($icone->exclui()){
    echo '1';
}
