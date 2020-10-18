<?php
$icone = new MenuIcone();
$icone->setidMenuIcone($_GET['id']);
$icone->seleciona();
?>
<div class="contentpanel">
    <form action="" method="post" id="formulario">
        <input type="hidden" name="idMenuIcone" value="<?php echo $_GET['id']; ?>" />
        <input type="hidden" name="oldIcone" value="<?php echo $icone->getIcone(); ?>" />
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">Editar Ícone > <div class="btn"><i class="<?php echo $icone->getIcone(); ?>"></i></div></h4>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="control-label">Classe do Ícone</label>
                        <input type="text" name="icone" class="form-control" maxlength="100" required value="<?php echo $icone->getIcone(); ?>">
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
