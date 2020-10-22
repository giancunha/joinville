$(document).ready(function () {
    var urlSecaoPai = $('#urlSecaoPai').val();
    var urlSecaoFilho = $('#urlSecaoFilho').val();
    $("#formFiltro").submit(function ( e ) {
        e.preventDefault();
        listaPrincipal();
    });
    function editaProduto() {
        $(".editaProduto").click(function () {
            var idProduto = $(this).data('id');
            $.getJSON('/telas/' + urlSecaoPai + '/' + urlSecaoFilho + '/editaProduto.php', {
                idProduto: idProduto
            }, function (data) {
                $('html, body').animate({scrollTop: 200}, {duration: 3000});
                $('.telacadastro').show();
                $("#tituloCadastro").html('Edita Produto - ' + data.nome);
                $('#idProduto').val(data.id);
                $('#nome').val(data.nome);
                $('#valor').val(data.valor);
                $('#idTipo').val(data.idTipo).trigger('change');
                $('#btnIncluiDado').hide();
                $('#btnAlteraDado').show();
            });
        });
    }
    function editaProdutoTipo() {
        $(".editaProdutoTipo").click(function () {
            var idProdutoTipo = $(this).data('id');
            $.getJSON('/telas/' + urlSecaoPai + '/' + urlSecaoFilho + '/editaTipos.php', {
                idProdutoTipo: idProdutoTipo
            }, function (data) {
                $('html, body').animate({scrollTop: 200}, {duration: 3000});
                $('.telacadastro').show();
                $("#tituloCadastro").html('Edita Tipo - ' + data.tipo);
                $('#idProdutoTipo').val(data.id);
                $('#imposto').val(data.imposto);
                $('#tipo').val(data.tipo);
                $('#btnIncluiDado').hide();
                $('#btnAlteraDado').show();
            });
        });
    }
    function editaVenda() {
        $(".editaVenda").click(function () {
            $('html, body').animate({scrollTop: 200}, {duration: 3000});
            var id = $(this).data('id');
            $('#id_venda').val(id);
            $('#id_produtoNovo').val('').trigger('change');
            $('#quantidadeNovo').val(1);
            listaCompras();
        });
    }
    function excluiItem() {
        $(".excluiItem").click(function (e) {
            e.preventDefault();
            mensagemajax("<i class='fa fa-spinner fa-spin'></i> Excluindo dado. Aguarde...", 'growl-warning');
            caminho = urlSecaoPai + "/" + urlSecaoFilho + "/excluiItem";
            id = $(this).attr("data-id");
            resposta = confirm("Realmente deseja excluir esse dado?");
            if (resposta) {
                $.ajax({
                    type: "POST",
                    data: {
                        id: id
                    },
                    url: '/telas/' + caminho + '.php',
                    success: function (data) {
                        if (data == 1) {
                            mensagemajax('Removido com sucesso!', 'growl-success');
                            listaCompras();
                        } else {
                            mensagemajax('Erro ao remover!<br />Motivo:<br />' + data, 'growl-danger');
                        }
                    },
                    error: function () {
                        mensagemajax('Erro ao excluir!', 'growl-danger');
                    }
                });
            } else {
                mensagemajax("<i class='fa fa-info'></i> Exclusão cancelada", 'growl-info');
            }
        });
    }
    function excluiProduto() {
        $(".excluiProduto").click(function (e) {
            e.preventDefault();
            mensagemajax("<i class='fa fa-spinner fa-spin'></i> Excluindo dado. Aguarde...", 'growl-warning');
            caminho = urlSecaoPai + "/" + urlSecaoFilho + "/exclui" + ucFirst(urlSecaoFilho);
            id = $(this).attr("data-id");
            resposta = confirm("Realmente deseja excluir esse dado?");
            if (resposta) {
                $.ajax({
                    type: "POST",
                    data: {
                        id: id
                    },
                    url: '/telas/' + caminho + '.php',
                    success: function (data) {
                        if (data == 1) {
                            mensagemajax('Removido com sucesso!', 'growl-success');
                            listaPrincipal();
                        } else {
                            mensagemajax('Erro ao remover!<br />Motivo:<br />' + data, 'growl-danger');
                        }
                    },
                    error: function () {
                        mensagemajax('Erro ao excluir!', 'growl-danger');
                    }
                });
            } else {
                mensagemajax("<i class='fa fa-info'></i> Exclusão cancelada", 'growl-info');
            }
        });
    }
    function excluiProdutoTipo() {
        $(".excluiProdutoTipo").click(function (e) {
            e.preventDefault();
            mensagemajax("<i class='fa fa-spinner fa-spin'></i> Excluindo dado. Aguarde...", 'growl-warning');
            caminho = urlSecaoPai + "/" + urlSecaoFilho + "/exclui" + ucFirst(urlSecaoFilho);
            id = $(this).attr("data-id");
            resposta = confirm("Realmente deseja excluir esse dado?");
            if (resposta) {
                $.ajax({
                    type: "POST",
                    data: {
                        id: id
                    },
                    url: '/telas/' + caminho + '.php',
                    success: function (data) {
                        if (data == 1) {
                            mensagemajax('Removido com sucesso!', 'growl-success');
                            listaPrincipal();
                        } else {
                            mensagemajax('Erro ao remover!<br />Motivo:<br />' + data, 'growl-danger');
                        }
                    },
                    error: function () {
                        mensagemajax('Erro ao excluir!', 'growl-danger');
                    }
                });
            } else {
                mensagemajax("<i class='fa fa-info'></i> Exclusão cancelada", 'growl-info');
            }
        });
    }
    function finalizaVenda() {
        $("#btnFinalizaVenda").click(function (e) {
            e.preventDefault();
            mensagemajax("<i class='fa fa-spinner fa-spin'></i> Finalizando. Aguarde...", 'growl-warning');
            caminho = urlSecaoPai + "/" + urlSecaoFilho + "/finalizaVenda";
            var id_venda = $("#id_venda").val();
            $.getJSON('/telas/' + urlSecaoPai + '/' + urlSecaoFilho + '/finalizaVenda.php', {
                id_venda: id_venda
            }, function (data) {
                if(data == 1){
                    mensagemajax('Venda Finalizada', 'growl-success');
                    $("#id_venda").val(0);
                    listaCompras();
                    $("#tituloVenda").html('Nova Venda');
                } else{
                    mensagemajax('Erro ao finalizar ' + data, 'growl-danger');
                }
            });
        });
    }
    function insereItem() {
        $("#btnIncluiItem").click(function () {
            var id_venda = $("#id_venda").val();
            var id_produtoNovo = $("#id_produtoNovo").val();
            var quantidadeNovo = $("#quantidadeNovo").val();
            var msgErro = 'Erro ao inserir:';
            var erro = false;
            if(id_produtoNovo == ''){
                msgErro += '<br>Produto não selecionado';
                erro = true;
            }
            if(quantidadeNovo < 1){
                msgErro += '<br>Quantidade inválida';
                erro = true;
            }
            if(erro){
                mensagemajax(msgErro, 'growl-danger');
                return false;
            }
            $('#listaCompra').html("<td colspan='6' class='text-center'><i class='fa fa-spinner fa-spin'></i>Carregando lançamentos. Aguarde...</td>");
            $('#totalCompra, #totalImposto').html("<i class='fa fa-spinner fa-spin'></i>");
            $.getJSON('/telas/' + urlSecaoPai + '/' + urlSecaoFilho + '/insereItem.php', {
                id_venda: id_venda,
                id_produto: id_produtoNovo,
                quantidade: quantidadeNovo
            }, function (data) {
                $('#id_venda').val(data.id_venda);
                $('#id_produtoNovo').val('').trigger('change');
                $('#quantidadeNovo').val(1);
                listaCompras();
            });
        });
    }
    function listaCompras(){
        $('#listaCompra, #listaVendas').html("<td colspan='6' class='text-center'><i class='fa fa-spinner fa-spin'></i>Carregando lançamentos. Aguarde...</td>");
        $('#totalCompra, #totalImposto').html("<i class='fa fa-spinner fa-spin'></i>");
        var id_venda = $("#id_venda").val();
        $.getJSON('/telas/' + urlSecaoPai + '/' + urlSecaoFilho + '/listaCompras.php', {
            id: id_venda
        }, function (data) {
            var compras = data.compras;
            var lista = '';
            var temVendas = false;
            for (var i = 0; i < compras.length; i++) {
                temVendas = true;
                lista += "" +
                    "<tr valign='middle'>\n" +
                    '    <td>' + compras[i].item + '</td>\n' +
                    '    <td>' + compras[i].produto + '</td>\n' +
                    '    <td align="right">' + compras[i].quantidade + '</td>\n' +
                    '    <td align="right">R$ ' + compras[i].valor + '</td>\n' +
                    '    <td align="right">R$ ' + compras[i].subTotal + '</td>\n' +
                    '    <td align="right">R$ ' + compras[i].imposto + '</td>\n' +
                    '    <td align="right">\n' +
                    '        <a href="#"\n' +
                    '           class="btn btn-default excluiItem"\n' +
                    '           data-id="' + compras[i].id + '"\n' +
                    '           title="Excluir"\n' +
                    '        >\n' +
                    '            <i class="fa fa-trash-o"></i>\n' +
                    '        </a>\n' +
                    '    </td>\n' +
                    '</tr>'
            }
            if(temVendas){
                $("#tituloVenda").html('Venda ' + id_venda.padStart(5, '0'));
            }
            var historico = data.historico;
            var vendas = '';
            for (var i = 0; i < historico.length; i++) {
                vendas += "" +
                    "<tr valign='middle'>\n" +
                    '    <td>' + historico[i].idCompra + '</td>\n' +
                    '    <td>' + historico[i].dia + '</td>\n' +
                    '    <td>' + historico[i].hora + '</td>\n' +
                    '    <td>' + historico[i].status + '</td>\n' +
                    '    <td>' + historico[i].vendedor + '</td>\n' +
                    '    <td align="right">R$ ' + historico[i].valor + '</td>\n' +
                    '    <td align="right">\n'
                if(historico[i].status == 'Aberta'){
                    vendas += "" +
                        '        <a class="btn btn-default editaVenda"\n' +
                        '           title="Editar"\n' +
                        '           data-id="' + historico[i].id + '"\n' +
                        '        >\n' +
                        '            <i class="fa fa-edit"></i>\n' +
                        '        </a>\n'
                } else {
                    vendas += "&nbsp;"
                }
                vendas += "" +
                    '    </td>\n' +
                    '</tr>'
            }
            $('#dadosProduto').html(lista);
            $('#dadosProdutoFoot').html(data.tFoot);
            $('#totalCompra').text('R$ ' + data.totalCompra);
            $('#totalImposto').html('R$ ' + data.totalImposto);
            $('#listaCompra').html(lista);
            $('#listaVendas').html(vendas);
            resetaFormulario();
            editaVenda();
            excluiItem();
        });
    }
    window.listaPrincipal = function listaPrincipal() {
        if(urlSecaoFilho == 'tipos') {
            $('#dadosProdutoTipo').html("<td colspan='6' class='text-center'><i class='fa fa-spinner fa-spin'></i>Carregando previsões. Aguarde...</td>");
            $('#dadosProdutoTipoFoot').html("<i class='fa fa-spinner fa-spin'></i>");
            $.getJSON('/telas/' + urlSecaoPai + '/' + urlSecaoFilho + '/listaPrincipal.php', {

            }, function (data) {
                var produtos = data.produtos;
                var tipos = '';
                for (var i = 0; i < produtos.length; i++) {
                    tipos += "" +
                        "<tr valign='middle'>\n" +
                        '    <td>' + produtos[i].id + '</td>\n' +
                        '    <td>' + produtos[i].tipo + '</td>\n' +
                        '    <td align="right">' + produtos[i].imposto + '%</td>\n' +
                        '    <td align="right">\n' +
                        '        <a class="btn btn-default editaProdutoTipo"\n' +
                        '           title="Editar"\n' +
                        '           data-id="' + produtos[i].id + '"\n' +
                        '        >\n' +
                        '            <i class="fa fa-edit"></i>\n' +
                        '        </a>\n' +
                        '        <a href="#"\n' +
                        '           class="btn btn-default excluiProdutoTipo"\n' +
                        '           data-id="' + produtos[i].id + '"\n' +
                        '           title="Excluir"\n' +
                        '        >\n' +
                        '            <i class="fa fa-trash-o"></i>\n' +
                        '        </a>\n' +
                        '    </td>\n' +
                        '</tr>'
                }
                $('#dadosProdutoTipo').html(tipos);
                $('#dadosProdutoTipoFoot').html(data.tFoot);
                mensagemajax("Tipos carregados", 'growl-primary', 5000);
                $("#tituloCadastro").html('Inserir tipo');
                resetaFormulario();
                editaProdutoTipo();
                excluiProdutoTipo();
            });
            $(".novoLancamento").click(function () {
                $('.btncadastro').hide();
                $('.telacadastro').show();
            });
        } else if(urlSecaoFilho == 'produto') {
            $('#dadosProduto').html("<td colspan='6' class='text-center'><i class='fa fa-spinner fa-spin'></i>Carregando lançamentos. Aguarde...</td>");
            $('#dadosProdutoFoot').html("<i class='fa fa-spinner fa-spin'></i>");
            $.getJSON('/telas/' + urlSecaoPai + '/' + urlSecaoFilho + '/listaPrincipal.php', {
            }, function (data) {
                var produtos = data.produtos;
                var lista = '';
                for (var i = 0; i < produtos.length; i++) {
                    lista += "" +
                        "<tr valign='middle'>\n" +
                        '    <td>' + produtos[i].id + '</td>\n' +
                        '    <td>' + produtos[i].tipo + '</td>\n' +
                        '    <td>' + produtos[i].nome + '</td>\n' +
                        '    <td align="right">R$ ' + produtos[i].valor + '</td>\n' +
                        '    <td align="right">R$ ' + produtos[i].imposto + '</td>\n' +
                        '    <td align="right">\n' +
                        '        <a class="btn btn-default editaProduto"\n' +
                        '           title="Editar"\n' +
                        '           data-id="' + produtos[i].id + '"\n' +
                        '        >\n' +
                        '            <i class="fa fa-edit"></i>\n' +
                        '        </a>\n' +
                        '        <a href="#"\n' +
                        '           class="btn btn-default excluiProduto"\n' +
                        '           data-id="' + produtos[i].id + '"\n' +
                        '           title="Excluir"\n' +
                        '        >\n' +
                        '            <i class="fa fa-trash-o"></i>\n' +
                        '        </a>\n' +
                        '    </td>\n' +
                        '</tr>'
                }
                $('#dadosProduto').html(lista);
                $('#dadosProdutoFoot').html(data.tFoot);
                mensagemajax("Produtos carregados", 'growl-primary', 5000);
                $("#tituloCadastro").html('Inserir produto');
                resetaFormulario();
                editaProduto();
                excluiProduto();
            });
        } else if(urlSecaoFilho == 'vendas') {
            $('#listaCompra').html("<td colspan='6' class='text-center'><i class='fa fa-spinner fa-spin'></i>Carregando sistema. Aguarde...</td>");
            $('#totalCompra, #totalImposto').html("<i class='fa fa-spinner fa-spin'></i>");
            $("#tituloVenda").html('Nova Venda');
            $.getJSON('/telas/' + urlSecaoPai + '/' + urlSecaoFilho + '/listaPrincipal.php', {

            }, function (data) {
                $('#id_venda').val(data.id_venda);
                resetaFormulario();
                listaCompras();
                insereItem();
                finalizaVenda();
                mensagemajax("Dados carregados", 'growl-primary', 2000);
            });
        }
    }
    listaPrincipal();
    function resetaFormulario(){
        $('#formulario').each(function () {
            this.reset();
        });
        resetaSelects2();
        $('#btnIncluiDado').show();
        $('#btnAlteraDado').hide();
        $('.telacadastro').hide();
        $('.btncadastro').show();
    }
});
