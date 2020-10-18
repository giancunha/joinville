<?php
include_once("config/includes.php");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="<?php echo URLADM; ?>/imagens/webicon.png" type="image/x-icon" />
    <title><?php echo EMPRESA; ?></title>
    <link href="<?php echo URLADM; ?>/assets/css/style.default.css" rel="stylesheet">
    <link href="<?php echo URLADM; ?>/assets/css/font.helvetica-neue.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
</head>
<body class="signin">
<section>
    <div class="signinpanel">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="signin-info">
                    <div class="logopanel">
                        <h1><span>[</span> <?php echo EMPRESA; ?> <span>]</span></h1>
                    </div><!-- logopanel -->

                    <div class="mb20"></div>
                </div><!-- signin0-info -->
            </div><!-- col-sm-7 -->
        </div>
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <form action="<?php echo URLADM; ?>/novaSenha.php" method="post" accept-charset="utf-8">
                    <h4 class="nomargin">Esqueci Minha Senha</h4>
                    <p class="mt5 mb20">Informe o seu e-mail para solicitar.</p>
                    <input type="hidden" name="para" value="index.php"/>
                    <input type="text" class="form-control" placeholder="Informe seu e-mail" name="email" required="">
                    <button class="btn btn-success btn-block">Solicitar nova senha</button>
                    <a class="btn btn-default btn-block" href="<?php echo URLADM; ?>">Voltar para o Login</a>
                </form>
            </div><!-- col-sm-5 -->
        </div>
        <div class="row">
            <div class="signup-footer col-md-6 col-md-offset-3">
                <div class="text-center">
                    &copy; 2020-<?php echo date('Y'); ?>. Todos os direitos Reservados.
                </div>
                <div class="text-center">
                    Desenvolvido por <a href="http://www.wgars.com.br/" target="_blank">WGA Webdesign</a>
                </div>
            </div>
        </div>
    </div><!-- signin -->
</section>
<script src="<?php echo URLADM; ?>/assets/js/jquery-1.11.1.min.js"></script>
<script src="<?php echo URLADM; ?>/assets/js/jquery-migrate-1.2.1.min.js"></script>
<script src="<?php echo URLADM; ?>/assets/js/bootstrap.min.js"></script>
<script src="<?php echo URLADM; ?>/assets/js/modernizr.min.js"></script>
<script src="<?php echo URLADM; ?>/assets/js/jquery.sparkline.min.js"></script>
<script src="<?php echo URLADM; ?>/assets/js/jquery.cookies.js"></script>
<script src="<?php echo URLADM; ?>/assets/js/toggles.min.js"></script>
<script src="<?php echo URLADM; ?>/assets/js/retina.min.js"></script>
<script src="<?php echo URLADM; ?>/assets/js/custom.js"></script>
</body>
</html>
