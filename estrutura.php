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
        echo '<link href="'. $GLOBALS['links']['css'][$value].'" rel="stylesheet">';
    }
    ?>
    <link rel="apple-touch-icon" sizes="180x180" href="https://www.otvelevadores.com.br/otv/icons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="https://www.otvelevadores.com.br/otv/icons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="192x192" href="https://www.otvelevadores.com.br/otv/icons/android-chrome-192x192.png">
    <link rel="icon" type="image/png" sizes="16x16" href="https://www.otvelevadores.com.br/otv/icons/favicon-16x16.png">
    <link rel="manifest" href="https://www.otvelevadores.com.br/otv/icons/site.webmanifest">
    <link rel="mask-icon" href="https://www.otvelevadores.com.br/otv/icons/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="apple-mobile-web-app-title" content="ADM OTV">
    <meta name="application-name" content="ADM OTV">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="<?php echo URLADM; ?>/assets/js/html5shiv.js"></script>
    <script src="<?php echo URLADM; ?>/assets/js/respond.min.js"></script>
    <![endif]-->
    <script type="text/javascript">
        var idFacebook = <?php echo IDFACEBOOK; ?>;
    </script>
</head>
<body>
<!-- Preloader -->
<!--
<div id="preloader">
    <div id="status"><i class="fa fa-spinner fa-spin"></i></div>
</div>
-->
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">&times;</button>
                <h4 class="modal-title" id="tituloModal">Large Modal</h4>
            </div>
            <div class="modal-body" id="conteudoModal">...</div>
        </div>
    </div>
</div>
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
                    <li><a href="<?php echo URLADM  ?>/usuarios/alteraSenha"><i class="fa fa-lock"></i> Altera Senha</a></li>
                    <li><a href="<?php echo URLADM  ?>/usuarios/meusDados"><i class="fa fa-user"></i> Meus Dados</a></li>
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
                                if($usuario->getIdFacebook() > 0){
                                    //VERIFICA SE O ICONE DO FACEBOOK DO JOGADOR JÁ ESTÁ NA PASTA E COPIA DO FACEBOOK SE NÃO ESIVER
                                    $imagemFace = IMAGENSFACE . $usuario->getIdFacebook() . ".jpg";
                                    $atualizarAposDias = $ultimaAtualizacao = 0;
                                    if(is_file(CAMINHOABSOLUTO . $imagemFace)){
                                        $ultimaAtualizacao = filectime(CAMINHOABSOLUTO . $imagemFace);
                                        $atualizarAposDias = time() -  (DIASIMAGEMFACE * 24 * 60 * 60);
                                    }
                                    if(!is_file(CAMINHOABSOLUTO . $imagemFace) or $ultimaAtualizacao < $atualizarAposDias){
                                        $imagemIconeFace = "http://graph.facebook.com/" . $usuario->getIdFacebook() . "/picture?type=large&redirect=false";
                                        $userJSON = file_get_contents($imagemIconeFace);
                                        $jsonStr = json_decode($userJSON, true);
                                        $imagemIconeFace = $jsonStr['data']['url'];
                                        if ($content = file_get_contents($imagemIconeFace)){
                                            if (!empty($content)) {
                                                $fp = fopen(CAMINHOABSOLUTO . $imagemFace, "w");
                                                fwrite($fp, $content);
                                                fclose($fp);
                                            }
                                        }
                                    }
                                    ?>
                                    <img src="<?php echo URL . '/' . $imagemFace; ?>" alt="<?php echo $usuario->getNome(); ?>" />
                                    <?php
                                }
                                ?>
                                <span style="color: #FFFFFF;"><?php echo $usuario->getNome(); ?></span>
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-usermenu pull-right">
                                <li><a href="<?php echo URLADM  ?>/usuarios/alteraSenha"><i class="fa fa-lock"></i>Altera Senha</a></li>
                                <li><a href="<?php echo URLADM  ?>/usuarios/meusDados"><i class="fa fa-user"></i>Meus Dados</a></li>
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
$versao = 1;//rand();
foreach ($GLOBALS['links']['addjs'] as $key => $value) {
    echo "<script src='". $GLOBALS['links']['js'][$value]."?v=$versao'></script>\n";
}
?>
<input type="hidden" value="<?php echo $gets['1']; ?>" id="urlSecaoFilho">
<script type="text/javascript">
    $(function () {
        <?php
        if(isset($_SESSION['graphs'])){
        foreach ($_SESSION['graphs'] as $chave => $graph) {
        if($graph['filho'] != $gets[1]){
            return false;
        }
        ?>
        //PIE CHART
        var dados = <?php echo json_encode($graph['dados']); ?>;
        var piedata = dados;
        jQuery.plot('#<?php echo $graph['id']; ?>', piedata, {
            series: {
                pie: {
                    show: true,
                    radius: 1,
                    label: {
                        show: true,
                        radius: 2/3,
                        formatter: labelFormatter,
                        threshold: 0.1
                    }
                }
            },
            grid: {
                hoverable: true,
                clickable: true
            },
            tooltip: true,
            tooltipOpts: {
                cssClass: "flotTip",
                content: "%p.0%, %s",
                shifts: {
                    x: 20,
                    y: 0
                },
                defaultTheme: false
            }
        });
        <?php
        }
        ?>
        function labelFormatter(label, series) {
            return "<div style='font-size:8pt; text-align:center; padding:2px; color:white;'>" + label + "<br/>" + Math.round(series.percent) + "%</div>";
        }
        <?php
        }
        ?>
    });
</script>
<style>
    .flot {
        left: 0px;
        top: 0px;
        width: 610px;
        height: 250px;
    }
    #flotTip {
        padding: 3px 5px;
        background-color: #000;
        z-index: 100;
        color: #fff;
        opacity: .80;
        filter: alpha(opacity=85);
    }
    .pieLabel div {
        color: white !important;
        text-shadow: 0 0 4px #000;
    }
</style>
</body>
</html>
