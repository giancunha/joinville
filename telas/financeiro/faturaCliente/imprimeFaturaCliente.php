<?php
include("../../../config/includes.php");
$fatura = new Fatura();
$fatura->setId($_GET['id']);
$fatura->seleciona();
$idCliente = $fatura->getIdCliente();
$idFatura = $fatura->getId();
$cliente = new Cliente();
$cliente->setId( $idCliente );
$cliente->seleciona();
$cidade = new Cidade();
$cidade->setIdCidade( $cliente->getIdCidade() );
$cidade->seleciona();
$estado = new Estado();
$estado->setIdEstado( $cliente->getIdEstado() );
$estado->seleciona();
?>
<title>Fatura <?php echo exibeId( $_GET['id'] ) . ' ' . $cliente->getRazaoSocial() . ' ' . nametofile( $fatura->getVencimento() ); ?></title>
<link href="<?php echo URLADM; ?>/assets/Style.css" rel="stylesheet">
<link href="<?php echo URLADM; ?>/assets/css/font.roboto.css" rel="stylesheet">
<div class="conteudo">
    <table width='100%' border='0' cellspacing='3' cellpadding='3'>
        <tr>
            <td width='33%'><img src='<?php echo URLADM; ?>/imagens/logo-otv.jpg' width='150'/></td>
            <td width='34%' align='center'>
                <p class="texto-pequeno"> OTV Elevadores LTDA. <br />
                    Capão da Canoa - RS <br />
                    Fone: (51) 99755.4088<br />
                    otvelevadores@gmail.com<br />
                    www.otvelevadores.com.br
                </p>
            </td>
            <td width='33%' class="texto-grande" align="right">
                Fatura N&ordm;<br/>
                <span class="numero-fatura"><?php echo exibeId($idFatura, 6); ?></span>
            </td>
        </tr>
    </table>
    <table width='100%' border='0' cellpadding='0' cellspacing='0'>
        <tr>
            <td align='left'>&nbsp;</td>
        </tr>
        <tr>
            <td align='left'>
                <table width="100%" border='0' cellspacing='4' cellpadding='2'>
                    <tr>
                        <td>NomeFantasia / Razão Social</td>
                        <td>CNPJ / CPF</td>
                        <td>Emissão</td>
                    </tr>
                    <tr>
                        <td class="campos"><?php echo $cliente->getRazaoSocial(); ?></td>
                        <td class="campos"><?php echo $cliente->getCnpjCpf(); ?></td>
                        <td align='center' class="campos"><?php echo date('d/m/Y'); ?></td>
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
                        <td class="campos"><?php echo $cliente->getEndereco(); ?>, <?php echo $cliente->getNumero(); ?> - <?php echo $cliente->getComplemento(); ?></td>
                        <td class="campos"><?php echo $cliente->getBairro(); ?></td>
                        <td class="campos"><?php echo $cliente->getCep(); ?></td>
                        <td align='center' class="campos"><?php echo $fatura->getVencimento(); ?></td>
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
                        <td class="campos"><?php echo $cliente->getTelefone(); ?></td>
                        <td class="campos"><?php echo $cidade->getCidade(); ?></td>
                        <td class="campos"><?php echo $estado->getUf(); ?></td>
                        <td class="campos">ISENTO</td>
                        <td align='center' class="campos"><?php echo date('H:i'); ?></td>
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
                        <tbody>
                        <?php
                        $valorFatura = 0;
                        $resultado2 = new FaturaItem();
                        $resultado2 = $resultado2->listaItens( $idFatura );
                        $servicos = array();
                        foreach($resultado2 as $chave2 => $valor2){
                            $servicos[$valor2->getIdServico()] = $valor2->getDescricaoServico();
                            $valorFatura += decimalToBase($valor2->getValor());
                            ?>
                            <tr>
                                <td><?php echo $valor2->getIdServico(); ?></td>
                                <td><?php echo $valor2->getDescricao(); ?></td>
                                <td align='right'><?php echo $valor2->getValor(); ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                        <tr class='tabelaBarra'>
                            <td align='right' colspan='4'><b>Total: </b> R$ <?php echo number_format($valorFatura, 2, ',', '.'); ?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </td>
        </tr>
        <tr><td><hr></td></tr>
        <!--
        <tr>
            <td align='center'><strong><em>Formas de Pagamento</em></strong></td>
        </tr>
        <tr><td><hr></td></tr>
        <tr>
            <td align='center'>
                <strong>Favorecido:</strong> OTV Elevadores LTDA
                <strong>CNPJ:</strong> 27.188.460/0001-41
            </td>
        </tr>
        <tr><td><hr></td></tr>
        <tr>
            <td align='left'>
                <table width='100%' border='0' align='center' cellpadding='0' cellspacing='0'>
                    <tr>
                        <td align='center' width="50%">
                            <table border='0' align='center' cellpadding='0' cellspacing='2'>
                                <tr>
                                    <td rowspan='3' align='center'>
                                        <img src='<?php echo URLADM; ?>/imagens/logo_santander.png' alt='Logo Santander' width='80' />
                                    </td>
                                    <td rowspan="3">&nbsp;</td>
                                    <td><strong>Banco:</strong> 033</td>
                                </tr>
                                <tr>
                                    <td><strong>Ag&ecirc;ncia:</strong> 1065</td>
                                </tr>
                                <tr>
                                    <td><strong>Conta: </strong>13001900-6</td>
                                </tr>
                            </table>
                        </td>
                        <td align='center'><div class="linha-vertical"></div></td>
                        <td align='center'>
                            <table border='0' align='center' cellpadding='0' cellspacing='2'>
                                <tr>
                                    <td rowspan='3' align='center'>
                                        <img src='<?php echo URLADM; ?>/imagens/logo_gerencianet.png' alt='Logo Gerencianet' width='110' />
                                    </td>
                                    <td rowspan="3">&nbsp;</td>
                                    <td><strong>Banco:</strong> 364</td>
                                </tr>
                                <tr>
                                    <td><strong>Ag&ecirc;ncia:</strong> Em Breve!</td>
                                </tr>
                                <tr>
                                    <td><strong>Conta: </strong>Em Breve!</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr><td colspan="3"><hr></td></tr>
                    <tr>
                        <td align='center' colspan="3">
                            <table border='0' align='center' cellpadding='0' cellspacing='2'>
                                <tr>
                                    <td align='center'><img src='<?php echo URLADM; ?>/imagens/logo_boleto.jpg' alt='' width='80' /></td>
                                    <td>&nbsp;</td>
                                    <td>
                                        <strong>
                                            Em breve!.<br />
                                        </strong>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr><td><hr></td></tr>
        -->
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
                        <tbody>
                        <?php
                        foreach($servicos as $nomeServico => $descricaoServico){
                            ?>
                            <tr>
                                <td><?php echo $nomeServico; ?></td>
                                <td><?php echo $descricaoServico; ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </td>
        </tr>
        <tr><td><hr></td></tr>
    </table>
</div>
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
<?php
if(isset($_GET['imprimir'])){
    ?>
    <script type='text/javascript'>
        document.onreadystatechange = function(){
            if (document.readyState === "complete") {
                window.print();
                fechaJanela();
            };
        }

        function sleep(ms) {
            return new Promise(resolve => setTimeout(resolve, ms));
        }

        async function fechaJanela() {
            await sleep(5000);
            window.close();
        }
    </script>
    <?php
}
?>
