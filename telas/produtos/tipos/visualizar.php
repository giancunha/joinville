<?php
$indice = '<ul class="letter-list">';
$indice .= '<li title="Topo"><a href="#"><span class="fa fa-arrow-up"></span></a></li>';
$indice .= '<li title="Novo Lançamento"><a href="#novoCadastro" class="novoLancamento">Novo lançamento</a></li>';
$indice .= '<li title="Tipos"><a href="#tipos">Tipos</a></li>';
$indice .= '<li title="Rodapé"><a href="#rodape"><span class="fa fa-arrow-down"></span></a></li>';
$indice .= '</ul>';
?>
<div class="contentpanel">
    <div class="col-sm-12">
        <?php echo $indice; ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">Tipos de Produtos</h4>
            </div>
        </div>
    </div>
    <div class="telacadastro">
        <form action="" method="post" id="formulario">
            <div class="col-sm-12">
                <a name="novoCadastro"></a>
                <?php echo $indice; ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title" id="tituloCadastro">Inserir tipo</h4>
                    </div>
                    <input type="hidden" id="idProdutoTipo" name="idProdutoTipo">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-9">
                                <label class="control-label">Nome Tipo</label>
                                <input type="text" name="tipo" class="form-control" maxlength="150" id="tipo" />
                            </div>
                            <div class="col-sm-3">
                                <label class="control-label">Imposto</label>
                                <input type="text" name="imposto" class="form-control imposto" maxlength="8" id="imposto" />
                            </div>
                        </div>
                    </div><!-- panel-body -->
                    <div class="panel-footer">
                        <button type="submit" class="btn btn-primary" id="btnIncluiDado" data-toggle="modal" data-secaoPai="<?php echo $gets[0]; ?>" data-secaoFilho="<?php echo $gets[1]; ?>">Cadastrar</button>
                        <button type="submit" class="btn btn-primary campoOculto" id="btnAlteraDado" data-toggle="modal" data-secaoPai="<?php echo $gets[0]; ?>" data-secaoFilho="<?php echo $gets[1]; ?>">Atualizar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="btncadastro col-sm-12">
        <div class="panel panel-default">
            <a href="#" class="btn btn-primary btnnewcad">Novo Lançamento</a>
        </div>
    </div>
    <div class="col-sm-12">
        <a name="tipos"></a>
        <?php echo $indice; ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">Tipos</h4>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-default">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tipo</th>
                            <th>Imposto</th>
                            <th>&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody id="dadosProdutoTipo">
                        <tr>
                            <td colspan='6' class='text-center'><i class='fa fa-spinner fa-spin'></i>Carregando o sistema. Aguarde...</td>
                        </tr>
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="6" id="dadosProdutoTipoFoot" class="text-center">

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
