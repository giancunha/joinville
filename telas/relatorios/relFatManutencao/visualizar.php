<div class="contentpanel">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">Faturas de Manutenção</h4>
            </div>
            <div class="panel-body">
                <div class="table-responsive" id='imprimirTabela'>
                    <table class="table table-bordered table-hover table-default">
                        <?php
                        $listados = 0;
                        ?>
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Administradora</th>
                            <th>Fantasia</th>
                            <th>Razão</th>
                            <th>Documento</th>
                            <th>Faturas</th>
                            <th>Vencimento</th>
                            <th>&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody class="dadosBD">
                        <?php
                        $resultado = Cliente::listaFaturasManutencao( );
                        foreach($resultado as $chave => $valor){
                            $listados++;
                            if($valor->getAtivo() == 1){
                                $icone = 'ban';
                                $status = 'Desativar';
                            } else {
                                $icone = 'thumbs-up';
                                $status = 'Ativar';
                            }
                            ?>
                            <tr data-id="<?php echo $valor->getId(); ?>">
                                <td><?php echo exibeId($valor->getId()); ?></td>
                                <td><?php echo $valor->getIdAdministradora(); ?></td>
                                <td><?php echo $valor->getNomeFantasia(); ?></td>
                                <td><?php echo $valor->getRazaoSocial(); ?></td>
                                <td><?php echo mascaraDocumento($valor->getCnpjCpf()); ?></td>
                                <td><?php echo exibeId($valor->getObservacoes(), 2); ?></td>
                                <td><?php echo baseToData($valor->getVencimentoFatura()); ?></td>
                                <td style="text-align:right">
                                    <a href="<?php echo URLADM."/financeiro/faturaCliente/alteraCliente?idCliente=" . $valor->getId(); ?>"
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
                    </table>
                </div>
            </div><!-- panel-body -->
            <div class="panel-footer">
                <h5><?php echo exibeId($listados, 3); ?> registros</h5>
            </div>
        </div>
    </div>
</div>
