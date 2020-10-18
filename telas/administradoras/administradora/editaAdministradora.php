<?php
$administradora = new Administradora();
$administradora->setid($_GET['id']);
$administradora->seleciona();
?>
<div class="contentpanel">
    <form action="" method="post" id="formulario">
        <input type="hidden" name="id" value="<?php echo $administradora->getId(); ?>" />
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">Dados Gerais</h4>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Razão Social</label>
                                    <input type="text" name="razaoSocial" class="form-control" maxlength="150" required value="<?php echo $administradora->getRazaoSocial(); ?>">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Nome Fantasia</label>
                                    <input type="text" name="nomeFantasia" class="form-control" maxlength="150" required value="<?php echo $administradora->getNomeFantasia(); ?>">
                                </div>
                            </div>
                        </div>
                        <div class="mb15"></div>
                        <div class="row">
                            <div class="col-sm-4">
                                <label class="control-label">Data Fundacao</label>
                                <input type="text" name="dataFundacao" class="form-control dataFundacao" maxlength="10" value="<?php echo $administradora->getDataFundacao(); ?>">
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label">CNPJ</label>
                                    <input type="text" name="cnpj" class="form-control cnpj" maxlength="15" required value="<?php echo $administradora->getCnpj(); ?>">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <label class="control-label">Telefone</label>
                                <input type="text" name="telefone" class="form-control telefone" maxlength="20" value="<?php echo $administradora->getTelefone(); ?>">
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
                            <div class="col-sm-12 buscaEndereco carregando">
                                <img src="../../../assets/images/loading.gif" />
                                Carregando endereço pelo novo CEP aguarde...
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-2">
                                <label class="control-label">CEP</label>
                                <input type="text" name="cep" id="cep" class="form-control cep" maxlength="10" value="<?php echo $administradora->getCep(); ?>">
                            </div>
                            <div class="col-sm-5">
                                <label class="control-label">Logradouro</label>
                                <input type="text" name="endereco" id="endereco" class="form-control" maxlength="200" value="<?php echo $administradora->getEndereco(); ?>">
                            </div>
                            <div class="col-sm-2">
                                <label class="control-label">Número</label>
                                <input type="text" name="numero" id="numero" class="form-control" maxlength="10" value="<?php echo $administradora->getNumero(); ?>">
                            </div>
                            <div class="col-sm-3">
                                <label class="control-label">Complemento</label>
                                <input type="text" name="complemento" class="form-control" maxlength="50" value="<?php echo $administradora->getComplemento(); ?>">
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
                                        if($valor->getIdPais() != $administradora->getIdPais()){
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
                                <span class="carregando">
                                    <img src="../../../assets/images/loading.gif" />Carregando, aguarde...
                                </span>
                                <select name="idEstado" title="Escolha seu estado" id="idEstado" class="select2">
                                    <?php
                                    $resultado = Estado::listaPorPais( $administradora->getIdPais() );
                                    foreach($resultado as $chave => $valor){
                                        if($valor->getIdEstado() != $administradora->getIdEstado()){
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
                                <span class="carregando">
                                    <img src="../../../assets/images/loading.gif" />Carregando, aguarde...
                                </span>
                                <select name="idCidade" title="Escolha sua cidade" id="idCidade" class="select2" required >
                                    <?php
                                    $resultado = Cidade::listaPorEstado( $administradora->getIdEstado() );
                                    foreach($resultado as $chave => $valor){
                                        if($valor->getIdCidade() != $administradora->getIdCidade()){
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
                                <input type="text" name="bairro" id="bairro" class="form-control" maxlength="100" value="<?php echo $administradora->getBairro(); ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- LINHA 1 -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">Observações</h4>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <textarea name="observacoes" class="form-control wysiwyg" rows="5"><?php echo $administradora->getObservacoes(); ?></textarea>
                                <br>
                            </div>
                        </div>
                    </div><!-- panel-body -->
                </div>
            </div>
        </div><!-- LINHA 2 -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary" id="btnAlteraDado" data-toggle="modal" data-secaoPai="<?php echo $gets[0]; ?>" data-secaoFilho="<?php echo $gets[1]; ?>">Atualizar</button>
                            <a href="javascript: history.go(-1);" class="btn btn-default">Voltar</a>
                            <a href="<?php echo URLADM ?>/<?php echo $gets[0]; ?>/<?php echo $gets[1]; ?>/historicoAgenda/?id=<?php echo $administradora->getId(); ?>" class="btn btn-default">
                                <i class="fa fa-history"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
