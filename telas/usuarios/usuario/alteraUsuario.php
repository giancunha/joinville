<?php
include('../../../config/includes.php');
if(
    $_POST['nome'] == ''
    or $_POST['email'] == ''
    or $_POST['telefone'] == ''
){
    echo "Campo(s) obrigat&oacute;rio(s):";
    if ($_POST['nome'] == ''){
        echo "<br /> - Nome";
    }
    if ($_POST['telefone'] == ''){
        echo "<br /> - Telefone";
    }
    if ($_POST['email'] == ''){
        echo "<br /> - E-mail";
    }
    exit();
}
if(!isset($_POST['alteraPermissoes'])){
    $_POST['alteraPermissoes'] = 'sim';
}
$idUsuario = $_POST['idUsuario'];
$nome = $_POST['nome'];
$email = $_POST['email'];
$telefone = $_POST['telefone'];
$cpf = $_POST['cpf'];
$sexo = $_POST['sexo'];
$fax = $_POST['fax'];
$celular = $_POST['celular'];

$usuario = new Usuario;
$usuario->setIdUsuario( $idUsuario );
$usuario->setNome( $nome );
$usuario->setEmail( $email );
$usuario->setTelefone( $telefone );
$usuario->setCpf( $cpf );
$usuario->setSexo( $sexo );
$usuario->setFax( $fax );
$usuario->setCelular( $celular );
if($usuario->selecionaEmail()){
    echo "E-mail " . $usuario->getEmail() . " já cadastrado em usuários!";
    exit();
}
$altera = $usuario->altera();
if( $altera > 0 ){
    if($_POST['alteraPermissoes'] != 'nao'){
        //Permissões
        $resultado = Perfil::listaUsuarioPerfil( $idUsuario );
        $inserir = '';
        $deletaTudo = "DELETE FROM UsuarioPerfil WHERE idUsuario = '$idUsuario';" . PHP_EOL;
        foreach($resultado as $chave => $valor){
            $idPerfil = $valor->getIdPerfil();
            if(isset($_POST['perfil'.$idPerfil])){
                $inserir .= "INSERT INTO UsuarioPerfil (idPerfil, idUsuario) VALUES ('$idPerfil','$idUsuario');" . PHP_EOL;
            }
        }
        $stringSQL = $deletaTudo . $inserir;
        $usuario->atualizaUsuarioPerfil( $stringSQL );
    } else {
        $usuario->seleciona();
        $_SESSION['usuario-adm-' . SESSAOADM] = serialize($usuario);
    }
    echo '1';
}
