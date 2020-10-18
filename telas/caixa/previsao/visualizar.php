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
$indice = '<ul class="letter-list">';
$indice .= '<li title="Topo"><a href="#"><span class="fa fa-arrow-up"></span></a></li>';
$indice .= '<li title="Novo Lançamento"><a href="#novoCadastro" class="novoLancamento">Novo lançamento</a></li>';
$indice .= '<li title="Previsões Variáveis"><a href="#variaveis">Variaveis</a></li>';
$indice .= '<li title="Previsões Fixas"><a href="#fixas">Fixas</a></li>';
$indice .= '<li title="Rodapé"><a href="#rodape"><span class="fa fa-arrow-down"></span></a></li>';
$indice .= '</ul>';
?>
<div class="contentpanel">
    <div class="col-sm-12">
        <?php echo $indice; ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">Previsão de Saídas Financeira</h4>
            </div>
            <div class="panel-body">
                <form action="" method="post" id="formFiltro">
                    <div class="row">
                        <div class="col-sm-3">
                            <label class="control-label">Data Inicial</label>
                            <input name="dataInicial" class="form-control data datepicker" value="<?php echo $dataInicial; ?>" id="dataInicial">
                        </div>
                        <div class="col-sm-3">
                            <label class="control-label">Data Final</label>
                            <input name="dataFinal" class="form-control data datepicker" value="<?php echo $dataFinal; ?>" id="dataFinal">
                        </div>
                        <div class="col-sm-1">
                            <br><button type="submit" class="btn btn-primary" data-toggle="modal" name="filtro" value="1">Filtrar</button>
                        </div>
                    </div>
                </form>
            </div><!-- panel-body -->
        </div>
    </div>
    <div class="telacadastro">
        <form action="" method="post" id="formulario">
            <div class="col-sm-12">
                <a name="novoCadastro"></a>
                <?php echo $indice; ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title" id="tituloCadastro">Inserir previsão</h4>
                    </div>
                    <input type="hidden" id="idPrevisao" name="idPrevisao">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <label class="control-label">Tipo de Pagamento</label>
                                <select name="tipoPagamento" class="select2" id="tipoPagamento">
                                    <option value="">Selecione</option>
                                    <option value="V">Variável</option>
                                    <option value="F">Fixo</option>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <label class="control-label">Vencimento <span class="formaPagamento"></span></label>
                                <input name="vencimento" class="form-control data datepicker" value="<?php echo date('d/m/Y'); ?>" id="vencimento">
                            </div>
                            <div class="col-sm-3">
                                <label class="control-label">Categoria</label>
                                <select name="idServico" class="select2" id="idServico">
                                    <option value="">Selecione</option>
                                    <?php
                                    $resultado = Servico::listaPrincipal( 'D' );
                                    foreach($resultado as $chave => $valor){
                                        ?>
                                        <option value="<?php echo $valor->getIdServico(); ?>"><?php echo $valor->getNome(); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <label class="control-label">Valor <span class="formaPagamento"></span></label>
                                <input type="text" name="valor" class="form-control preco" maxlength="8" id="valor" />
                            </div>
                        </div>
                        <div class="mb15"></div>
                        <div class="row">
                            <div class="col-sm-9" id="divDescricao">
                                <label class="control-label">Descrição da previsão</label>
                                <input type="text" name="descricao" class="form-control" maxlength="150" id="descricao" />
                            </div>
                            <div class="col-sm-3" id="divLancamentos">
                                <label class="control-label">Lançamentos</label>
                                <select name="lancamentos" class="select2" id="lancamentos">
                                    <option value="">Selecione</option>
                                    <?php for ($i = 1; $i <= 24; $i++) { ?>
                                        <option value='<?php echo $i; ?>'><?php echo exibeId($i, 2) ?></option>
                                    <?php }	?>
                                </select>
                            </div>
                            <div class="col-sm-3 campoOculto" id="divPeriodicidade">
                                <label class="control-label">Periodicidade</label>
                                <select name="periodicidade" class="select2">
                                    <option value="">Selecione</option>
                                    <option value="10 days"> 10 dias </option>
                                    <option value="15 days"> 15 dias </option>
                                    <option value="20 days"> 20 dias </option>
                                    <option value="1 month" selected> Mensal </option>
                                    <option value="3 months"> Trimestral </option>
                                    <option value="6 months"> Semestral </option>
                                    <option value="1 year"> Anual </option>
                                </select>
                            </div>
                        </div>
                    </div><!-- panel-body -->
                    <div class="panel-footer">
                        <button type="submit" class="btn btn-primary" id="btnIncluiDado" data-toggle="modal" data-secaoPai="<?php echo $gets[0]; ?>" data-secaoFilho="<?php echo $gets[1]; ?>">Cadastrar</button>
                        <button type="submit" class="btn btn-primary campoOculto" id="btnAlteraDado" data-toggle="modal" data-secaoPai="<?php echo $gets[0]; ?>" data-secaoFilho="<?php echo $gets[1]; ?>">Atualizar</button>
                        <div class="alert alert-info">
                            <span class="fa fa-info-circle"></span><br>
                            - Serão listadas apenas categorias setadas como Ambas ou Despesas<br>
                            - Como é uma saída, o sistema irá sempre registrar o valor como negativo.<br>
                            - Em lançamentos deve ser informado quantas vezes se repetirá<br>
                            - Em periodicidade deve ser informado de quanto em quanto tempo se repetirá o lançamento
                        </div>
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
        <a name="variaveis"></a>
        <?php echo $indice; ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">Variáveis</h4>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-default">
                        <thead>
                        <tr>
                            <th>Vencimento</th>
                            <th>Faltam</th>
                            <th>Categoria</th>
                            <th>Descrição</th>
                            <th align="right">Valor</th>
                            <th>&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody id="dadosPrevisaoVariaveis">
                        <tr>
                            <td colspan='6' class='text-center'><i class='fa fa-spinner fa-spin'></i>Carregando o sistema. Aguarde...</td>
                        </tr>
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="6" id="dadosPrevisaoVariaveisFoot" class="text-center">

                            </td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div><!-- panel-body -->
        </div>
    </div>
    <div class="col-sm-12">
        <a name="fixas"></a>
        <?php echo $indice; ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">Fixos</h4>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-default">
                        <thead>
                        <tr>
                            <th>Dia Vencimento</th>
                            <th>Categoria</th>
                            <th>Descrição</th>
                            <th align="right">Valor</th>
                            <th>&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody id="dadosPrevisaoFixas">
                        <tr>
                            <td colspan='6' class='text-center'><i class='fa fa-spinner fa-spin'></i>Carregando o sistema. Aguarde...</td>
                        </tr>
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="6" id="dadosPrevisaoFixasFoot" class="text-center">

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
