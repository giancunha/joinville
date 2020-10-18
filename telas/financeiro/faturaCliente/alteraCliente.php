<?php
$sessaoPai = 'financeiro';
$sessaoFilho = 'faturaCliente';
if(isset($_POST['secaoPai']) or isset($_POST['secaoFilho'])){
    $sessaoPai = $_POST['secaoPai'];
    $sessaoFilho = $_POST['secaoFilho'];
}
$_SESSION['filtro']['idCliente'] = $_REQUEST['idCliente'];
$retorno = URLADM . '/' . $sessaoPai;
if($sessaoFilho != ''){
    $retorno .= '/' . $sessaoFilho;
}
echo exibeAlerta("", $retorno);
