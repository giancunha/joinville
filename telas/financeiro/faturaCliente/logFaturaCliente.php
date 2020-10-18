<?php
include('../../../config/includes.php');
$fatura = new Fatura();
$fatura->setId($_POST['id']);
$fatura->seleciona();
$idFatura = exibeId($fatura->getId(), 6);
$idCliente = $fatura->getIdCliente();
?>
<div class="contentpanel">
    <div class="row">
        <div class="col-sm-12">
            <?php
            $faturaHistorico = $fatura->logFaturaHistoricoLista( $fatura->getId() );
            ?>
            <table class="table table-bordered table-hover table-default display">
                <thead>
                <tr>
                    <th>Data</th>
                    <th>Ação</th>
                    <th>Responsável</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach($faturaHistorico as $chave => $valor){
                    ?>
                    <tr>
                        <td><?php echo timeStamptoData($valor->getId(), 'datahora'); ?></td>
                        <td><?php echo $valor->getStatus(); ?></td>
                        <td><?php echo $valor->getIdUsuario(); ?></td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php
$grupo = $fatura->listaControle();
if(count($grupo) > 0){
    $idControle = $fatura->getIdControle();
    $caminhoNota = '../../../../uploads/notas/';
    ?>
    <div class="contentpanel">
        <div class="row">
            <div class="col-sm-12">
                <h3>Agrupamento Fatura (<?php echo exibeId($idControle); ?>)</h3>
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
                <?php
                $alerta = NULL;
                if($temBoleto != $totalFaturas){
                    $alerta .= 'Impossível enviar!!!';
                    $alerta .= "\\n - Uma ou mais faturas estão sem boleto";
                    $alerta = "onclick=\"alert('$alerta'); return false;\"";
                } else if(
                    $temBoleto == 0
                    or $temNota == 0
                    or $temNota != $totalFaturas
                ) {
                    $alerta .= 'Enviar a cobrança por e-mail com as seguintes pendências?';
                    if ($temBoleto == 0) {
                        $alerta .= "\\n - Todas faturas sem boleto gerado";
                    }
                    if ($temNota == 0) {
                        $alerta .= "\\n - Todas faturas sem nota carregada";
                    } else if ($temNota != $totalFaturas) {
                        $alerta .= "\\n - Existem faturas sem nota";
                    }
                    $alerta = "onclick=\"return duvida('$alerta');\"";
                }
                ?>
                <a href="<?php echo URLADM; ?>/telas/financeiro/faturaCliente/enviaFaturasAgrupadas.php?idControle=<?php echo $idControle; ?>"
                   target="_blank"
                   title="Enviar agrupamento de faturas <?= exibeId($idControle, 6); ?>"
                    <?php echo $alerta; ?>
                >
                    <button class="btn btn-success">Enviar todas faturas</button>
                </a>

            </div>
        </div>
    </div>
    <?php
}
?>
