<?php
$servico = new Servico();
$servico->setidServico($_GET['id']);
$servico->seleciona();
?>
<div class="contentpanel">
    <form action="" method="post" id="formulario">
        <input type="hidden" name="idServico" value="<?php echo $_GET['id']; ?>" />
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">Editar > <?php echo $servico->getNome(); ?></h4>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-3">
                            <label class="control-label">Natureza</label>
                            <select name="natureza" class="select2" required>
                                <option value=""> Selecione </option>
                                <option value="R"<?php if($servico->getNatureza() == 'R'){ echo ' selected'; } ?>> Receita </option>
                                <option value="D"<?php if($servico->getNatureza() == 'D'){ echo ' selected'; } ?>> Despesa </option>
                                <option value="A"<?php if($servico->getNatureza() == 'A'){ echo ' selected'; } ?>> Ambas </option>
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <label class="control-label">Nome</label>
                            <input type="text" name="nome" class="form-control" maxlength="50" required value="<?php echo $servico->getNome(); ?>" />
                        </div>
                        <div class="col-sm-6">
                            <label class="control-label">Descrição</label>
                            <input type="text" name="descricao" class="form-control" value="<?php echo $servico->getDescricao(); ?>" />
                        </div>
                    </div>
                </div><!-- panel-body -->
                <div class="panel-footer">
                    <button type="submit" class="btn btn-primary" id="btnAlteraDado" data-toggle="modal" data-secaoPai="<?php echo $gets[0]; ?>" data-secaoFilho="<?php echo $gets[1]; ?>">Atualizar</button>
                    <a href="javascript: history.go(-1);" class="btn btn-default">Voltar</a>
                </div>
            </div>
        </div>
    </form>
</div>
