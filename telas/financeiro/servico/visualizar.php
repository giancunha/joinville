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
                            <div class="col-sm-3">
                                <label class="control-label">Natureza</label>
                                <select name="natureza" class="select2" required>
                                    <option value=""> Selecione </option>
                                    <option value="R"> Receita </option>
                                    <option value="D"> Despesa </option>
                                    <option value="A"> Ambas </option>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <label class="control-label">Nome</label>
                                <input type="text" name="nome" class="form-control" maxlength="75" required />
                            </div>
                            <div class="col-sm-6">
                                <label class="control-label">Descrição</label>
                                <input type="text" name="descricao" class="form-control" />
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
            <a href="#" class="btn btn-primary btnnewcad">Cadastrar</a>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">Resgistros</h4>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-default">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Natureza</th>
                            <th>Descrição</th>
                            <th>&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody class="dadosBD">
                        <?php
                        $resultado = Servico::listaPrincipal( );
                        $listados = 0;
                        foreach($resultado as $chave => $valor){
                            $listados++;
                            switch ($valor->getNatureza()) {
                                case 'R': $natureza = 'Receita'; break;
                                case 'D': $natureza = 'Despesa'; break;
                                default: $natureza = 'Ambas'; break;
                            }
                            ?>
                            <tr data-id="<?php echo $valor->getIdServico(); ?>">
                                <td><?php echo exibeId($valor->getIdServico()); ?></td>
                                <td><?php echo $valor->getNome(); ?></td>
                                <td><?php echo $natureza; ?></td>
                                <td><?php echo $valor->getDescricao(); ?></td>
                                <td class="text-right">
                                    <?php
                                    if($valor->getIdServico() > 3){
                                        ?>
                                        <a href="<?php echo URLADM."/".$gets[0]."/".$gets[1]."/edita".ucfirst($gets[1]); ?>/?id=<?php echo $valor->getIdServico(); ?>" class="btn btn-default"><i class="fa fa-edit"></i></a>
                                        <a href="#" class="btn btn-default excluiDado" data-secaoPai="<?php echo $gets[0]; ?>" data-secaoFilho="<?php echo $gets[1]; ?>" data-id="<?php echo $valor->getIdServico(); ?>"><i class="fa fa-trash-o"></i></a>
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
            <div class="panel-footer">
                <h5><?php echo exibeId($listados, 3); ?> cadastros</h5>
            </div>
        </div>
    </div>
</div>