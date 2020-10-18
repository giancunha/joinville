<?php
include('../../../config/includes.php');
$idServico = $_POST['id'];
$servico = new Servico();
$servico->setIdServico( $idServico );
$servico->seleciona();
if($servico->exclui()){
    echo '1';
}
