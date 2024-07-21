<form class="row" id="form_visitante" name="form_visitante" onsubmit="return false;" enctype="multipart/form-data">
    <div class="col-12 mb-3">
        <label for="f-fullName" class="form-label">Nome Completo (Obrigatório)</label>
        <input type="text" class="form-control" id="f-fullName" name="f-fullName" placeholder="" style="text-transform: uppercase;" value="<?php echo isset($visitante['fullName']) ? $visitante['fullName'] : ''; ?>">
        <div id="fullNameHelp" class="form-text">Nome completo para poder entrar no sistema.</div>
    </div>

    <div class="col-12 mb-3">
        <label for="f-foto" class="form-label">Foto de perfil</label>
        <div class="row">
            <div class="col-12">
                <a class="btn btn-sm btn-info m-1" onclick="obterCameras()">Ligar Câmera</a>
                <div id="cameras" style="display: contents;"></div>
            </div>
            <div class="col-12">

            </div>
            <div class="col-6 text-center">
                <div id="boxvideo" style="width: 100px; margin:auto;">
                    <video id="video" autoplay style="width: 100px; margin:auto;"></video>
                </div>
            </div>
            <div class="col-6 text-center">
                <img src="" id="img-out" alt="" style="width: 100px; margin:auto;">
            </div>
            <div class="col-12 text-end">
                <span id="tamanho" class="d-none"></span>
                <input type="text" id="f-fotoPerfil" name="f-fotoPerfil" hidden>
                <a class="btn btn-sm btn-success m-1" onclick="tirarFoto()">Tirar Foto</a>
            </div>
        </div>
    </div>

    <div class="col-12 mb-3">
        <label for="f-tpulseira" class="form-label">Tipo Pulseira (Obrigatório)</label><br>
        <div class="form-check form-check-inline tpulseira" style="border-color: #d1d1d1 !important;">
            <input class="form-check-input" type="radio" name="f-tpulseira" id="f-branca" value="branca" required <?php echo isset($visitante['tpulseira']) && $visitante['tpulseira'] == 'BRANCA' ? 'checked' : ''; ?>>
            <label class="form-check-label" for="f-branca"><i class="fas fa-square text-light"></i>Branca</label>
        </div>
        <div class="form-check form-check-inline tpulseira" style="border-color: #FFEB3B !important;">
            <input class="form-check-input" type="radio" name="f-tpulseira" id="f-amarela" value="amarela" required <?php echo isset($visitante['tpulseira']) && $visitante['tpulseira'] == 'AMARELA' ? 'checked' : ''; ?>>
            <label class="form-check-label" for="f-amarela"><i class="fas fa-square text-warning"></i>Amarela</label>
        </div>
        <div class="form-check form-check-inline tpulseira" style="border-color: #ff3b3b !important;">
            <input class="form-check-input" type="radio" name="f-tpulseira" id="f-vermelha" value="vermelha" required <?php echo isset($visitante['tpulseira']) && $visitante['tpulseira'] == 'VERMELHA' ? 'checked' : ''; ?>>
            <label class="form-check-label" for="f-vermelha"><i class="fas fa-square text-danger"></i>Vermelha</label>
        </div>
        <div class="form-check form-check-inline tpulseira" style="border-color: #1c37cf !important;">
            <input class="form-check-input" type="radio" name="f-tpulseira" id="f-azul" value="azul" required <?php echo isset($visitante['tpulseira']) && $visitante['tpulseira'] == 'AZUL' ? 'checked' : ''; ?>>
            <label class="form-check-label" for="f-azul"><i class="fas fa-square text-primary"></i>Azul</label>
        </div>
        <div id="tpulseiraHelp" class="form-text">Cor da pulseira.</div>
    </div>
    <div class="col-5 mb-3">
        <label for="f-pulseira" class="form-label">Pulseira (Obrigatório)</label>
        <input type="number" class="form-control" id="f-pulseira" name="f-pulseira" placeholder="" value="<?php echo isset($visitante['pulseira']) ? $visitante['pulseira'] : ''; ?>">
        <div id="pulseiraHelp" class="form-text">Número da pulseira do visitante.</div>
    </div>
    <div class="col-7 mb-3">
        <label for="f-telefone" class="form-label">Telefone</label>
        <input type="number" class="form-control" id="f-telefone" name="f-telefone" placeholder="" value="<?php echo isset($visitante['telefone']) ? $visitante['telefone'] : ''; ?>">
        <div id="telefoneHelp" class="form-text">Número de telefone do visitante ou responsável com ddd.</div>
    </div>

    <div class="col-6 col-sm-3 mb-3">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="SIM" id="f-whatsapp" name="f-whatsapp" <?php echo isset($visitante['whatsapp']) && $visitante['whatsapp'] == 'SIM' ? 'checked' : ''; ?>>
            <label class="form-check-label" for="f-whatsapp">
                Whatsapp
            </label>
        </div>
        <div id="telefoneHelp" class="form-text">Número é whatsapp?</div>
    </div>

    <div class="col-6 col-sm-3 mb-3">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="SIM" id="f-info" name="f-info" <?php echo isset($visitante['info']) && $visitante['info'] == 'SIM' ? 'checked' : ''; ?>>
            <label class="form-check-label" for="f-info">
                Info
            </label>
        </div>
        <div id="telefoneHelp" class="form-text">Podemos enviar informações?</div>
    </div>
    <div class="col-12 mb-3">
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="f-sexo" id="f-m" value="m" <?php echo isset($visitante['sexo']) && $visitante['sexo'] == 'M' ? 'checked' : ''; ?>>
            <label class="form-check-label" for="f-m">Masculino</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="f-sexo" id="f-f" value="f" <?php echo isset($visitante['sexo']) && $visitante['sexo'] == 'F' ? 'checked' : ''; ?>>
            <label class="form-check-label" for="f-f">Feminino</label>
        </div>
    </div>
    <div class="col-12 mb-3">
        <label for="f-religiao" class="form-label">Religião</label>
        <input type="text" class="form-control" id="f-religiao" name="f-religiao" placeholder="" style="text-transform: uppercase;" value="<?php echo isset($visitante['religiao']) ? $visitante['religiao'] : ''; ?>">
        <div id="religiaoHelp" class="form-text">Igreja ou religião que participa.</div>
    </div>

    <div class="col-6 col-sm-3 mb-3">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="SIM" id="f-fe" name="f-fe" <?php echo isset($visitante['fe']) && $visitante['fe'] == 'SIM' ? 'checked' : ''; ?>>
            <label class="form-check-label" for="f-fe">
                Mesma fé?
            </label>
        </div>
        <div id="telefoneHelp" class="form-text">Visitante acredita em cristo?</div>
    </div>

    <div class="col-12 mb-3">
        <label for="f-email" class="form-label">E-Mail</label>
        <input type="text" class="form-control" id="f-email" name="f-email" value="<?php echo isset($visitante['email']) ? $visitante['email'] : ''; ?>">
        <div id="emailHelp" class="form-text">E-Mail de contato do visitante.</div>
    </div>
    <div class="col-6 mb-3">
        <label for="f-cidade" class="form-label">Cidade</label>
        <input type="text" class="form-control" id="f-cidade" name="f-cidade" placeholder="" style="text-transform: uppercase;" value="<?php echo isset($visitante['cidade']) ? $visitante['cidade'] : ''; ?>">
    </div>
    <div class="col-6 mb-3">
        <label for="f-bairro" class="form-label">Bairro</label>
        <input type="text" class="form-control" id="f-bairro" name="f-bairro" placeholder="" style="text-transform: uppercase;" value="<?php echo isset($visitante['bairro']) ? $visitante['bairro'] : ''; ?>">
    </div>
    <div class="col-12 mb-3">
        <label for="f-endereco" class="form-label">Endereço</label>
        <input type="text" class="form-control" id="f-endereco" name="f-endereco" placeholder="" style="text-transform: uppercase;" value="<?php echo isset($visitante['endereco']) ? $visitante['endereco'] : ''; ?>">
        <div class="form-text">Endereço com rua, número e complemento.</div>
    </div>

    <div class="col-6 col-sm-3 mb-3">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="SIM" id="f-contato" name="f-contato" <?php echo isset($visitante['contato']) && $visitante['contato'] == 'SIM' ? 'checked' : ''; ?>>
            <label class="form-check-label" for="f-contato">
                Contato
            </label>
        </div>
        <div id="telefoneHelp" class="form-text">Gostaria de conversar?</div>
    </div>

    <div class="col-6 col-sm-3 mb-3">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="SIM" id="f-palco" name="f-palco" <?php echo isset($visitante['palco']) && $visitante['palco'] == 'SIM' ? 'checked' : ''; ?>>
            <label class="form-check-label" for="f-palco">
                Palco
            </label>
        </div>
        <div id="telefoneHelp" class="form-text">Participaria no palco?</div>
    </div>

    <div class="col-6 col-sm-3 mb-3">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="SIM" id="f-calouro" name="f-calouro" <?php echo isset($visitante['calouro']) && $visitante['calouro'] == 'SIM' ? 'checked' : ''; ?>>
            <label class="form-check-label" for="f-calouro">
                Calouro
            </label>
        </div>
        <div id="telefoneHelp" class="form-text">Primeira vez no evento?</div>
    </div>

    <div class="col-12 mb-3">
        <label for="f-nascimento" class="form-label">Nascimento</label>
        <div class="row">
            <div class="col-3 px-1">
                <input type="number" class="form-control" id="f-nascimento-dia" name="f-nascimento-dia" onkeyup="changeDay(this)" placeholder="" value="<?php echo isset($visitante['nascimento']) && $visitante['nascimento'] != '0000-00-00' ? date('d', strtotime($visitante['nascimento'])) : ''; ?>">
            </div>
            <div class="col-1 px-1 text-center">/</div>
            <div class="col-3 px-1">
                <input type="number" class="form-control" id="f-nascimento-mes" name="f-nascimento-mes" onkeyup="changeMonth(this)" placeholder="" value="<?php echo isset($visitante['nascimento']) && $visitante['nascimento'] != '0000-00-00' ? date('m', strtotime($visitante['nascimento'])) : ''; ?>">
            </div>
            <div class="col-1 px-1 text-center">/</div>
            <div class="col-4 px-1">
                <input type="number" class="form-control" id="f-nascimento-ano" name="f-nascimento-ano" onkeyup="changeYear(this)" placeholder="" value="<?php echo isset($visitante['nascimento']) && $visitante['nascimento'] != '0000-00-00' ? date('Y', strtotime($visitante['nascimento'])) : ''; ?>">
            </div>
        </div>
    </div>
    <!--
            <div class="col-12 mb-3">
                <label for="f-foto" class="form-label">Foto de perfil</label>


                <div>
                    <div class="boxvideo">
                        <video autoplay="" id="video" onclick="funcScreenshot()" ondblclick="funcChangeCamera()"></video>
                    </div>

                    <div style="margin: auto; display: flex;">
                        <a class="button btn btn-info" id="btnPlay" style="display: none;">
                            <i class="fas fa-play"></i>
                        </a>
                        <a class="button" id="btnPause">
                            <i class="fas fa-pause"></i>
                        </a>
                        <a class="button is-success" id="btnScreenshot">
                            <i class="fas fa-camera"></i>
                        </a>
                        <a class="button" id="btnChangeCamera">
                            <i class="fas fa-sync-alt"></i>
                            <span>Switch</span>
                        </a>
                    </div>
                </div>

                <div id="screenshot" style="width: 160px;">
                    <img src="" alt="" id="screenshots" style="display: block; width: 160px;">
                </div>

                <div id="fotoHelp" class="form-text">Foto para identificação rápida.</div>
            </div>
                -->

    <?php
    if (isset($visitante) && $visitante) {
    ?>
        <div class="col-12 mb-3">
            <label for="f-status" class="form-label">Status</label><br>
            <div class="form-check form-check-inline" style="border-color: #d1d1d1 !important;">
                <input class="form-check-input" type="radio" name="f-status" id="f-ok" value="1" required <?php echo isset($visitante['status']) && $visitante['status'] == '1' ? 'checked' : ''; ?>>
                <label class="form-check-label" for="f-ok">OK</label>
            </div>
            <div class="form-check form-check-inline" style="border-color: #FFEB3B !important;">
                <input class="form-check-input" type="radio" name="f-status" id="f-atualizar" value="2" required <?php echo isset($visitante['status']) && $visitante['status'] == '2' ? 'checked' : ''; ?>>
                <label class="form-check-label" for="f-atualizar">Atualizar</label>
            </div>
            <div class="form-check form-check-inline" style="border-color: #ff3b3b !important;">
                <input class="form-check-input" type="radio" name="f-status" id="f-atencao" value="3" required <?php echo isset($visitante['status']) && $visitante['status'] == '3' ? 'checked' : ''; ?>>
                <label class="form-check-label" for="f-atencao">Atenção</label>
            </div>
            <div class="form-check form-check-inline" style="border-color: #1c37cf !important;">
                <input class="form-check-input" type="radio" name="f-status" id="f-bloqueado" value="4" required <?php echo isset($visitante['status']) && $visitante['status'] == '4' ? 'checked' : ''; ?>>
                <label class="form-check-label" for="f-bloqueado">Bloqueado</label>
            </div>
            <div id="statusHelp" class="form-text">Cor da pulseira.</div>
        </div>
    <?php
    }
    ?>

    <div class="mb-3 mt-3 text-end">

        <?php

        if (isset($visitante) && $visitante) {
            echo '<button class="btn btn-success" onclick="btnatualizar()" id="btn_cadastrar">Atualizar</button>';
        } else {
            echo '<button class="btn btn-success" onclick="btncadastrar()" id="btn_cadastrar">Cadastrar</button>';
        }

        if ($user['id'] == 1) {
            echo '<br><br><button class="btn btn-danger" onclick="testeStress()">Teste de Stress</button>';
        }

        ?>

    </div>



    <style>
        .tpulseira {
            border-bottom: solid;
            border-width: 3px;
            border-radius: 5px;
        }
    </style>


    <script src="src/js/jquery.min.js"></script>
    <script src="src/js/html2canvas.min.js"></script>
    <script src="src/js/dom-to-image.min.js"></script>
    <script src="src/js/camera.js"></script>

    <script>
        let pulseira_teste = 5000;

        function btncadastrar(teste = false) {

            form = $('#form_visitante')[0];
            // Preparação dos dados.
            dados = new FormData(form);

            // Deixa pulseira sempre como 0;
            if (dados.get('f-oldPulseira') == '') {
                dados.set('f-oldPulseira', 0);
            }

            $('#btn_cadastrar').text('Aguarde');
            $('#btn_cadastrar').prop('disabled', true);

            if (teste) {
                $('#f-fullName').val("TESTE - " + pulseira_teste);
                $("#f-pulseira").val(pulseira_teste++);
                console.log(pulseira_teste);
            }

            // Chamada AJAX
            ajaxDados('<?php echo BASE_URL . '?api=cadastro'; ?>', dados, function(ret) {
                // Para testes
                console.log(ret);

                // Verifica se teve retorno ok.
                if (ret.ret) {

                    if (!teste) {

                        $('#form_visitante').each(function() {
                            this.reset();
                        });

                        $("#f-fotoPerfil").val('');
                        $("#img-out").prop('src', '');
                        $("#video").stop(); // não está funcionando.

                        $('#f-fullName').focus();
                    }


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
            });
        }

        function btnatualizar() {

            form = $('#form_visitante')[0];
            // Preparação dos dados.
            dados = new FormData(form);

            <?php
            if (isset($visitante) && $visitante) {
                echo "dados.append('id', '" . $_GET['id'] . "');";
            }
            ?>

            // Deixa pulseira sempre como 0;
            if (dados.get('f-oldPulseira') == '') {
                dados.set('f-oldPulseira', 0);
            }

            $('#btn_cadastrar').text('Aguarde');
            $('#btn_cadastrar').prop('disabled', true);

            // Chamada AJAX
            ajaxDados('<?php echo BASE_URL . '?api=cadastro'; ?>', dados, function(ret) {
                // Para testes
                console.log(ret);

                // Verifica se teve retorno ok.
                if (ret.ret) {

                    $('#form_visitante').each(function() {
                        this.reset();
                    });

                    $("#f-fotoPerfil").val('');
                    $("#img-out").prop('src', '');
                    $("#video").stop();

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

                    window.location.reload(true);
                } else {


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

                $('#btn_cadastrar').text('Atualizar');
                $('#btn_cadastrar').prop('disabled', false);
            })
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

        function testeStress() {
            qtqPulseiras = $("#f-pulseira").val();

            for (let i = 0; i < qtqPulseiras; i++) {
                btncadastrar(true);
            }
        }
    </script>

</form>