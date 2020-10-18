<?php
include('../../../config/includes.php');
if($_POST['icone'] == ''){
    echo "Campo(s) obrigat&oacute;rio(s):";
    if ($_POST['icone'] == ''){
        echo "<br /> - Icone"; 
    }
    exit();
}
$icone = $_POST['icone'];
$menuIcone = new MenuIcone;
$menuIcone->setIcone( $icone );
if($menuIcone->selecionaIcone()){
        echo "Ícone já cadastrado, informe outro!";
        exit();
}
$insere = $menuIcone->insere();
if( $insere > 0 ){
    echo '1';
}
