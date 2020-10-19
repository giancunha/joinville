<?php
include_once("config/includes.php");
$usuario = new Usuario();
$usuario->setEmail($_POST["login"]);
$usuario->setSenha($_POST["senha"]);
if($usuario->login()) {
    $_SESSION['usuario-adm-' . SESSAOADM] = serialize($usuario);
    $caminho = "";
    echo exibeAlerta("", "/" . $caminho );
} else {
    echo exibeAlerta("Seu login ou senha estão errados, ou seu acesso está desativado! Tente novamente", "voltar");
}
