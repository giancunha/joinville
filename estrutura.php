<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="<?php echo URL; ?>/imagens/favicon.png" />
    <title><?php echo EMPRESA; ?></title>
    <!-- Importação de links CSS -->
    <?php
    foreach ($GLOBALS['links']['addcss'] as $key => $value) {
        echo '<link href="'. $GLOBALS['links']['css'][$value].'" rel="stylesheet">' . PHP_EOL;
    }
    ?>
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="<?php echo URLADM; ?>/assets/js/html5shiv.js"></script>
    <script src="<?php echo URLADM; ?>/assets/js/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<section>
    <div class="leftpanel">
        <div class="logopanel">
            <h1><span>[</span> <?php echo EMPRESA; ?> <span>]</span></h1>
        </div><!-- logopanel -->
        <div class="leftpanelinner">
            <!-- This is only visible to small devices -->
            <div class="visible-xs hidden-sm hidden-md hidden-lg">
                <div class="media userlogged">
                    <div class="media-body">
                        <h4><?php echo $usuario->getNome(); ?></h4>
                        <span>Bem vindo(a)!</span>
                    </div>
                </div>
                <h5 class="sidebartitle actitle">CONTA DE ACESSO</h5>
                <ul class="nav nav-pills nav-stacked nav-bracket mb30">
                    <li><a href="<?php echo URLADM  ?>/sair.php"><i class="glyphicon glyphicon-log-out"></i>Sair</a></li>
                </ul>
            </div>
            <?php include('telas/estrutura-menu.php'); ?>
        </div><!-- leftpanelinner -->
    </div><!-- leftpanel -->
    <div class="mainpanel">
        <div class="headerbar">
            <div class="header-left">
                <div class="topnav">
                    <a class="menutoggle"><i class="fa fa-bars"></i></a>
                </div>
            </div>
            <div class="header-center hidden-xs visible-sm visible-md visible-lg">
                <?php echo diaSemana(date('D')); ?> &nbsp;
                <i class="fa fa-calendar-o"></i> <?php echo date('d/m/Y'); ?> &nbsp;
                <i class="glyphicon glyphicon-time"></i> <?php echo date('H:i'); ?> &nbsp;
                <?php echo ola(); ?>
            </div>
            <div class="header-right">
                <ul class="headermenu">
                    <li>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                <?php
                                $usuario = unserialize($_SESSION['usuario-adm-'.SESSAOADM]);
                                ?>
                                <span style="color: #FFFFFF;"><?php echo $usuario->getNome(); ?></span>
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-usermenu pull-right">
                                <li><a href="<?php echo URLADM  ?>/sair.php"><i class="glyphicon glyphicon-log-out"></i>Sair</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div><!-- header-right -->
        </div><!-- headerbar -->
        <?php
        include('telas/estrutura-topo.php');
        ?>
        <?php mostrapaginas(); ?>
    </div><!-- mainpanel -->
</section>
<!-- Importação de links javascript -->
<?php
$versao = 1;
foreach ($GLOBALS['links']['addjs'] as $key => $value) {
    echo "<script src='". $GLOBALS['links']['js'][$value]."?v=$versao'></script>\n";
}
?>
<input type="hidden" value="<?php echo $gets['1']; ?>" id="urlSecaoFilho">
</body>
</html>
