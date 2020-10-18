<div class="contentpanel">
    <form action="" method="post" id="formulario">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">Novo Ícone</h4>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="control-label">Classe do Ícone</label>
                        <input type="text" name="icone" class="form-control" maxlength="100" required />
                    </div>
                </div><!-- panel-body -->
                <div class="panel-footer">
                    <button type="submit" class="btn btn-primary" id="btnIncluiDado" data-toggle="modal" data-secaoPai="<?php echo $gets[0]; ?>" data-secaoFilho="<?php echo $gets[1]; ?>">Cadastrar</button>
                </div>
            </div>
        </div>
    </form>
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">Ícones Cadastrados</h4>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table id="produtosDataTable" class="table table-bordered table-hover table-default">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Icone</th>
                            <th>Imagem</th>
                            <th>&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $listados = 0;
                        $resultado = MenuIcone::listaPrincipal( );
                        foreach($resultado as $chave => $valor){
                            $listados++;
                            ?>
                            <tr data-id="<?php echo $valor->getIdMenuIcone(); ?>">
                                <td><?php echo exibeId($valor->getIdMenuIcone()); ?></td>
                                <td><?php echo $valor->getIcone(); ?></td>
                                <td><div class="btn"><i class="<?php echo $valor->getIcone(); ?>"></i></div></td>
                                <td>
                                    <a
                                        href="<?php echo URLADM."/".$gets[0]."/".$gets[1]."/edita".ucfirst($gets[1]); ?>/?id=<?php echo $valor->getIdMenuIcone(); ?>"
                                        class="btn btn-default"
                                        title="Editar"
                                    >
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a
                                        href="#"
                                        class="btn btn-default excluiDado"
                                        data-secaoPai="<?php echo $gets[0]; ?>"
                                        data-secaoFilho="<?php echo $gets[1]; ?>"
                                        data-id="<?php echo $valor->getIdMenuIcone(); ?>"
                                        title="Excluir"
                                    >
                                        <i class="fa fa-trash-o"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div><!-- panel-body -->
            <div class="panel-footer">
                <h5><?php echo exibeId($listados, 3); ?> ícones cadastrados</h5>
            </div>
        </div>
    </div>
</div>
