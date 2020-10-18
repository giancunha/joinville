<?php
$usuario = unserialize($_SESSION['usuario-adm-'.SESSAOADM]);
$idUsuario = $usuario->getIdUsuario();
$usuario = new Usuario();
$usuario->setidUsuario( $idUsuario );
$usuario->seleciona();
?>
<div class="contentpanel">
    <form action="" method="post" id="formulario">
        <input type="hidden" name="idUsuario" value="<?php echo $usuario->getIdUsuario(); ?>" id="idMedico" />
        <input type="hidden" name="alteraPermissoes" value="nao" />
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">Meus Dados > <?php echo $usuario->getNome(); ?></h4>
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
                </div><!-- panel-body -->
                <div class="panel-footer">
                    <button type="submit" class="btn btn-primary" id="btnAlteraDado" data-toggle="modal" data-secaoPai="<?php echo $gets[0]; ?>" data-secaoFilho="usuario">Atualizar</button>
                    <a href="javascript: history.go(-1);" class="btn btn-default">Voltar</a>
                </div>
            </div>
        </div>
    </form>
    <?php
    if(LOGINFACEBOOK) {
        ?>
        <div class="col-sm-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">Login por facebook</h4>
                    <?php
                    if($usuario->getIdFacebook() > 0){
                        $imagemFace = IMAGENSFACE . $usuario->getIdFacebook() . ".jpg";
                        ?>
                        <div class="btn btn-success btn-block">
                            Conta vinculada com o Facebook
                        </div>
                        <div align="center">
                            <img src="<?php echo URL . '/' . $imagemFace; ?>" alt="<?php echo $usuario->getNome(); ?>" />
                        </div>
                        <div class="btn btn-primary btn-block loginface">
                            <i class="fa fa-facebook-square"></i> Remover Login por facebook
                        </div>
                        <?php
                    } else {
                        ?>
                        <div class="btn btn-primary btn-block loginface">
                            <i class="fa fa-facebook-square"></i> Ativar Login por facebook
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php
    }
    ?>
</div>
