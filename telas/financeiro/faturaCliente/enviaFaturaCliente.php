<?php
include("../../../config/includes.php");
$usuario = unserialize($_SESSION['usuario-adm-'.SESSAOADM]);
$fatura = new Fatura();
$fatura->setId($_GET['id']);
$fatura->seleciona();
$fatura->setIdUsuario( $usuario->getIdUsuario() );
$idCliente = $fatura->getIdCliente();
$idFatura = $fatura->getId();
$cliente = new Cliente();
$cliente->setid( $idCliente );
$cliente->seleciona();
$cidade = new Cidade();
$cidade->setIdCidade( $cliente->getIdCidade() );
$cidade->seleciona();
$estado = new Estado();
$estado->setIdEstado( $cliente->getIdEstado() );
$estado->seleciona();
$caminhoNota = '../../../../uploads/notas/';
$mensagem = "
<html>
<head>
    <title>Fatura " . exibeId( $_GET['id'] ) . ' ' . $cliente->getRazaoSocial() . ' ' . nametofile( $fatura->getVencimento() ) . "</title>
    <link href='" . URLADM . "/assets/Style.css' rel='stylesheet'>
    <link href='" . URLADM . "/assets/css/font.roboto.css' rel='stylesheet'>
    <style>
        a {
            color: #666666;
        }
        hr {
            border: 1px dotted #DDDDDD;
            border-style: none none dotted;
            color: #FFFFFF;
            background-color: #FFFFFF;
            width: 98%;
        }
        strong {
            font-weight: bold !important;
        }
        th {
            text-align: left;
        }
        .campos {
            border:#000000 1px solid;
        }
        .conteudo{
            background-color: #FFFFFF;
            border: 1px #000000 solid;
            margin: 0 auto;
            width: 750px;
        }
        .linha-vertical {
            height: 90px;
            border-left: 1px dotted #DDDDDD;
        }
        .numero-fatura {
            color:#EA6A23;
            font-weight: bold;
        }
        .texto-grande {
            font-size: 20px;
        }
        .texto-pequeno {
            font-size:10px;
        }
    </style>
</head>
<body>
<div class='conteudo'>
    <table width='750' border='0' cellspacing='3' cellpadding='3'>
        <tr>
            <td width='33%'><img src='" . URLADM . "/imagens/logo-otv.jpg' width='150'/></td>
            <td width='34%' align='center'>
                <p class='texto-pequeno'> OTV Elevadores LTDA. <br />
                    Capão da Canoa - RS <br />
                    Fone: (51) 99755.4088<br />
                    otvelevadores@gmail.com<br />
                    www.otvelevadores.com.br
                </p>
            </td>
            <td width='33%' class='texto-grande' align='right'>
                Fatura N&ordm;<br/>
                <span class='numero-fatura'>" . exibeId($idFatura, 6) . "</span>
            </td>
        </tr>
    </table>
    <table width='750' border='0' cellpadding='0' cellspacing='0'>
        <tr>
            <td align='left'>&nbsp;</td>
        </tr>
        <tr>
            <td align='left'>
                <table width='100%' border='0' cellspacing='4' cellpadding='2'>
                    <tr>
                        <td>NomeFantasia / Razão Social</td>
                        <td>CNPJ / CPF</td>
                        <td>Emissão</td>
                    </tr>
                    <tr>
                        <td class='campos'>" . $cliente->getRazaoSocial() . "</td>
                        <td class='campos'>" . $cliente->getCnpjCpf() . "</td>
                        <td align='center' class='campos'>" . date('d/m/Y') . "</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td align='left'>
                <table width='100%' border='0' cellspacing='4' cellpadding='2'>
                    <tr>
                        <td>Endereço</td>
                        <td>Bairro</td>
                        <td>CEP</td>
                        <td>Vencimento</td>
                    </tr>
                    <tr>
                        <td class='campos'>" . $cliente->getEndereco() . ", " . $cliente->getNumero() . " - " . $cliente->getComplemento() . "</td>
                        <td class='campos'>" . $cliente->getBairro() . "</td>
                        <td class='campos'>" . $cliente->getCep() . "</td>
                        <td align='center' class='campos'>" . $fatura->getVencimento() . "</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td align='left'>
                <table width='100%' border='0' cellspacing='4' cellpadding='2'>
                    <tr>
                        <td>Fone</td>
                        <td>Munic&iacute;pio</td>
                        <td>UF</td>
                        <td>Inscrição Estadual</td>
                        <td>Hora</td>
                    </tr>
                    <tr>
                        <td class='campos'>" . $cliente->getTelefone() . "</td>
                        <td class='campos'>" . $cidade->getCidade() . "</td>
                        <td class='campos'>" . $estado->getUf() . "</td>
                        <td class='campos'>ISENTO</td>
                        <td align='center' class='campos'>" . date('H:i') . "</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr><td><hr></td></tr>
        <tr>
            <td align='center'><strong><em>Itens da Fatura</em></strong></td>
        </tr>
        <tr><td><hr></td></tr>
        <tr>
            <td align='center'>
                <div>
                    <table border='0' cellpadding='2' cellspacing='0' width='98%'>
                        <thead>
                        <tr class='tabelaBarra'>
                            <th>Serviço</th>
                            <th>Descrição</th>
                            <th align='right'>Valor</th>
                        </tr>
                        </thead>
                        <tbody>";
