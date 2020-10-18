<div class="contentpanel">
    <div class="telacadastro">
        <form action="" method="post" id="formulario">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">Novo Menu</h4>
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
                                    <option value="<?php echo $valor->getIdMenu(); ?>"><?php echo $valor->getNome(); ?></option>
                                <? } ?>
                            </select>
                            <label class="control-label">Ordem</label>
                            <input type="text" name="ordem" class="form-control" maxlength="3" required />
                            <label class="control-label">Nome</label>
                            <input type="text" name="nome" class="form-control" maxlength="50" required />
                            <label class="control-label">Descri&ccedil;&atilde;o</label>
                            <input type="text" name="descricao" class="form-control" maxlength="150" required />
                            <label class="control-label">Se&ccedil;&atilde;o</label>
                            <input type="text" name="secao" class="form-control" maxlength="50" required />
                            <label class="control-label">&Iacute;cone</label>
                            <div class="form-control">
                                <?php
                                $resultado = MenuIcone::listaPrincipal();
                                foreach($resultado as $chave => $valor){
                                    ?>
                                    <label title="<?php echo $valor->getIcone(); ?>">
                                        <input type="radio" name="idIcone" value="<?php echo $valor->getIdMenuIcone(); ?>">
                                        <div class="btn"><i class="<?php echo $valor->getIcone(); ?>"></i></div>
                                    </label>
                                    <?php
                                }
                                ?>
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
            <a href="#" class="btn btn-primary btnnewcad">Cadastrar novo</a>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">Menus Cadastrados</h4>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table id="produtosDataTable" class="table table-bordered table-hover table-default">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Ordem</th>
                            <th>&Iacute;cone ou Pai</th>
                            <th>Nome</th>
                            <th>Se&ccedil;&atilde;o</th>
                            <th>&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $listados = 0;
                        $resultado = Menu::listaMenuPais( );
                        foreach($resultado as $chave => $valor){
                            $listados++;
                            ?>
                            <tr title="<?php echo $valor->getDescricao(); ?>">
                                <td><?php echo exibeId($valor->getIdMenu()); ?></td>
                                <td><?php echo exibeId($valor->getOrdem(), 3); ?></td>
                                <td><div class="btn"><i class="<?php echo $valor->getIdIcone(); ?>"></i></div></td>
                                <td><?php echo $valor->getNome(); ?></td>
                                <td><?php echo $valor->getSecao(); ?></td>
                                <td>
                                    <a href="<?php echo URLADM."/".$gets[0]."/".$gets[1]."/edita".ucfirst($gets[1]); ?>/?id=<?php echo $valor->getIdMenu(); ?>" class="btn btn-default"><i class="fa fa-edit"></i> Editar</a>
                                </td>
                            </tr>
                            <?php
                            $resultado2 = Menu::listaMenuFilhos( $valor->getIdMenu() );
                            foreach($resultado2 as $chave2 => $valor2){
                                $listados++;
                                ?>
                                <tr title="<?php echo $valor2->getDescricao(); ?>">
                                    <td><?php echo exibeId($valor2->getIdMenu()); ?></td>
                                    <td><?php echo exibeId($valor2->getOrdem(), 3); ?></td>
                                    <td><?php echo $valor2->getIdMenuPai(); ?></td>
                                    <td><?php echo $valor2->getNome(); ?></td>
                                    <td><?php echo $valor2->getSecao(); ?></td>
                                    <td>
                                        <a href="<?php echo URLADM."/".$gets[0]."/".$gets[1]."/edita".ucfirst($gets[1]); ?>/?id=<?php echo $valor2->getIdMenu(); ?>" class="btn btn-default"><i class="fa fa-edit"></i> Editar</a>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div><!-- panel-body -->
            <div class="panel-footer">
                <h5><?php echo exibeId($listados, 3); ?> menus cadastrados</h5>
            </div>
        </div>
    </div>
</div>
