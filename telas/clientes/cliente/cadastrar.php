<div class="contentpanel">
    <form action="" method="post" id="formulario">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">Dados Gerais</h4>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label">Razão Social / Nome Completo</label>
                                    <input type="text" name="razaoSocial" class="form-control" maxlength="150" required>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label">Nome Fantasia</label>
                                    <input type="text" name="nomeFantasia" class="form-control" maxlength="150" required>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label class="control-label">Vencimento Fatura</label>
                                    <select name="vencimentoFatura" class="select2" required>
                                        <?php
                                        $vencimentos = explode(',', VENCIMENTOSFATURA);
                                        foreach($vencimentos as $chave => $vencimento){
                                            ?>
                                            <option value="<?php echo $vencimento; ?>"> <?php echo $vencimento; ?> </option>
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
                                        <option value="1">Sim</option>
                                        <option value="0">Não</option>
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
                                        ?>
                                        <option value="<?php echo $valor->getId(); ?>"><?php echo $valor->getNomeFantasia(); ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <label class="control-label">Data Fundacao / Data Nascimento</label>
                                <input type="text" name="dataFundacao" class="form-control dataFundacao" maxlength="10">
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="control-label">CNPJ/CPF</label>
                                    <input type="text" name="cnpjCpf" class="form-control cnpjCpf" maxlength="18" required>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <label class="control-label">Telefone</label>
                                <input type="text" name="telefone" class="form-control telefone" maxlength="20">
                            </div>
                        </div>
                    </div><!-- panel-body -->
                </div>
            </div><!-- PANEL DADOS PESSOAIS -->
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">Endereço</h4>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-2">
                                <label class="control-label">CEP</label>
                                <input type="text" name="cep" id="cep" class="form-control cep" maxlength="10" />
                            </div>
                            <div class="col-sm-5">
                                <label class="control-label">Logradouro</label>
                                <input type="text" name="endereco" id="endereco" class="form-control" maxlength="200" />
                            </div>
                            <div class="col-sm-2">
                                <label class="control-label">Número</label>
                                <input type="text" name="numero" id="numero" class="form-control" maxlength="10" />
                            </div>
                            <div class="col-sm-3">
                                <label class="control-label">Complemento</label>
                                <input type="text" name="complemento" class="form-control" maxlength="50" />
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
                                        if($valor->getIdPais() != 1){
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
                                    $resultado = Estado::listaPorPais( 1 );
                                    foreach($resultado as $chave => $valor){
                                        if($valor->getIdEstado() != 23 ){
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
                                    $resultado = Cidade::listaPorEstado( 23 );
                                    foreach($resultado as $chave => $valor){
                                        if($valor->getIdCidade() != 3932){
                                            $selecionado = '';
                                        } else {
                                            $selecionado = ' selected';
                                        }
                                        ?>
                                        <option value="<?php echo $valor->getIdCidade(); ?>"<?php echo $selecionado; ?>><?php echo $valor->getCidade(); ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <label class="control-label">Bairro</label>
                                <input type="text" name="bairro" id="bairro" class="form-control" maxlength="100"  />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">Localização</h4>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <label class="control-label">Latitude</label>
                                <input type="text" name="latitude" class="form-control" maxlength="14" />
                            </div>
                            <div class="col-sm-6">
                                <label class="control-label">Longitude</label>
                                <input type="text" name="longitude" class="form-control" maxlength="14" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">Observações</h4>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <textarea name="observacoes" class="form-control wysiwyg" rows="5"></textarea>
                                <br>
                            </div>
                        </div>
                    </div><!-- panel-body -->
                </div>
            </div><!-- PAINEL DESCRIÇÃO PRODUTOS -->
        </div><!-- LINHA 2 -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">Contatos</h4>
                    </div>
                    <div class="panel-body">
                        <?php
                        $numeroContatos = 3;
                        for ($i = 1; $i <= $numeroContatos; $i++) {
                            ?>
                            <div class="row">
                                <div class="col-sm-4">
                                    <select name="idPessoaFuncao[]" title="Escolha a função da pessoa" class="select2">
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
                                <div class="col-sm-8">
                                    <select name="idPessoa[]" title="Escolha o contato" class="select2">
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
                            </div>
                            <div class="mb10"></div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary" id="btnIncluiDado" data-toggle="modal" data-secaoPai="<?php echo $gets[0]; ?>" data-secaoFilho="<?php echo $gets[1]; ?>">Cadastrar</button>
                            <button type="reset" class="btn btn-warning" data-toggle="modal">Limpar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
