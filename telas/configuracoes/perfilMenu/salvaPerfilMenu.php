<?php
include('../../../config/includes.php');
if($_POST['nome'] == '' or count($_POST) < 3){
    echo "Campo(s) obrigatório(s):";
    if ($_POST['nome'] == ''){
        echo "<br /> - Nome";
    }
    if (count($_POST) < 3){
        echo "<br /> - Permissões";
    }
    exit();
}
$nome = $_POST['nome'];
$descricao = $_POST['descricao'];
$perfil = new Perfil;
$perfil->setNome( $nome );
$perfil->setDescricao( $descricao );
if($perfil->selecionaNome()){
    echo "- O perfil com nome " . $nome . " já existe, por favor altere!";
    exit();
}
$insere = $perfil->insere();
if( $insere > 0 ){
    $idPerfil = $insere;
    //Permissões
    $resultado = Menu::listaPrincipal( );
    $deletar = $inserir = '';
    foreach($resultado as $chave => $valor){
        $idMenu = $valor->getIdMenu();
        if(isset($_POST['menu'.$idMenu])){
            $inserir .= "INSERT INTO PerfilMenu (idMenu, idPerfil) VALUES ('$idMenu','$idPerfil');" . PHP_EOL;
        }
    }
    $stringSQL = $inserir;
    $perfil->atualizaPerfilMenu( $stringSQL );
    echo '1';
}
