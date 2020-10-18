<?php
if($menuPai->getIdMenu() > 0){
    $menuFilho = new Menu();
    $menuFilho->setSecao($gets[1]);
    $menuFilho->selecionaFilho();
    $icone = new MenuIcone();
    $icone->setIdMenuIcone($menuPai->getIdIcone());
    $icone->seleciona();
    ?>
    <div class="pageheader">
        <h2><i class="<?php echo $icone->getIcone(); ?>"></i> <?php echo $menuPai->getNome(); ?> <span><?php echo $menuFilho->getNome(); ?></span></h2>
        <div class="breadcrumb-wrapper">
            <span class="label">Você está aqui:</span>
            <ol class="breadcrumb">
                <li><a href="#"><?php echo $menuPai->getNome(); ?></a></li>
                <li class="active"><?php echo $menuFilho->getNome(); ?></li>
            </ol>
        </div>
    </div>
    <?php
} else {
    ?>

    <div class="pageheader">
        <h2><i class="fa fa-home"></i> Dashboard</h2>
        <div class="breadcrumb-wrapper">
            <span class="label">Você está aqui:</span>
            <ol class="breadcrumb">
                <li><a href="/">Dashboard</a></li>
            </ol>
        </div>
    </div>
    <?php
}
