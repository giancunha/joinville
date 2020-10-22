<?php
include_once("../../../config/includes.php");
$usuario = unserialize($_SESSION['usuario-adm-'.SESSAOADM]);
$idVendedor = $usuario->getIdUsuario();
$venda = new Venda();
$venda->setIdVendedor( $idVendedor );
$id_venda = $venda->selecionaVendaAtual();
$dados["id_venda"] = $id_venda;
echo json_encode($dados);
