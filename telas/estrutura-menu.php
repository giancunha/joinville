<h5 class="sidebartitle">Navegação por perfis</h5>
<ul class="nav nav-pills nav-stacked nav-bracket">
    <li><a href="<?php echo URLADM; ?>/"><i class="fa fa-home"></i> <span>Dashboard</span></a></li>
    <?php
    $idUsuario = $usuario->getIdUsuario();
    $menuPai = new Menu();
    $menuPai->setSecao($gets[1]);
    $menuPai->selecionaPai();
    $resultado = Menu::listaMenuPaisPorPerfil( $idUsuario );
    foreach($resultado as $chave => $valor){
        ?>
        <li class="nav-parent<?php if($valor->getIdMenu() == $menuPai->getIdMenu()){ echo ' nav-active active'; } ?>" title="<?php echo $valor->getDescricao(); ?>"><a href="<?php echo $valor->getSecao(); ?>"><i class="<?php echo $valor->getIdIcone(); ?>"></i> <span><?php echo corrigeCodificacao($valor->getNome()); ?></span></a>
            <ul class="children"<?php if($valor->getIdMenu() == $menuPai->getIdMenu()){ echo ' style="display: block;"'; } ?>>
                <?php
                $resultado2 = Menu::listaMenuFilhosPorPerfil( $valor->getIdMenu(), $idUsuario );
                foreach($resultado2 as $chave2 => $valor2){
                    ?>
                    <li<?php if($gets[1] == $valor2->getSecao()){ echo ' class="active"'; } ?>><a href="<?php echo URLADM."/".$valor->getSecao()."/".$valor2->getSecao(); ?>"><i class="fa fa-caret-right"></i> <?php echo corrigeCodificacao($valor2->getNome()); ?></a></li>
                    <?php
                }
                ?>
            </ul>
        </li>
        <?php
    }
    ?>
</ul>
