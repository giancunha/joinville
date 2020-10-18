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
    $ano = date('Y');
    $mes = date('m');
    $mes = $mes + 6;
    if($mes > 12){
        $mes = $mes - 12;
        $ano++;
    }
    $mes = exibeId($mes, 2);
    $dataFinal = date("$ultimoDia/$mes/$ano");
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
                <div class="mb30"></div>
                <div class="row">
                    <div class="col-md-12 mb30">
                        <h5 class="subtitle">Gráfico Previsão Entradas</h5>
                        <p>Aqui será exibido a previsão de entradas por periodo, agrupados por categoria.</p>
                        <div id="bar-chart" class="body-chart"></div>
                    </div>
                </div><!-- row -->
            </div>
        </div>
    </div>
</div>
<?php
$resultado = new Fatura();
$resultado = $resultado->listaGraficoPrevisao( $dataInicial, $dataFinal );
foreach($resultado as $chave => $valor){
    $data = $valor->getVencimento();
    $data = explode("/", $data);
    list($dia, $mes, $ano) = $data;
    $periodo = "$mes/$ano";
    $dados[$periodo]['periodo'] = $periodo;
    $dados[$periodo][$valor->getNumeroNota()] = decimalToBase($valor->getValor());
    $labels[$valor->getNumeroNota()] = $valor->getStatus();
}
$barras = array();
foreach($dados as $chave => $dado) {
    $barras[] = $dado;
}
?>
<script>
    var previsao = <?php echo json_encode($barras); ?>;
    var yKeys = <?php echo json_encode(array_keys($labels)); ?>;
    var labels = <?php echo json_encode(array_values($labels)); ?>;
</script>
