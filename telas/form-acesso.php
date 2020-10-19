<?php include('config/includes.php'); ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title><?php echo EMPRESA; ?></title>
    <link rel="shortcut icon" href="<?php echo URL; ?>/imagens/favicon.png" />
    <link href="<?php echo URLADM; ?>/assets/css/style.default.css" rel="stylesheet">
    <link href="<?php echo URLADM; ?>/assets/css/font.helvetica-neue.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
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
                <form action="<?php echo URLADM; ?>/entrar.php" method="post" accept-charset="utf-8">
                    <h4 class="nomargin">Login</h4>
                    <p class="mt5 mb20">Faça login para acessar a sua conta.</p>
                    <input type="text" class="form-control uname" placeholder="Usuário" name="login" required="">
                    <input type="password" class="form-control pword" placeholder="Senha" name="senha" required="">
                    <button class="btn btn-success btn-block">Entrar</button>
                    <a class="btn btn-default btn-block" href="recuperaSenha.php">Esqueci Minha Senha</a>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="signup-footer col-md-6 col-md-offset-3">
                <div class="text-center">
                    &copy; 2020 - <?php echo date('Y'); ?>. Todos os direitos Reservados.
                </div>
                <div class="text-center">
                    Desenvolvido por <a href="http://www.wgars.com.br/" target="_blank">WGA Webdesign</a>
                </div>
            </div>
        </div>
    </div>
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
