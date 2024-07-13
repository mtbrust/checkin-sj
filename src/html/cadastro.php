<div class="container">
    <h1>Cadastro</h1>

    <div class="my-2">

        <form class="row" id="form_visitante" name="form_visitante" onsubmit="return false;" enctype="multipart/form-data">

            <div class="col-12 mb-3">
                <label for="f-tpulseira" class="form-label">Tipo Pulseira</label><br>
                <div class="form-check form-check-inline tpulseira" style="border-color: #d1d1d1 !important;">
                    <input class="form-check-input" type="radio" name="f-tpulseira" id="f-branca" value="branca" required>
                    <label class="form-check-label" for="f-branca"><i class="fas fa-square text-light"></i>Branca</label>
                </div>
                <div class="form-check form-check-inline tpulseira" style="border-color: #FFEB3B !important;">
                    <input class="form-check-input" type="radio" name="f-tpulseira" id="f-amarela" value="amarela" required>
                    <label class="form-check-label" for="f-amarela"><i class="fas fa-square text-warning"></i>Amarela</label>
                </div>
                <div class="form-check form-check-inline tpulseira" style="border-color: #ff3b3b !important;">
                    <input class="form-check-input" type="radio" name="f-tpulseira" id="f-vermelha" value="vermelha" required>
                    <label class="form-check-label" for="f-vermelha"><i class="fas fa-square text-danger"></i>Vermelha</label>
                </div>
                <div class="form-check form-check-inline tpulseira" style="border-color: #1c37cf !important;">
                    <input class="form-check-input" type="radio" name="f-tpulseira" id="f-azul" value="azul" required>
                    <label class="form-check-label" for="f-azul"><i class="fas fa-square text-primary"></i>Azul</label>
                </div>
                <div id="tpulseiraHelp" class="form-text">Cor da pulseira.</div>
            </div>
            <div class="col-5 mb-3">
                <label for="f-pulseira" class="form-label">Pulseira (Nova)</label>
                <input type="number" class="form-control" id="f-pulseira" name="f-pulseira" placeholder="" value="">
                <div id="pulseiraHelp" class="form-text">Número da pulseira do visitante.</div>
            </div>
            <div class="col-7 mb-3">
                <label for="f-telefone" class="form-label">Telefone</label>
                <input type="number" class="form-control" id="f-telefone" name="f-telefone" placeholder="" value="">
                <div id="telefoneHelp" class="form-text">Número de telefone do visitante ou responsável com ddd.</div>
            </div>

            <div class="col-12 mb-3">
                <label for="f-fullName" class="form-label">Nome Completo</label>
                <input type="text" class="form-control" id="f-fullName" name="f-fullName" placeholder="" style="text-transform: uppercase;" value="">
                <div id="fullNameHelp" class="form-text">Nome completo para poder entrar no sistema.</div>
            </div>
            <div class="col-12 mb-3">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="f-sexo" id="f-m" value="m">
                    <label class="form-check-label" for="f-m">Masculino</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="f-sexo" id="f-f" value="f">
                    <label class="form-check-label" for="f-f">Feminino</label>
                </div>
            </div>
            <div class="col-12 mb-3">
                <label for="f-religiao" class="form-label">Religião</label>
                <input type="text" class="form-control" id="f-religiao" name="f-religiao" placeholder="" style="text-transform: uppercase;" value="">
                <div id="religiaoHelp" class="form-text">Igreja ou religião que participa.</div>
            </div>
            <div class="col-12 mb-3">
                <label for="f-email" class="form-label">E-Mail</label>
                <input type="text" class="form-control" id="f-email" name="f-email" placeholder="">
                <div id="emailHelp" class="form-text">E-Mail de contato do visitante.</div>
            </div>
            <div class="col-6 mb-3">
                <label for="f-cidade" class="form-label">Cidade</label>
                <input type="text" class="form-control" id="f-cidade" name="f-cidade" placeholder="" style="text-transform: uppercase;" value="">
            </div>
            <div class="col-6 mb-3">
                <label for="f-bairro" class="form-label">Bairro</label>
                <input type="text" class="form-control" id="f-bairro" name="f-bairro" placeholder="" style="text-transform: uppercase;" value="">
            </div>
            <div class="col-12 mb-3">
                <label for="f-nascimento" class="form-label">Nascimento</label>
                <div class="row">
                    <div class="col-3 px-1">
                        <input type="number" class="form-control" id="f-nascimento-dia" name="f-nascimento-dia" onkeyup="changeDay(this)" placeholder="" value="">
                    </div>
                    <div class="col-1">/</div>
                    <div class="col-3 px-1">
                        <input type="number" class="form-control" id="f-nascimento-mes" name="f-nascimento-mes" onkeyup="changeMonth(this)" placeholder="" value="">
                    </div>
                    <div class="col-1">/</div>
                    <div class="col-4 px-1">
                        <input type="number" class="form-control" id="f-nascimento-ano" name="f-nascimento-ano" onkeyup="changeYear(this)" placeholder="" value="">
                    </div>
                </div>
            </div>

            <div class="col-12 mb-3">
                <label for="f-foto" class="form-label">Foto de perfil</label>
                <input class="form-control" type="file" id="f-foto" name="f-foto">
                <div id="fotoHelp" class="form-text">Foto para identificação rápida.</div>
            </div>

            <div class="mb-3 mt-3 text-end">
                <button class="btn btn-success" onclick="btncadastrar()" id="btn_cadastrar">Cadastrar</button>
            </div>
        </form>

    </div>


    <style>
        .tpulseira {
            border-bottom: solid;
            border-width: 3px;
            border-radius: 5px;
        }
    </style>

    <script>
        function btnatualizar() {

            form = $('#form_visitante')[0];
            // Preparação dos dados.
            dados = new FormData(form);

            // Deixa pulseira sempre como 0;
            if (dados.get('f-oldPulseira') == '') {
                dados.set('f-oldPulseira', 0);
            }

            $('#btn_atualizar').text('Aguarde');
            $('#btn_atualizar').prop('disabled', true);

            // dados.append('f-formToken', '{{tokens.pageApi}}');  // Token para uso de API da própria página.
            // dados.append('f-formToken', '{{tokens.pageFunc}}'); // Token para uso envio de dados para própria página.
            // dados.append('campo', 'valor'); // Exemplo de inclusão de valores.

            // Chamada AJAX
            ajaxDados('{{base.dir_relative}}editar/{{ visitante.id }}', dados, function(ret) {
                // Para testes
                console.log(ret);

                // Verifica se teve retorno ok.
                if (ret.ret) {

                    // code...
                    $('#resultado').append(ret.html);

                    console.log(ret.ret);

                    // $('#f-pulseira').val(ret.ret.pulseira);
                    //$('#f-tpulseira').val(ret.ret.tpulseira);
                    $('#f-bairro').val(ret.ret.bairro);
                    $('#f-cidade').val(ret.ret.cidade);
                    $('#f-fullName').val(ret.ret.fullName);
                    //$('#f-nascimento').val(ret.ret.nascimento);
                    $('#f-religiao').val(ret.ret.religiao);
                    //$('#f-sexo').val(ret.ret.sexo);
                    $('#f-telefone').val(ret.ret.telefone);

                    // Marca o sexo
                    if (ret.ret.sexo == 'M') {
                        $('#f-m').prop('checked', 'true');
                    } else {
                        $('#f-f').prop('checked', 'true');
                    }

                    switch (ret.ret.tpulseira) {
                        case 'AMARELA':
                            $('#f-amarela').prop('checked', 'true');
                            break;
                        case 'VERMELHA':
                            $('#f-vermelha').prop('checked', 'true');
                            break;
                        case 'BRANCA':
                            $('#f-branca').prop('checked', 'true');
                            break;
                        case 'AZUL':
                            $('#f-azul').prop('checked', 'true');
                            break;
                    }

                    data = new Date(ret.ret.nascimento);
                    dia = data.getDate() + 1;
                    mes = ("00" + (data.getMonth() + 1)).slice(-2);
                    ano = data.getFullYear();

                    $('#f-nascimento-dia').val(dia);
                    $('#f-nascimento-mes').val(mes);
                    $('#f-nascimento-ano').val(ano);

                    $('#f-pulseira').focus();

                    // Notificação.
                    Swal.fire({
                        icon: "success",
                        title: "Sucesso.",
                        text: ret.msg,
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                    });
                } else {

                    // code...

                    // Notificação.
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro.',
                        text: ret.msg,
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                    });
                }

                $('#btn_atualizar').text('Atualizar');
                $('#btn_atualizar').prop('disabled', false);
            })
        } {
            %
            else %
        }

        function btncadastrar() {

            form = $('#form_visitante')[0];
            // Preparação dos dados.
            dados = new FormData(form);

            // Deixa pulseira sempre como 0;
            if (dados.get('f-oldPulseira') == '') {
                dados.set('f-oldPulseira', 0);
            }

            $('#btn_cadastrar').text('Aguarde');
            $('#btn_cadastrar').prop('disabled', true);

            // dados.append('f-formToken', '{{tokens.pageApi}}');  // Token para uso de API da própria página.
            // dados.append('f-formToken', '{{tokens.pageFunc}}'); // Token para uso envio de dados para própria página.
            // dados.append('campo', 'valor'); // Exemplo de inclusão de valores.

            // Chamada AJAX
            ajaxDados('{{base.dir_relative}}visitante/', dados, function(ret) {
                // Para testes
                console.log(ret);

                // Verifica se teve retorno ok.
                if (ret.ret) {

                    // code...
                    // $('#resultado').append(ret.html);

                    // $('#f-pulseira').val('');
                    // $('#f-tpulseira').val('');
                    // $('#f-bairro').val('');
                    // $('#f-cidade').val('');
                    // $('#f-fullName').val('');
                    // $('#f-nascimento').val('');
                    // $('#f-religiao').val('');
                    // $('#f-sexo').val('');
                    // $('#f-telefone').val('');

                    $('#form_visitante').each(function() {
                        this.reset();
                    });

                    $('#f-pulseira').focus();

                    // Notificação.
                    Swal.fire({
                        icon: "success",
                        title: "Sucesso.",
                        text: ret.msg,
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                    });
                } else {

                    // code...

                    // Notificação.
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro.',
                        text: ret.msg,
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                    });
                }

                $('#btn_cadastrar').text('Cadastrar');
                $('#btn_cadastrar').prop('disabled', false);
            })
        }

        function btnbuscaantigo() {

            // Preparação dos dados.
            dados = new FormData();

            $('#btn_cadastrar_antigo').text('Aguarde');
            $('#btn_cadastrar_antigo').prop('disabled', true);

            // dados.append('f-formToken', '{{tokens.pageApi}}');  // Token para uso de API da própria página.
            // dados.append('f-formToken', '{{tokens.pageFunc}}'); // Token para uso envio de dados para própria página.
            // dados.append('campo', 'valor'); // Exemplo de inclusão de valores.

            // Chamada AJAX
            ajaxDados('{{base.dir_relative}}buscaantigo/' + $('#f-oldPulseira').val(), dados, function(ret) {
                // Para testes
                console.log(ret);

                // Verifica se teve retorno ok.
                if (ret.ret) {

                    // code...
                    $('#resultado').append(ret.html);

                    // $('#f-pulseira').val(ret.ret.pulseira);
                    //$('#f-tpulseira').val(ret.ret.tpulseira);
                    $('#f-bairro').val(ret.ret.bairro);
                    $('#f-cidade').val(ret.ret.cidade);
                    $('#f-fullName').val(ret.ret.fullName);
                    //$('#f-nascimento').val(ret.ret.nascimento);
                    $('#f-religiao').val(ret.ret.religiao);
                    //$('#f-sexo').val(ret.ret.sexo);
                    $('#f-telefone').val(ret.ret.telefone);

                    // Marca o sexo
                    if (ret.ret.sexo == 'M') {
                        $('#f-m').prop('checked', 'true');
                    } else {
                        $('#f-f').prop('checked', 'true');
                    }

                    switch (ret.ret.tpulseira) {
                        case 'AMARELA':
                            $('#f-amarela').prop('checked', 'true');
                            break;
                        case 'VERMELHA':
                            $('#f-vermelha').prop('checked', 'true');
                            break;
                        case 'BRANCA':
                            $('#f-branca').prop('checked', 'true');
                            break;
                        case 'AZUL':
                            $('#f-azul').prop('checked', 'true');
                            break;
                    }

                    data = new Date(ret.ret.nascimento);
                    dia = data.getDate() + 1;
                    mes = ("00" + (data.getMonth() + 1)).slice(-2);
                    ano = data.getFullYear();

                    $('#f-nascimento-dia').val(dia);
                    $('#f-nascimento-mes').val(mes);
                    $('#f-nascimento-ano').val(ano);

                    $('#f-pulseira').focus();

                    // Notificação.
                    Swal.fire({
                        icon: "success",
                        title: "Sucesso.",
                        text: ret.msg,
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                    });
                } else {

                    // code...

                    // Notificação.
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro.',
                        text: ret.msg,
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                    });
                }

                $('#btn_cadastrar_antigo').text('Buscar Antigo');
                $('#btn_cadastrar_antigo').prop('disabled', false);
            })
        } {
            %
            endif %
        }

        function changeDay(e) {
            valor = $(e).val();
            qtd = valor.length;

            // Varifica se é um dia correto.
            if (valor < 1 && valor > 31) {
                $(e).val('');
            }

            // Passa para próximo campo.
            if (qtd == 2) {
                $('#f-nascimento-mes').focus();
            }

        }

        function changeMonth(e) {
            valor = $(e).val();
            qtd = valor.length;

            // Varifica se é um mês correto.
            if (valor < 1 && valor > 31) {
                $(e).val('');
            }

            // Passa para próximo campo.
            if (qtd == 2) {
                $('#f-nascimento-ano').focus();
            }
        }

        function changeYear(e) {
            valor = $(e).val();
            qtd = valor.length;

        }

        function oi() {

            console.log('test');
        }
    </script>
</div>