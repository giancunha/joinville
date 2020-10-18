<?php
$perfil = new Perfil();
$perfil->setidPerfil($_GET['id']);
$perfil->seleciona();
?>
<div class="contentpanel">
    <form action="" method="post" id="formulario">
        <input type="hidden" name="idPerfil" value="<?php echo $_GET['id']; ?>" />
        <input type="hidden" name="nomeOld"value="<?php echo $perfil->getNome(); ?>" />
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">Editar Perfil > <?php echo $perfil->getNome(); ?></h4>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="control-label">Nome</label>
                        <input type="text" name="nome" class="form-control" maxlength="50" required value="<?php echo $perfil->getNome(); ?>" />
                        <label class="control-label">Descrição</label>
                        <input type="text" name="descricao" class="form-control" maxlength="150" required value="<?php echo $perfil->getDescricao(); ?>" />
                        <label class="control-label">Permissões:</label>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-default">
                                <thead>
                                <tr>
                                    <th>Nome</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $resultado = PerfilMenu::listaPerfilMenuPai( $perfil->getIdPerfil() );
                                foreach($resultado as $chave => $valor){
                                    $marcado = '';
                                    ?>
                                    <tr title="<?php echo $valor->getDescricao(); ?>">
                                        <td>
                                            <?php
                                            if($valor->getIdPerfilMenu() > 0){
                                                $marcado = ' checked';
                                                ?>
                                                <input type='hidden' name='oldMenu<?php echo $valor->getIdMenu(); ?>' value='on'>
                                                <?php
                                            }
                                            ?>
                                            <input type="checkbox" name="menu<?php echo $valor->getIdMenu(); ?>"<?php echo $marcado; ?>>
                                            <div class="btn">
                                                <i class="<?php echo $valor->getIdIcone(); ?>"></i>
                                            </div>
                                            <?php echo $valor->getNome(); ?>
                                        </td>
                                    </tr>
                                    <?php
                                    $resultado2 = PerfilMenu::listaPerfilMenuFilho( $valor->getIdMenu(), $perfil->getIdPerfil() );
                                    foreach($resultado2 as $chave2 => $valor2){
                                        $marcado = '';
                                        ?>
                                        <tr title="<?php echo $valor->getDescricao(); ?>">
                                            <td>
                                                &nbsp;
                                                <?php
                                                if($valor2->getIdPerfilMenu() > 0){
                                                    $marcado = ' checked';
                                                    ?>
                                                    <input type='hidden' name='oldMenu<?php echo $valor2->getIdMenu(); ?>' value='on'>
                                                    <?php
                                                }
                                                ?>
                                                <input type="checkbox" name="menu<?php echo $valor2->getIdMenu(); ?>"<?php echo $marcado; ?>>
                                                <?php echo $valor2->getNome(); ?>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                }
                                ?>
                                </tbody>
                            </table>
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