$valorFatura = 0;
$resultado2 = new FaturaItem();
$resultado2 = $resultado2->listaItens( $idFatura );
$servicos = array();
$valorServico = 0;
foreach($resultado2 as $chave2 => $valor2){
    $servicos[$valor2->getIdServico()] = $valor2->getDescricaoServico();
    $valorItem = decimalToBase($valor2->getValor());
    $valorFatura += $valorItem;
    if($valorItem > $valorServico){
        $nomeAnexoServico = $valor2->getDescricao();
    }
    $mensagem .= "
                            <tr>
                                <td>" . $valor2->getIdServico() . "</td>
                                <td>" . $valor2->getDescricao() . "</td>
                                <td align='right'>" . $valor2->getValor() . "</td>
                            </tr>
    ";
}
$mensagem .= "
                        <tr class='tabelaBarra'>
                            <td align='right' colspan='4'><b>Total: </b> R$ " . number_format($valorFatura, 2, ',', '.') . "</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </td>
        </tr>
        <tr><td><hr></td></tr>
        <tr>
            <td align='center'><strong><em>Serviços - O que são?</em></strong></td>
        </tr>
        <tr><td><hr></td></tr>
        <tr>
            <td align='center'>
                <div>
                    <table border='0' cellpadding='2' cellspacing='0' width='98%'>
                        <thead>
                        <tr class='tabelaBarra'>
                            <th>Serviço</th>
                            <th>Descrição</th>
                        </tr>
                        </thead>
                        <tbody>";
foreach($servicos as $nomeServico => $descricaoServico){
    $mensagem .= "
                            <tr>
                                <td>" . $nomeServico . "</td>
                                <td>" . $descricaoServico . "</td>
                            </tr>
    ";
}
$mensagem .= "
                        </tbody>
                    </table>
                </div>
            </td>
        </tr>
        <tr><td><hr></td></tr>
    </table>
</div>
</body>
</html>";
$nomeFantasiaCliente = $cliente->getNomeFantasia();
$mail = new PHPMailer();
$mail->AddReplyTo( DESTINOMAIL, EMPRESA );
$mail->IsHTML(true);
$mail->IsSMTP();
$mail->CharSet='UTF-8';
$mail->setLanguage('br');
$mail->AltBody = 'Seu servidor não suporta mensagens HTML';
$mail->From = DESTINOMAILRECEPCAO;
$mail->FromName = EMPRESA;
$mail->Host = SMTP;
$mail->Password = SENHAMAIL;
$mail->Port = 587;
$mail->Sender = EMAIL;
$mail->SMTPAuth = true;
$mail->SMTPSecure = 'tls';
$mail->Subject = mb_strtoupper($nomeFantasiaCliente) . ' - Fatura';
$mail->Username = USERMAIL;
$mail->WordWrap = 50;
$mail->Body = $mensagem;
if(is_file('../../../../uploads/boletos/' . exibeId($idFatura) . '.pdf')) {
    $nomeBoleto = mb_strtoupper($nomeFantasiaCliente . ' - ' . $nomeAnexoServico . ' - BOLETO.pdf');
    $mail->AddAttachment('../../../../uploads/boletos/' . exibeId($idFatura) . '.pdf', $nomeBoleto);
}
$arquivoNota = exibeId($idFatura) . '.pdf';
$arquivoNotaGrupo = exibeId($fatura->getIdControle()) . '_' . exibeId($fatura->getNumeroNota()) . '.pdf';
if(is_file($caminhoNota . $arquivoNotaGrupo)){
    $arquivoNota = $arquivoNotaGrupo;
}
if(is_file($caminhoNota . $arquivoNota)){
    $nomeNota = mb_strtoupper($nomeFantasiaCliente . ' - ' . $nomeAnexoServico . ' - NFe.pdf');
    $mail->AddAttachment($caminhoNota . $arquivoNota, $nomeNota);
}
$pessoas = new Pessoa();
$pessoas = $pessoas->listaEnviaFatura( $idCliente );
foreach ($pessoas as $chave => $pessoa) {
    $nome = $pessoa->getNome();
    $emailDestino = $pessoa->getEmail();
    if(!validaEmail($emailDestino)) {
        error_log('Envia Fatura Cliente: E-mail ' . $emailDestino . ' inválido!');
        echo '<br>E-mail ' . $emailDestino . ' inválido!';
    }
    if($pessoa->getIdPessoaFuncao() == 6){
        $mail->addAddress($emailDestino, $nome);
    } else {
        $mail->addCC($emailDestino, $nome);
    }
}
$mail->addBCC(DESTINOMAILRECEPCAO, EMPRESA); //todo remover cópia oculta
if (!$mail->send()) {
    echo "<pre>";
    print_r('Erro: ' . $mail->ErrorInfo);
    error_log('Erro: ' . $mail->ErrorInfo);
    echo "</pre>";
    exit();
}
$fatura->logFaturaHistorico( $fatura->getIdUsuario(), $fatura->getId(), 'E' );
?>
<script type='text/javascript'>
    document.onreadystatechange = function(){
        if (document.readyState === "complete") {
            alert('Fatura enviada!');
            window.close();
        };
    }
</script>
