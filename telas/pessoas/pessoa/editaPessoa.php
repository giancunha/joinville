<?php
$pessoa = new Pessoa();
$pessoa->setidPessoa($_GET['id']);
$pessoa->seleciona();
?>
<div class="contentpanel">
    <form action="" method="post" id="formulario">
        <input type="hidden" name="idPessoa" value="<?php echo $pessoa->getIdPessoa(); ?>" />
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">Dados Gerais</h4>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label class="control-label">Nome</label>
                                    <input type="text" name="nome" class="form-control" maxlength="150" required value="<?php echo $pessoa->getNome(); ?>">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <label class="control-label">Data Nascimento</label>
                                <input type="text" name="dataNascimento" class="form-control dataNascimento" maxlength="10" value="<?php echo $pessoa->getDataNascimento(); ?>" required>
                            </div>
                        </div>
                        <div class="mb15"></div>
                        <div class="row">
                            <div class="col-sm-4">
                                <label class="control-label">Telefone Celular</label>
                                <input type="text" name="telefoneCelular" class="form-control telefone" maxlength="20" value="<?php echo $pessoa->getTelefoneCelular(); ?>">
                            </div>
                            <div class="col-sm-4">
                                <label>Sexo</label>
                                <select name="sexo" class="select2" required>
                                    <option value=""> Selecione </option>
                                    <option value="M"<?php if($pessoa->getSexo() == 'M'){ echo ' selected'; } ?>> Masculino </option>
                                    <option value="F"<?php if($pessoa->getSexo() == 'F'){ echo ' selected'; } ?>> Feminino </option>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label class="control-label">E-mail</label>
                                <input type="text" name="email" class="form-control" maxlength="100" value="<?php echo $pessoa->getEmail(); ?>">
                            </div>
                        </div>
                    </div><!-- panel-body -->
                </div>
            </div><!-- PANEL DADOS PESSOAIS -->
        </div><!-- LINHA 1 -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">Observações</h4>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <textarea name="observacoes" class="form-control wysiwyg" rows="5"><?php echo $pessoa->getObservacoes(); ?></textarea>
                                <br>
                            </div>
                        </div>
                    </div><!-- panel-body -->
                </div>
            </div>
        </div><!-- LINHA 2 -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary" id="btnAlteraDado" data-toggle="modal" data-secaoPai="<?php echo $gets[0]; ?>" data-secaoFilho="<?php echo $gets[1]; ?>">Atualizar</button>
                            <a href="javascript: history.go(-1);" class="btn btn-default">Voltar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">Clientes Vinculados</h4>
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
                                <th>Função</th>
                                <th>Telefone</th>
                                <th>&nbsp;</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $resultado = Cliente::listaPessoaClientes( $pessoa->getIdPessoa() );
                            $listados = 0;
                            foreach($resultado as $chave => $valor){
                                $listados++;
                                ?>
                                <tr data-id="<?php echo $valor->getId(); ?>">
                                    <td><?php echo exibeId($valor->getId()); ?></td>
                                    <td><?php echo $valor->getIdAdministradora(); ?></td>
                                    <td><?php echo $valor->getNomeFantasia(); ?></td>
                                    <td><?php echo $valor->getRazaoSocial(); ?></td>
                                    <td><?php echo $valor->getObservacoes(); ?></td>
                                    <td><?php echo mascaraTelefone($valor->getTelefone()); ?></td>
                                    <td style="text-align:right">
                                        <a href="<?php echo URLADM; ?>/clientes/cliente/editaCliente/?id=<?php echo $valor->getId(); ?>"
                                           class="btn btn-default"
                                           title="Editar Cliente"
                                        >
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a href="<?php echo URLADM."/financeiro/faturaCliente/alteraCliente?idCliente=" . $valor->getId(); ?>"
                                           class="btn btn-default"
                                           title="Visualizar Faturas"
                                        >
                                            <i class="fa fa-money"></i>
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
            </div>
        </div>
    </div>
</div>
