<?php
if(!isset($_SESSION['filtro']['idCliente'])){
    $_SESSION['filtro']['idCliente'] = '1';
}
$idCliente = $_SESSION['filtro']['idCliente'];
$cliente = new Cliente();
$cliente->setId($idCliente);
$cliente->seleciona();
$dadosCliente = $cliente->getRazaoSocial() . " " . $cliente->getCnpjCpf();
$enviaNota = $cliente->getEnviaNota();
$caminhoNota = '../uploads/notas/';
?>
<div class="contentpanel">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <?php echo $dadosCliente; ?>
                    <a href="javascript:;"
                       class="btn btn-default copiarCampo"
                       title="Copiar documento cliente"
                       data-clipboard-text="<?php echo soNumero($cliente->getCnpjCpf()); ?>"
                       data-nomeCampo="Documento"
                    >
                        <i class="fa fa-id-card"></i>
                    </a>
                </h4>
            </div>
            <div class="panel-body">
                <form action="<?php echo URLADM."/".$gets[0]."/".$gets[1]."/alteraCliente"; ?>" method="post">
                    <input type="hidden" name="secaoPai" value="<?php echo $gets[0]; ?>" />
                    <input type="hidden" name="secaoFilho" value="<?php echo $gets[1]; ?>" />
                    <div class="row">
                        <div class="col-sm-2">
                            <label class="control-label">ID</label>
                            <input type="text" class="form-control" readonly value="<?php echo exibeId($cliente->getId()); ?>" />
                        </div>
                        <div class="col-sm-4">
                            <label class="control-label">NomeFantasia Fantasia:</label>
                            <input type="text" class="form-control" readonly value="<?php echo $cliente->getNomeFantasia(); ?>" />
                        </div>
                        <div class="col-sm-3">
                            <label class="control-label">CNPJ/CPF:</label>
                            <input type="text" class="form-control" readonly value="<?php echo $cliente->getCnpjCpf(); ?>" />
                        </div>
                        <div class="col-sm-3">
                            <label class="control-label">Telefone:</label>
                            <input type="text" class="form-control" readonly value="<?php echo $cliente->getTelefone(); ?>" />
                        </div>
                    </div>
                    <div class="mb15"></div>
                    <div class="row">
                        <div class="col-sm-10">
                            <label class="control-label">Cliente</label>
                            <select name="idCliente" id="idCliente" class="select2">
                                <?php
                                $resultado = Cliente::listaPrincipal( );
                                foreach($resultado as $chave => $valor){
                                    ?>
                                    <option value="<?php echo $valor->getId(); ?>"<?php if($valor->getId() == $_SESSION['filtro']['idCliente']){ echo " selected"; } ?>>
                                        <?php echo "(".exibeId($valor->getId(), 4).") - ".$valor->getNomeFantasia()." - ".$valor->getRazaoSocial()." - ".$valor->getCnpjCpf()." - ".$valor->getTelefone(); ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <label class="control-label">&nbsp;</label>
                            <input type="submit" class="form-control btn btn-primary" value="Alterar">
                        </div>
                    </div>
            </div><!-- panel-body -->
            </form>
        </div>
    </div>
</div>
<div class="contentpanel">
    <div class="telacadastro">
        <form action="" method="post" id="formulario">
            <input type="hidden" name="idCliente" value="<?php echo $idCliente; ?>" />
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">Inserir serviços à fatura</h4>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <label class="control-label">Vencimento</label>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <select name="diaVencimento" class="select2">
                                            <?php
                                            for ($i = 1; $i <= 30; $i++) {
                                                if($cliente->getVencimentoFatura() != $i){
                                                    $selecionado = NULL;
                                                } else {
                                                    $selecionado = ' selected';
                                                }
                                                ?>
                                                <option value='<?php echo $i; ?>'<?php echo $selecionado; ?>><?php echo exibeId($i, 2) ?></option>
                                            <?php }	?>
                                        </select>
                                    </div>
                                    <div class="col-sm-6">
                                        <select name="mesVencimento" class="select2">
                                            <?php
                                            for ($i = 1; $i <= 12; $i++) {
                                                if(date('m') != $i-1){
                                                    $selecionado = NULL;
                                                } else {
                                                    $selecionado = ' selected';
                                                }
                                                ?>
                                                <option value='<?php echo $i; ?>'<?php echo $selecionado; ?>><?php echo qualMes($i); ?></option>
                                            <?php }	?>
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <select name="anoVencimento" class="select2">
                                            <option value="<?php $ano = date('Y'); echo $ano - 1; ?>"><?php echo $ano - 1; ?></option>
                                            <option selected value="<?php echo $ano; ?>"><?php echo $ano; ?></option>
                                            <option value="<?php echo $ano + 1; ?>"><?php echo $ano + 1; ?></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <label class="control-label">Serviço</label>
                                <select name="idServico" class="select2">
                                    <option value="">Selecione</option>
                                    <?php
                                    $resultado = Servico::listaPrincipal( 'R' );
                                    foreach($resultado as $chave => $valor){
                                        ?>
                                        <option value="<?php echo $valor->getIdServico(); ?>"><?php echo $valor->getNome(); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label class="control-label">Valor</label>
                                <input type="text" name="valor" class="form-control preco" maxlength="8" />
                            </div>
                        </div>
                        <div class="mb15"></div>
                        <div class="row">
                            <div class="col-sm-6">
                                <label class="control-label">Descrição</label>
                                <input type="text" name="descricao" class="form-control" maxlength="150" />
                            </div>
                            <div class="col-sm-3">
                                <label class="control-label">Lançamentos</label>
                                <select name="lancamentos" class="select2">
                                    <?php for ($i = 1; $i <= 12; $i++) { ?>
                                        <option value='<?php echo $i; ?>'><?php echo exibeId($i, 2) ?></option>
                                    <?php }	?>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <label class="control-label">Periodicidade</label>
                                <select name="periodicidade" class="select2">
                                    <option value="1"> Mensal </option>
                                    <option value="3"> Trimestral </option>
                                    <option value="6"> Semestral </option>
                                    <option value="12"> Anual </option>
                                </select>
                            </div>
                        </div>
                    </div><!-- panel-body -->
                    <div class="panel-footer">
                        <button type="submit" class="btn btn-primary" id="btnIncluiDado" data-toggle="modal" data-secaoPai="<?php echo $gets[0]; ?>" data-secaoFilho="<?php echo $gets[1]; ?>">Cadastrar</button>
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
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">Faturas em aberto - <?php echo $dadosCliente; ?></h4>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-default">
                        <thead>
                        <tr>
                            <th>Cód. Fatura</th>
                            <th>Vencimento</th>
                            <th>Faltam</th>
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
                        $resultado = $resultado->listaAbertas( $idCliente );
                        $listados = $totalFaturas = 0;
                        foreach($resultado as $chave => $valor){
                            $totalFaturas+= decimalToBase($valor->getValor());
                            $listados++;
                            $cidade = new Cidade();
                            $cidade->setIdCidade( $cliente->getIdCidade() );
                            $cidade->seleciona();
                            $estado = new Estado();
                            $estado->setIdEstado( $cliente->getIdEstado() );
                            $estado->seleciona();

                            $idFatura = $valor->getId();
                            $resultado2 = new FaturaItem();
                            $resultado2 = $resultado2->listaItens( $idFatura );
                            $descricaoFatura = NULL;
                            foreach($resultado2 as $chave2 => $valor2) {
                                $descricaoFatura .= $valor2->getIdServico() . ' ' . $valor2->getDescricao() . ' ' . $valor2->getValor() . "\n";
                                $valorBoleto = $valor->getValor();
                                if($cidade->getIdCidade() == 3932 and $valor2->getIdServico() == 'Manutenção' and $enviaNota == 1){
                                    $valorBoleto = preco(decimalToBase($valorBoleto) * 0.98);
                                }
                            }
                            $temBoleto = $temNota = false;
                            ?>
                            <tr valign='middle'>
                                <td><?php echo exibeId($valor->getId()); ?></td>
                                <td><?php echo $valor->getVencimento(); ?></td>
                                <td><?php echo diasVencimento($valor->getVencimento()); ?></td>
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
                                                data-secaoPai="<?php echo $gets[0]; ?>"
                                                data-secaoFilho="<?php echo $gets[1]; ?>"
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
                                       title="Liquidar"
                                       data-toggle="modal"
                                       data-target=".bs-example-modal-lg"
                                       data-acao="liquida"
                                       data-tituloModal="Liquidar Fatura <?php echo exibeId($valor->getId(), 5); ?>"
                                       data-id="<?php echo $valor->getId(); ?>"
                                       data-secaoPai="<?php echo $gets[0]; ?>"
                                       data-secaoFilho="<?php echo $gets[1]; ?>">
                                        <i class="fa fa-money"></i>
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
                                       href="<?php echo URLADM; ?>/telas/<?php echo $gets[0]; ?>/<?php echo $gets[1]; ?>/envia<?php echo ucfirst($gets[1]); ?>.php?id=<?php echo $valor->getId(); ?>"
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
                                       data-secaoPai="<?php echo $gets[0]; ?>"
                                       data-secaoFilho="<?php echo $gets[1]; ?>"
                                    >
                                        <i class="fa fa-list"></i>
                                    </a>
                                    <a class="btn btn-default abreModal"
                                       title="Editar"
                                       data-toggle="modal"
                                       data-target=".bs-example-modal-lg"
                                       data-acao="edita"
                                       data-tituloModal="Fatura <?php echo exibeId($valor->getId(), 5); ?> - Edição"
                                       data-id="<?php echo $valor->getId(); ?>"
                                       data-secaoPai="<?php echo $gets[0]; ?>"
                                       data-secaoFilho="<?php echo $gets[1]; ?>"
                                    >
                                        <i class="fa fa-edit"></i>
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
                                <?php echo exibeId($listados, 3); ?> faturas totalizando R$ <?php echo baseToDecimal($totalFaturas); ?>
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div><!-- panel-body -->
        </div>
    </div>
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">Faturas enviadas - <?php echo $dadosCliente; ?></h4>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-default">
                        <thead>
                        <tr>
                            <th>Cód. Fatura</th>
                            <th>Vencimento</th>
                            <th>Faltam</th>
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
                        $resultado = $resultado->listaEnviadas( $idCliente );
                        $listados = $totalFaturas = 0;
                        foreach($resultado as $chave => $valor){
                            $totalFaturas+= decimalToBase($valor->getValor());
                            $listados++;
                            $cidade = new Cidade();
                            $cidade->setIdCidade( $cliente->getIdCidade() );
                            $cidade->seleciona();
                            $estado = new Estado();
                            $estado->setIdEstado( $cliente->getIdEstado() );
                            $estado->seleciona();

                            $idFatura = $valor->getId();
                            $resultado2 = new FaturaItem();
                            $resultado2 = $resultado2->listaItens( $idFatura );
                            $descricaoFatura = NULL;
                            foreach($resultado2 as $chave2 => $valor2) {
                                $descricaoFatura .= $valor2->getIdServico() . ' ' . $valor2->getDescricao() . ' ' . $valor2->getValor() . "\n";
                                $valorBoleto = $valor->getValor();
                                if($cidade->getIdCidade() == 3932 and $valor2->getIdServico() == 'Manutenção' and $enviaNota == 1){
                                    $valorBoleto = preco(decimalToBase($valorBoleto) * 0.98);
                                }
                            }
                            $temBoleto = $temNota = false;
                            ?>
                            <tr valign='middle'>
                                <td><?php echo exibeId($valor->getId()); ?></td>
                                <td><?php echo $valor->getVencimento(); ?></td>
                                <td><?php echo diasVencimento($valor->getVencimento()); ?></td>
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
                                                data-secaoPai="<?php echo $gets[0]; ?>"
                                                data-secaoFilho="<?php echo $gets[1]; ?>"
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
                                       title="Liquidar"
                                       data-toggle="modal"
                                       data-target=".bs-example-modal-lg"
                                       data-acao="liquida"
                                       data-tituloModal="Liquidar Fatura <?php echo exibeId($valor->getId(), 5); ?>"
                                       data-id="<?php echo $valor->getId(); ?>"
                                       data-secaoPai="<?php echo $gets[0]; ?>"
                                       data-secaoFilho="<?php echo $gets[1]; ?>">
                                        <i class="fa fa-money"></i>
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
                                       href="<?php echo URLADM; ?>/telas/<?php echo $gets[0]; ?>/<?php echo $gets[1]; ?>/envia<?php echo ucfirst($gets[1]); ?>.php?id=<?php echo $valor->getId(); ?>"
                                       target="_blank"
                                       title="Reenviar fatura Nº <?= exibeId($valor->getId(), 6); ?>"
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
                                       data-secaoPai="<?php echo $gets[0]; ?>"
                                       data-secaoFilho="<?php echo $gets[1]; ?>"
                                    >
                                        <i class="fa fa-list"></i>
                                    </a>
                                    <a class="btn btn-default abreModal"
                                       title="Editar"
                                       data-toggle="modal"
                                       data-target=".bs-example-modal-lg"
                                       data-acao="edita"
                                       data-tituloModal="Fatura <?php echo exibeId($valor->getId(), 5); ?> - Edição"
                                       data-id="<?php echo $valor->getId(); ?>"
                                       data-secaoPai="<?php echo $gets[0]; ?>"
                                       data-secaoFilho="<?php echo $gets[1]; ?>"
                                    >
                                        <i class="fa fa-edit"></i>
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
                                <?php echo exibeId($listados, 3); ?> faturas totalizando R$ <?php echo baseToDecimal($totalFaturas); ?>
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div><!-- panel-body -->
        </div>
    </div>
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">Faturas liquidadas - <?php echo $dadosCliente; ?></h4>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-default">
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
                        $resultado = new Fatura();
                        $resultado = $resultado->listaLiquidadas( $idCliente );
                        $listados = $totalFaturas = 0;
                        foreach($resultado as $chave => $valor){
                            $idFatura = $valor->getId();
                            $totalFaturas+= decimalToBase($valor->getValor());
                            $listados++;
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
                        <tfoot>
                        <tr>
                            <td colspan="6">
                                <?php echo exibeId($listados, 3); ?> faturas totalizando R$ <?php echo baseToDecimal($totalFaturas); ?>
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div><!-- panel-body -->
        </div>
    </div>
</div>
