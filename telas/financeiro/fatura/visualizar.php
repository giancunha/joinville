<?php
$dataInicial = $dataFinal = NULL;
if(isset($_REQUEST['dataInicial'])){
    $dataInicial = $_REQUEST['dataInicial'];
} else {
    $dataInicial = date("01/m/Y");
}
if(isset($_REQUEST['dataFinal'])){
    $dataFinal = $_REQUEST['dataFinal'];
} else {
    $ultimoDia = date("t", mktime(0, 0, 0, date('m'), '01', date('Y')));
    $dataFinal = date($ultimoDia . "/m/Y");
}
?>
<div class="contentpanel">
    <div class="col-sm-12">
        <div class="panel-heading">
            <h4 class="panel-title">
                Faturas
            </h4>
        </div>
        <div class="panel panel-default">
            <div class="panel-body">
                <form action="" method="post" id="formulario">
                    <div class="row">
                        <div class="col-sm-4">
                            <label class="control-label">Data Inicial</label>
                            <input name="dataInicial" class="form-control data datepicker" value="<?php echo $dataInicial; ?>">
                        </div>
                        <div class="col-sm-4">
                            <label class="control-label">Data Final</label>
                            <input name="dataFinal" class="form-control data datepicker" value="<?php echo $dataFinal; ?>">
                        </div>
                        <div class="col-sm-2">
                            <br><button type="submit" class="btn btn-primary" data-toggle="modal" name="filtro" value="1">Filtrar</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="panel-heading">
                <h4 class="panel-title">
                    Liquidadas
                </h4>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-default">
                        <thead>
                        <tr>
                            <th>Pagamento</th>
                            <th>Cliente</th>
                            <th>Cód. Fatura</th>
                            <th>Serviço</th>
                            <th align="right">Valor</th>
                            <th>Nota</th>
                            <th>&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody class="dadosBD">
                        <?php
                        $resultado = new Fatura();
                        $resultado = $resultado->listaPagamentos( 'F', $dataInicial, $dataFinal );
                        $listados = $totalFaturas = 0;
                        foreach($resultado as $chave => $valor){
                            $totalFaturas+= decimalToBase($valor->getValor());
                            $listados++;
                            $idCliente = $valor->getIdCliente();
                            $cliente = new Cliente();
                            $cliente->setId($idCliente);
                            $cliente->seleciona();
                            $enviaNota = $cliente->getEnviaNota();

                            $idFatura = $valor->getId();
                            $resultado2 = new FaturaItem();
                            $resultado2 = $resultado2->listaItens( $idFatura );
                            $descricaoFatura = NULL;
                            foreach($resultado2 as $chave2 => $valor2) {
                                $descricaoFatura .= $valor2->getIdServico() . ' ' . $valor2->getDescricao() . ' ' . $valor2->getValor() . "\n";
                                $valorBoleto = $valor->getValor();
                                if($cliente->getIdCidade() == 3932 and $valor2->getIdServico() == 'Manutenção' and $enviaNota == 1){
                                    $valorBoleto = preco(decimalToBase($valor->getValor()) * 0.98);
                                }
                            }
                            ?>
                            <tr valign='middle'>
                                <td><?php echo $valor->getPagamento(); ?></td>
                                <td><?php echo $cliente->getNomeFantasia(); ?> - (<?php echo $cliente->getRazaoSocial(); ?>)</td>
                                <td><?php echo exibeId($valor->getId()); ?></td>
                                <td><?php echo $valor->getStatus(); ?></td>
                                <td align="right"><?php echo "R$ " . $valor->getValor(); ?></td>
                                <td>
                                    <?php
                                    if(is_file('../uploads/notas/' . exibeId($idFatura) . '.pdf')){
                                        ?>
                                        <a href="<?php echo URLADM . '/ajax/baixarNota.php?arquivo=' . exibeId($idFatura); ?>.pdf&servico=<?php echo $valor->getStatus(); ?>&cliente=<?php echo $cliente->getNomeFantasia(); ?>"
                                           style="text-decoration: none;"
                                        >
                                            <button
                                                    type="button"
                                                    class="btn btn-maroon"
                                                    title="Baixar Nota"
                                            >
                                                <i class="fa fa-download"></i> <?php echo $valor->getNumeroNota(); ?>
                                            </button>
                                        </a>
                                        <?php
                                    }
                                    ?>
                                </td>
                                <td>
                                    <a class="btn btn-default"
                                       href="<?php echo URLADM; ?>/telas/financeiro/faturaCliente/imprimeFaturaCliente.php?id=<?php echo $valor->getId(); ?>"
                                       target="_blank"
                                       title="Visualizar"
                                    >
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a class="btn btn-default abreModal"
                                       title="Histórico Fatura"
                                       data-toggle="modal"
                                       data-target=".bs-example-modal-lg"
                                       data-acao="log"
                                       data-tituloModal="Fatura <?php echo exibeId($valor->getId(), 5); ?> - Histórico"
                                       data-id="<?php echo $valor->getId(); ?>"
                                       data-secaoPai="financeiro"
                                       data-secaoFilho="faturaCliente"
                                    >
                                        <i class="fa fa-list"></i>
                                    </a>
                                    <a href="<?php echo URLADM."/financeiro/faturaCliente/alteraCliente?idCliente=" . $idCliente; ?>"
                                       class="btn btn-default"
                                       title="Visualizar Faturas"
                                    >
                                        <i class="fa fa-money"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="6">
                                <?php echo exibeId($listados, 3); ?> faturas totalizando R$ <?php echo preco($totalFaturas); ?>
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                    <div class="alert alert-info">
                        <span class="fa fa-info-circle"></span>
                        Aqui serão listadas as faturas em aberto com <b>pagamento</b> de <b><?php echo $dataInicial; ?></b> a <b><?php echo $dataFinal; ?></b>.
                    </div>
                </div>
            </div><!-- panel-body -->
            <div class="panel-heading">
                <h4 class="panel-title">
                    Em aberto
                </h4>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-default">
                        <thead>
                        <tr>
                            <th>Vencimento</th>
                            <th>Cliente</th>
                            <th>Cód. Fatura</th>
                            <th>Serviço</th>
                            <th align="right">Valor</th>
                            <th>Boleto</th>
                            <th>Nota</th>
                            <th>&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody class="dadosBD">
                        <?php
                        $resultado = new Fatura();
                        $resultado = $resultado->listaPagamentos( 'A', $dataInicial, $dataFinal );
                        $listados = $totalFaturas = 0;
                        foreach($resultado as $chave => $valor){
                            $totalFaturas+= decimalToBase($valor->getValor());
                            $listados++;
                            $idCliente = $valor->getIdCliente();
                            $cliente = new Cliente();
                            $cliente->setId($idCliente);
                            $cliente->seleciona();
                            $enviaNota = $cliente->getEnviaNota();

                            $idFatura = $valor->getId();
                            $resultado2 = new FaturaItem();
                            $resultado2 = $resultado2->listaItens( $idFatura );
                            $descricaoFatura = NULL;
                            foreach($resultado2 as $chave2 => $valor2) {
                                $descricaoFatura .= $valor2->getIdServico() . ' ' . $valor2->getDescricao() . ' ' . $valor2->getValor() . "\n";
                                $valorBoleto = $valor->getValor();
                                if($cliente->getIdCidade() == 3932 and $valor2->getIdServico() == 'Manutenção' and $enviaNota == 1){
                                    $valorBoleto = preco(decimalToBase($valor->getValor()) * 0.98);
                                }
                            }
                            ?>
                            <tr valign='middle'>
                                <td><?php echo $valor->getVencimento(); ?></td>
                                <td><?php echo $cliente->getNomeFantasia(); ?></td>
                                <td><?php echo exibeId($valor->getId()); ?></td>
                                <td><?php echo $valor->getStatus(); ?></td>
                                <td align="right"><?php echo "R$ " . $valor->getValor(); ?></td>
                                <td>
                                    <?php
                                    if(is_file('../uploads/boletos/' . exibeId($idFatura) . '.pdf')){
                                        ?>
                                        <a href="<?php echo URLADM . '/ajax/baixarBoleto.php?arquivo=' . exibeId($idFatura); ?>.pdf&servico=<?php echo $valor->getStatus(); ?>&cliente=<?php echo $cliente->getNomeFantasia(); ?>"
                                           style="text-decoration: none;"
                                        >
                                            <button
                                                    type="button"
                                                    class="btn btn-maroon"
                                                    id="baixar<?php echo $idFatura; ?>"
                                                    title="Baixar Boleto"
                                            >
                                                <i class="fa fa-download"></i> Baixar
                                            </button>
                                        </a>
                                        <?php
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if(is_file('../uploads/notas/' . exibeId($idFatura) . '.pdf')){
                                        ?>
                                        <a href="<?php echo URLADM . '/ajax/baixarNota.php?arquivo=' . exibeId($idFatura); ?>.pdf&servico=<?php echo $valor->getStatus(); ?>&cliente=<?php echo $cliente->getNomeFantasia(); ?>"
                                           style="text-decoration: none;"
                                        >
                                            <button
                                                    type="button"
                                                    class="btn btn-maroon"
                                                    title="Baixar Nota"
                                            >
                                                <i class="fa fa-download"></i> <?php echo $valor->getNumeroNota(); ?>
                                            </button>
                                        </a>
                                        <?php
                                    }
                                    ?>
                                </td>
                                <td>
                                    <a class="btn btn-default"
                                       href="<?php echo URLADM; ?>/telas/financeiro/faturaCliente/imprimeFaturaCliente.php?id=<?php echo $valor->getId(); ?>"
                                       target="_blank"
                                       title="Visualizar"
                                    >
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a class="btn btn-default abreModal"
                                       title="Histórico Fatura"
                                       data-toggle="modal"
                                       data-target=".bs-example-modal-lg"
                                       data-acao="log"
                                       data-tituloModal="Fatura <?php echo exibeId($valor->getId(), 5); ?> - Histórico"
                                       data-id="<?php echo $valor->getId(); ?>"
                                       data-secaoPai="financeiro"
                                       data-secaoFilho="faturaCliente"
                                    >
                                        <i class="fa fa-list"></i>
                                    </a>
                                    <a href="<?php echo URLADM."/financeiro/faturaCliente/alteraCliente?idCliente=" . $idCliente; ?>"
                                       class="btn btn-default"
                                       title="Visualizar Faturas"
                                    >
                                        <i class="fa fa-money"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="6">
                                <?php echo exibeId($listados, 3); ?> faturas totalizando R$ <?php echo preco($totalFaturas); ?>
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                    <div class="alert alert-info">
                        <span class="fa fa-info-circle"></span>
                        Aqui serão listadas as faturas em aberto com <b>vencimento</b> de <b><?php echo $dataInicial; ?></b> a <b><?php echo $dataFinal; ?></b>.
                    </div>
                </div>
            </div><!-- panel-body -->
        </div>
    </div>
</div>
