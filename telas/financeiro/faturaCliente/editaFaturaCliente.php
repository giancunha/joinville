<?php
include('../../../config/includes.php');
$fatura = new Fatura();
$fatura->setId($_POST['id']);
$fatura->seleciona();
$idFatura = exibeId($fatura->getId(), 6);
$idCliente = $fatura->getIdCliente();
?>
<div class="contentpanel">
    <form action="<?php echo URLADM; ?>/telas/financeiro/faturaCliente/alteraFatura.php" method="post">
        <input type="hidden" name="idFatura" value="<?php echo $fatura->getId(); ?>" />
        <input type="hidden" name="vencimentoAntigo" value="<?php echo $fatura->getVencimento(); ?>" />
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-4">
                            <label class="control-label">Vencimento Fatura</label>
                            <input type="text" name="vencimento" class="form-control data" maxlength="10" value="<?php echo $fatura->getVencimento(); ?>" />
                        </div>
                    </div>
                </div><!-- panel-body -->
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="panel-heading">
                                <h4 class="panel-title">Itens Fatura</h4>
                            </div>
                            <?php
                            $faturaItem = new FaturaItem();
                            $faturaItem = $faturaItem->listaItens( $idFatura );
                            ?>
                            <table class="table table-bordered table-hover table-default display">
                                <thead>
                                <tr>
                                    <th>Serviço</th>
                                    <th>Descrição</th>
                                    <th>Valor</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $valorFatura = 0;
                                foreach($faturaItem as $chave => $valor){
                                    $valorFatura += decimalToBase($valor->getValor());
                                    ?>
                                    <tr>
                                        <td>
                                            <select name="idServico<?php echo $valor->getId(); ?>">
                                                <option value="">Selecione</option>
                                                <?php
                                                $resultado = Servico::listaPrincipal( 'R' );
                                                foreach($resultado as $chave => $valor2){
                                                    ?>
                                                    <option value="<?php echo $valor2->getIdServico(); ?>"<?php if($valor2->getNome() == $valor->getIdServico()){ echo " selected"; } ?>><?php echo $valor2->getNome(); ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td><input name="descricao<?php echo $valor->getId(); ?>" type="text" maxlength="100" value="<?php echo $valor->getDescricao(); ?>" /></td>
                                        <td><input name="valor<?php echo $valor->getId(); ?>" type="text" onKeyPress="return verificacampo(true,false,'-.,')" value="<?php echo $valor->getValor(); ?>" /></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                <tr>
                                    <td align="right" colspan="4"><b>Total: </b> R$ <?php echo number_format($valorFatura, 2, ',', '.'); ?></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <button type="submit" class="btn btn-primary">Atualizar</button>
                    <button type="reset" class="btn btn-default" title="Desfazer alterações">Desfazer</button>
                    <button data-dismiss="modal" class="btn btn-default">Voltar</button>
                </div>
            </div>
        </div>
    </form>
</div>
