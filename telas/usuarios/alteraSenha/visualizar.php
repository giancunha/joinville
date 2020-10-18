<?php
$usuario = unserialize($_SESSION['usuario-adm-'.SESSAOADM]);
$nomeUsuario = $usuario->getNome();
?>
<div class="contentpanel">
    <form action="" method="post" id="formulario">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">Usuário - Alterar senha [<?php echo $nomeUsuario; ?>]</h4>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-4">
                            <label>Senha Atual</label>
                            <input type="password" name="oldpwd" maxlength="32" size="20" title="Senha atual" required class="form-control" autocomplete="off" >
                        </div>
                        <div class="col-sm-4">
                            <label>Nova Senha</label>
                            <input type="password" name="newpwd" maxlength="32" size="20" title="Nova Senha" required class="form-control" autocomplete="off" >
                        </div>
                        <div class="col-sm-4">
                            <label>Confirme nova senha</label>
                            <input type="password" name="newpwd2" maxlength="32" size="20" title="Repita a Nova Senha" required class="form-control" autocomplete="off" >
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="col-sm-12">
                        <button type="submit" class="btn btn-primary" id="btnAlteraSenha" data-toggle="modal" data-secaoPai="<?php echo $gets[0]; ?>" data-secaoFilho="<?php echo $gets[1]; ?>">Atualizar</button>
                        <button type="reset" class="btn btn-default">Limpar Campos</button>
                        <a href="javascript: history.go(-1);" class="btn btn-default">Voltar</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
