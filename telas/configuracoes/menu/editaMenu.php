<?php
$menu = new Menu();
$menu->setidMenu($_GET['id']);
$menu->seleciona();
?>
<div class="contentpanel">
    <form action="" method="post" id="formulario">
        <input type="hidden" name="idMenu" value="<?php echo $_GET['id']; ?>" />
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">Editar Menu > <?php echo $menu->getNome(); ?></h4>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="control-label">Menu Pai</label>
                        <select class="select2 form-control" name="idMenuPai" required>
                            <option value="1" selected>_Raiz</option>
                            <?php
                            $resultado = Menu::listaMenuPais( );
                            foreach($resultado as $chave => $valor){
                                ?>
                                <option value="<?php echo $valor->getIdMenu(); ?>"<?php if($valor->getIdMenu() == $menu->getIdMenuPai()) { echo " selected"; } ?>><?php echo $valor->getNome(); ?></option>
                            <? } ?>
                        </select>
                        <label class="control-label">Ordem</label>
                        <input type="text" name="ordem" class="form-control" maxlength="3" required value="<?php echo $menu->getOrdem(); ?>" />
                        <label class="control-label">Nome</label>
                        <input type="text" name="nome" class="form-control" maxlength="50" required value="<?php echo $menu->getNome(); ?>" />
                        <label class="control-label">Descri&ccedil;&atilde;o</label>
                        <input type="text" name="descricao" class="form-control" maxlength="150" required value="<?php echo $menu->getDescricao(); ?>" />
                        <label class="control-label">Se&ccedil;&atilde;o</label>
                        <input type="text" name="secao" class="form-control" maxlength="50" required value="<?php echo $menu->getSecao(); ?>" />
                        <label class="control-label">&Iacute;cone</label>
                        <div class="form-control">
                            <?php
                            $resultado = MenuIcone::listaPrincipal( );
                            foreach($resultado as $chave => $valor){
                                ?>
                                <label title="<?php echo $valor->getIcone(); ?>">
                                    <input type="radio" name="idIcone" value="<?php echo $valor->getIdMenuIcone(); ?>"<?php if($valor->getIdMenuIcone() == $menu->getIdIcone()) { echo " checked"; } ?>>
                                    <div class="btn"><i class="<?php echo $valor->getIcone(); ?>"></i></div>
                                </label>
                                <?php
                            }
                            ?>
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
