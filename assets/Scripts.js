$(document).ready(function () {
    //AJAX CARREGA NACIONALIDADE
    $('#idNacionalidade').change(function () {
        $('#s2id_idEstadoNaturalidade .select2-chosen').html('Selecione');
        $('#s2id_idNaturalidade .select2-chosen').html('Selecione');
        if( $(this).val() > 0 ) {
            $('#idEstadoNaturalidade').hide();
            $('#idNaturalidade').hide();
            mensagemajax("<i class='fa fa-spinner fa-spin'></i> Buscando estados. Aguarde...", 'growl-warning', 3000);
            $.getJSON('/ajax/estados.ajax.php?search=', {idPais: $(this).val(), ajax: 'true'}, function (j) {
                var options = '<option value=""></option>';
                for (var i = 0; i < j.length; i++) {
                    options += '<option value="' + j[i].idEstado + '">' + j[i].estado + '</option>';
                }
                $('#idEstadoNaturalidade').html(options).show();
                $('#idNaturalidade').html('<option value=""> Escolha um estado </option>').show();
                mensagemajax("Estados listados!", 'growl-info', 4000);
            });
        } else {
            $('#idEstadoNaturalidade').html('<option value=""> Escolha uma nacionalidade </option>');
            $('#idNaturalidade').html('<option value=""> Escolha um estado </option>');
            mensagemajax("<i class='fa fa-info-circle'></i> Escolha um país válido.", 'growl-info', 3000);
        }
    });
    //AJAX CARREGA CIDADES NATURALIDADE
    $('#idEstadoNaturalidade').change(function () {
        $('#s2id_idNaturalidade .select2-chosen').html('Selecione');
        if( $(this).val() > 0 ) {
            $('#idNaturalidade').hide();
            mensagemajax("<i class='fa fa-spinner fa-spin'></i> Buscando cidades. Aguarde...", 'growl-warning', 3000);
            $.getJSON('/ajax/cidades.ajax.php?search=', {idEstado: $(this).val(), ajax: 'true'}, function (j) {
                var options = '<option value=""></option>';
                for (var i = 0; i < j.length; i++) {
                    options += '<option value="' + j[i].idCidade + '">' + j[i].cidade + '</option>';
                }
                $('#idNaturalidade').html(options).show();
                mensagemajax("Cidades listadas!", 'growl-info', 4000);
            });
        } else {
            $('#idNaturalidade').html('<option value=""> Escolha um estado </option>');
            mensagemajax("<i class='fa fa-info-circle'></i> Escolha um estado válido.", 'growl-info', 3000);
        }
    });
    //AJAX CARREGA ESTADOS COMERCIAL
    $('#idPaisComercial').change(function () {
        $('#s2id_idEstadoComercial .select2-chosen').html('Selecione');
        $('#s2id_idCidadeComercial .select2-chosen').html('Selecione');
        if( $(this).val() > 0 ) {
            $('#idCidadeComercial').hide();
            $('#idEstadoComercial').hide();
            $('.carregando').show();
            $.getJSON('/ajax/estados.ajax.php?search=', {idPais: $(this).val(), ajax: 'true'}, function (j) {
                var options = '<option value=""></option>';
                for (var i = 0; i < j.length; i++) {
                    options += '<option value="' + j[i].idEstado + '">' + j[i].estado + '</option>';
                }
                $('#idEstadoComercial').html(options).show();
                $('#idCidadeComercial').html('<option value=""> Escolha um estado </option>').show();
                $('.carregando').hide();
            });
        } else {
            $('#idEstadoComercial').html('<option value=""> Escolha um país </option>');
            $('#idCidadeComercial').html('<option value=""> Escolha um estado </option>');
            mensagemajax("<i class='fa fa-info-circle'></i> Escolha um país válido.", 'growl-info', 3000);
        }
    });
    //AJAX CARREGA CIDADES COMERCIAL
    $('#idEstadoComercial').change(function () {
        $('#s2id_idCidadeComercial .select2-chosen').html('Selecione');
        if( $(this).val() > 0 ) {
            $('#idCidadeComercial').hide();
            $('.carregando').show();
            $.getJSON('/ajax/cidades.ajax.php?search=', {idEstado: $(this).val(), ajax: 'true'}, function (j) {
                var options = '<option value=""></option>';
                for (var i = 0; i < j.length; i++) {
                    options += '<option value="' + j[i].idCidade + '">' + j[i].cidade + '</option>';
                }
                $('#idCidadeComercial').html(options).show();
                $('.carregando').hide();
            });
        } else {
            $('#idCidadeComercial').html('<option value=""> Escolha um estado </option>');
            mensagemajax("<i class='fa fa-info-circle'></i> Escolha um estado válido.", 'growl-info', 3000);
        }
    });
    //AJAX CARREGA ESTADOS PADRÃO
    $('#idPais').change(function () {
        $('#s2id_idEstado .select2-chosen').html('Selecione');
        $('#s2id_idCidade .select2-chosen').html('Selecione');
        if( $(this).val() > 0 ) {
            $('#idCidade').hide();
            $('#idEstado').hide();
            $('.carregando').show();
            $.getJSON('/ajax/estados.ajax.php?search=', {idPais: $(this).val(), ajax: 'true'}, function (j) {
                var options = '<option value=""></option>';
                for (var i = 0; i < j.length; i++) {
                    options += '<option value="' + j[i].idEstado + '" uf="'+j[i].uf+'">' + j[i].estado + '</option>';
                }
                $('#idEstado').html(options).show();
                $('#idCidade').html('<option value=""> Escolha um estado </option>').show();
                $('.carregando').hide();
            });
        } else {
            $('#idEstado').html('<option value=""> Escolha um país </option>');
            $('#idCidade').html('<option value=""> Escolha um estado </option>');
            mensagemajax("<i class='fa fa-info-circle'></i> Escolha um país válido.", 'growl-info', 3000);
        }
    });
    //AJAX CARREGA CIDADES PADRÃO
    $('#idEstado').change(function () {
        $('#s2id_idCidade .select2-chosen').html('Selecione');
        $('#s2id_idSecretaria .select2-chosen').html('Selecione uma cidade');
        if( $(this).val() > 0 ) {
            $('#idCidade').hide();
            $('.carregando').show();
            $.getJSON('/ajax/cidades.ajax.php?search=', {idEstado: $(this).val(), ajax: 'true'}, function (j) {
                var options = '<option value=""></option>';
                for (var i = 0; i < j.length; i++) {
                    options += '<option value="' + j[i].idCidade + '">' + j[i].cidade + '</option>';
                }
                $('#idCidade').html(options).show();
                $('.carregando').hide();
            });
        } else {
            $('#idCidade').html('<option value=""> Escolha um estado </option>');
            mensagemajax("<i class='fa fa-info-circle'></i> Escolha um estado válido.", 'growl-info', 3000);
        }
    });

    //AJAX CARREGA ENDEREÇO PELO CEP
    $('#cep').blur(function () {
        if ($(this).val()) {
            if(($(this).val().length) == 9){
                $('.buscaEndereco').show();
                mensagemajax("<i class='fa fa-spinner fa-spin'></i> Carregando endereço pelo novo CEP, aguarde...", 'growl-info', 5000);
                $.getJSON('/ajax/enderecoCep.ajax.php?search=', {cep: $(this).val(), ajax: 'true'}, function (data) {
                    if (!data.erro) {
                        $('#endereco').val(data.logradouro);
                        $('#bairro').val(data.bairro);
                        $('#idPais').val('1').trigger('change');
                        $('#numero').focus();
                        recursiceSelectOption({id: "idEstado", value: data.uf, attibute: "uf"}, {
                            id: "idCidade",
                            value: data.localidade
                        });
                        $('.buscaEndereco').hide();
                    }
                });
            }
        }
    });

// função recursiva para selecionar estado e cidade
    function recursiceSelectOption(objEstado, objCidade = null) {

        setTimeout(function () {
            var select = document.getElementById(objEstado.id);
            if (select.options.length > 1) {
                for (var i = 0; i < select.options.length; i++) {
                    var compare = Object.keys(objEstado).indexOf("attibute") != -1 ? select.options[i].getAttribute(objEstado.attibute) : select.options[i].text;
                    if (compare === objEstado.value) {
                        select.selectedIndex = i;
                        select.dispatchEvent(new Event('change'));
                        if (objCidade != null) {
                            recursiceSelectOption(objCidade);
                        }
                        break;
                    }
                }
            } else {
                recursiceSelectOption(objEstado, objCidade);
            }
        }, 1000);
    }

    $('.wysiwyg').wysihtml5();

    // CKEditor
    jQuery('#ckeditor, .ckeditor').ckeditor();
    CKEDITOR.config.height = 700;

    // Uncomment the following code to test the "Timeout Loading Method".
    // CKEDITOR.loadFullCoreTimeout = 5;

    jQuery('.datepicker').datepicker({
        dateFormat: 'dd/mm/yy',
        dayNames: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
        dayNamesMin: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S', 'D'],
        dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'],
        monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
        monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
        nextText: 'Próximo',
        prevText: 'Anterior'
    });
    var anoAtual = (new Date).getFullYear() + 1;
    var anoInicial = anoAtual-101;
    jQuery('.dataFundacao, .dataNascimento').datepicker({
        dateFormat: 'dd/mm/yy',
        dayNames: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
        dayNamesMin: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S', 'D'],
        dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'],
        monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
        monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
        changeMonth: true,
        changeYear: true,
        yearRange: anoInicial+':'+anoAtual
    });

    $('#pessoasDataTable').DataTable({
        "ajax": {
            "url": "/ajax/pessoas.ajax.php",
            "dataSrc": ""
        },
        columnDefs: [
            {
                targets: 4,
                className: 'text-align:right'
            }
        ],
        columns: [
            { "data": "idPessoa" },
            { "data": "nome" },
            { "data": "telefoneCelular" },
            { "data": "email" },
            { "data": "ativo",
                "render": function(data, type, full, meta){
                    var ativo = data;
                    if (ativo == 1){
                        return 'Ativo';
                    } else {
                        return 'Inativo';
                    }
                }
            },
            { "data": "idPessoa",
                "render": function(data, type, full, meta){
                    var sclass = ' class="btn btn-default"';
                    var url = "/pessoas/pessoa/editaPessoa/?id=";
                    var ativo = "/pessoas/pessoa/ativacaoPessoa/?id=";
                    return '<a href='+url+ data + sclass + ' title="Editar Cliente"><i class="fa fa-edit"></i></a>' +
                        '<a href=' + ativo + data + sclass + ' title="Ativar/Desativar">' +
                        '<i class="fa fa-user"></i>' +
                        '</a>\n';
                }
            }
        ],
        "ordering": false,
        "pagingType": "full_numbers",
        "order": [[1, "asc"]],
        "language": {
            "emptyTable": "Sem dados disponíveis na tabela",
            "info": "Exibindo _START_ a _END_ de _TOTAL_ registros",
            "infoEmpty": "Exibindo 0 de 0 registros",
            "infoFiltered": "(filtrado de _MAX_ registros)",
            "infoPostFix": "",
            "thousands": ".",
            "lengthMenu": "Exibir _MENU_ registros",
            "loadingRecords": "Carregando...",
            "processing": "Processando...",
            "search": "Pesquisar:",
            "zeroRecords": "Registro n&atilde;o encontrado.",
            "paginate": {
                "first": "Primeira",
                "last": "&Uacute;ltima",
                "next": "Pr&oacute;xima",
                "previous": "Anterior"
            },
            "aria": {
                "sortAscending": ": activate to sort column ascending",
                "sortDescending": ": activate to sort column descending"
            },
        },
        "lengthMenu": [[25, 50, 75, 90, -1], [25, 50, 75, 90, "Todos"]],
        /**/
        initComplete: function () {
            this.api().columns('.select-filter').every(function () {
                var column = this;
                var select = $('<select><option value=""></option></select>')
                    .appendTo($(column.header()).empty())
                    .on('change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );

                        column
                            .search(val ? '^' + val + '$' : '', true, false)
                            .draw();
                    });

                column.data().unique().sort().each(function (d, j) {
                    select.append('<option value="' + d + '">' + d + '</option>')
                });
            });
        }
    });
    $('#produtosDataTable').DataTable({
        "ordering": false,
        "pagingType": "full_numbers",
        "order": [[1, "asc"]],
        "language": {
            "emptyTable": "Sem dados disponíveis na tabela",
            "info": "Exibindo _START_ a _END_ de _TOTAL_ registros",
            "infoEmpty": "Exibindo 0 de 0 registros",
            "infoFiltered": "(filtrado de _MAX_ registros)",
            "infoPostFix": "",
            "thousands": ".",
            "lengthMenu": "Exibir _MENU_ registros",
            "loadingRecords": "Carregando...",
            "processing": "Processando...",
            "search": "Pesquisar:",
            "zeroRecords": "Registro n&atilde;o encontrado.",
            "paginate": {
                "first": "Primeira",
                "last": "&Uacute;ltima",
                "next": "Pr&oacute;xima",
                "previous": "Anterior"
            },
            "aria": {
                "sortAscending": ": activate to sort column ascending",
                "sortDescending": ": activate to sort column descending"
            }
        },
        "lengthMenu": [[25, 50, 75, 90, -1], [25, 50, 75, 90, "Todos"]],
        initComplete: function () {
            this.api().columns('.select-filter').every(function () {
                var column = this;
                var select = $('<select><option value=""></option></select>')
                    .appendTo($(column.header()).empty())
                    .on('change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );

                        column
                            .search(val ? '^' + val + '$' : '', true, false)
                            .draw();
                    });

                column.data().unique().sort().each(function (d, j) {
                    select.append('<option value="' + d + '">' + d + '</option>')
                });
            });
        }
        /**/
    });

    function exibeTodosDataTable() {
        var table = $('#produtosDataTable').dataTable();
        table.fnFilterClear();

        $('select[name="produtosDataTable_length"] option[value="-1"]').attr({selected: "selected"});
        $('select[name="produtosDataTable_length"]').trigger("change");
    }

    function imprimirDiv() {
        $(".imprimirDiv").click(function (e) {
            e.preventDefault();//Evita reload na tela
            var divID = $(this).attr("data-id");
            $("#etiqueta" + divID).css("display", "block");
            /**/
            var divElements = document.getElementById('etiqueta' + divID).innerHTML;
            var oldPage = document.body.innerHTML;
            document.body.innerHTML = "<html><head><title>Imprimir</title></head><body>" + divElements + " </body>";
            window.print();
            document.body.innerHTML = oldPage;
            $("#etiqueta" + divID).css("display", "none");
            imprimirDiv();
            excluiDadoDT();
            /**/
            // window.location.reload();
        });
    }
    imprimirDiv();

    function mensagemajax($mensagem, $tipo, tempo = 10000) {
        jQuery.gritter.add({
            class_name: $tipo, //growl-primary, growl-success, growl-warning, growl-danger, growl-info
            title: $mensagem,
            sticky: false,
            time: tempo
        });
    }

    window.mensagemajax = mensagemajax;

