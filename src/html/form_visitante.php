<form class="row g-2" id="form_visitante" name="form_visitante" onsubmit="return false;" enctype="multipart/form-data">
    <?php
    if (!isset($user)) {
        $user = Seguranca::getSession();
    }
    ?>
    <div class="col-12 mb-3">
        <label for="f-fullName" class="form-label">Nome Completo (Obrigatório)</label>
        <input type="text" class="form-control" id="f-fullName" name="f-fullName" placeholder="" style="text-transform: uppercase;" value="<?php echo isset($visitante['fullName']) ? $visitante['fullName'] : ''; ?>">
        <div class="form-text">Nome completo do visitante.</div>
    </div>

    <input type="hidden" id="f-fotoPerfil" name="f-fotoPerfil" value="">

    <?php require_once(BASE_DIR . 'src/html/pulseiras_tipo.php'); ?>

    <div class="col-12 col-sm-6 mb-3">
        <label for="f-pulseira" class="form-label">Pulseira (Obrigatório)</label>
        <input type="number" class="form-control" id="f-pulseira" name="f-pulseira" placeholder="" value="<?php echo isset($visitante['pulseira']) ? $visitante['pulseira'] : ''; ?>">
        <div class="form-text">Número da pulseira do visitante.</div>
    </div>
    <div class="col-12 col-sm-6 mb-3">
        <label for="f-oldPulseira" class="form-label">Pulseira Antiga</label>
        <input type="number" class="form-control" id="f-oldPulseira" name="f-oldPulseira" placeholder="" value="<?php echo isset($visitante['oldPulseira']) ? $visitante['oldPulseira'] : ''; ?>">
        <div class="form-text">Número da pulseira perdida.</div>
    </div>
    <div class="col-12 col-sm-6 mb-3">
        <label for="f-telefone" class="form-label">Telefone</label>
        <input type="text" class="form-control phone" id="f-telefone" name="f-telefone" placeholder="(00) 00000-0000" value="<?php echo isset($visitante['telefone']) ? $visitante['telefone'] : ''; ?>">
        <div class="form-text">DDD + 9 + número.</div>
    </div>

    <div class="col-6 col-sm-3 mb-3 d-none">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="SIM" id="f-whatsapp" name="f-whatsapp" <?php echo isset($visitante['whatsapp']) && $visitante['whatsapp'] == 'SIM' ? 'checked' : ''; ?>>
            <label class="form-check-label" for="f-whatsapp">
                Whatsapp
            </label>
        </div>
        <div id="telefoneHelp" class="form-text">Número é whatsapp?</div>
    </div>

    <div class="col-6 col-sm-3 mb-3 d-none">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="SIM" id="f-info" name="f-info" <?php echo isset($visitante['info']) && $visitante['info'] == 'SIM' ? 'checked' : ''; ?>>
            <label class="form-check-label" for="f-info">
                Info
            </label>
        </div>
        <div id="telefoneHelp" class="form-text">Podemos enviar informações?</div>
    </div>
    <div class="col-12 col-sm-6 mb-3">
        <label class="form-label">Sexo</label>
        <div class="row g-2">
            <div class="col-6">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="f-sexo" id="f-m" value="m" <?php echo isset($visitante['sexo']) && $visitante['sexo'] == 'M' ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="f-m">Masculino</label>
                </div>
            </div>
            <div class="col-6">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="f-sexo" id="f-f" value="f" <?php echo isset($visitante['sexo']) && $visitante['sexo'] == 'F' ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="f-f">Feminino</label>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 mb-3">
        <label for="f-religiao" class="form-label">Religião</label>
        <input type="text" class="form-control" id="f-religiao" name="f-religiao" placeholder="" style="text-transform: uppercase;" value="<?php echo isset($visitante['religiao']) ? $visitante['religiao'] : ''; ?>">
        <div class="form-text">Igreja ou religião que participa.</div>
    </div>

    <div class="col-6 col-sm-3 mb-3 d-none">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="SIM" id="f-fe" name="f-fe" <?php echo isset($visitante['fe']) && $visitante['fe'] == 'SIM' ? 'checked' : ''; ?>>
            <label class="form-check-label" for="f-fe">
                Mesma fé?
            </label>
        </div>
        <div id="telefoneHelp" class="form-text">Visitante acredita em cristo?</div>
    </div>

    <div class="col-12 mb-3 d-none">
        <label for="f-email" class="form-label">E-Mail</label>
        <input type="text" class="form-control" id="f-email" name="f-email" value="<?php echo isset($visitante['email']) ? $visitante['email'] : ''; ?>">
        <div id="emailHelp" class="form-text">E-Mail de contato do visitante.</div>
    </div>

    <div class="col-12 col-sm-6 mb-3">
        <label for="f-cidade" class="form-label">Cidade</label>
        <input type="text" class="form-control" id="f-cidade" name="f-cidade" placeholder="" style="text-transform: uppercase;" value="<?php echo isset($visitante['cidade']) ? $visitante['cidade'] : ''; ?>">
    </div>
    <div class="col-12 col-sm-6 mb-3">
        <label for="f-bairro" class="form-label">Bairro</label>
        <input type="text" class="form-control" id="f-bairro" name="f-bairro" placeholder="" style="text-transform: uppercase;" value="<?php echo isset($visitante['bairro']) ? $visitante['bairro'] : ''; ?>">
    </div>
    <div class="col-12 mb-3">
        <label for="f-endereco" class="form-label">Endereço</label>
        <input type="text" class="form-control" id="f-endereco" name="f-endereco" placeholder="" style="text-transform: uppercase;" value="<?php echo isset($visitante['endereco']) ? $visitante['endereco'] : ''; ?>">
        <div class="form-text">Endereço com rua, número e complemento.</div>
    </div>

    <div class="col-6 col-sm-3 mb-3 d-none">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="SIM" id="f-contato" name="f-contato" <?php echo isset($visitante['contato']) && $visitante['contato'] == 'SIM' ? 'checked' : ''; ?>>
            <label class="form-check-label" for="f-contato">
                Contato
            </label>
        </div>
        <div id="telefoneHelp" class="form-text">Gostaria de conversar?</div>
    </div>

    <div class="col-12 col-sm-6 mb-3">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="SIM" id="f-palco" name="f-palco" <?php echo isset($visitante['palco']) && $visitante['palco'] == 'SIM' ? 'checked' : ''; ?>>
            <label class="form-check-label" for="f-palco">Palco</label>
            <div class="form-text">Participaria no palco?</div>
        </div>
    </div>

    <div class="col-12 col-sm-6 mb-3">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="SIM" id="f-calouro" name="f-calouro" <?php echo isset($visitante['calouro']) && $visitante['calouro'] == 'SIM' ? 'checked' : ''; ?>>
            <label class="form-check-label" for="f-calouro">Primeira vez</label>
            <div class="form-text">Primeira vez no evento?</div>
        </div>
    </div>

    <div class="col-12 mb-3">
        <label for="f-nascimento" class="form-label">Nascimento</label>
        <div class="row g-2">
            <div class="col-4">
                <input type="number" class="form-control" id="f-nascimento-dia" name="f-nascimento-dia" onkeyup="changeDay(this)" placeholder="DD" value="<?php echo isset($visitante['nascimento']) && $visitante['nascimento'] != '0000-00-00' ? date('d', strtotime($visitante['nascimento'])) : ''; ?>">
            </div>
            <div class="col-4">
                <input type="number" class="form-control" id="f-nascimento-mes" name="f-nascimento-mes" onkeyup="changeMonth(this)" placeholder="MM" value="<?php echo isset($visitante['nascimento']) && $visitante['nascimento'] != '0000-00-00' ? date('m', strtotime($visitante['nascimento'])) : ''; ?>">
            </div>
            <div class="col-4">
                <input type="number" class="form-control" id="f-nascimento-ano" name="f-nascimento-ano" onkeyup="changeYear(this)" placeholder="AAAA" value="<?php echo isset($visitante['nascimento']) && $visitante['nascimento'] != '0000-00-00' ? date('Y', strtotime($visitante['nascimento'])) : ''; ?>">
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
            <label for="f-status" class="form-label">Status</label>
            <div class="row g-2">
                <div class="col-6 col-md-3">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="f-status" id="f-ok" value="1" required <?php echo isset($visitante['status']) && $visitante['status'] == '1' ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="f-ok">OK</label>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="f-status" id="f-atualizar" value="2" required <?php echo isset($visitante['status']) && $visitante['status'] == '2' ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="f-atualizar">Atualizar</label>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="f-status" id="f-atencao" value="3" required <?php echo isset($visitante['status']) && $visitante['status'] == '3' ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="f-atencao">Atenção</label>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="f-status" id="f-bloqueado" value="4" required <?php echo isset($visitante['status']) && $visitante['status'] == '4' ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="f-bloqueado">Bloqueado</label>
                    </div>
                </div>
            </div>
            <div class="form-text">Status do visitante.</div>
        </div>
    <?php
    }
    ?>

    <div class="col-12 mb-3">
        <div class="d-flex flex-wrap align-items-center justify-content-end gap-2">
            <?php
            $fotoVisitanteUrl = '';
            if (isset($visitante['foto']) && $visitante['foto']) {
                $fotoVisitanteUrl = MidiaVisitante::urlDoVisitante($visitante);
            }
            ?>
            <img
                src="<?php echo htmlspecialchars($fotoVisitanteUrl, ENT_QUOTES, 'UTF-8'); ?>"
                alt="Foto do visitante"
                id="visitante-foto-preview"
                title="Clique para ampliar"
                class="visitante-foto-preview<?php echo $fotoVisitanteUrl ? '' : ' d-none'; ?>">
            <small id="visitante-foto-info" class="text-muted<?php echo $fotoVisitanteUrl ? '' : ' d-none'; ?>">
                <?php echo $fotoVisitanteUrl ? 'Foto atual' : ''; ?>
            </small>
            <button type="button" class="btn btn-outline-primary" id="btn_foto_visitante">
                <i class="fas fa-camera"></i> Foto
            </button>
            <?php
            if (isset($visitante) && $visitante) {
                echo '<button type="button" class="btn btn-success" onclick="btnatualizar()" id="btn_cadastrar">Atualizar</button>';
            } else {
                echo '<button type="button" class="btn btn-success" onclick="btncadastrar()" id="btn_cadastrar">Cadastrar</button>';
            }

            if ($user['id'] == 1 and isset($_GET['stress'])) {
                echo '<button type="button" class="btn btn-danger" onclick="testeStress()">Teste de Stress</button>';
            }
            ?>
        </div>
    </div>

    <div class="modal fade" id="modal-foto-visitante" tabindex="-1" aria-labelledby="modalFotoVisitanteLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header py-2">
                    <h2 class="modal-title h6 mb-0" id="modalFotoVisitanteLabel">Capturar foto</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body text-center">
                    <video id="visitante-foto-video" autoplay playsinline muted class="visitante-foto-video"></video>
                    <p class="text-muted small mb-0 mt-2">Câmera traseira por padrão. Foto reduzida para até 320px mantendo rosto identificável.</p>
                </div>
                <div class="modal-footer py-2 d-flex justify-content-between">
                    <button type="button" class="btn btn-outline-secondary btn-sm" id="btn-foto-trocar">
                        <i class="fas fa-sync-alt"></i> Trocar
                    </button>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-secondary btn-sm" id="btn-foto-cancelar" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary btn-sm" id="btn-foto-capturar">
                            <i class="fas fa-camera"></i> Capturar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-foto-visitante-preview" tabindex="-1" aria-labelledby="modalFotoVisitantePreviewLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header py-2">
                    <h2 class="modal-title h6 mb-0" id="modalFotoVisitantePreviewLabel">Foto do visitante</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body text-center">
                    <img src="" alt="Foto ampliada do visitante" id="visitante-foto-preview-modal-img" class="visitante-foto-modal-img">
                </div>
            </div>
        </div>
    </div>

    <style>
        .visitante-foto-preview {
            width: 56px;
            height: 56px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #dee2e6;
            cursor: zoom-in;
        }

        .visitante-foto-video {
            width: 100%;
            max-width: 280px;
            border-radius: 8px;
            background: #000;
        }

        .visitante-foto-modal-img {
            width: 100%;
            max-width: 420px;
            max-height: 70vh;
            object-fit: contain;
            border-radius: 8px;
            border: 1px solid #e9ecef;
        }
    </style>



    <script src="src/js/visitante-foto.js"></script>

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

            // Altero os valores do formulário para teste.
            if (teste) {
                $('#f-fullName').val("TESTE - " + pulseira_teste);
                dados.set('f-fullName', "TESTE - " + pulseira_teste);
                $("#f-pulseira").val(pulseira_teste);
                dados.set('f-pulseira', pulseira_teste);

                switch (random(1, 2)) {
                    case 1:
                        dados.set('f-tpulseira', 'amarela');
                        break;
                    case 2:
                        dados.set('f-tpulseira', 'azul');
                        break;
                }

                $("#f-telefone").val('3599709' + pulseira_teste);
                dados.set('f-telefone', '3599709' + pulseira_teste);
                dados.set('f-sexo', 'm');
                if (random(0, 1)) {
                    dados.set('f-sexo', 'f');
                }
                $("#f-nascimento-dia").val(random(1, 28));
                $("#f-nascimento-mes").val(random(1, 12));
                console.log(pulseira_teste);

                pulseira_teste++;
            }

            // Chamada AJAX
            ajaxDados('<?php echo BASE_URL . '?api=cadastro'; ?>', dados, function(ret) {
                // Para testes
                // console.log(ret);

                // Verifica se teve retorno ok.
                if (ret.ret) {

                    if (!teste) {

                        $('#form_visitante').each(function() {
                            this.reset();
                        });

                        $("#f-fotoPerfil").val('');
                        if (typeof visitanteFotoLimpar === 'function') {
                            visitanteFotoLimpar();
                        }

                        $('#f-fullName').focus();
                    }


                    notificaSucesso(ret.msg);
                } else {

                    // code...

                    // Notificação.
                    notificaErro(ret.msg);
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
                // console.log(ret);

                // Verifica se teve retorno ok.
                if (ret.ret) {

                    $('#form_visitante').each(function() {
                        this.reset();
                    });

                    $("#f-fotoPerfil").val('');
                    if (typeof visitanteFotoLimpar === 'function') {
                        visitanteFotoLimpar();
                    }

                    $('#f-pulseira').focus();

                    notificaSucesso(ret.msg);

                    window.location.reload(true);
                } else {


                    // Notificação.
                    notificaErro(ret.msg);
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

        function random(min, max) {
            min = Math.ceil(min);
            max = Math.floor(max);
            return Math.floor(Math.random() * (max - min + 1)) + min;
        }
    </script>

</form>