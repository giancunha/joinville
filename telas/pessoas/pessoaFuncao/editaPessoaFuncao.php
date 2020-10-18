<?php
$pessoaFuncao = new PessoaFuncao();
$pessoaFuncao->setid($_GET['id']);
$pessoaFuncao->seleciona();
?>
<div class="contentpanel">
    <form action="" method="post" id="formulario">
        <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">Editar Status Agenda > <?php echo $pessoaFuncao->getNome(); ?></h4>
                </div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-4">
                            <label class="control-label">Nome</label>
                            <input type="text" name="nome" class="form-control" maxlength="50" required value="<?php echo $pessoaFuncao->getNome(); ?>" />
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