//ESTILOSCSS
    jQuery(".select2").select2({
        width: '100%',
    });
});

jQuery(function ($) {
    window.resetaSelects2 = resetAllSelects2;
    function abreModal() {
        $(".abreModal").click(function (e) {
            var secaoPai = $(this).attr("data-secaoPai");
            var secaoFilho = $(this).attr("data-secaoFilho");
            var tituloModal = $(this).attr("data-tituloModal");
            var acao = $(this).attr("data-acao");
            var icone = $(this).attr("data-icone");
            if(icone != ''){
                tituloModal = '<i class="' + icone + '"></i> ' + tituloModal;
            }
            var id = $(this).attr("data-id");
            $('#tituloModal').html(tituloModal);
            $('#conteudoModal').html("<thead><th><i class='fa fa-spinner fa-spin'></i>Carregando conteudo. Aguarde...</th></thead>");
            $.post('/telas/' + secaoPai + "/" + secaoFilho + '/' + acao + ucFirst(secaoFilho) + '.php', {id: id}, function (data) {
                if (data) {
                    $('#conteudoModal').html(data);
                } else {
                    mensagemajax('Erro!', 'growl-danger');
                }
            });
        });
    }
    abreModal();
    window.abreModal = abreModal;
    $("#imprimir").click(function(e) {
        var divElements = document.getElementById('imprimirTabela').innerHTML;
        var oldPage = document.body.innerHTML;
        document.body.innerHTML = "<html><head><title>Imprimir</title></head><body>" + divElements + " </body>";
        window.print();
        document.body.innerHTML = oldPage;
        window.location.reload();
    });

    function resetAllSelects2() {
        $("select").each(function () { //added a each loop here
            $(this).select2('val', '')
        });
    }

    function pegaDominio() {
        var url = location.href;
        url = url.split("/");
        return url[2];
    }

    $(".imprimeDocumentoAgenda").click(function (e) {
        e.preventDefault();
        mensagemajax("<i class='fa fa-spinner fa-spin'></i> Preparando impressão. Aguarde...", 'growl-warning');
        var idAgenda = $('#idAgendaAtendimento').val();
        var documento = $(this).data('documento');
        myWindow = window.open("https://" + pegaDominio() + "/template/tpl-blank.htm","_blank", "scrollbars=1,resizable=1,height=768,width=1024");
        $.post('/ajax/agendaImprimeDocumento.ajax.php', { idAgenda: idAgenda, documento: documento }, function (tela) {
            myWindow.document.write(tela);
            myWindow.focus();
            myWindow.print();
            myWindow.close();
            mensagemajax('Impressão preparada com sucesso!', 'growl-info');
        });
    });

    $("#imprimirAba").click(function (e) {
        var abaSelecionada = document.getElementById('abaSelecionada').value;
        var divElements = document.getElementById(abaSelecionada).innerHTML;
        var oldPage = document.body.innerHTML;
        document.body.innerHTML = "<html><head><title>Imprimir</title></head><body>" + divElements + " </body>";
        window.print();
        document.body.innerHTML = oldPage;
        window.location.reload();
    });

    $('#myTab a').click(function (e) {
        e.preventDefault();
        var abaSelecionada = String(this);
        abaSelecionada = abaSelecionada.split("#");
        document.getElementById("abaSelecionada").value = abaSelecionada[1];
        $(this).tab('show');
    })

    $("#sortable").sortable({
        distance: 15,
        cursor: 'move',
        revert: 200,
        stop: function (event, ui) {
            var secaoPai = $(this).data('secaopai');
            var secaoFilho = $(this).data('secaofilho');
            var count = 0;
            var ordem = [];
            $(this).find("li").each(function () {
                ordem[count] = $(this).data('id');
                count++;
            });
            $.post('/telas/' + secaoPai + "/" + secaoFilho + '/alteraOrdemFotos.php', {ordem: ordem}, function (data) { //caminho a partir da raiz
                if (data == '1') {
                    mensagemajax('ORDEM DAS FOTOS ALTERADA COM SUCESSO.', 'growl-success');
                } else {
                    mensagemajax('ERRO AO ORDENAR SUAS FOTOS.', 'growl-danger');
                }
            });
        }
    });
    $("#sortable").disableSelection();
    jQuery("a[data-rel^='prettyPhoto']").prettyPhoto();

//Máscaras
    $('.telefone').mask('(99)9999-9999Z', {
        translation: {
            'Z': {
                pattern: /[0-9]/,
                optional: true
            }
        }
    });
    $(".cep").mask("99999-999");
    var options = {
        onKeyPress : function(cnpjCpf, e, field, options) {
            console.log(cnpjCpf.length);
            var masks = ['000.000.000-009', '00.000.000/0000-00'];
            var mask = (cnpjCpf.length > 14) ? masks[1] : masks[0];
            $('.cnpjCpf').mask(mask, options);
        }
    };
    $('.cnpjCpf').mask('00.000.000/0000-00', options);
    $(".cnpj").mask("99.999.999/9999-99");
    $(".cpf").mask("999.999.999-99");
    $(".data, .dataFundacao, .dataNascimento").mask("99/99/9999");
    $(".preco").mask("##.##0,00", {reverse: true});
    var mask = function (val) {
        val = val.split(":");
        return (parseInt(val[0]) > 19)? "HZ:M0" : "H0:M0";
    }

    pattern = {
        onKeyPress: function(val, e, field, options) {
            field.mask(mask.apply({}, arguments), options);
        },
        translation: {
            'H': { pattern: /[0-2]/, optional: false },
            'Z': { pattern: /[0-3]/, optional: false },
            'M': { pattern: /[0-5]/, optional: false }
        },
        placeholder: 'hh:mm'
    };

    $(".hora").mask(mask, pattern);
    $(".hora").focusout(function(e) {
        var value = e.target.value;
        var re = /(\d{0,2})(:|)(\d{0,2})/;
        var found = value.match(re);
        var new_value = "";
        if(found[1]){
            new_value = found[1].length > 1? found[1]: "0"+found[1];
        }else if(found[3]){
            new_value = "00";
        }
        if(found[1] || found[3]){
            new_value += found[2].length > 0? found[2]: ":";
        }
        if(found[3]){
            new_value += found[3].length > 1? found[3]: "0"+found[3];
        }else if(found[1]){
            new_value += "00";
        }

        e.target.value = new_value;
    });

//MENSAGEM EM TELA
    function mensagemajax($mensagem, $tipo, tempo = 20000) {
        jQuery.gritter.add({
            class_name: $tipo, //growl-primary, growl-success, growl-warning, growl-danger, growl-info
            title: $mensagem,
            sticky: false,
            time: tempo
        });
    }

//AJAX CRUD
    function alteraDado() {
        $("#btnAlteraDado").click(function (e) {
            e.preventDefault();//Evita reload na tela
            mensagemajax("<i class='fa fa-spinner fa-spin'></i> Atualizando dados. Aguarde...", 'growl-info');
            var secaoPai = $("#btnAlteraDado").attr("data-secaoPai");
            var secaoFilho = $("#btnAlteraDado").attr("data-secaoFilho");
            caminho = secaoPai + "/" + secaoFilho + "/altera" + ucFirst(secaoFilho);
            // montar um objeto que contém todos os campos incluindo os files
            var fd = new FormData();
            if ($('input[type="file"]').length > 0) {
                var file_data = $('input[type="file"]'); // for multiple files
                for (var i = 0; i < file_data.length; i++) {
                    //adiciona multiplos files com a chave 'file_'+ posição
                    for (var e = 0; e < file_data[i].files.length; e++) {
                        fd.append("file_" + i + "_" + e, file_data[i].files[e]);
                    }
                }
            }
            var other_data = $('form#formulario').serializeArray();
            $.each(other_data, function (key, input) {
                fd.append(input.name, input.value);
            });
            $.ajax({
                url: '/telas/' + caminho + '.php', //caminho a partir da raiz
                data: fd,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function (data) {
                    if (data == '1') {
                        mensagemajax('Dados atualizados com sucesso!', 'growl-success');
                        if( typeof listaPrincipal === 'function') {
                            listaPrincipal();
                        }
                    } else {
                        mensagemajax('Erro ao atualizar!<br />Motivo:<br />' + data, 'growl-danger');
                    }
                }
            });
        });
        $("#btnAlteraConsulta").click(function (e) {
            e.preventDefault();//Evita reload na tela
            mensagemajax("<i class='fa fa-spinner fa-spin'></i> Atualizando consulta. Aguarde...", 'growl-info');
            var secaoPai = $("#btnAlteraConsulta").attr("data-secaoPai");
            var secaoFilho = $("#btnAlteraConsulta").attr("data-secaoFilho");
            caminho = secaoPai + "/" + secaoFilho + "/alteraConsulta";
            // montar um objeto que contém todos os campos incluindo os files
            var fd = new FormData();
            var other_data = $('form#formularioConsulta').serializeArray();
            $.each(other_data, function (key, input) {
                fd.append(input.name, input.value);
            });
            $.ajax({
                url: '/telas/' + caminho + '.php',
                data: fd,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function (data) {
                    if (data == '1') {
                        mensagemajax('Consulta atualizada com sucesso!', 'growl-success');
                    } else {
                        mensagemajax('Erro ao atualizar!<br />Motivo:<br />' + data, 'growl-danger');
                    }
                }
            });
        });
    }
    alteraDado();

    function alteraSenha() {
        $("#btnAlteraSenha").click(function (e) {
            e.preventDefault();//Evita reload na tela
            var secaoPai = $("#btnAlteraSenha").attr("data-secaoPai");
            var secaoFilho = $("#btnAlteraSenha").attr("data-secaoFilho");
            caminho = secaoPai + "/" + secaoFilho + "/alteraSenha";
            $.post('/telas/' + caminho + '.php', $("#formulario").serialize(), function (data) { //caminho a partir da raiz
                if (data == '1') {
                    mensagemajax('Senha atualizada com sucesso!', 'growl-success');
                } else {
                    mensagemajax('Erro ao atualizar!<br />Motivo:<br />' + data, 'growl-danger');
                }
            });
        });
    }
    alteraSenha();

    function ativacaoDado() {
        $(".ativacaoDado").click(function (e) {
            e.preventDefault();//Evita reload na tela
            var secaoPai = $(this).attr("data-secaoPai");
            var secaoFilho = $(this).attr("data-secaoFilho");
            var titulo = $(this).attr("title").toLowerCase();
            if(!duvida('Realmente deseja ' + titulo + ' o acesso?')){
                return false;
            }
            caminho = secaoPai + "/" + secaoFilho + "/ativacao" + ucFirst(secaoFilho);
            id = $(this).attr("data-id");
            ativo = $(this).attr("data-ativo");

            $.ajax({
                type: "POST",
                data: {
                    id: id,
                    ativo: ativo
                },
                url: '/telas/' + caminho + '.php',
                success: function (data) {
                    if (data == 1) {
                        mensagemajax('Alterado com sucesso!', 'growl-success');
                        $("tr[data-id='" + id + "']").toggle();
                    } else {
                        mensagemajax('Erro ao alterar!<br />Motivo:<br />' + data, 'growl-danger');
                        $("tr[data-id='" + id + "']").css("color", "#d9534f");
                    }
                },
                error: function () {
                    mensagemajax('Erro ao alterar!', 'growl-danger');
                }
            });
        });
    }
    ativacaoDado();

    var clipboard = new Clipboard('.copiaLink,.copiarCampo');
    clipboard.on('success', function (e) {
        console.log(e);
    });
    clipboard.on('error', function (e) {
        console.log(e);
    });

    function copiaLink() {
        $(".copiaLink").click(function (e) {
            e.preventDefault();//Evita reload na tela
            caminho = $(this).attr("data-caminho");
            arquivo = $(this).attr("data-arquivo");
            mensagemajax('<img src="' + caminho + "min/" + arquivo + '"><br>URL da imagem copiada.', 'growl-success');
        });
        $(".copiarCampo").click(function (e) {
            e.preventDefault();//Evita reload na tela
            nomeCampo = $(this).attr("data-nomeCampo");
            mensagemajax(nomeCampo + ' copiado com sucesso!', 'growl-success');
        });
    }
    copiaLink();

    function excluiDado() {
        $(".excluiDado").click(function (e) {
            e.preventDefault();//Evita reload na tela
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
                            var $this = $(this);
                            mensagemajax('Removido com sucesso!', 'growl-success');
                            //$("tr[data-id='" + id + "']").toggle();
                            $("tr[data-id='" + id + "']").remove();
                        } else {
                            mensagemajax('Erro ao remover!<br />Motivo:<br />' + data, 'growl-danger');
                            $("tr[data-id='" + id + "']").css("color", "#d9534f");
                        }
                    },
                    error: function () {
                        mensagemajax('Erro ao excluir!', 'growl-danger');
                    }
                });
            }
        });
    }
    excluiDado();

    function excluiSubDado() {
        $(".excluiSubDado").click(function (e) {
            e.preventDefault();//Evita reload na tela
            var secaoPai = $(this).attr("data-secaoPai");
            var secaoFilho = $(this).attr("data-secaoFilho");
            caminho = secaoPai + "/" + secaoFilho + "/excluiSub" + ucFirst(secaoFilho);
            id = $(this).attr("data-id");
            resposta = confirm("Realmente deseja excluir esse item?");
            if (resposta) {
                $.ajax({
                    type: "POST",
                    data: {
                        id: id
                    },
                    url: '/telas/' + caminho + '.php',
                    success: function (data) {
                        if (data == 1) {
                            var $this = $(this);
                            mensagemajax('Removido com sucesso!', 'growl-success');
                            $("div[data-id='" + id + "'], li[data-id='" + id + "']").remove();
                        } else {
                            mensagemajax('Erro ao remover!<br />Motivo:<br />' + data, 'growl-danger');
                        }
                    },
                    error: function () {
                        mensagemajax('Erro ao excluir!', 'growl-danger');
                    }
                });
            }
        });
    }
    excluiSubDado();

    function incluiDado() {
        $("#btnIncluiDado").click(function (e) {
            e.preventDefault();//Evita reload na tela
            mensagemajax("<i class='fa fa-spinner fa-spin'></i> Incluindo dado. Aguarde...", 'growl-warning');
            var secaoPai = $("#btnIncluiDado").attr("data-secaoPai");
            var secaoFilho = $("#btnIncluiDado").attr("data-secaoFilho");

            var caminho = secaoPai + "/" + secaoFilho + "/salva" + ucFirst(secaoFilho);

            // montar um objeto que contém todos os campos incluindo os files
            var fd = new FormData();

            if ($('input[type="file"]').length > 0) {
                var file_data = $('input[type="file"]'); // for multiple files
                for (var i = 0; i < file_data.length; i++) {
                    //adiciona multiplos files com a chave 'file_'+ posição
                    for (var e = 0; e < file_data[i].files.length; e++) {
                        fd.append("file_" + i + "_" + e, file_data[i].files[e]);
                    }
                }
            }

            var other_data = $('form#formulario').serializeArray();
            $.each(other_data, function (key, input) {
                fd.append(input.name, input.value);
            });

            $.ajax({
                url: '/telas/' + caminho + '.php', //caminho a partir da raiz
                data: fd,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function (data) {
                    if (data == '1') {
                        var idItem = 0;
                        mensagemajax('Cadastro efetuado com sucesso!', 'growl-success');
                        $('#formulario').each(function () {
                            this.reset();
                        });
                        resetAllSelects2();
                        $('.btnnewcad').trigger('click');
                        if (secaoPai == 'agendas' && secaoFilho == 'agenda') {
                            $('#s2id_idConvenio .select2-chosen').html('Selecione um pessoa');
                            var idMedico = $('a[class*=medicoSelecionado]').attr("data-id");
                            $('a[data-id=' + idMedico + ']').trigger('click');
                            agendaOcultaTelas();
                        }
                    } else {
                        mensagemajax('Erro ao cadastrar!<br />Motivo:<br />' + data, 'growl-danger');
                    }
                }
            });
        });

        $("#btnClientePessoa").click(function (e) {
            e.preventDefault();//Evita reload na tela
            mensagemajax("<i class='fa fa-spinner fa-spin'></i> Processando. Aguarde...", 'growl-info');
            var secaoPai = $("#btnClientePessoa").attr("data-secaoPai");
            var secaoFilho = $("#btnClientePessoa").attr("data-secaoFilho");
            caminho = secaoPai + "/" + secaoFilho + "/salvaClientePessoa";
            var fd = new FormData();
            var other_data = $('form#formularioClientePessoa').serializeArray();
            $.each(other_data, function (key, input) {
                fd.append(input.name, input.value);
            });
            $.ajax({
                url: '/telas/' + caminho + '.php',
                data: fd,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function (data) {
                    if (data > 0) {
                        $('.consultaClientePessoa').html("<th><i class='fa fa-spinner fa-spin'></i>Carregando Contatos. Aguarde...</th>");
                        $.post('/ajax/consultaClientePessoa.ajax.php', {idCliente: data}, function (data2) {
                            $('.consultaClientePessoa').html(data2);
                            resetaClientePessoa();
                            $('#btnClientePessoa').html('Cadastrar');
                            editaClientePessoa();
                            excluiClientePessoa();
                            mensagemajax('Efetuado com sucesso!', 'growl-success');
                        });
                    } else {
                        mensagemajax('Erro!<br />Motivo:<br />' + data, 'growl-danger');
                    }
                }
            });
        });
        $(".formBoleto").click(function (e) {
            e.preventDefault();//Evita reload na tela
            var fatura = $(this).attr("data-fatura");
            var tituloModal = $(this).attr("data-tituloModal");

            $('#tituloModal').html(tituloModal);
            $('#conteudoModal').html("<thead><th><i class='fa fa-spinner fa-spin'></i>Gerando Boleto. Aguarde...</th></thead>");

            var fd = new FormData();

            $('form#form' + fatura + ' :input').each(
                function(){
                    var input = $(this);
                    fd.append( input.attr('id'),input.val() );
                }
            );

            $.ajax({
                url: '/ajax/emitirBoleto.php',
                data: fd,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function (resposta) {
                    try {
                        resposta = JSON.parse(resposta);
                        if(resposta.code==200){
                            var retornoHtml = '' +
                                '           <div class="row">' +
                                '                <div class="col-sm-12">\n' +
                                '                    <div class="panel panel-success">\n' +
                                '                        <div class="panel-body">\n' +
                                '                            <table class="table">\n' +
                                '                                <thead>\n' +
                                '                                <tr>\n' +
                                '                                    <th>ID da transação</th>\n' +
                                '                                    <th>Código de Barras</th>\n' +
                                '                                    <th>Link</th>\n' +
                                '                                    <th>Vencimento</th>\n' +
                                '                                    <th>Status</th>\n' +
                                '                                    <th>Total</th>\n' +
                                '                                    <th>Método de pagamento</th>\n' +
                                '                                </tr>\n' +
                                '                                </thead>\n' +
                                '                                <tbody>\n' +
                                '                                <tr id="result_table">\n' +
                                '                                </tr>\n' +
                                '                                </tbody>\n' +
                                '                            </table>\n' +
                                '                        </div>\n' +
                                '                    </div>\n' +
                                '                </div>\n' +
                                '            </div>\n'
                            ;
                            var html="<th>"+resposta.data.charge_id+"</th>"
                            html+="<th>"+resposta.data.barcode+"</th>"
                            html+="<th><a target='blank' href='"+resposta.data.link+"'> clique aqui para acessar o boleto </a></a></th>"
                            html+="<th>"+resposta.data.expire_at+"</th>"
                            html+="<th>"+resposta.data.status+"</th>"
                            html+="<th>"+resposta.data.total+"</th>"
                            html+="<th>"+resposta.data.payment+"</th>";
                            $("#result_table").html(html);
                            $("#gerar" + fatura).hide();
                            $("#baixar" + fatura).show();
                        } else {
                            $('#tituloModal').html('Erro ao emitir boleto!!');
                            var retornoHtml = '' +
                                '           <div class="row">' +
                                '                <div class="col-sm-12">\n' +
                                '                    <div class="panel panel-success">\n' +
                                '                        <div class="panel-body">\n' +
                                '                            <table class="table">\n' +
                                '                                <thead>\n' +
                                '                                <tr>\n' +
                                '                                    <th>Código</th>\n' +
                                '                                    <th>Erro</th>\n' +
                                '                                    <th>Campo</th>\n' +
                                '                                    <th>Descrição</th>\n' +
                                '                                </tr>\n' +
                                '                                </thead>\n' +
                                '                                <tbody>\n' +
                                '                                <tr id="result_table">\n' +
                                '                                </tr>\n' +
                                '                                </tbody>\n' +
                                '                            </table>\n' +
                                '                        </div>\n' +
                                '                    </div>\n' +
                                '                </div>\n' +
                                '            </div>\n'
                            ;
                            var html="<th>"+resposta.code+"</th>";
                            html+="<th>"+resposta.error+"</th>";
                            html+="<th>"+resposta.errorDescription.property+"</th>";
                            html+="<th>"+resposta.errorDescription.message+"</th>";
                        }
                        $('#conteudoModal').html(retornoHtml);
                        $("#result_table").html(html);
                    } catch (e) {
                        console.log(resposta);
                        console.log(e);
                    }
                },
                error:function(resposta){
                    $("#myModal").modal('hide');
                }
            });
        });
    }
    incluiDado();

    function editaClientePessoa() {
        $(".btnEditaClientePessoa").click(function (e) {
            e.preventDefault();//Evita reload na tela
            var idClientePessoa = $(this).attr('data-idClientePessoa');
            var idPessoaFuncao = $(this).attr('data-idPessoaFuncao');
            var idPessoa = $(this).attr('data-idPessoa');
            $('#idClientePessoa').val(idClientePessoa);
            $('#idPessoaFuncao').val(idPessoaFuncao).trigger('change');
            $('#idPessoa').val(idPessoa).trigger('change');
            $('#btnClientePessoa').html('Alterar');
        });
    }
    editaClientePessoa();

    function excluiClientePessoa() {
        $(".excluiClientePessoa").click(function (e) {
            e.preventDefault();
            var idClientePessoa = $(this).attr("data-idClientePessoa");
            var idCliente = $(this).attr("data-idCliente");
            if(confirm('Tem certeza que deseja excluir esse contato?')){
                mensagemajax("<i class='fa fa-spinner fa-spin'></i> Excluindo contato. Aguarde...", 'growl-warning', 20000);
                $.ajax({
                    url: '/telas/pessoas/pessoa/excluiClientePessoa.php',
                    data: {
                        idClientePessoa: idClientePessoa,
                        idCliente: idCliente
                    },
                    type: 'POST',
                    success: function (data) {
                        if (data > 0) {
                            mensagemajax('Contato removido com sucesso!', 'growl-success');
                            $('.consultaClientePessoa').html("<th><i class='fa fa-spinner fa-spin'></i>Carregando Contatos. Aguarde...</th>");
                            $.post('/ajax/consultaClientePessoa.ajax.php', { idCliente: data }, function (data2) {
                                $('.consultaClientePessoa').html(data2);
                                $('#btnClientePessoa').html('Cadastrar');
                                resetaClientePessoa();
                                editaClientePessoa();
                                excluiClientePessoa();
                            });
                        } else {
                            mensagemajax('Erro ao excluir!<br />Motivo:<br />' + data, 'growl-danger');
                        }
                    }
                });
            } else{
                return false;
            }
        });
    }
    excluiClientePessoa();

    function resetaClientePessoa() {
        $('#idClientePessoa').val(null);
        $('#idPessoaFuncao').val(null).trigger('change');
        $('#idPessoa').val(null).trigger('change');
    }

    function filtraPessoas() {
        $("#btnFiltraPessoas").click(function(e) {
            e.preventDefault();//Evita reload na tela
            $('#btnFiltraPessoas').html('<i class="fa fa-spinner fa-spin"></i> Buscando...');
            mensagemajax("<i class='fa fa-spinner fa-spin'></i> Buscando Pessoas, aguarde!", 'growl-info');
            $('.tabelaPessoas').html("<thead><th><i class='fa fa-spinner fa-spin'></i>Carregando pessoas. Aguarde...</th></thead>");
            var secaoPai = $("#btnIncluiDado").attr("data-secaoPai");
            var secaoFilho = $("#btnIncluiDado").attr("data-secaoFilho");
            $.post('/telas/' + secaoPai + "/" + secaoFilho + '/listaPessoas.php', $("#formulario").serialize(), function(data){ //caminho a partir da raiz
                $('.tabelaPessoas').html('');
                $('.tabelaPessoas').html(data);
            })
                .done(function() {
                    $('#btnFiltraPessoas').html('Filtrar novamente');
                    mensagemajax('Listado com sucesso!', 'growl-success');
                    marcarDesmarcarTodos();
                });
        });
    }
    filtraPessoas();

    function marcarDesmarcarTodos(){
        //SMS
        $("#checkTodosSms").change(function () {
            $("input:checkbox .marcarSms").prop('checked', $(this).prop("checked"));
        });

        $("#checkTodosSms").click(function () {
            $('input:checkbox .marcarSms').not(this).prop('checked', this.checked);
        });

        var checkTodosSms = $("#checkTodosSms");
        checkTodosSms.click(function () {
            if ($(this).is(':checked')) {
                $('.marcarSms').prop("checked", true);
            } else {
                $('.marcarSms').prop("checked", false);
            }
        });
        //SMTP
        $("#checkTodosSmtp").change(function () {
            $("input:checkbox .marcarSmtp").prop('checked', $(this).prop("checked"));
        });

        $("#checkTodosSms").click(function () {
            $('input:checkbox .marcarSmtp').not(this).prop('checked', this.checked);
        });

        var checkTodosSmtp = $("#checkTodosSmtp");
        checkTodosSmtp.click(function () {
            if ($(this).is(':checked')) {
                $('.marcarSmtp').prop("checked", true);
            } else {
                $('.marcarSmtp').prop("checked", false);
            }
        });
    }

    //Foto Destaque
    $('.fotodestacar').click(function () {
        var secaoPai = $(this).data('secaopai');
        var secaoFilho = $(this).data('secaofilho');
        var idFoto = $(this).data('idfoto');
        $.post('/telas/' + secaoPai + "/" + secaoFilho + '/alteraDestaque.php', {idFoto: idFoto}, function (data) { //caminho a partir da raiz
            if (data == 'S') {
                $(".fotodestacar[data-idfoto='" + idFoto + "'] .icondestaque").removeClass('glyphicon-star-empty');
                $(".fotodestacar[data-idfoto='" + idFoto + "'] .icondestaque").addClass('glyphicon-star');
                mensagemajax('FOTO ADICIONADA A DESTAQUES.', 'growl-success');
            } else {
                $(".fotodestacar[data-idfoto='" + idFoto + "'] .icondestaque").removeClass('glyphicon-star');
                $(".fotodestacar[data-idfoto='" + idFoto + "'] .icondestaque").addClass('glyphicon-star-empty');
                mensagemajax('FOTO REMOVIDA DOS DESTAQUES.', 'growl-warning');
            }
        });
    });

    $('.btnnewcad').click(function () {
        $('.btncadastro').toggle();
        $('.telacadastro').toggle();
    });

    var elements = document.getElementsByTagName("INPUT");
    for (var i = 0; i < elements.length; i++) {
        elements[i].oninvalid = function (e) {
            e.target.setCustomValidity("");
            if (!e.target.validity.valid) {
                e.target.setCustomValidity("Campo Obrigatório");
            }
        };
        elements[i].oninput = function (e) {
            e.target.setCustomValidity("");
        };
    }
    var elements2 = document.getElementsByTagName("TEXTAREA");
    for (var i = 0; i < elements2.length; i++) {
        elements2[i].oninvalid = function (e) {
            e.target.setCustomValidity("");
            if (!e.target.validity.valid) {
                e.target.setCustomValidity("Campo Obrigatório");
            }
        };
        elements2[i].oninput = function (e) {
            e.target.setCustomValidity("");
        };
    }

});

function ucFirst(str) {
    str += '';
    var f = str.charAt(0)
        .toUpperCase();
    return f + str.substr(1);
}

function duvida(duvida)
{
    if (confirm( duvida )){
        return true;
    } else {
        return false;
    }
}
