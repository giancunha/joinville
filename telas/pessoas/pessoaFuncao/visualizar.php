<div class="contentpanel">
    <div class="telacadastro">
        <form action="" method="post" id="formulario">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">Novo</h4>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <label class="control-label">Nome</label>
                                <input type="text" name="nome" class="form-control" maxlength="75" required />
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
                <h4 class="panel-title">Cadastrados</h4>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table id="produtosDataTable" class="table table-bordered table-hover table-default display">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $resultado = PessoaFuncao::listaPrincipal( );
                        foreach($resultado as $chave => $valor){
                            ?>
                            <tr data-id="<?php echo $valor->getId(); ?>">
                                <td><?php echo exibeId($valor->getId()); ?></td>
                                <td><?php echo $valor->getNome(); ?></td>
                                <td class="text-right">
                                    <?php
                                    if($valor->getId() > 6){
                                        ?>
                                        <a href="<?php echo URLADM."/".$gets[0]."/".$gets[1]."/edita".ucfirst($gets[1]); ?>/?id=<?php echo $valor->getId(); ?>" class="btn btn-default" title="Editar"><i class="fa fa-edit"></i></a>
                                        <a href="#" class="btn btn-default excluiDado" data-secaoPai="<?php echo $gets[0]; ?>" data-secaoFilho="<?php echo $gets[1]; ?>" data-id="<?php echo $valor->getId(); ?>" title="Excluir">
                                            <i class="fa fa-trash-o"></i>
                                        </a>
                                        <?php
                                    }
                                    ?>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div><!-- panel-body -->
        </div>
    </div>
</div>
