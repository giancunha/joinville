<div class="contentpanel">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">Cancelar Fatura</h4>
            </div>
            <div class="panel-body">
                <form action="" method="post" id="formulario">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="alert alert-danger">
                                <strong>Atenção!</strong><br>
                                Seguem informações sobre o cancelamento da fatura:<br>
                                1 - O status da fatura será alterado para Cancelado<br>
                                2 - A fatura não aparecerá mais na tela de faturas do cliente<br>
                                3 - Será registrado o dia e hora que foi efetuado o cancelamento da fatura<br>
                                4 - Será registrado o usuário solicitante do cancelamento<br>
                                5 - Se houver, será excluído o arquivo do boleto<br>
                                6 - Se houver, será excluído o arquivo da nota<br>
                                <b>Após concluída a operação, ela não poderá ser desfeita!</b>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <label class="control-label">Número da Fatura</label>
                            <input type="number" name="idFatura" class="form-control" />
                        </div>
                        <div class="col-sm-2">
                            <br><button type="submit" class="btn btn-primary" id="btnAlteraDado" data-toggle="modal" data-secaoPai="<?php echo $gets[0]; ?>" data-secaoFilho="<?php echo $gets[1]; ?>">Excluir Fatura</button>
                        </div>
                    </div>
                </form>
            </div><!-- panel-body -->
            <div class="panel-body">
                <div class="table-responsive" id='imprimirTabela'>
                    <table class="table table-bordered table-hover table-default">
                        <thead>
                        <tr>
                            <th>Data</th>
                            <th>Responsável</th>
                            <th>Número Fatura</th>
                            <th>Cliente</th>
                            <th>Serviço</th>
                            <th align="right">Valor</th>
                            <th>&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody class="dadosBD">
                        <?php
                        $listados = 0;
                        $fatura = new Fatura();
                        $resultado = $fatura->listaCanceladas();
                        foreach($resultado as $chave => $valor){
                            $listados++;
                            ?>
                            <tr>
                                <td><?php echo $valor->getPagamento(); ?></td>
                                <td><?php echo $valor->getIdUsuario(); ?></td>
                                <td><?php echo exibeId($valor->getId()); ?></td>
                                <td><?php echo $valor->getIdCliente(); ?></td>
                                <td><?php echo $valor->getStatus(); ?></td>
                                <td align="right">R$ <?php echo preco($valor->getValor()); ?></td>
                                <td>
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
