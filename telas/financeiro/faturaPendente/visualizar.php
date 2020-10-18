<div class="contentpanel">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    Faturas com pendências
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
                        $resultado = $resultado->listaPendentes( DIASENVIOFATURA*3 );
                        $listados = $totalFaturas = 0;
                        $caminhoNota = '../uploads/notas/';
                        foreach($resultado as $chave => $valor){
                            $totalFaturas+= decimalToBase($valor->getValor());
                            $listados++;
                            $idCliente = $valor->getIdCliente();
                            $cliente = new Cliente();
                            $cliente->setId($idCliente);
                            $cliente->seleciona();
                            $enviaNota = $cliente->getEnviaNota();
                            $cidade = new Cidade();
                            $cidade->setIdCidade( $cliente->getIdCidade() );
                            $cidade->seleciona();
                            $estado = new Estado();
                            $estado->setIdEstado( $cliente->getIdEstado() );
                            $estado->seleciona();
                            $dataBanrisul = explode("/",$valor->getVencimento());

                            $idFatura = $valor->getId();
                            $resultado2 = new FaturaItem();
                            $resultado2 = $resultado2->listaItens( $idFatura );
                            $descricaoFatura = NULL;
                            foreach($resultado2 as $chave2 => $valor2) {
                                $descricaoFatura .= $valor2->getIdServico() . ' ' . $valor2->getDescricao() . ' ' . $valor2->getValor() . "\n";
                                $valorBoleto = $valor->getValor();
                                if($cidade->getIdCidade() == 3932 and $valor2->getIdServico() == 'Manutenção' and $enviaNota == 1){
                                    $valorBoleto = preco(decimalToBase($valor->getValor()) * 0.98);
                                }
                            }
                            $temBoleto = $temNota = false;
                            ?>
                            <tr valign='middle'>
                                <td><?php echo $valor->getVencimento(); ?></td>
                                <td><?php echo $cliente->getNomeFantasia(); ?></td>
                                <td><?php echo exibeId($valor->getId()); ?></td>
                                <td><?php echo $valor->getStatus(); ?></td>
                                <td align="right"><?php echo "R$ " . $valor->getValor(); ?></td>
                                <td>
                                    <form method="POST" action="" id="form<?php echo $idFatura; ?>">
                                        <input type="hidden" class="form-control" id="descricao" value="Fatura <?php echo exibeId($idFatura); ?>">
                                        <input type="hidden" class="form-control" id="valor" value="<?php echo soNumero($valorBoleto); ?>">
                                        <input type="hidden" class="form-control" id="quantidade" value="1">
                                        <input type="hidden" class="form-control" id="nome_cliente" value="<?php echo $cliente->getNomeFantasia(); ?>">
                                        <input type="hidden" class="form-control" id="nome_empresa" value="<?php echo $cliente->getRazaoSocial(); ?>">
                                        <input type="hidden" class="form-control" id="cpf" placeholder="CPF" value="<?php echo soNumero($cliente->getCnpjCpf()); ?>">
                                        <input type="hidden" class="form-control" id="telefone" placeholder="Telefone" value="<?php echo soNumero($cliente->getTelefone()); ?>">
                                        <input type="hidden" class="form-control" id="vencimento" placeholder="Data de vencimento" value="<?php echo dataToBase($valor->getVencimento()); ?>">
                                        <input type="hidden" class="form-control" id="message" placeholder="Descrição da Cobrança" value="<?php echo $descricaoFatura; ?>">
                                        <?php
                                        $baixar = 'none';
                                        $gerar = 'block';
                                        if(is_file('../uploads/boletos/' . exibeId($idFatura) . '.pdf')){
                                            $baixar = 'block';
                                            $gerar = 'none';
                                            $temBoleto = true;
                                        }
                                        if(dataToBase($valor->getVencimento()) >= date('Y-m-d')){
                                            ?>
                                            <button
                                                    type="button"
                                                    class="btn btn-success formBoleto"
                                                    data-fatura="<?php echo $idFatura; ?>"
                                                    id="gerar<?php echo $idFatura; ?>"
                                                    title="Emitir Boleto"
                                                    data-toggle="modal"
                                                    data-target=".bs-example-modal-lg"
                                                    data-tituloModal="Fatura <?php echo $idFatura; ?> - Boleto"
                                                    style="display: <?php echo $gerar; ?>"
                                            >
                                                <i class="fa fa-barcode"></i> <?php echo preco($valorBoleto); ?>
                                            </button>
                                            <?php
                                        }
                                        ?>
                                        <a href="<?php echo URLADM . '/ajax/baixarBoleto.php?arquivo=' . exibeId($idFatura); ?>.pdf&servico=<?php echo $valor->getStatus(); ?>&cliente=<?php echo $cliente->getNomeFantasia(); ?>"
                                           style="text-decoration: none;"
                                        >
                                            <button
                                                    type="button"
                                                    class="btn btn-maroon"
                                                    id="baixar<?php echo $idFatura; ?>"
                                                    title="Baixar Boleto"
                                                    style="display: <?php echo $baixar; ?>"
                                            >
                                                <i class="fa fa-download"></i> Baixar
                                            </button>
                                        </a>
                                    </form>
                                </td>
                                <td>
                                    <?php
                                    $baixar = 'none';
                                    $enviar = 'block';
                                    $arquivoNota = exibeId($idFatura) . '.pdf';
                                    $arquivoNotaGrupo = exibeId($valor->getIdControle()) . '_' . exibeId($valor->getNumeroNota()) . '.pdf';
                                    if(is_file($caminhoNota . $arquivoNotaGrupo)){
                                        $arquivoNota = $arquivoNotaGrupo;
                                    }
                                    if(is_file($caminhoNota . $arquivoNota)){
                                        $baixar = 'block';
                                        $enviar = 'none';
                                        $temNota = true;
                                    }
                                    if(dataToBase($valor->getVencimento()) >= date('Y-m-d')){
                                        ?>
                                        <button class="btn btn-success abreModal"
                                                title="Enviar nota"
                                                data-toggle="modal"
                                                data-target=".bs-example-modal-lg"
                                                data-acao="nota"
                                                data-tituloModal="Fatura <?php echo exibeId($valor->getId(), 5); ?> - Nota Fiscal - Vencimento <?php echo $valor->getVencimento(); ?>"
                                                data-id="<?php echo $valor->getId(); ?>"
                                                data-secaoPai="financeiro"
                                                data-secaoFilho="faturaCliente"
                                                style="display: <?php echo $enviar; ?>"
                                        >
                                            <i class="fa fa-upload"></i> Carregar
                                        </button>
                                        <?php
                                    }
                                    ?>
                                    <a href="<?php echo URLADM . '/ajax/baixarNota.php?arquivo=' . $arquivoNota; ?>&servico=<?php echo $valor->getStatus(); ?>&cliente=<?php echo $cliente->getNomeFantasia(); ?>"
                                       style="text-decoration: none;"
                                    >
                                        <button
                                                type="button"
                                                class="btn btn-maroon"
                                                title="Baixar Nota"
                                                style="display: <?php echo $baixar; ?>"
                                        >
                                            <i class="fa fa-download"></i> <?php echo $valor->getNumeroNota(); ?>
                                        </button>
                                    </a>
                                </td>
                                <td>
                                    <a class="btn btn-default"
                                       href="<?php echo URLADM; ?>/telas/financeiro/faturaCliente/imprimeFaturaCliente.php?id=<?php echo $valor->getId(); ?>"
                                       target="_blank"
                                       title="Visualizar"
                                    >
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <?php
                                    $duvida = NULL;
                                    if(!$temBoleto or !$temNota) {
                                        $duvida .= 'Enviar a cobrança por e-mail com as seguintes pendências?';
                                        if (!$temBoleto) {
                                            $duvida .= "\\n - Fatura sem boleto gerado";
                                        }
                                        if (!$temNota) {
                                            $duvida .= "\\n - Fatura sem nota carregada";
                                        }
                                        $duvida = "onclick=\"return duvida('$duvida');\"";
                                    }
                                    ?>
                                    <a class="btn btn-default"
                                       href="<?php echo URLADM; ?>/telas/financeiro/faturaCliente/enviaFaturaCliente.php?id=<?php echo $valor->getId(); ?>"
                                       target="_blank"
                                       title="Enviar fatura Nº <?= exibeId($valor->getId(), 6); ?>"
                                        <?php echo $duvida; ?>
                                    >
                                        <i class="fa fa-send"></i>
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
                    <?php
                    $diaLimite = date('d/m/Y', strtotime('+' . DIASENVIOFATURA*3 . ' days'));
                    ?>
                    <div class="alert alert-info">
                        <span class="fa fa-info-circle"></span>
                        Aqui serão listadas as faturas com vencimento inferior a <b><?php echo $diaLimite; ?></b>, que ainda não foram enviadas.<br>
                        Faturas com vencimento até <b><?php echo date('d/m/Y', strtotime('+' . DIASENVIOFATURA+1 . ' days')); ?></b> que possuam boleto e nota serão enviadas automaticamente amanhã.
                    </div>
                </div>
            </div><!-- panel-body -->
        </div>
    </div>
</div>
