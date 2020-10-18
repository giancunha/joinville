<?php
include('../../../config/includes.php');
if($_POST['icone'] == ''){
    echo "Campo(s) obrigat&oacute;rio(s):";
    if ($_POST['icone'] == ''){
        echo "<br /> - Icone";
    }
    exit();
}
$idMenuIcone = $_POST['idMenuIcone'];
$icone = $_POST['icone'];
$menuIcone = new MenuIcone;
$menuIcone->setIdMenuIcone( $idMenuIcone );
$menuIcone->setIcone( $icone );
if($menuIcone->selecionaIcone() and $icone != $_POST['oldIcone']){
    echo "Ícone já cadastrado, informe outro!";
    exit();
}
$altera = $menuIcone->altera();
if( $altera > 0 ){
    echo '1';
}
