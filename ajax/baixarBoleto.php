<?php
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);
$arquivo = '../../uploads/boletos/' . $_GET["arquivo"];
$nomeArquivo = mb_strtoupper($_REQUEST['cliente'] . ' - ' . $_REQUEST['servico'] . ' - BOLETO.pdf');
if(isset($arquivo) && file_exists($arquivo)){
// faz o teste se a variavel não esta vazia e se o arquivo realmente existe
    switch(strtolower(substr(strrchr(basename($arquivo),"."),1))){
// verifica a extensão do arquivo para pegar o tipo
        case "pdf": $tipo="application/pdf"; break;
        default: ;
    }
    header("Content-Type: ".$tipo);
// informa o tipo do arquivo ao navegador
    header("Content-Length: ".filesize($arquivo));
// informa o tamanho do arquivo ao navegador
    header("Content-Disposition: attachment; filename=$nomeArquivo");
    // informa ao navegador que é tipo anexo e faz abrir a janela de download,
//tambem informa o nome do arquivo
    readfile($arquivo); // lê o arquivo
    exit; // aborta pós-ações
}
