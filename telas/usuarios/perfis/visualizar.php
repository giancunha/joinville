<div class="contentpanel">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">Menus por Perfil</h4>
            </div>
            <div class="panel-group" id="accordion">
                <?php
                $perfis = Perfil::listaPrincipal( );
                foreach($perfis as $chave => $perfil) {
                    if($perfil->getIdPerfil() == 1){
                        continue;
                    }
                    $usuarios = Usuario::selecionaPorPerfil( $perfil->getIdPerfil() );
                    ?>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" class="collapsed" data-parent="#accordion"
                                   href="#<?php echo nametofile($perfil->getNome()) . $perfil->getIdPerfil(); ?>">
                                    Perfil - <?php echo $perfil->getNome(); ?>
                                </a>
                            </h4>
                        </div>
                        <div class="panel-collapse collapse" id="<?php echo nametofile($perfil->getNome()) . $perfil->getIdPerfil(); ?>">
                            <div class="panel-body">
                                <div class="col-sm-12">
                                    <strong>Descrição:</strong>
                                    <?php echo $perfil->getDescricao(); ?>
                                </div>
                                <div class="col-sm-12">
                                    <strong>Usuários:</strong>
                                    <?php echo $usuarios; ?>.
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-default">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Ordem</th>
                                            <th>Ícone</th>
                                            <th>Nome</th>
                                            <th>Descrição</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $resultado = Menu::listaMenuPerfisPais( $perfil->getIdPerfil() );
                                        foreach ($resultado as $chave => $valor) {
                                            ?>
                                            <tr title="<?php echo $valor->getDescricao(); ?>">
                                                <td><?php echo exibeId($valor->getIdMenu()); ?></td>
                                                <td><?php echo exibeId($valor->getOrdem(), 3); ?></td>
                                                <td>
                                                    <div class="btn"><i class="<?php echo $valor->getIdIcone(); ?>"></i>
                                                    </div>
                                                </td>
                                                <td><?php echo $valor->getNome(); ?></td>
                                                <td><?php echo $valor->getDescricao(); ?></td>
                                            </tr>
                                            <?php
                                            $resultado2 = Menu::listaMenuPerfisFilhos( $perfil->getIdPerfil(), $valor->getIdMenu() );
                                            foreach ($resultado2 as $chave2 => $valor2) {
                                                ?>
                                                <tr title="<?php echo $valor2->getDescricao(); ?>">
                                                    <td><?php echo exibeId($valor2->getIdMenu()); ?></td>
                                                    <td><?php echo exibeId($valor2->getOrdem(), 3); ?></td>
                                                    <td>&nbsp;</td>
                                                    <td><?php echo $valor2->getNome(); ?></td>
                                                    <td><?php echo $valor2->getDescricao(); ?></td>
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
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>
