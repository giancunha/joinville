<?php
$usuario = new Usuario();
$usuario->setIdUsuario($_GET['id']);
$usuario->seleciona();
?>
<div class="contentpanel">
    <form action="" method="post" id="formulario">
        <input type="hidden" name="idUsuario" value="<?php echo $usuario->getIdUsuario(); ?>" />
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">Editar Usuário > <?php echo $usuario->getNome(); ?></h4>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <label class="control-label">Nome</label>
                            <input type="text" name="nome" class="form-control" maxlength="100" required value="<?php echo $usuario->getNome(); ?>" />
                        </div>
                        <div class="col-sm-6">
                            <label class="control-label">E-mail</label>
                            <input type="text" name="email" class="form-control" maxlength="75" required value="<?php echo $usuario->getEmail(); ?>" />
                        </div>
                    </div>
                    <div class="mb15"></div>
                    <div class="row">
                        <div class="col-sm-6">
                            <label class="control-label">Telefone:</label>
                            <input type="text" name="telefone" class="form-control telefone" maxlength="20" required value="<?php echo $usuario->getTelefone(); ?>" />
                        </div>
                        <div class="col-sm-6">
                            <label class="control-label">CPF:</label>
                            <input type="text" name="cpf" class="form-control cpf" maxlength="18" value="<?php echo $usuario->getCpf(); ?>" />
                        </div>
                    </div>
                    <div class="mb15"></div>
                    <div class="row">
                        <div class="col-sm-4">
                            <label class="control-label">Sexo:</label>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="radio"><label><input type="radio" name="sexo" value="M" <?php if($usuario->getSexo() == 'M'){ echo ' checked'; } ?> /> Masculino</label></div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="radio"><label><input type="radio" name="sexo" value="F" <?php if($usuario->getSexo() == 'F'){ echo ' checked'; } ?> /> Feminino</label></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <label class="control-label">Fax:</label>
                            <input type="text" name="fax" class="form-control telefone" maxlength="20" value="<?php echo $usuario->getFax(); ?>"  />
                        </div>
                        <div class="col-sm-4">
                            <label class="control-label">Celular:</label>
                            <input type="text" name="celular" class="form-control telefone" maxlength="20" value="<?php echo $usuario->getCelular(); ?>" />
                        </div>
                    </div>
                    <div class="mb15"></div>
                    <div class="row">
                        <div class="col-sm-12">
                            <hr/>
                            <label class="control-label"><strong>Perfis do Usuário</strong></label>
                            <div class="row">
                                <?php
                                $usuarioLogado = unserialize($_SESSION['usuario-adm-'.SESSAOADM]);
                                $resultado = Perfil::listaUsuarioPerfil( $usuario->getIdUsuario() );
                                foreach($resultado as $chave => $valor){
                                    $marcado = '';
                                    if($valor->getIdPerfil() != 1 or $usuarioLogado->getIdUsuario() == 1){
                                        ?>
                                        <?php
                                        if($valor->getIdUsuarioPerfil() > 0){
                                            $marcado = ' checked';
                                        }
                                        ?>
                                        <div class="col-sm-2" title="<?php echo $valor->getDescricao(); ?>">
                                            <div>
                                                <input type="checkbox" name="perfil<?php echo $valor->getIdPerfil(); ?>"<?php echo $marcado; ?>>
                                                <label><?php echo $valor->getNome(); ?></label>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                            <hr/>
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
