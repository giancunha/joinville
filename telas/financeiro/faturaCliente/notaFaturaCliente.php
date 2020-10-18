<?php
include('../../../config/includes.php');
$fatura = new Fatura();
$fatura->setId($_POST['id']);
$fatura->seleciona();
$idFatura = exibeId($fatura->getId(), 6);
$idCliente = $fatura->getIdCliente();
$caminhoNota = '../../../../uploads/notas/';
?>
<div class="contentpanel">
    <form action="<?php echo URLADM; ?>/telas/financeiro/faturaCliente/carregaNota.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="idFatura" value="<?php echo $fatura->getId(); ?>" />
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label class="control-label">Tipo nota</label>
                                <select name="tipoNota" class="select2" required="required" >
                                    <option value=""> Selecione </option>
                                    <option value="A"> Agrupado </option>
                                    <option value="I"> Individual </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label class="control-label">Número nota</label>
                                <input class="form-control" type="text" id="numeroNota" name="numeroNota" placeholder="Número Nota" required />
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label class="control-label">Arquivo nota</label>
                                <input class="form-control" type="file" id="nota" name="nota" required />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <button type="submit" class="btn btn-primary">Carregar Nota</button>
                    <button type="reset" class="btn btn-default" title="Desfazer alterações">Desfazer</button>
                    <button data-dismiss="modal" class="btn btn-default">Voltar</button>
                </div>
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="panel-heading">
                                <h4 class="panel-title">Itens Fatura</h4>
                            </div>
                            <?php
                            $faturaItem = new FaturaItem();
                            $faturaItem = $faturaItem->listaItens( $idFatura );
                            ?>
                            <table class="table table-bordered table-hover table-default display">
                                <thead>
                                <tr>
                                    <th>Serviço</th>
                                    <th>Descrição</th>
                                    <th>Valor</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $valorFatura = 0;
                                foreach($faturaItem as $chave => $valor){
                                    $idServico = $valor->getIdServico();
                                    $servico = new Servico();
                                    $servico->setNome($idServico);
                                    $servico->seleciona();
                                    $valorFatura += decimalToBase($valor->getValor());
                                    $nomeServico = $servico->getNome();
                                    ?>
                                    <tr>
                                        <td><?php echo $nomeServico; ?></td>
                                        <td><?php echo $valor->getDescricao(); ?></td>
                                        <td><?php echo $valor->getValor(); ?></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                <tr>
                                    <td align="right" colspan="4"><b>Total: </b> R$ <?php echo number_format($valorFatura, 2, ',', '.'); ?></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="panel-heading">
                                <h4 class="panel-title">Faturas anteriores de <?php echo $nomeServico; ?></h4>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover table-default display">
                                    <thead>
                                    <tr>
                                        <th>Cód. Fatura</th>
                                        <th>Vencimento</th>
                                        <th>Data Pagamento</th>
                                        <th>Serviço</th>
                                        <th align="right">Valor</th>
                                        <th>Nota</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                    </thead>
                                    <tbody class="dadosBD">
                                    <?php
                                    $resultado = $fatura->listaLiquidadasPorServico( $servico->getIdServico() );
                                    foreach($resultado as $chave => $valor){
                                        $idFatura = $valor->getId();
                                        ?>
                                        <tr valign='middle'>
                                            <td><?php echo exibeId($valor->getId()); ?></td>
                                            <td><?php echo $valor->getVencimento(); ?></td>
                                            <td><?php echo $valor->getPagamento(); ?></td>
                                            <td><?php echo $valor->getStatus(); ?></td>
                                            <td align="right"><?php echo "R$ " . $valor->getValor(); ?></td>
                                            <td>
                                                <?php
                                                $arquivoNota = exibeId($idFatura) . '.pdf';
                                                $arquivoNotaGrupo = exibeId($valor->getIdControle()) . '_' . exibeId($valor->getNumeroNota()) . '.pdf';
                                                if(is_file($caminhoNota . $arquivoNotaGrupo)){
                                                    $arquivoNota = $arquivoNotaGrupo;
                                                }
                                                if(is_file($caminhoNota . $arquivoNota)){
                                                    ?>
                                                    <a href="<?php echo $caminhoNota . $arquivoNota; ?>"
                                                       target="_blank"
                                                    >
                                                        <button
                                                                type="button"
                                                                class="btn btn-maroon"
                                                                title="Ver Nota"
                                                        >
                                                            <i class="fa fa-search"></i> <?php echo $valor->getNumeroNota(); ?>
                                                        </button>
                                                    </a>
                                                    <?php
                                                } else {
                                                    echo 'Sem nota';
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <a class="btn btn-default"
                                                   href="<?php echo URLADM; ?>/telas/<?php echo $gets[0]; ?>/<?php echo $gets[1]; ?>/imprime<?php echo ucfirst($gets[1]); ?>.php?id=<?php echo $valor->getId(); ?>"
                                                   target="_blank"
                                                   title="Visualizar"
                                                >
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a class="btn btn-default"
                                                   href="<?php echo URLADM; ?>/telas/<?php echo $gets[0]; ?>/<?php echo $gets[1]; ?>/imprime<?php echo ucfirst($gets[1]); ?>.php?id=<?php echo $valor->getId(); ?>&imprimir=sim"
                                                   target="_blank"
                                                   title="Imprimir"
                                                >
                                                    <i class="fa fa-print"></i>
                                                </a>
                                                <a class="btn btn-default abreModal"
                                                   title="Histórico Fatura"
                                                   data-toggle="modal"
                                                   data-target=".bs-example-modal-lg"
                                                   data-acao="log"
                                                   data-tituloModal="Fatura <?php echo exibeId($valor->getId(), 5); ?> - Histórico"
                                                   data-id="<?php echo $valor->getId(); ?>"
                                                   data-secaoPai="<?php echo $gets[0]; ?>"
                                                   data-secaoFilho="<?php echo $gets[1]; ?>"
                                                >
                                                    <i class="fa fa-list"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div><!-- panel-body -->
                    </div>
                </div>
                <?php
                $grupo = $fatura->listaControle();
                if(count($grupo) > 0){
                    $idControle = $fatura->getIdControle();
                    ?>
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="panel-heading">
                                    <h4>Agrupamento Fatura (<?php echo exibeId($idControle); ?>)</h4>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-default display">
                                        <thead>
                                        <tr>
                                            <th>Cód. Fatura</th>
                                            <th>Vencimento</th>
                                            <th>Data Pagamento/Faltam</th>
                                            <th>Serviço</th>
                                            <th align="right">Valor</th>
                                            <th>Boleto</th>
                                            <th>Nota</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $temBoleto = $temNota = $totalFaturas = 0;
                                        foreach($grupo as $chave => $valor){
                                            $idFatura = $valor->getId();
                                            $totalFaturas++;
                                            ?>
                                            <tr>
                                                <td><?php echo exibeId($valor->getId()); ?></td>
                                                <td><?php echo $valor->getVencimento(); ?></td>
                                                <td>
                                                    <?php
                                                    if(empty($valor->getPagamento())){
                                                        echo diasVencimento($valor->getVencimento());
                                                    } else {
                                                        echo $valor->getPagamento();
                                                    }
                                                    ?>
                                                </td>
                                                <td><?php echo $valor->getStatus(); ?></td>
                                                <td align="right"><?php echo "R$ " . $valor->getValor(); ?></td>
                                                <td>
                                                    <?php
                                                    $arquivoBoleto = '../../../../uploads/boletos/' . exibeId($idFatura) . '.pdf';
                                                    if(is_file($arquivoBoleto)){
                                                        $temBoleto++;
                                                        ?>
                                                        <a href="<?php echo URLADM . '/ajax/baixarBoleto.php?arquivo=' . exibeId($idFatura); ?>.pdf&servico=<?php echo $valor->getStatus(); ?>&cliente=<?php echo $valor->getIdCliente(); ?>"
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
                                                    } else {
                                                        echo 'Sem boleto';
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    $arquivoNota = exibeId($idFatura) . '.pdf';
                                                    $arquivoNotaGrupo = exibeId($valor->getIdControle()) . '_' . exibeId($valor->getNumeroNota()) . '.pdf';
                                                    if(is_file($caminhoNota . $arquivoNotaGrupo)){
                                                        $arquivoNota = $arquivoNotaGrupo;
                                                    }
                                                    if(is_file($caminhoNota . $arquivoNota)){
                                                        $temNota++;
                                                        ?>
                                                        <a href="<?php echo $caminhoNota . $arquivoNota; ?>"
                                                           target="_blank"
                                                        >
                                                            <button
                                                                    type="button"
                                                                    class="btn btn-maroon"
                                                                    title="Ver Nota"
                                                            >
                                                                <i class="fa fa-search"></i> <?php echo $valor->getNumeroNota(); ?>
                                                            </button>
                                                        </a>
                                                        <?php
                                                    } else {
                                                        echo 'Sem nota';
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div><!-- panel-body -->
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </form>
</div>
