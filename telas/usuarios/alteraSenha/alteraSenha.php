<?php
include('../../../config/includes.php');
$usuario = unserialize($_SESSION['usuario-adm-'.SESSAOADM]);
if ($usuario->getSenha() != encriptaSenha($_POST['oldpwd'])) {
    echo "- Senha atual inválida!";
} else if ($_POST['newpwd'] != $_POST['newpwd2']) {
    echo"- O campo nova senha e o da confirmação de senha não coincidem";
} else {
    $senha = $_POST['newpwd'];
    $usuario->setSenha( $senha );
    $altera = $usuario->alteraSenha();
    if( $altera > 0 ){
        echo "1";
    }
}
