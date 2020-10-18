<?php
include_once("../config/includes.php");
$idCliente = $_POST['idCliente'];
$resultado = new Pessoa();
$resultado = $resultado->listaCliente( $idCliente );
foreach ($resultado as $chave => $valor) {
    ?>
    <tr>
        <td><?php echo exibeId($valor->getIdClientePessoa()); ?></td>
        <td><?php echo $valor->getFuncao(); ?></td>
        <td><?php echo $valor->getNome(); ?></td>
        <td><?php echo $valor->getDataNascimento(); ?></td>
        <td><?php echo $valor->getEmail(); ?></td>
        <td><?php echo $valor->getTelefoneCelular(); ?></td>
        <td>
            <a class="btn btn-default btnEditaClientePessoa"
               title="Editar"
               data-idClientePessoa="<?php echo $valor->getIdClientePessoa(); ?>"
               data-idPessoaFuncao="<?php echo $valor->getIdPessoaFuncao(); ?>"
               data-idPessoa="<?php echo $valor->getIdPessoa(); ?>"
               data-nomePessoa="<?php echo $valor->getNome(); ?>"
            >
                <i class="fa fa-edit"></i>
            </a>
            <a href="#"
               class="btn btn-default excluiClientePessoa"
               data-idClientePessoa="<?php echo $valor->getIdClientePessoa(); ?>"
               data-idCliente="<?php echo $idCliente; ?>"
               title="Excluir"
            >
                <i class="fa fa-trash-o"></i>
            </a>
        </td>
    </tr>
    <?php
}
