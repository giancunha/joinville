<?php
include('../../../config/includes.php');
if(
    $_POST['idFatura'] == ''
){
    echo "Campo(s) obrigatório(s):";
    if ($_POST['idFatura'] == ''){
        echo "<br /> - ID Fatura";
    }
    exit();
}
$idFatura = $_POST['idFatura'];
$usuario = unserialize($_SESSION['usuario-adm-'.SESSAOADM]);
$fatura = new Fatura();
$fatura->setId( $idFatura );
$fatura->setIdUsuario( $usuario->getIdUsuario() );
if(is_file('../../../../uploads/boletos/' . exibeId($idFatura) . '.pdf')) {
    unlink('../../../../uploads/boletos/' . exibeId($idFatura) . '.pdf');
}
if(is_file('../../../../uploads/notas/' . exibeId($idFatura) . '.pdf')) {
    unlink('../../../../uploads/notas/' . exibeId($idFatura) . '.pdf');
}
if( $fatura->cancela() ){
    echo '1';
}
