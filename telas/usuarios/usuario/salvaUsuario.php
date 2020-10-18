<?php
include('../../../config/includes.php');
if(
    $_POST['nome'] == ''
    or $_POST['email'] == ''
    or $_POST['telefone'] == ''
    or $_POST['senha'] == ''
){
    echo "Campo(s) obrigatório(s):";
    if ($_POST['nome'] == ''){
        echo "<br /> - Nome";
    }
    if ($_POST['telefone'] == ''){
        echo "<br /> - Telefone";
    }
    if ($_POST['email'] == ''){
        echo "<br /> - E-mail";
    }
    if ($_POST['senha'] == ''){
        echo "<br /> - Senha";
    }
    exit();
}
$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = $_POST['senha'];
$telefone = $_POST['telefone'];
$cpf = $_POST['cpf'];
$sexo = $_POST['sexo'];
$fax = $_POST['fax'];
$celular = $_POST['celular'];
$usuario = new Usuario;
$usuario->setNome( $nome );
$usuario->setEmail( $email );
$usuario->setSenha( $senha );
$usuario->setTelefone( $telefone );
$usuario->setCpf( $cpf );
$usuario->setSexo( $sexo );
$usuario->setFax( $fax );
$usuario->setCelular( $celular );
$insere = $usuario->insere();
if($usuario->selecionaEmail()){
    echo "E-mail " . $usuario->getEmail() . " já cadastrado em usuários!";
    exit();
}
if( $insere > 0 ){
    $idUsuario = $insere;
    //Perfil
    $resultado = Perfil::listaPrincipal( );
    $deletar = $inserir = '';
    foreach($resultado as $chave => $valor){
        $idPerfil = $valor->getIdPerfil();
        if(isset($_POST['perfil'.$idPerfil])){
            $inserir .= "INSERT INTO UsuarioPerfil (idPerfil, idUsuario) VALUES ('$idPerfil','$idUsuario');" . PHP_EOL;
        }
    }
    $stringSQL = $inserir;
    if($inserir != ''){
        $usuario->atualizaUsuarioPerfil( $stringSQL );
    }
    echo '1';
}
