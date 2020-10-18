$(document).ready(function () {
    function novoLancamento() {
        var totalLancamentos = $('#lancamentos').val();
        if (totalLancamentos == 1) {
            $('#divPeriodicidade').hide();
            $("#divDescricao").removeClass('col-sm-6');
            $("#divDescricao").addClass('col-sm-9');
            $(".formaPagamento").html('');
        } else {
            $('#divPeriodicidade').show();
            $("#divDescricao").removeClass('col-sm-9');
            $("#divDescricao").addClass('col-sm-6');
            $(".formaPagamento").html('1ª parcela');
        }
    }
    $("#tipoPagamento").change(function () {
        var tipoPagamento = $('#tipoPagamento').val();
        if (tipoPagamento == 'F'){
            $('#lancamentos').val('1').trigger('change');
            $(".formaPagamento").html('mensal');
            $("#divDescricao").removeClass('col-sm-9');
            $("#divDescricao").addClass('col-sm-12');
            $('#divLancamentos').hide();
        } else {
            $("#divDescricao").removeClass('col-sm-12');
            $("#divDescricao").addClass('col-sm-9');
            $('#divLancamentos').show();
        }
    });
    $("#formFiltro").submit(function ( e ) {
        e.preventDefault();
        listaPrincipal();
    });
    $("#lancamentos").change(function () {
        novoLancamento();
    });
    function editaPrevisao() {
        $(".editaPrevisao").click(function () {
            var idPrevisao = $(this).data('id');
            $.getJSON('/adm/telas/caixa/previsao/editaPrevisao.php', {
                idPrevisao: idPrevisao
            }, function (data) {
                $('html, body').animate({scrollTop: 200}, {duration: 3000});
                $('.telacadastro').show();
                $("#tituloCadastro").html('Edita Previsão - ' + data.descricao);
                $('#idPrevisao').val(data.id);
                $('#tipoPagamento').val(data.tipo).trigger('change');
                $('#vencimento').val(data.vencimento);
                $('#idServico').val(data.idServico).trigger('change');
                $('#valor').val(data.valor);
                $('#descricao').val(data.descricao);
                $("#lancamentos").prop("disabled", true);
                $('#btnIncluiDado').hide();
                $('#btnAlteraDado').show();
            });
        });
    }
    function excluiPrevisao() {
        $(".excluiPrevisao").click(function (e) {
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
                    url: '/adm/telas/' + caminho + '.php',
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
    function liquidaPrevisao() {
        $(".liquidaPrevisao").click(function (e) {
            e.preventDefault();
            var secaoPai = $(this).attr("data-secaoPai");
            var secaoFilho = $(this).attr("data-secaoFilho");
            caminho = secaoPai + "/" + secaoFilho + "/liquida" + ucFirst(secaoFilho);
            id = $(this).attr("data-id");
            resposta = confirm("Realmente deseja dar baixa nessa previsão?");
            if (resposta) {
                mensagemajax("<i class='fa fa-spinner fa-spin'></i> Liquidando previsão. Aguarde...", 'growl-warning');
                $.ajax({
                    type: "POST",
                    data: {
                        id: id
                    },
                    url: '/adm/telas/' + caminho + '.php',
                    success: function (data) {
                        if (data == 1) {
                            mensagemajax('Liquidada com sucesso!', 'growl-success');
                            listaPrincipal();
                        } else {
                            mensagemajax('Erro ao liquidar!<br />Motivo:<br />' + data, 'growl-danger');
                        }
                    },
                    error: function () {
                        mensagemajax('Erro ao liquidar!', 'growl-danger');
                    }
                });
            } else {
                mensagemajax("<i class='fa fa-info'></i> Liquidação cancelada", 'growl-info');
            }
        });
    }
    window.listaPrincipal = function listaPrincipal() {
        var urlSecaoFilho = $('#urlSecaoFilho').val();
        if(urlSecaoFilho == 'previsao') {
            var dataInicial = $('#dataInicial').val();
            var dataFinal = $('#dataFinal').val();
            $('#dadosPrevisaoVariaveis, #dadosPrevisaoFixas').html("<td colspan='6' class='text-center'><i class='fa fa-spinner fa-spin'></i>Carregando previsões. Aguarde...</td>");
            $('#dadosPrevisaoVariaveisFoot, #dadosPrevisaoFixasFoot').html("<i class='fa fa-spinner fa-spin'></i>");
            $.getJSON('/adm/telas/caixa/' + urlSecaoFilho + '/listaPrincipal.php', {
                dataInicial: dataInicial,
                dataFinal: dataFinal
            }, function (data) {
                var previsoesVariaveis = data.previsoesVariaveis;
                var variaveis = '';
                for (var i = 0; i < previsoesVariaveis.length; i++) {
                    variaveis += "" +
                        "<tr valign='middle'>\n" +
                        '    <td>' + previsoesVariaveis[i].vencimento + '</td>\n' +
                        '    <td>' + previsoesVariaveis[i].faltam + '</td>\n' +
                        '    <td>' + previsoesVariaveis[i].categoria + '</td>\n' +
                        '    <td>' + previsoesVariaveis[i].descricao + '</td>\n' +
                        '    <td align="right">R$ ' + previsoesVariaveis[i].valor + '</td>\n' +
                        '    <td align="right">\n' +
                        '        <a href="#"\n' +
                        '           class="btn btn-default liquidaPrevisao"\n' +
                        '           data-secaoPai="' + data.secaoPai + '"\n' +
                        '           data-secaoFilho="' + data.secaoFilho + '"\n' +
                        '           data-id="' + previsoesVariaveis[i].id + '"\n' +
                        '           title="Liquidar"\n' +
                        '        >\n' +
                        '            <i class="fa fa-money"></i>\n' +
                        '        </a>\n' +
                        '        <a class="btn btn-default editaPrevisao"\n' +
                        '           title="Editar"\n' +
                        '           data-id="' + previsoesVariaveis[i].id + '"\n' +
                        '        >\n' +
                        '            <i class="fa fa-edit"></i>\n' +
                        '        </a>\n' +
                        '        <a href="#"\n' +
                        '           class="btn btn-default excluiPrevisao"\n' +
                        '           data-secaoPai="' + data.secaoPai + '"\n' +
                        '           data-secaoFilho="' + data.secaoFilho + '"\n' +
                        '           data-id="' + previsoesVariaveis[i].id + '"\n' +
                        '           title="Excluir"\n' +
                        '        >\n' +
                        '            <i class="fa fa-trash-o"></i>\n' +
                        '        </a>\n' +
                        '    </td>\n' +
                        '</tr>'
                }
                var previsoesFixas = data.previsoesFixas;
                var fixas = '';
                for (var i = 0; i < previsoesFixas.length; i++) {
                    fixas += "" +
                        "<tr valign='middle'>\n" +
                        '    <td>' + previsoesFixas[i].vencimento + '</td>\n' +
                        '    <td>' + previsoesFixas[i].categoria + '</td>\n' +
                        '    <td>' + previsoesFixas[i].descricao + '</td>\n' +
                        '    <td align="right">R$ ' + previsoesFixas[i].valor + '</td>\n' +
                        '    <td align="right">\n' +
                        '        <a href="#"\n' +
                        '           class="btn btn-default liquidaPrevisao"\n' +
                        '           data-secaoPai="' + data.secaoPai + '"\n' +
                        '           data-secaoFilho="' + data.secaoFilho + '"\n' +
                        '           data-id="' + previsoesFixas[i].id + '"\n' +
                        '           title="Liquidar"\n' +
                        '        >\n' +
                        '            <i class="fa fa-money"></i>\n' +
                        '        </a>\n' +
                        '        <a class="btn btn-default editaPrevisao"\n' +
                        '           title="Editar"\n' +
                        '           data-id="' + previsoesFixas[i].id + '"\n' +
                        '        >\n' +
                        '            <i class="fa fa-edit"></i>\n' +
                        '        </a>\n' +
                        '        <a href="#"\n' +
                        '           class="btn btn-default excluiPrevisao"\n' +
                        '           data-secaoPai="' + data.secaoPai + '"\n' +
                        '           data-secaoFilho="' + data.secaoFilho + '"\n' +
                        '           data-id="' + previsoesFixas[i].id + '"\n' +
                        '           title="Excluir"\n' +
                        '        >\n' +
                        '            <i class="fa fa-trash-o"></i>\n' +
                        '        </a>\n' +
                        '    </td>\n' +
                        '</tr>'
                }
                $('#dadosPrevisaoVariaveis').html(variaveis);
                $('#dadosPrevisaoFixas').html(fixas);
                $('#dadosPrevisaoVariaveisFoot').html(data.tFootVariaveis);
                $('#dadosPrevisaoFixasFoot').html(data.tFootFixas);
                mensagemajax("Previsões carregadas", 'growl-primary', 5000);
                resetaFormulario();
                editaPrevisao();
                liquidaPrevisao();
                excluiPrevisao();
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
            $.getJSON('/adm/telas/caixa/' + urlSecaoFilho + '/listaPrincipal.php', {
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
        $("#lancamentos").prop("disabled", false);
        $('#btnIncluiDado').show();
        $('#btnAlteraDado').hide();
        $('.telacadastro').hide();
        $('.btncadastro').show();
    }
});
