<div class="contentpanel">
    <div class="telacadastro">
        <form action="" method="post" id="formulario">
            <fieldset>
                <div class="col-sm-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">Novo Usuário</h4>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label class="control-label">Nome</label>
                                    <input type="text" name="nome" class="form-control" maxlength="100" required />
                                </div>
                                <div class="col-sm-6">
                                    <label class="control-label">E-mail</label>
                                    <input type="text" name="email" class="form-control" maxlength="75" required />
                                </div>
                            </div>
                            <div class="mb15"></div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <label class="control-label">Senha</label>
                                    <input type="password" name="senha" class="form-control" maxlength="75" required />
                                </div>
                                <div class="col-sm-4">
                                    <label class="control-label">Telefone:</label>
                                    <input type="text" name="telefone" class="form-control telefone" maxlength="20" required />
                                </div>
                                <div class="col-sm-4">
                                    <label class="control-label">CPF:</label>
                                    <input type="text" name="cpf" class="form-control cpf" maxlength="18" />
                                </div>
                            </div>
                            <div class="mb15"></div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <label class="control-label">Sexo:</label>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="radio"><label><input type="radio" name="sexo" value="M" /> Masculino</label></div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="radio"><label><input type="radio" name="sexo" value="F" /> Feminino</label></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <label class="control-label">Fax:</label>
                                    <input type="text" name="fax" class="form-control telefone" maxlength="20"  />
                                </div>
                                <div class="col-sm-4">
                                    <label class="control-label">Celular:</label>
                                    <input type="text" name="celular" class="form-control telefone" maxlength="20" />
                                </div>
                            </div>
                            <div class="mb15"></div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <hr/>
                                    <label class="control-label"><strong>Perfis do Usuário</strong></label>
                                    <div class="row">
                                        <?php
                                        $resultado = Perfil::listaPrincipal();
                                        $usuario = unserialize($_SESSION['usuario-adm-'.SESSAOADM]);
                                        foreach($resultado as $chave => $valor){
                                            if($valor->getIdPerfil() != 1 or $usuario->getIdUsuario() == 1){
                                                ?>
                                                <div class="col-sm-2" title="<?php echo $valor->getDescricao(); ?>">
                                                    <div>
                                                        <input type="checkbox" name="perfil<?php echo $valor->getIdPerfil(); ?>">
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
                            <button type="submit" class="btn btn-primary" id="btnIncluiDado" data-toggle="modal" data-secaoPai="<?php echo $gets[0]; ?>" data-secaoFilho="<?php echo $gets[1]; ?>">Cadastrar</button>
                        </div>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
    <div class="btncadastro col-sm-12">
        <div class="panel panel-default">
            <a href="#" class="btn btn-primary btnnewcad">Cadastrar um novo Usuário</a>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">Usuários Cadastrados</h4>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table id="produtosDataTable" class="table table-bordered table-hover table-default display">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Facebook</th>
                            <th>Nome</th>
                            <th>E-mail</th>
                            <th>Celular</th>
                            <th>&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $resultado = Usuario::listaPrincipal( );
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
                            <tr data-id="<?php echo $valor->getIdUsuario(); ?>">
                                <td><?php echo exibeId($valor->getIdUsuario()); ?></td>
                                <td>
                                    <?php
                                    if($valor->getIdFacebook() > 0) {
                                        //VERIFICA SE O ICONE DO FACEBOOK DO JOGADOR JÁ ESTÁ NA PASTA E COPIA DO FACEBOOK SE NÃO ESIVER
                                        $imagemFace = IMAGENSFACE . $usuario->getIdFacebook() . ".jpg";
                                        ?>
                                        <img src="<?php echo URL . '/' . $imagemFace; ?>"
                                             class="imagemFacebook"
                                             alt="<?php echo $valor->getNome(); ?>"
                                        />
                                        <?php
                                    } else {
                                        ?>
                                        Não
                                        <?php
                                    }
                                    ?>
                                </td>
                                <td><?php echo $valor->getNome(); ?></td>
                                <td><?php echo $valor->getEmail(); ?></td>
                                <td><?php echo $valor->getCelular(); ?></td>
                                <td style="text-align:right">
                                    <a href="#"
                                       class="btn btn-default ativacaoDado"
                                       data-secaoPai="<?php echo $gets[0]; ?>"
                                       data-secaoFilho="<?php echo $gets[1]; ?>"
                                       data-id="<?php echo $valor->getIdUsuario(); ?>"
                                       data-ativo="<?php echo $valor->getAtivo(); ?>"
                                       title="<?php echo $status; ?>"
                                    >
                                        <i class="fa fa-<?php echo $icone; ?>"></i>
                                    </a>
                                    <a href="<?php echo URLADM."/".$gets[0]."/".$gets[1]."/edita".ucfirst($gets[1]); ?>/?id=<?php echo $valor->getIdUsuario(); ?>"
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
            </div>
            <div class="panel-footer">
                <h5><?php echo exibeId($listados, 3); ?> usuários cadastrados</h5>
            </div>
        </div>
    </div>
</div>
