<?php
include('../../../config/includes.php');
$idPrevisao = $_POST['id'];
$previsao = new Previsao();
$previsao->setId( $idPrevisao );
$previsao->seleciona();
if($previsao->exclui()){
    echo '1';
}
