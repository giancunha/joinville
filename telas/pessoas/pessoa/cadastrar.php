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
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label class="control-label">Nome</label>
                                    <input type="text" name="nome" class="form-control" maxlength="150" required>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <label class="control-label">Data Nascimento</label>
                                <input type="text" name="dataNascimento" class="form-control dataNascimento" maxlength="10">
                            </div>
                        </div>
                        <div class="mb15"></div>
                        <div class="row">
                            <div class="col-sm-4">
                                <label class="control-label">Telefone Celular</label>
                                <input type="text" name="telefoneCelular" class="form-control telefone" maxlength="20">
                            </div>
                            <div class="col-sm-4">
                                <label>Sexo</label>
                                <select name="sexo" class="select2" required>
                                    <option value=""> Selecione </option>
                                    <option value="M"> Masculino </option>
                                    <option value="F"> Feminino </option>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label class="control-label">E-mail</label>
                                <input type="text" name="email" class="form-control" maxlength="100">
                            </div>
                        </div>
                    </div><!-- panel-body -->
                </div>
            </div><!-- PANEL DADOS PESSOAIS -->
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
