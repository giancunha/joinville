<?php
$idPessoa = $_REQUEST['id'];
$pessoa = new Pessoa();
$pessoa->setIdPessoa( $idPessoa );
$pessoa->seleciona();
$ativo = ($pessoa->getAtivo() == '1') ? '0' : '1';
$pessoa->setAtivo( $ativo );
if($pessoa->ativacao()){
    echo exibeAlerta('Alterado com sucesso!', '/adm/pessoas/pessoa');
}
