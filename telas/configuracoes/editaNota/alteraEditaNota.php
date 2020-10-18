<?php
include('../../../config/includes.php');
if(
    $_POST['idFatura'] == ''
    or $_POST['numeroNota'] == ''
    or !isset($_FILES["file_0_0"]["tmp_name"])
){
    echo "Campo(s) obrigatório(s):";
    if ($_POST['idFatura'] == ''){
        echo "<br /> - ID Fatura";
    }
    if ($_POST['numeroNota'] == '') {
        echo "<br /> - Número Nota";
    }
    if (!isset($_FILES["file_0_0"]["tmp_name"])) {
        echo "<br /> - Arquivo Nota";
    }
    exit();
}
$usuario = unserialize($_SESSION['usuario-adm-'.SESSAOADM]);
$idFatura = $_POST['idFatura'];
$idUsuario = $usuario->getIdUsuario();
$numeroNota = $_POST['numeroNota'];
$fatura = new Fatura;
$fatura->setId($idFatura);
$fatura->seleciona();
$fatura->logFaturaHistorico( $idUsuario, $idFatura, 'R' );
$fatura->setIdUsuario( $idUsuario );
$fatura->setNumeroNota($numeroNota);
$fatura->alteraNumeroNota();
$nomeNota = exibeId($idFatura);
$arquivo = "../../../../uploads/notas/$nomeNota.pdf";
if(is_file($arquivo)) {
    unlink($arquivo);
}
move_uploaded_file($_FILES["file_0_0"]["tmp_name"], $arquivo);
echo 1;
