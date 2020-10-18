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
$idPerfil = $_POST['idPerfil'];
$nome = $_POST['nome'];
$descricao = $_POST['descricao'];
$perfil = new Perfil;
$perfil->setIdPerfil( $idPerfil );
$perfil->setNome( $nome );
$perfil->setDescricao( $descricao );
if($perfil->selecionaNome() and $nome != $_POST['nomeOld']){
    echo "- O perfil com nome " . $nome . " já existe, por favor altere!";
    exit();
}
$altera = $perfil->altera();
if( $altera > 0 ){
    //Permissões
    $resultado = Menu::listaPrincipal( );
    $deletar = $inserir = '';
    foreach($resultado as $chave => $valor){
        $idMenu = $valor->getIdMenu();
        if(PerfilMenu::selecionaPerfilMenu( $idPerfil, $idMenu )){
            if(!isset($_POST['menu'.$idMenu])) {
                $deletar .= "DELETE FROM PerfilMenu WHERE idPerfil = '$idPerfil' AND idMenu = '$idMenu';" . PHP_EOL;
            }
        } else if(isset($_POST['menu'.$idMenu])){
            $inserir .= "INSERT INTO PerfilMenu (idMenu, idPerfil) VALUES ('$idMenu','$idPerfil');" . PHP_EOL;
        }
    }
    $stringSQL = $deletar . $inserir;
    if(!empty($stringSQL)) {
        $perfil->atualizaPerfilMenu($stringSQL);
    }
    echo '1';
}
