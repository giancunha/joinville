<?php
include("../../../config/includes.php");
$fatura = new Fatura();
$fatura->setId($_POST['id']);
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
<title>Fatura <?php echo exibeId( $_POST['id'] ) . ' ' . $cliente->getRazaoSocial() . ' ' . nametofile( $fatura->getVencimento() ); ?></title>
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
    </table>
    <div class="contentpanel">
        <form action="<?php echo URLADM; ?>/telas/financeiro/faturaCliente/salvaLiquidaFatura.php" method="post">
            <input type="hidden" name="idFatura" value="<?php echo $idFatura; ?>" />
            <input type="hidden" name="valorCerto" value="<?php echo $valorFatura; ?>" />
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-3" title="Data Pagamento">
                                <input type="text" name="pagamento" class="form-control data" maxlength="10" value="<?php echo $fatura->getVencimento(); ?>" />
                            </div>
                            <div class="col-sm-3" title="Valor">
                                <input type="text" name="valor" class="form-control preco" value="<?php echo baseToDecimal($valorFatura); ?>" maxlength="10" />
                            </div>
                            <div class="col-sm-6">
                                <label class="control-label">&nbsp;</label>
                                <button type="submit" class="btn btn-primary">Liquidar</button>
                                <button type="reset" class="btn btn-default" title="Desfazer alterações">Desfazer</button>
                                <button data-dismiss="modal" class="btn btn-default">Voltar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
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
