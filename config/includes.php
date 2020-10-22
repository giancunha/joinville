<?php
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);
if(is_file("../config/includes.php")){
    $caminho = "../";
} else if(is_file("../../../config/includes.php")){
    $caminho = "../../../";
} else {
    $caminho = "";
}
//CONFIGURAÇÕES
include_once($caminho . "config/config.php");
include_once($caminho . "config/funcoes.php");
include_once($caminho . "config/validaSessao.php");
include_once($caminho . "config/links.php");
include_once($caminho . "class/BdSQL.php");
include_once($caminho . "class/Menu.php");
include_once($caminho . "class/MenuIcone.php");
include_once($caminho . "class/Perfil.php");
include_once($caminho . "class/PerfilMenu.php");
include_once($caminho . "class/Usuario.php");
include_once($caminho . "class/UsuarioPerfil.php");
//CLASSES
include_once($caminho . "class/Produto.php");
include_once($caminho . "class/ProdutoTipo.php");
include_once($caminho . "class/Venda.php");
include_once($caminho . "class/VendaItem.php");
