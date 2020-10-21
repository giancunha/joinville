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
    function excluiProdutoTipo() {
        $(".excluiProdutoTipo").click(function (e) {
            e.preventDefault();
            mensagemajax("<i class='fa fa-spinner fa-spin'></i> Excluindo dado. Aguarde...", 'growl-warning');
            var secaoPai = $(this).attr("data-secaoPai");
            var secaoFilho = $(this).attr("data-secaoFilho");
            caminho = secaoPai + "/" + secaoFilho + "/exclui" + ucFirst(secaoFilho);
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
                        '           data-secaoPai="' + data.secaoPai + '"\n' +
                        '           data-secaoFilho="' + data.secaoFilho + '"\n' +
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
                        '           class="btn btn-default excluiProdutoTipo"\n' +
                        '           data-secaoPai="' + urlSecaoPai + '"\n' +
                        '           data-secaoFilho="' + urlSecaoFilho + '"\n' +
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
