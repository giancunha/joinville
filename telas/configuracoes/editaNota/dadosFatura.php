<?php
include_once("../../../config/includes.php");
$idFatura = $_REQUEST['idFatura'];
$fatura = new Fatura();
$fatura->setId( $idFatura );
$fatura->selecionaPelaFatura();
$cliente = new Cliente();
$cliente->setId( $fatura->getIdCliente() );
$cliente->seleciona();
$servico = new Servico();
$servico->setIdServico( $fatura->getIdUsuario() );
$servico->seleciona();
$dadosFatura[] = array(
    'id' => exibeId($fatura->getId()),
    'numeroNota' => $fatura->getNumeroNota(),
    'valor' => $fatura->getValor(),
    'cliente' => $cliente->getNomeFantasia(),
    'servico' => $servico->getNome(),
    'descricao' => $fatura->getStatus(),
);
$dados["dadosFatura"] = $dadosFatura;
$dados["secaoPai"] = $gets[1];
$dados["secaoFilho"] = $gets[2];
echo json_encode($dados);
