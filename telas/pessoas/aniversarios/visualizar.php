<?php $mesAtual = date('m'); ?>
<div class="contentpanel">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">Aniversariantes</h4>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <ul class="nav nav-tabs" id="myTab">
                        <li<?php if($mesAtual == 1){ echo ' class="active"'; } ?>><a href="#janeiro">Janeiro</a></li>
                        <li<?php if($mesAtual == 2){ echo ' class="active"'; } ?>><a href="#fevereiro">Fevereiro</a></li>
                        <li<?php if($mesAtual == 3){ echo ' class="active"'; } ?>><a href="#marco">Março</a></li>
                        <li<?php if($mesAtual == 4){ echo ' class="active"'; } ?>><a href="#abril">Abril</a></li>
                        <li<?php if($mesAtual == 5){ echo ' class="active"'; } ?>><a href="#maio">Maio</a></li>
                        <li<?php if($mesAtual == 6){ echo ' class="active"'; } ?>><a href="#junho">Junho</a></li>
                        <li<?php if($mesAtual == 7){ echo ' class="active"'; } ?>><a href="#julho">Julho</a></li>
                        <li<?php if($mesAtual == 8){ echo ' class="active"'; } ?>><a href="#agosto">Agosto</a></li>
                        <li<?php if($mesAtual == 9){ echo ' class="active"'; } ?>><a href="#setembro">Setembro</a></li>
                        <li<?php if($mesAtual == 10){ echo ' class="active"'; } ?>><a href="#outubro">Outubro</a></li>
                        <li<?php if($mesAtual == 11){ echo ' class="active"'; } ?>><a href="#novembro">Novembro</a></li>
                        <li<?php if($mesAtual == 12){ echo ' class="active"'; } ?>><a href="#dezembro">Dezembro</a></li>
                    </ul>
                    <?php
                    switch ($mesAtual) {
                        case '1': $aba = 'janeiro'; break;
                        case '2': $aba = 'fevereiro'; break;
                        case '3': $aba = 'marco'; break;
                        case '4': $aba = 'abril'; break;
                        case '5': $aba = 'maio'; break;
                        case '6': $aba = 'junho'; break;
                        case '7': $aba = 'julho'; break;
                        case '8': $aba = 'agosto'; break;
                        case '9': $aba = 'setembro'; break;
                        case '10': $aba = 'outubro'; break;
                        case '11': $aba = 'novembro'; break;
                        case '12': $aba = 'dezembro'; break;
                    }
                    ?>
                    <div class="col-sm-12">
                        <button type="button" class="btn btn-primary" data-toggle="modal" id="imprimirAba">Imprimir</button>
                        <input type="hidden" id="abaSelecionada" value="<?php echo $aba; ?>"/>
                    </div>
                    <div class="tab-content" id="myTab">
                        <div class="tab-pane<?php if($mesAtual == 1){ echo ' active'; } ?>" id="janeiro">
                            <h2>Janeiro</h2>
                            <table class="table table-bordered table-stripped table-hover">
                                <thead>
                                    <tr>
                                      <th>Dia</th>
                                      <th>Nome</th>
                                      <th>E-mail</th>
                                      <th>Celular</th>
                                    </tr>
                                </thead>
                                <tbody>
                            <?php
                                $resultado = Pessoa::listaAniversarios( 1 );
                                foreach($resultado as $chave => $valor){
                                    $data = explode('/', $valor->getDataNascimento());
                                    $dia = $data[0];
                                    $mes = $data[1];
                            ?>
                                    <tr>
                                        <td><?php echo $dia."/".$mes; ?></td>
                                        <td><?php echo $valor->getNome(); ?></td>
                                        <td><?php echo $valor->getEmail(); ?></td>
                                        <td><?php echo $valor->getTelefoneCelular(); ?></td>
                                    </tr>
                            <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane<?php if($mesAtual == 2){ echo ' active'; } ?>" id="fevereiro">
                            <h2>Fevereiro</h2>
                            <table class="table table-bordered table-stripped table-hover">
                                <thead>
                                    <tr>
                                      <th>Dia</th>
                                      <th>Nome</th>
                                      <th>E-mail</th>
                                      <th>Celular</th>
                                    </tr>
                                </thead>
                                <tbody>
                            <?php
                                $resultado = Pessoa::listaAniversarios( 2 );
                                foreach($resultado as $chave => $valor){
                                    $data = explode('/', $valor->getDataNascimento());
                                    $dia = $data[0];
                                    $mes = $data[1];
                            ?>
                                    <tr>
                                        <td><?php echo $dia."/".$mes; ?></td>
                                        <td><?php echo $valor->getNome(); ?></td>
                                        <td><?php echo $valor->getEmail(); ?></td>
                                        <td><?php echo $valor->getTelefoneCelular(); ?></td>
                                    </tr>
                            <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane<?php if($mesAtual == 3){ echo ' active imprimirTabela'; } ?>" id="marco">
                            <h2>Março</h2>
                            <table class="table table-bordered table-stripped table-hover">
                                <thead>
                                    <tr>
                                      <th>Dia</th>
                                      <th>Nome</th>
                                      <th>E-mail</th>
                                      <th>Celular</th>
                                    </tr>
                                </thead>
                                <tbody>
                            <?php
                                $resultado = Pessoa::listaAniversarios( 3 );
                                foreach($resultado as $chave => $valor){
                                    $data = explode('/', $valor->getDataNascimento());
                                    $dia = $data[0];
                                    $mes = $data[1];
                            ?>
                                    <tr>
                                        <td><?php echo $dia."/".$mes; ?></td>
                                        <td><?php echo $valor->getNome(); ?></td>
                                        <td><?php echo $valor->getEmail(); ?></td>
                                        <td><?php echo $valor->getTelefoneCelular(); ?></td>
                                    </tr>
                            <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane<?php if($mesAtual == 4){ echo ' active'; } ?>" id="abril">
                            <h2>Abril</h2>
                            <table class="table table-bordered table-stripped table-hover">
                                <thead>
                                    <tr>
                                      <th>Dia</th>
                                      <th>Nome</th>
                                      <th>E-mail</th>
                                      <th>Celular</th>
                                    </tr>
                                </thead>
                                <tbody>
                            <?php
                                $resultado = Pessoa::listaAniversarios( 4 );
                                foreach($resultado as $chave => $valor){
                                    $data = explode('/', $valor->getDataNascimento());
                                    $dia = $data[0];
                                    $mes = $data[1];
                            ?>
                                    <tr>
                                        <td><?php echo $dia."/".$mes; ?></td>
                                        <td><?php echo $valor->getNome(); ?></td>
                                        <td><?php echo $valor->getEmail(); ?></td>
                                        <td><?php echo $valor->getTelefoneCelular(); ?></td>
                                    </tr>
                            <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane<?php if($mesAtual == 5){ echo ' active'; } ?>" id="maio">
                            <h2>Maio</h2>
                            <table class="table table-bordered table-stripped table-hover">
                                <thead>
                                    <tr>
                                      <th>Dia</th>
                                      <th>Nome</th>
                                      <th>E-mail</th>
                                      <th>Celular</th>
                                    </tr>
                                </thead>
                                <tbody>
                            <?php
                                $resultado = Pessoa::listaAniversarios( 5 );
                                foreach($resultado as $chave => $valor){
                                    $data = explode('/', $valor->getDataNascimento());
                                    $dia = $data[0];
                                    $mes = $data[1];
                            ?>
                                    <tr>
                                        <td><?php echo $dia."/".$mes; ?></td>
                                        <td><?php echo $valor->getNome(); ?></td>
                                        <td><?php echo $valor->getEmail(); ?></td>
                                        <td><?php echo $valor->getTelefoneCelular(); ?></td>
                                    </tr>
                            <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane<?php if($mesAtual == 6){ echo ' active'; } ?>" id="junho">
                            <h2>Junho</h2>
                            <table class="table table-bordered table-stripped table-hover">
                                <thead>
                                    <tr>
                                      <th>Dia</th>
                                      <th>Nome</th>
                                      <th>E-mail</th>
                                      <th>Celular</th>
                                    </tr>
                                </thead>
                                <tbody>
                            <?php
                                $resultado = Pessoa::listaAniversarios( 6 );
                                foreach($resultado as $chave => $valor){
                                    $data = explode('/', $valor->getDataNascimento());
                                    $dia = $data[0];
                                    $mes = $data[1];
                            ?>
                                    <tr>
                                        <td><?php echo $dia."/".$mes; ?></td>
                                        <td><?php echo $valor->getNome(); ?></td>
                                        <td><?php echo $valor->getEmail(); ?></td>
                                        <td><?php echo $valor->getTelefoneCelular(); ?></td>
                                    </tr>
                            <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane<?php if($mesAtual == 7){ echo ' active'; } ?>" id="julho">
                            <h2>Julho</h2>
                            <table class="table table-bordered table-stripped table-hover">
                                <thead>
                                    <tr>
                                      <th>Dia</th>
                                      <th>Nome</th>
                                      <th>E-mail</th>
                                      <th>Celular</th>
                                    </tr>
                                </thead>
                                <tbody>
                            <?php
                                $resultado = Pessoa::listaAniversarios( 7 );
                                foreach($resultado as $chave => $valor){
                                    $data = explode('/', $valor->getDataNascimento());
                                    $dia = $data[0];
                                    $mes = $data[1];
                            ?>
                                    <tr>
                                        <td><?php echo $dia."/".$mes; ?></td>
                                        <td><?php echo $valor->getNome(); ?></td>
                                        <td><?php echo $valor->getEmail(); ?></td>
                                        <td><?php echo $valor->getTelefoneCelular(); ?></td>
                                    </tr>
                            <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane<?php if($mesAtual == 8){ echo ' active'; } ?>" id="agosto">
                            <h2>Agosto</h2>
                            <table class="table table-bordered table-stripped table-hover">
                                <thead>
                                    <tr>
                                      <th>Dia</th>
                                      <th>Nome</th>
                                      <th>E-mail</th>
                                      <th>Celular</th>
                                    </tr>
                                </thead>
                                <tbody>
                            <?php
                                $resultado = Pessoa::listaAniversarios( 8 );
                                foreach($resultado as $chave => $valor){
                                    $data = explode('/', $valor->getDataNascimento());
                                    $dia = $data[0];
                                    $mes = $data[1];
                            ?>
                                    <tr>
                                        <td><?php echo $dia."/".$mes; ?></td>
                                        <td><?php echo $valor->getNome(); ?></td>
                                        <td><?php echo $valor->getEmail(); ?></td>
                                        <td><?php echo $valor->getTelefoneCelular(); ?></td>
                                    </tr>
                            <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane<?php if($mesAtual == 9){ echo ' active'; } ?>" id="setembro">
                            <h2>Setembro</h2>
                            <table class="table table-bordered table-stripped table-hover">
                                <thead>
                                    <tr>
                                      <th>Dia</th>
                                      <th>Nome</th>
                                      <th>E-mail</th>
                                      <th>Celular</th>
                                    </tr>
                                </thead>
                                <tbody>
                            <?php
                                $resultado = Pessoa::listaAniversarios( 9 );
                                foreach($resultado as $chave => $valor){
                                    $data = explode('/', $valor->getDataNascimento());
                                    $dia = $data[0];
                                    $mes = $data[1];
                            ?>
                                    <tr>
                                        <td><?php echo $dia."/".$mes; ?></td>
                                        <td><?php echo $valor->getNome(); ?></td>
                                        <td><?php echo $valor->getEmail(); ?></td>
                                        <td><?php echo $valor->getTelefoneCelular(); ?></td>
                                    </tr>
                            <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane<?php if($mesAtual == 10){ echo ' active'; } ?>" id="outubro">
                            <h2>Outubro</h2>
                            <table class="table table-bordered table-stripped table-hover">
                                <thead>
                                    <tr>
                                      <th>Dia</th>
                                      <th>Nome</th>
                                      <th>E-mail</th>
                                      <th>Celular</th>
                                    </tr>
                                </thead>
                                <tbody>
                            <?php
                                $resultado = Pessoa::listaAniversarios( 10 );
                                foreach($resultado as $chave => $valor){
                                    $data = explode('/', $valor->getDataNascimento());
                                    $dia = $data[0];
                                    $mes = $data[1];
                            ?>
                                    <tr>
                                        <td><?php echo $dia."/".$mes; ?></td>
                                        <td><?php echo $valor->getNome(); ?></td>
                                        <td><?php echo $valor->getEmail(); ?></td>
                                        <td><?php echo $valor->getTelefoneCelular(); ?></td>
                                    </tr>
                            <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane<?php if($mesAtual == 11){ echo ' active'; } ?>" id="novembro">
                            <h2>Novembro</h2>
                            <table class="table table-bordered table-stripped table-hover">
                                <thead>
                                    <tr>
                                      <th>Dia</th>
                                      <th>Nome</th>
                                      <th>E-mail</th>
                                      <th>Celular</th>
                                    </tr>
                                </thead>
                                <tbody>
                            <?php
                                $resultado = Pessoa::listaAniversarios( 11 );
                                foreach($resultado as $chave => $valor){
                                    $data = explode('/', $valor->getDataNascimento());
                                    $dia = $data[0];
                                    $mes = $data[1];
                            ?>
                                    <tr>
                                        <td><?php echo $dia."/".$mes; ?></td>
                                        <td><?php echo $valor->getNome(); ?></td>
                                        <td><?php echo $valor->getEmail(); ?></td>
                                        <td><?php echo $valor->getTelefoneCelular(); ?></td>
                                    </tr>
                            <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane<?php if($mesAtual == 12){ echo ' active'; } ?>" id="dezembro">
                            <h2>Dezembro</h2>
                            <table class="table table-bordered table-stripped table-hover">
                                <thead>
                                    <tr>
                                      <th>Dia</th>
                                      <th>Nome</th>
                                      <th>E-mail</th>
                                      <th>Celular</th>
                                    </tr>
                                </thead>
                                <tbody>
                            <?php
                                $resultado = Pessoa::listaAniversarios( 12 );
                                foreach($resultado as $chave => $valor){
                                    $data = explode('/', $valor->getDataNascimento());
                                    $dia = $data[0];
                                    $mes = $data[1];
                            ?>
                                    <tr>
                                        <td><?php echo $dia."/".$mes; ?></td>
                                        <td><?php echo $valor->getNome(); ?></td>
                                        <td><?php echo $valor->getEmail(); ?></td>
                                        <td><?php echo $valor->getTelefoneCelular(); ?></td>
                                    </tr>
                            <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div><!-- panel-body -->
        </div>
    </div>
</div>
