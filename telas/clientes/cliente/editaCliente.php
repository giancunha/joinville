<?php
$cliente = new Cliente();
$cliente->setid($_GET['id']);
$cliente->seleciona();
?>
<div class="contentpanel">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">Cliente - <?php echo $cliente->getNomeFantasia(); ?> - <?php echo $cliente->getCnpjCpf(); ?></h4>
            </div>
            <ul class="nav nav-tabs nav-justified">
                <li class="active"><a href="#dadosCadastrais" data-toggle="tab"><strong>Dados Cadastrais</strong></a></li>
                <li><a href="#contatos" data-toggle="tab"><strong>Contatos</strong></a></li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane active" id="dadosCadastrais">
                    <form action="" method="post" id="formulario">
                        <input type="hidden" name="id" value="<?php echo $cliente->getId(); ?>" />
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="control-label">Razão Social / Nome Completo</label>
                                            <input type="text" name="razaoSocial" class="form-control" maxlength="150" required value="<?php echo $cliente->getRazaoSocial(); ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="control-label">Nome</label>
                                            <input type="text" name="nomeFantasia" class="form-control" maxlength="150" required value="<?php echo $cliente->getNomeFantasia(); ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label class="control-label">Vencimento Fatura</label>
                                            <select name="vencimentoFatura" class="select2" required>
                                                <?php
                                                $vencimentos = explode(',', VENCIMENTOSFATURA);
                                                foreach($vencimentos as $chave => $vencimento){
                                                    if($vencimento != $cliente->getVencimentoFatura()){
                                                        $seleciona = '';
                                                    } else {
                                                        $seleciona = " selected";
                                                    }
                                                    ?>
                                                    <option value="<?php echo $vencimento; ?>"<?php echo $seleciona; ?>> <?php echo $vencimento; ?> </option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label class="control-label">Envia Nota</label>
                                            <select name="enviaNota" class="select2" required>
                                                <option value="1"<?php if($cliente->getEnviaNota() == 1){ echo ' selected'; } ?>>Sim</option>
                                                <option value="0"<?php if($cliente->getEnviaNota() == 0){ echo ' selected'; } ?>>Não</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb15"></div>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <label>Administradora</label>
                                        <select name="idAdministradora" class="select2">
                                            <option value="0"> Selecione </option>
                                            <?php
                                            $resultado = Administradora::listaPrincipal( );
                                            foreach($resultado as $chave => $valor){
                                                if($valor->getId() != $cliente->getIdAdministradora()){
                                                    $selecionado = '';
                                                } else {
                                                    $selecionado = ' selected';
                                                }
                                                ?>
                                                <option value="<?php echo $valor->getId(); ?>"<?php echo $selecionado; ?>><?php echo $valor->getNomeFantasia(); ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="control-label">Data Fundacao / Data Nascimento</label>
                                        <input type="text" name="dataFundacao" class="form-control dataFundacao" maxlength="10" value="<?php echo $cliente->getDataFundacao(); ?>">
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label class="control-label">
                                                CNPJ/CPF
                                                <a href="javascript:;"
                                                   class="btn btn-default copiarCampo"
                                                   title="Copiar documento cliente"
                                                   data-clipboard-text="<?php echo soNumero($cliente->getCnpjCpf()); ?>"
                                                   data-nomeCampo="Documento"
                                                >
                                                    <i class="fa fa-id-card"></i>
                                                </a>
                                            </label>
                                            <input type="text" name="cnpjCpf" class="form-control cnpjCpf" maxlength="18" required value="<?php echo $cliente->getCnpjCpf(); ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="control-label">Telefone</label>
                                        <input type="text" name="telefone" class="form-control telefone" maxlength="20" value="<?php echo $cliente->getTelefone(); ?>">
                                    </div>
                                </div>
                                <div class="mb15"></div>
                                <div class="row">
                                    <div class="col-sm-2">
                                        <label class="control-label">CEP</label>
                                        <input type="text" name="cep" id="cep" class="form-control cep" maxlength="10" value="<?php echo $cliente->getCep(); ?>">
                                    </div>
                                    <div class="col-sm-5">
                                        <label class="control-label">Logradouro</label>
                                        <input type="text" name="endereco" id="endereco" class="form-control" maxlength="200" value="<?php echo $cliente->getEndereco(); ?>">
                                    </div>
                                    <div class="col-sm-2">
                                        <label class="control-label">Número</label>
                                        <input type="text" name="numero" id="numero" class="form-control" maxlength="10" value="<?php echo $cliente->getNumero(); ?>">
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="control-label">Complemento</label>
                                        <input type="text" name="complemento" class="form-control" maxlength="50" value="<?php echo $cliente->getComplemento(); ?>">
                                    </div>
                                </div>
                                <div class="mb15"></div>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <label>País</label>
                                        <select name="idPais" class="select2" id="idPais">
                                            <option value="0"> Selecione </option>
                                            <?php
                                            $resultado = Pais::listaPrincipal( );
                                            foreach($resultado as $chave => $valor){
                                                if($valor->getIdPais() != $cliente->getIdPais()){
                                                    $selecionado = '';
                                                } else {
                                                    $selecionado = ' selected';
                                                }
                                                ?>
                                                <option value="<?php echo $valor->getIdPais(); ?>"<?php echo $selecionado; ?>><?php echo $valor->getNome(); ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Estado</label>
                                        <select name="idEstado" title="Escolha seu estado" id="idEstado" class="select2">
                                            <?php
                                            $resultado = Estado::listaPorPais( $cliente->getIdPais() );
                                            foreach($resultado as $chave => $valor){
                                                if($valor->getIdEstado() != $cliente->getIdEstado()){
                                                    $selecionado = '';
                                                } else {
                                                    $selecionado = ' selected';
                                                }
                                                ?>
                                                <option value="<?php echo $valor->getIdEstado(); ?>"<?php echo $selecionado; ?>><?php echo $valor->getEstado(); ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Cidade</label>
                                        <select name="idCidade" title="Escolha sua cidade" id="idCidade" class="select2" required >
                                            <?php
                                            $cidade = new Cidade();
                                            $cidade->setIdCidade( $cliente->getIdCidade() );
                                            $cidade->seleciona();
                                            ?>
                                            <option value="<?php echo $cidade->getIdCidade(); ?>" selected><?php echo $cidade->getCidade(); ?></option>
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="control-label">Bairro</label>
                                        <input type="text" name="bairro" id="bairro" class="form-control" maxlength="100" value="<?php echo $cliente->getBairro(); ?>">
                                    </div>
                                </div>
                                <div class="mb15"></div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <label class="control-label">Latitude</label>
                                        <input type="text" name="latitude" class="form-control" maxlength="14" value="<?php echo $cliente->getLatitude(); ?>" />
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="control-label">Longitude</label>
                                        <input type="text" name="longitude" class="form-control" maxlength="14" value="<?php echo $cliente->getLongitude(); ?>" />
                                    </div>
                                </div>
                                <div class="mb15"></div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label class="control-label">Observações</label>
                                        <textarea name="observacoes" class="form-control wysiwyg" rows="5"><?php echo $cliente->getObservacoes(); ?></textarea><br>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="panel panel-default">
                                            <div class="panel-body">
                                                <div class="col-md-12">
                                                    <button type="submit" class="btn btn-primary" id="btnAlteraDado" data-toggle="modal" data-secaoPai="<?php echo $gets[0]; ?>" data-secaoFilho="<?php echo $gets[1]; ?>">Atualizar</button>
                                                    <a href="javascript: history.go(-1);" class="btn btn-default">Voltar</a>
                                                    <button type="reset" class="btn btn-warning" data-toggle="modal">Limpar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="tab-pane" id="contatos">
                    <div class="panel-body">
                        <form action="" method="post" id="formularioClientePessoa">
                            <input type="hidden" name="idClientePessoa" id="idClientePessoa" />
                            <input type="hidden" name="idCliente" id="idCliente" value="<?php echo $cliente->getId(); ?>" />
                            <div class="row">
                                <div class="col-sm-3">
                                    <select name="idPessoaFuncao" title="Escolha a função da pessoa" id="idPessoaFuncao" class="select2">
                                        <option value="">Selecione a função</option>
                                        <?php
                                        $resultado = PessoaFuncao::listaPrincipal( );
                                        foreach($resultado as $chave => $valor){
                                            ?>
                                            <option value="<?php echo $valor->getId(); ?>"><?php echo $valor->getNome(); ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-sm-7">
                                    <select name="idPessoa" title="Escolha o contato" id="idPessoa" class="select2">
                                        <option value="">Selecione o contato</option>
                                        <?php
                                        $resultado = Pessoa::listaPrincipal( );
                                        foreach($resultado as $chave => $valor){
                                            ?>
                                            <option value="<?php echo $valor->getIdPessoa(); ?>"><?php echo $valor->getNome(); ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit"
                                            class="btn btn-primary"
                                            id="btnClientePessoa"
                                            data-toggle="modal"
                                            data-secaoPai="pessoas"
                                            data-secaoFilho="pessoa"
                                    >
                                        Cadastrar
                                    </button>
                                    <a href="<?php echo URLADM . '/pessoas/pessoa/cadastrar'; ?>"
                                       class="btn btn-default"
                                       title="Cadastrar Nova Pessoa"
                                       target="_blank"
                                    >
                                        <i class="fa fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                        </form>
                        <div class="mb15"></div>
                        <div class="col-sm-12">
                            <div class="row table-responsive">
                                <table class="table table-bordered table-hover table-default display">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Função</th>
                                        <th>Nome</th>
                                        <th>Aniversário</th>
                                        <th>E-mail</th>
                                        <th>Telefone</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                    </thead>
                                    <tbody class="consultaClientePessoa">
                                    <?php
                                    $resultado = new Pessoa();
                                    $resultado = $resultado->listaCliente( $cliente->getId() );
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
                                                   data-idCliente="<?php echo $cliente->getId(); ?>"
                                                   title="Excluir"
                                                >
                                                    <i class="fa fa-trash-o"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
