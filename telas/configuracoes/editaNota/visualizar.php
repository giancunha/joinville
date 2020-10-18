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
                                Seguem informações sobre a alteração da nota:<br>
                                1 - Ao sair do campo de inserção do número da fatura, o sistema carregará seus dados<br>
                                2 - O sistema informará o valor bruto da fatura<br>
                                3 - O sistema <b>não</b> vai validar se a nota já foi ou não enviada<br>
                                4 - Será registrado o dia e hora que foi efetuado a troca da nota<br>
                                5 - Será registrado o usuário solicitante da troca<br>
                                6 - Se houver, será excluído o arquivo da nota anterior<br>
                                7 - O sistema vai guardar a nova nota para envios futuros<br>
                                8 - O sistema irá substituir a nota individualmente, mesmo que seja anteriormente agrupada<br>
                                <b>Após concluída a operação, ela não poderá ser desfeita!</b>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2">
                            <label class="control-label">Número da Fatura</label>
                            <input type="number" name="idFatura" id="idFatura" class="form-control" />
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label">Número nota</label>
                                <input class="form-control" type="text" id="numeroNota" name="numeroNota" placeholder="Número Nota" required />
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label">Arquivo nota</label>
                                <input class="form-control" type="file" id="nota" name="nota" required />
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <br><button type="submit" class="btn btn-primary" id="btnAlteraDado" data-toggle="modal" data-secaoPai="<?php echo $gets[0]; ?>" data-secaoFilho="<?php echo $gets[1]; ?>">Editar Nota</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2">
                            <label class="control-label">Valor</label>
                            <input type="text" id="valor" class="form-control preco" maxlength="8" disabled />
                        </div>
                        <div class="col-sm-4">
                            <label class="control-label">Cliente</label>
                            <input type="text" id="cliente" class="form-control" disabled />
                        </div>
                        <div class="col-sm-3">
                            <label class="control-label">Serviço</label>
                            <input type="text" id="servico" class="form-control" disabled />
                        </div>
                        <div class="col-sm-3">
                            <label class="control-label">Descrição</label>
                            <input type="text" id="descricao" class="form-control" maxlength="150" disabled />
                        </div>
                    </div>
                </form>
                <div class="col-sm-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">Faturas com notas já alteradas</h4>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover table-default">
                                    <thead>
                                    <tr>
                                        <th>Data</th>
                                        <th>Responsável</th>
                                        <th>Número Fatura</th>
                                        <th>Cliente</th>
                                        <th>Serviço</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                    </thead>
                                    <tbody id="dadosNotaTrocadas">
                                    <tr>
                                        <td colspan='6' class='text-center'><i class='fa fa-spinner fa-spin'></i>Carregando o sistema. Aguarde...</td>
                                    </tr>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td colspan="6" id="dadosNotaTrocadasFoot" class="text-center">

                                        </td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div><!-- panel-body -->
                    </div>
                </div>
            </div><!-- panel-body -->
        </div>
    </div>
</div>

