<div class="contentpanel">
    <div class="btncadastro col-sm-12">
        <div class="panel panel-default">
            <a href="<?php echo URLADM ?>/<?php echo $gets[0]; ?>/<?php echo $gets[1]; ?>/cadastrar" class="btn btn-primary">Cadastrar novo</a>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">Cadastros</h4>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table id="produtosDataTable" class="table table-bordered table-hover table-default display">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Administradora</th>
                            <th>Fantasia</th>
                            <th>Razão</th>
                            <th>Documento</th>
                            <th>Telefone</th>
                            <th>&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $resultado = Cliente::listaPrincipal( );
                        $listados = 0;
                        foreach($resultado as $chave => $valor){
                            $listados++;
                            if($valor->getAtivo() == 1){
                                $icone = 'ban';
                                $status = 'Desativar';
                            } else {
                                $icone = 'thumbs-up';
                                $status = 'Ativar';
                            }
                            ?>
                            <tr data-id="<?php echo $valor->getId(); ?>">
                                <td><?php echo exibeId($valor->getId()); ?></td>
                                <td><?php echo $valor->getIdAdministradora(); ?></td>
                                <td><?php echo $valor->getNomeFantasia(); ?></td>
                                <td><?php echo $valor->getRazaoSocial(); ?></td>
                                <td><?php echo mascaraDocumento($valor->getCnpjCpf()); ?></td>
                                <td><?php echo mascaraTelefone($valor->getTelefone()); ?></td>
                                <td style="text-align:right">
                                    <a href="#"
                                       class="btn btn-default ativacaoDado"
                                       data-secaoPai="<?php echo $gets[0]; ?>"
                                       data-secaoFilho="<?php echo $gets[1]; ?>"
                                       data-id="<?php echo $valor->getId(); ?>"
                                       data-ativo="<?php echo $valor->getAtivo(); ?>"
                                       title="<?php echo $status; ?>"
                                    >
                                        <i class="fa fa-<?php echo $icone; ?>"></i>
                                    </a>
                                    <a href="<?php echo URLADM."/".$gets[0]."/".$gets[1]."/edita".ucfirst($gets[1]); ?>/?id=<?php echo $valor->getId(); ?>"
                                       class="btn btn-default"
                                       title="Editar"
                                    >
                                        <i class="fa fa-edit"></i>
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
            </div>
        </div>
    </div>
</div>
