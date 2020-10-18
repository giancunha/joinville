<div class="contentpanel">
    <div class="telacadastro">
        <form action="" method="post" id="formulario">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">Novo Perfil</h4>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="control-label">Nome</label>
                            <input type="text" name="nome" class="form-control" maxlength="50" required />
                            <label class="control-label">Descri&ccedil;&atilde;o</label>
                            <input type="text" name="descricao" class="form-control" maxlength="150" required />
                            <label class="control-label">Permissões:</label>
                            <div class="table-responsive">
                                <table id="produtosDataTable" class="table table-bordered table-hover table-default">
                                    <thead>
                                    <tr>
                                        <th>Nome</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $resultado = Menu::listaMenuPais(  );
                                    foreach($resultado as $chave => $valor){
                                        ?>
                                        <tr title="<?php echo $valor->getDescricao(); ?>">
                                            <td>
                                                <input type="checkbox" name="menu<?php echo $valor->getIdMenu(); ?>">
                                                <div class="btn">
                                                    <i class="<?php echo $valor->getIdIcone(); ?>"></i>
                                                </div>
                                                <?php echo $valor->getNome(); ?>
                                            </td>
                                        </tr>
                                        <?php
                                        $resultado2 = Menu::listaMenuFilhos( $valor->getIdMenu() );
                                        foreach($resultado2 as $chave2 => $valor2){
                                            ?>
                                            <tr title="<?php echo $valor->getDescricao(); ?>">
                                                <td>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="checkbox" name="menu<?php echo $valor2->getIdMenu(); ?>">
                                                    <?php echo $valor2->getNome(); ?></blockquote>
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
                        <button type="submit" class="btn btn-primary" id="btnIncluiDado" data-toggle="modal" data-secaoPai="<?php echo $gets[0]; ?>" data-secaoFilho="<?php echo $gets[1]; ?>">Cadastrar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="btncadastro col-sm-12">
        <div class="panel panel-default">
            <a href="#" class="btn btn-primary btnnewcad">Cadastrar um novo Perfil</a>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">Perfis Cadastrados</h4>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-default">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Perfil</th>
                            <th>Descrição</th>
                            <th>&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $resultado = Perfil::listaPrincipal( );
                        $listados = 0;
                        foreach($resultado as $chave => $valor){
                            $listados++;
                            ?>
                            <tr data-id="<?php echo $valor->getIdPerfil(); ?>">
                                <td><?php echo exibeId($valor->getIdPerfil()); ?></td>
                                <td><?php echo $valor->getNome(); ?></td>
                                <td><?php echo $valor->getDescricao(); ?></td>
                                <td style="text-align:right">
                                    <a href="<?php echo URLADM."/".$gets[0]."/".$gets[1]."/edita".ucfirst($gets[1]); ?>/?id=<?php echo $valor->getIdPerfil(); ?>" class="btn btn-default" title="Editar"><i class="fa fa-edit"></i></a>
                                    <a href="#" class="btn btn-default excluiDado" data-secaoPai="<?php echo $gets[0]; ?>" data-secaoFilho="<?php echo $gets[1]; ?>" data-id="<?php echo $valor->getIdPerfil(); ?>" title="Excluir"><i class="fa fa-trash-o"></i></a>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="panel-footer">
                <h5><?php echo exibeId($listados, 3); ?> perfis cadastrados</h5>
            </div>
        </div>
    </div>
</div>
