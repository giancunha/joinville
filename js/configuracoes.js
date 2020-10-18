$(document).ready(function () {
    function buscaFatura(){
        $("#idFatura").blur(function () {
            mensagemajax("Carregando dados fatura", 'growl-primary', 10000);
            var idFatura = $('#idFatura').val();
            resetaFormulario();
            $.getJSON('/adm/telas/configuracoes/editaNota/dadosFatura.php', {
                idFatura: idFatura
            }, function (data) {
                var fatura = data.dadosFatura[0];
                if(fatura.id > 0) {
                    console.log(fatura);
                    $('#idFatura').val(fatura.id);
                    $('#numeroNota').val(fatura.numeroNota);
                    $('#valor').val(fatura.valor);
                    $('#cliente').val(fatura.cliente);
                    $('#servico').val(fatura.servico);
                    $('#descricao').val(fatura.descricao);
                    mensagemajax("Dados carregados", 'growl-success', 5000);
                } else {
                    mensagemajax("Fatura não encontrada", 'growl-warning', 5000);
                }
            });
        });
    }
    window.listaPrincipal = function listaPrincipal() {
        var urlSecaoFilho = $('#urlSecaoFilho').val();
        if(urlSecaoFilho == 'editaNota') {
            $('#dadosNotaTrocadas').html("<td colspan='7' class='text-center'><i class='fa fa-spinner fa-spin'></i>Carregando previsões. Aguarde...</td>");
            $('#dadosNotaTrocadasFoot').html("<i class='fa fa-spinner fa-spin'></i>");
            $.getJSON('/adm/telas/configuracoes/' + urlSecaoFilho + '/listaPrincipal.php', {}, function (data) {
                var registros = data.listaLancamentos;
                var registro = '';
                for (var i = 0; i < registros.length; i++) {
                    registro += "" +
                        "<tr valign='middle'>\n" +
                        '    <td>' + registros[i].data + '</td>\n' +
                        '    <td>' + registros[i].responsavel + '</td>\n' +
                        '    <td>' + registros[i].id + '</td>\n' +
                        '    <td>' + registros[i].cliente + '</td>\n' +
                        '    <td>' + registros[i].servico + '</td>\n' +
                        '    <td align="right">\n' +
                        '        <a class="btn btn-default abreModal"\n' +
                        '           title="Histórico Fatura"\n' +
                        '           data-toggle="modal"\n' +
                        '           data-target=".bs-example-modal-lg"\n' +
                        '           data-acao="log"\n' +
                        '           data-tituloModal="Fatura ' + registros[i].id + ' - Histórico"\n' +
                        '           data-id="' + registros[i].id + '"\n' +
                        '           data-secaoPai="financeiro"\n' +
                        '           data-secaoFilho="faturaCliente"\n' +
                        '        >\n' +
                        '            <i class="fa fa-list"></i>\n' +
                        '        </a>' +
                        '    </td>\n' +
                        '</tr>'
                }
                $('#dadosNotaTrocadas').html(registro);
                $('#dadosNotaTrocadasFoot').html(data.tFootLancamentos);
                mensagemajax("Faturas carregadas", 'growl-primary', 5000);
                abreModal();
                buscaFatura();
                resetaFormulario();
            });
        }
    }
    listaPrincipal();
    function resetaFormulario(){
        $('#formulario').each(function () {
            this.reset();
        });
    }
});
