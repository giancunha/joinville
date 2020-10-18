<?php
include_once("config/includes.php");
$email = $_POST['email'];
$paraOnde = isset($_POST['para'])?$_POST['para']:'index.php';
$sistema = "Sistema " . EMPRESA;
$usuario = new Usuario;
$usuario->setEmail( $email );
$title = "Recupera senha - " . $sistema . " - Administrativo";
?>
    <!DOCTYPE html>
    <html lang='pt-br'>
<head>
    <title><?php echo $title; ?></title>
</head>
<?php
if(!$usuario->selecionaEmail()){
    echo exibeAlerta("O e-mail " . $email . " não foi localizado em nossa base de Dados!", "voltar");
    exit();
}
//CRIA NOVA SENHA
$cont=0;
$novasenha='';
while ($cont < 4) {
    $senha = mt_rand(0, 9);
    $lsenha = gerasenha();
    $cont++;
    $novasenha .="$lsenha$senha";
}
$hora = date('H');
if ($hora < 12) {
    $ola = "Bom dia";
} else if ($hora < 18) {
    $ola = "Boa tarde";
} else {
    $ola = "Boa noite";
}
$mail = new PHPMailer();
$mail->IsSMTP();
$mail->Host = SMTP;
$mail->SMTPAuth = true;
$mail->Username = USERMAIL;
$mail->Password = SENHAMAIL;
$mail->Port = 587;
$mail->From = DESTINOMAILRECEPCAO;
$mail->Sender = EMAIL;
$mail->FromName = $sistema;
if(validaEmail($email)){
    $mail->AddAddress($usuario->getEmail(), $usuario->getNome());
}else{
    $email = DESTINOMAILRECEPCAO;
    $mail->AddAddress(DESTINOMAILRECEPCAO, $usuario->getNome());
}
$mail->addReplyTo(DESTINOMAIL, EMPRESA);
$mail->IsHTML(true);
$mail->CharSet='UTF-8';
$mail->WordWrap = 50;
$mail->Subject = $title;
$mensagem = $mail->Body = "
<!DOCTYPE html>
<html lang='pt-br'>
<head>
</head>
<body>
<h2 style='font-family: Arial, Helvetica, sans-serif;  color:#2B2564; text-transform:uppercase; margin-bottom:15px; padding:0;'>" . $ola . " ". $usuario->getNome() . ",</h2>
<h3 style='font-size:15px; font-family: Arial, Helvetica, sans-serif; color:#2B2564; text-transform:uppercase;margin-bottom:5px; padding:0;'>Contato</h3>
<div style='font-family: Calibri,Trebuchet MS,Arial,Helvetica,sans-serif; font-size: 14px; color:#515151;'>
	<p>Conforme sua solicita&ccedil;&atilde;o, estamos lhe enviando os novos dados de acesso do " . $sistema . ".</p>
    <p>
    	<div>Para acessar o " . $sistema . " entre no site, ou se preferir acesse:</div>
        <div><a href='" . URLADM . "' target='_blank'>" . URLADM . "</a></div>
    </p>
    <p>Os dados para acesso seguem abaixo. Lembre-se de alterar esta nova senha gerada logo em seu pr&oacute;ximo acesso ao sistema.</p>
    <p>
    	<div>Usuário: " . $usuario->getEmail() . "</div>
        <div>Senha: ".$novasenha."</div>
    </p>
    <p><strong>Atenciosamente,<br />" . $sistema . ".</strong></p>
</div>
</body>
</html>";
//ATUALIZA NOVA SENHA NO BANCO
$usuario->setSenha( $novasenha );
$usuario->alteraSenha( );
if(!$mail->Send()){
    echo "Mensagem não pode ser enviada. <p>";
    echo "Erro: " . $mail->ErrorInfo;
    exit();
}
$location = is_numeric($paraOnde)? "window.history.go($paraOnde)":"window.location='$paraOnde'";
echo "
  <script language='JavaScript'> 
    alert('Os novos dados de acesso foram encaminhados para o e-mail " . $email . "! Verifique também sua caixa de SPAMs.');
    $location
  </script>
";
