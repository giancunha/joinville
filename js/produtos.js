$(document).ready(function () {
    var urlSecaoPai = $('#urlSecaoPai').val();
    var urlSecaoFilho = $('#urlSecaoFilho').val();
    $("#formFiltro").submit(function ( e ) {
        e.preventDefault();
        listaPrincipal();
    });
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
        } else if(urlSecaoFilho == 'caixaFluxo') {
            var dataInicial = $('#dataInicial').val();
            var dataFinal = $('#dataFinal').val();
            $('.saldoAnterior, .saldoPeriodo, .saldoTotal').html("<i class='fa fa-spinner fa-spin'></i>");
            $('#dadosCaixa').html("<td colspan='6' class='text-center'><i class='fa fa-spinner fa-spin'></i>Carregando lançamentos. Aguarde...</td>");
            $('#dadosCaixaFoot').html("<i class='fa fa-spinner fa-spin'></i>");
            $.getJSON('/telas/caixa/' + urlSecaoFilho + '/listaPrincipal.php', {
                dataInicial: dataInicial,
                dataFinal: dataFinal
            }, function (data) {
                var lancamentos = data.listaLancamentos;
                var lancamento = '';
                for (var i = 0; i < lancamentos.length; i++) {
                    lancamento += "" +
                        "<tr valign='middle'>\n" +
                        '    <td>' + lancamentos[i].dia + '</td>\n' +
                        '    <td>' + lancamentos[i].categoria + '</td>\n' +
                        '    <td>' + lancamentos[i].forma + '</td>\n' +
                        '    <td>' + lancamentos[i].descricao + '</td>\n' +
                        '    <td align="right">R$ ' + lancamentos[i].valor + '</td>\n' +
                        '    <td align="right">R$ ' + lancamentos[i].saldo + '</td>\n' +
                        '</tr>'
                }
                $('.saldoAnterior').html(data.saldoAnterior);
                $('.saldoPeriodo').html(data.saldoPeriodo);
                $('.saldoTotal').html(data.saldoTotal);
                $('#dadosCaixa').html(lancamento);
                $('#dadosCaixaFoot').html(data.tFootLancamentos);
                mensagemajax("Lançamentos carregados", 'growl-primary', 5000);
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
