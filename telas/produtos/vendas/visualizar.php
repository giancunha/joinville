<?php
$indice = '<ul class="letter-list">';
$indice .= '<li title="Topo"><a href="#"><span class="fa fa-arrow-up"></span></a></li>';
$indice .= '<li title="Novo Lançamento"><a href="#novoCadastro" class="novoLancamento">Novo lançamento</a></li>';
$indice .= '<li title="Produtos"><a href="#produtos">Produtos</a></li>';
$indice .= '<li title="Rodapé"><a href="#rodape"><span class="fa fa-arrow-down"></span></a></li>';
$indice .= '</ul>';
?>
<div class="contentpanel">
    <div class="col-sm-12">
        <?php echo $indice; ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title" id="tituloVenda">Vendas</h4>
            </div>
            <div class="panel panel-default col-sm-12">
                <input type="hidden" id="id_venda" name="id_venda" value="0">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-4">
                            <label class="control-label">Produto</label>
                            <select name="id_produtoNovo" class="select2" id="id_produtoNovo">
                                <option value="">Selecione</option>
                                <?php
                                $resultado = Produto::listaPrincipal();
                                foreach($resultado as $chave => $valor){
                                    ?>
                                    <option value="<?php echo $valor->getId(); ?>"><?php echo $valor->getNome(); ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <label class="control-label">Quantidade</label>
                            <input type="number" name="quantidadeNovo" class="form-control" maxlength="3" id="quantidadeNovo" value="1" />
                        </div>
                        <div class="col-sm-2">
                            <p>&nbsp;</p>
                            <button type="button" class="btn btn-primary" id="btnIncluiItem" data-toggle="modal">Inserir Item</button>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-default">
                            <thead>
                            <tr>
                                <th>Item</th>
                                <th>Produto</th>
                                <th>Quantidade</th>
                                <th>Valor Unitário</th>
                                <th>Subtotal</th>
                                <th>Imposto</th>
                                <th>&nbsp;</th>
                            </tr>
                            </thead>
                            <tbody id="listaCompra">

                            </tbody>
                            <tfoot>
                            <tr>
                                <th colspan="4" class="text-right">
                                    Totais:
                                </th>
                                <th id="totalCompra" class="text-right">
                                    R$ 0,00
                                </th>
                                <th id="totalImposto" class="text-right">
                                    R$ 0,00
                                </th>
                                <th>&nbsp;</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div><!-- panel-body -->
                <div class="panel-footer">
                    <button type="submit" class="btn btn-primary" id="btnFinalizaVenda" data-toggle="modal">Finalizar Venda</button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12">
        <a name="produtos"></a>
        <?php echo $indice; ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">Histórico Vendas</h4>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-default">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Dia</th>
                            <th>Hora</th>
                            <th>Status</th>
                            <th>Vendedor</th>
                            <th>Valor</th>
                            <th>&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody id="listaVendas">
                        <tr>
                            <td colspan='6' class='text-center'><i class='fa fa-spinner fa-spin'></i>Carregando o sistema. Aguarde...</td>
                        </tr>
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="6" id="listaVendasFoot" class="text-center">

                            </td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div><!-- panel-body -->
        </div>
    </div>
</div>
<?php echo $indice; ?>
<a name="rodape"></a>
