<?php
include_once("config/includes.php");
$usuario = new Usuario();
$usuario->setIdFacebook($_POST['id']);
if($usuario->login()) {
    $_SESSION['usuario-adm-' . SESSAOADM] = serialize($usuario);
    echo 1;
} else {
    echo 'Acesso negado, por favor verifique seu seu usuário está ativo e com usuário de acesso vinculado ao seu Facebook.';
}
