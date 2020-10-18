<?php
include('../../../config/includes.php');
$usuario = unserialize($_SESSION['usuario-adm-'.SESSAOADM]);
if(
    $_POST['numeroNota'] == ''
    OR $_POST['tipoNota'] == ''
){
    echo "<script type='text/javascript'>
        alert('O(s) seguinte(s) campos obrigatórios não foram preenchidos:";
    if ($_POST['numeroNota'] == ''){
        echo "\\n - Número Nota";
    }
    if ($_POST['tipoNota'] == ''){
        echo "\\n - Tipo Nota";
    }
    echo "');
        history.go(-1);
     </script>";
    exit();
}
$idFatura = $_POST['idFatura'];
$numeroNota = $_POST['numeroNota'];
$idUsuario = $usuario->getIdUsuario();
$fatura = new Fatura;
$fatura->setId( $idFatura );
$fatura->seleciona();
$fatura->setIdUsuario( $idUsuario );
$fatura->setNumeroNota( $numeroNota );
$fatura->alteraNumeroNota();
$nomeNota = exibeId($idFatura);
if ($_POST['tipoNota'] == 'A') {
    $fatura->alteraGrupoNota();
    $nomeNota = exibeId($fatura->getIdControle()) . '_' . exibeId($numeroNota);
}
$destino = "../../../../uploads/notas/$nomeNota.pdf";
move_uploaded_file($_FILES["nota"]["tmp_name"], $destino);
echo exibeAlerta("Nota enviada com sucesso!", "/adm/financeiro/faturaCliente");
