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
        <input type="text" class="form-control phone" id="f-telefone" name="f-telefone" placeholder="(00) 00000-0000" inputmode="numeric" maxlength="15" value="<?php echo isset($visitante['telefone']) ? htmlspecialchars($visitante['telefone'], ENT_QUOTES, 'UTF-8') : ''; ?>">
        <div class="form-text">DDD + 9 dígitos (11 no total). Ex.: (35) 99709-1234</div>
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
                <?php if ($fotoVisitanteUrl): ?>src="<?php echo htmlspecialchars($fotoVisitanteUrl, ENT_QUOTES, 'UTF-8'); ?>"<?php endif; ?>
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
        <div class="text-end mt-2 small text-muted" id="cadastro-sync-status"></div>
    </div>

    <div class="col-12 mb-3" id="cadastro-fila-wrap" style="display:none;">
        <div class="card border-warning-subtle">
            <div class="card-header py-2 d-flex justify-content-between align-items-center">
                <strong class="small mb-0">Cadastros pendentes</strong>
                <button type="button" class="btn btn-sm btn-outline-primary" id="cadastro-btn-sync-agora">Sincronizar agora</button>
            </div>
            <div class="card-body py-2">
                <div class="small text-muted mb-2" id="cadastro-fila-resumo"></div>
                <div id="cadastro-fila-lista" class="d-grid gap-2"></div>
            </div>
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



    <script src="<?php echo BASE_URL; ?>src/js/visitante-foto.js"></script>

    <script>
        let pulseira_teste = 5000;
        const CADASTRO_MODO_EDICAO = <?php echo (isset($visitante) && $visitante) ? 'true' : 'false'; ?>;
        const CADASTRO_DRAFT_KEY = 'checkin.cadastro.draft.v2.<?php echo isset($user['id']) ? (int) $user['id'] : 0; ?>';
        const CADASTRO_QUEUE_KEY = 'checkin.cadastro.queue.fallback.v2.<?php echo isset($user['id']) ? (int) $user['id'] : 0; ?>';
        const CADASTRO_DB_NAME = 'checkin_offline_v2';
        const CADASTRO_DB_STORE = 'cadastro_queue';
        const CAMPOS_CHECKBOX = ['f-whatsapp', 'f-info', 'f-fe', 'f-contato', 'f-palco', 'f-calouro'];
        let sincronizandoFila = false;
        let timerFila = null;
        let debounceDraft = null;
        let cadastroDb = null;
        let ultimoErroSync = '';

        function statusSincronizacao(txt) {
            $('#cadastro-sync-status').text(txt || '');
        }

        function getFilaFallback() {
            const raw = localStorage.getItem(CADASTRO_QUEUE_KEY);
            if (!raw) return [];
            try {
                const lista = JSON.parse(raw);
                return Array.isArray(lista) ? lista : [];
            } catch (e) {
                return [];
            }
        }

        function setFilaFallback(lista) {
            localStorage.setItem(CADASTRO_QUEUE_KEY, JSON.stringify(lista || []));
        }

        function abrirDbCadastro() {
            if (!('indexedDB' in window)) {
                return Promise.resolve(null);
            }
            if (cadastroDb) {
                return Promise.resolve(cadastroDb);
            }
            return new Promise(function(resolve) {
                const req = indexedDB.open(CADASTRO_DB_NAME, 1);
                req.onupgradeneeded = function(event) {
                    const db = event.target.result;
                    if (!db.objectStoreNames.contains(CADASTRO_DB_STORE)) {
                        const store = db.createObjectStore(CADASTRO_DB_STORE, { keyPath: 'id', autoIncrement: true });
                        store.createIndex('status', 'status', { unique: false });
                        store.createIndex('createdAt', 'createdAt', { unique: false });
                    }
                };
                req.onsuccess = function(event) {
                    cadastroDb = event.target.result;
                    resolve(cadastroDb);
                };
                req.onerror = function() {
                    resolve(null);
                };
            });
        }

        async function filaCount() {
            const db = await abrirDbCadastro();
            if (!db) return getFilaFallback().length;
            return new Promise(function(resolve) {
                const tx = db.transaction(CADASTRO_DB_STORE, 'readonly');
                const store = tx.objectStore(CADASTRO_DB_STORE);
                const req = store.count();
                req.onsuccess = function() { resolve(req.result || 0); };
                req.onerror = function() { resolve(0); };
            });
        }

        async function filaListar() {
            const db = await abrirDbCadastro();
            if (!db) {
                return getFilaFallback();
            }
            return new Promise(function(resolve) {
                const tx = db.transaction(CADASTRO_DB_STORE, 'readonly');
                const store = tx.objectStore(CADASTRO_DB_STORE);
                const req = store.getAll();
                req.onsuccess = function() {
                    const arr = Array.isArray(req.result) ? req.result : [];
                    arr.sort(function(a, b) {
                        return (a.id || 0) - (b.id || 0);
                    });
                    resolve(arr);
                };
                req.onerror = function() { resolve([]); };
            });
        }

        async function filaGetById(id) {
            const db = await abrirDbCadastro();
            if (!db) {
                const fila = getFilaFallback();
                return fila.find(function(it) { return Number(it.id) === Number(id); }) || null;
            }
            return new Promise(function(resolve) {
                const tx = db.transaction(CADASTRO_DB_STORE, 'readonly');
                const req = tx.objectStore(CADASTRO_DB_STORE).get(Number(id));
                req.onsuccess = function() { resolve(req.result || null); };
                req.onerror = function() { resolve(null); };
            });
        }

        async function filaPush(payload, origem) {
            const item = {
                createdAt: new Date().toISOString(),
                updatedAt: new Date().toISOString(),
                attempts: 0,
                status: 'pending',
                lastError: '',
                origem: origem || 'offline',
                payload: payload
            };
            const db = await abrirDbCadastro();
            if (!db) {
                const fila = getFilaFallback();
                item.id = Date.now() + Math.floor(Math.random() * 1000);
                fila.push(item);
                setFilaFallback(fila);
                return true;
            }
            return new Promise(function(resolve) {
                const tx = db.transaction(CADASTRO_DB_STORE, 'readwrite');
                tx.objectStore(CADASTRO_DB_STORE).add(item).onsuccess = function() { resolve(true); };
                tx.onerror = function() { resolve(false); };
            });
        }

        async function filaGetPrimeiro() {
            const db = await abrirDbCadastro();
            if (!db) {
                const fila = getFilaFallback();
                return fila.length ? fila[0] : null;
            }
            return new Promise(function(resolve) {
                const tx = db.transaction(CADASTRO_DB_STORE, 'readonly');
                const store = tx.objectStore(CADASTRO_DB_STORE);
                const req = store.openCursor();
                req.onsuccess = function(event) {
                    const cursor = event.target.result;
                    resolve(cursor ? cursor.value : null);
                };
                req.onerror = function() { resolve(null); };
            });
        }

        async function filaAtualizar(item) {
            const db = await abrirDbCadastro();
            if (!db) {
                const fila = getFilaFallback();
                const idx = fila.findIndex(function(it) { return it.id === item.id; });
                if (idx >= 0) {
                    fila[idx] = item;
                    setFilaFallback(fila);
                }
                return;
            }
            return new Promise(function(resolve) {
                const tx = db.transaction(CADASTRO_DB_STORE, 'readwrite');
                tx.objectStore(CADASTRO_DB_STORE).put(item).onsuccess = function() { resolve(); };
                tx.onerror = function() { resolve(); };
            });
        }

        async function filaRemover(id) {
            const db = await abrirDbCadastro();
            if (!db) {
                const fila = getFilaFallback().filter(function(it) { return it.id !== id; });
                setFilaFallback(fila);
                return;
            }
            return new Promise(function(resolve) {
                const tx = db.transaction(CADASTRO_DB_STORE, 'readwrite');
                tx.objectStore(CADASTRO_DB_STORE).delete(id).onsuccess = function() { resolve(); };
                tx.onerror = function() { resolve(); };
            });
        }

        async function renderFilaPendentes() {
            if (CADASTRO_MODO_EDICAO) return;
            const lista = await filaListar();
            const $wrap = $('#cadastro-fila-wrap');
            const $resumo = $('#cadastro-fila-resumo');
            const $lista = $('#cadastro-fila-lista');

            if (!lista.length) {
                $wrap.hide();
                $lista.html('');
                $resumo.text('');
                return;
            }

            $wrap.show();
            $resumo.text('Itens salvos no aparelho. Use "Forçar cadastro" para enviar cada registro pendente.');

            const html = lista.map(function(item) {
                const p = item.payload || {};
                const nome = p['f-fullName'] || '(sem nome)';
                const pulseira = p['f-pulseira'] || '-';
                const cor = p['f-tpulseira'] || '-';
                const tentativas = item.attempts || 0;
                const erro = item.lastError ? String(item.lastError) : '';
                const badge = erro ? '<span class="badge text-bg-danger">erro</span>' : '<span class="badge text-bg-warning">pendente</span>';
                return (
                    '<div class="border rounded p-2">' +
                        '<div class="d-flex justify-content-between align-items-center gap-2">' +
                            '<div class="small">' +
                                '<strong>' + nome + '</strong><br>' +
                                'Pulseira ' + pulseira + ' • ' + String(cor).toUpperCase() + ' • tentativas: ' + tentativas + ' ' + badge +
                            '</div>' +
                            '<div class="d-flex flex-column flex-sm-row gap-1">' +
                                '<button type="button" class="btn btn-sm btn-primary fila-enviar" data-id="' + item.id + '">Forçar cadastro</button>' +
                            '</div>' +
                        '</div>' +
                        (erro ? ('<div class="small text-danger mt-1">Erro: ' + erro + '</div>') : '') +
                    '</div>'
                );
            }).join('');

            $lista.html(html);
        }

        async function atualizarStatusFila() {
            if (CADASTRO_MODO_EDICAO) return;
            const qtd = await filaCount();
            if (qtd <= 0) {
                statusSincronizacao('');
                ultimoErroSync = '';
                await renderFilaPendentes();
                return;
            }
            const textoConexao = navigator.onLine ? 'online' : 'offline';
            const sufixo = ultimoErroSync ? (' | último erro: ' + ultimoErroSync) : '';
            statusSincronizacao('Cadastros pendentes: ' + qtd + ' (' + textoConexao + ')' + sufixo);
            await renderFilaPendentes();
        }

        function capturarPayloadFormulario() {
            const payload = {};
            const arr = $('#form_visitante').serializeArray();
            arr.forEach(function(item) {
                payload[item.name] = item.value;
            });

            CAMPOS_CHECKBOX.forEach(function(name) {
                payload[name] = $('#' + name).is(':checked') ? 'SIM' : '';
            });

            payload['f-fotoPerfil'] = $('#f-fotoPerfil').val() || '';
            return payload;
        }

        function preencherFormularioComPayload(payload) {
            if (!payload || typeof payload !== 'object') return;

            Object.keys(payload).forEach(function(name) {
                const valor = payload[name];
                const $el = $('[name="' + name + '"]');
                if (!$el.length) return;

                const tipo = ($el.attr('type') || '').toLowerCase();
                if (tipo === 'radio') {
                    $('[name="' + name + '"][value="' + valor + '"]').prop('checked', true);
                    return;
                }
                if (tipo === 'checkbox') {
                    $el.prop('checked', String(valor).toUpperCase() === 'SIM');
                    return;
                }
                $el.val(valor);
            });
        }

        function salvarRascunho() {
            if (CADASTRO_MODO_EDICAO) return;
            try {
                localStorage.setItem(CADASTRO_DRAFT_KEY, JSON.stringify(capturarPayloadFormulario()));
            } catch (e) {
                statusSincronizacao('Memória do navegador cheia para salvar rascunho.');
            }
        }

        function ofertarRecuperarRascunho() {
            if (CADASTRO_MODO_EDICAO) return;

            let payload = null;
            try {
                const raw = localStorage.getItem(CADASTRO_DRAFT_KEY);
                if (!raw) return;
                payload = JSON.parse(raw);
            } catch (e) {
                localStorage.removeItem(CADASTRO_DRAFT_KEY);
                return;
            }

            if (!payload || (!payload['f-fullName'] && !payload['f-pulseira'] && !payload['f-telefone'])) {
                localStorage.removeItem(CADASTRO_DRAFT_KEY);
                return;
            }

            if ($('#cadastro-rascunho-banner').length) return;

            const nome = payload['f-fullName'] || '(sem nome)';
            const pulseira = payload['f-pulseira'] || '-';
            const $banner = $(
                '<div class="col-12 mb-3" id="cadastro-rascunho-banner">' +
                    '<div class="alert alert-info py-2 mb-0 d-flex flex-wrap align-items-center justify-content-between gap-2">' +
                        '<span class="small">Rascunho salvo: <strong></strong></span>' +
                        '<span class="d-flex gap-2">' +
                            '<button type="button" class="btn btn-sm btn-primary" id="cadastro-rascunho-recuperar">Recuperar</button>' +
                            '<button type="button" class="btn btn-sm btn-outline-secondary" id="cadastro-rascunho-descartar">Descartar</button>' +
                        '</span>' +
                    '</div>' +
                '</div>'
            );
            $banner.find('strong').text(nome + ' • pulseira ' + pulseira);
            $('#form_visitante').prepend($banner);

            $('#cadastro-rascunho-recuperar').on('click', function() {
                preencherFormularioComPayload(payload);
                $('#cadastro-rascunho-banner').remove();
                statusSincronizacao('Rascunho recuperado do dispositivo.');
            });

            $('#cadastro-rascunho-descartar').on('click', function() {
                limparRascunho();
                $('#cadastro-rascunho-banner').remove();
                statusSincronizacao('');
            });
        }

        function limparRascunho() {
            if (CADASTRO_MODO_EDICAO) return;
            localStorage.removeItem(CADASTRO_DRAFT_KEY);
        }

        function limparFormularioCadastro() {
            $('#form_visitante').each(function() {
                this.reset();
            });
            $("#f-fotoPerfil").val('');
            if (typeof visitanteFotoLimpar === 'function') {
                visitanteFotoLimpar();
            }
            $('#cadastro-rascunho-banner').remove();
            $('#f-fullName').focus();
        }

        function validarMinimoCadastro(payload) {
            if (!payload['f-fullName']) return 'Nome é obrigatório.';
            if (!payload['f-pulseira']) return 'Pulseira é obrigatório.';
            if (!payload['f-tpulseira']) return 'Cor de Pulseira é obrigatório.';
            return '';
        }

        function payloadParaFormData(payload) {
            const dados = new FormData();
            Object.keys(payload || {}).forEach(function(key) {
                dados.append(key, payload[key]);
            });
            if (!dados.get('f-oldPulseira')) {
                dados.set('f-oldPulseira', 0);
            }
            return dados;
        }

        async function enfileirarCadastro(payload, origem) {
            if (CADASTRO_MODO_EDICAO) return false;
            const ok = await filaPush(payload, origem);
            if (!ok) {
                statusSincronizacao('Falha ao salvar fila local.');
                return false;
            }
            await atualizarStatusFila();
            return true;
        }

        function enviarCadastroPromise(payload) {
            return new Promise(function(resolve) {
                const dados = payloadParaFormData(payload || {});
                ajaxDados('<?php echo BASE_URL . '?api=cadastro'; ?>', dados, function(ret) {
                    resolve(ret || { ret: false, msg: 'Erro na chamada AJAX.' });
                });
            });
        }

        async function enviarItemFilaPorId(id, notificarSucesso = true) {
            const item = await filaGetById(id);
            if (!item) {
                await atualizarStatusFila();
                return;
            }
            if (!navigator.onLine) {
                notificaErro('Sem conexão para forçar envio.');
                return;
            }

            statusSincronizacao('Forçando envio do cadastro pendente...');
            const ret = await enviarCadastroPromise(item.payload || {});

            if (ret && ret.ret) {
                await filaRemover(item.id);
                ultimoErroSync = '';
                if (notificarSucesso) {
                    notificaSucesso('Cadastro pendente enviado com sucesso.');
                }
            } else {
                item.attempts = (item.attempts || 0) + 1;
                item.updatedAt = new Date().toISOString();
                item.lastError = (ret && ret.msg) ? ret.msg : 'Erro na chamada AJAX.';
                item.status = (item.lastError === 'Erro na chamada AJAX.') ? 'pending' : 'error';
                ultimoErroSync = item.lastError;
                await filaAtualizar(item);
                notificaErro('Falha ao forçar envio: ' + item.lastError);
            }

            await atualizarStatusFila();
        }

        async function sincronizarFilaCadastro() {
            if (CADASTRO_MODO_EDICAO || sincronizandoFila || !navigator.onLine) return;
            const item = await filaGetPrimeiro();
            if (!item) {
                await atualizarStatusFila();
                return;
            }

            sincronizandoFila = true;
            const total = await filaCount();
            statusSincronizacao('Sincronizando ' + total + ' cadastro(s)...');

            const ret = await enviarCadastroPromise(item.payload || {});
            sincronizandoFila = false;

            if (ret && ret.ret) {
                ultimoErroSync = '';
                await filaRemover(item.id);
                notificaSucesso('Cadastro pendente sincronizado.');
                await atualizarStatusFila();
                const restantes = await filaCount();
                if (restantes > 0) {
                    setTimeout(function() {
                        sincronizarFilaCadastro();
                    }, 200);
                }
                return;
            }

            item.attempts = (item.attempts || 0) + 1;
            item.updatedAt = new Date().toISOString();
            item.lastError = (ret && ret.msg) ? ret.msg : 'Erro na chamada AJAX.';
            item.status = (item.lastError === 'Erro na chamada AJAX.') ? 'pending' : 'error';
            ultimoErroSync = item.lastError;
            await filaAtualizar(item);
            await atualizarStatusFila();
        }

        async function initOfflineCadastro() {
            if (CADASTRO_MODO_EDICAO) return;

            ofertarRecuperarRascunho();
            await atualizarStatusFila();
            sincronizarFilaCadastro();

            $('#form_visitante').on('input change', function() {
                clearTimeout(debounceDraft);
                debounceDraft = setTimeout(salvarRascunho, 250);
            });

            window.addEventListener('online', function() {
                ultimoErroSync = '';
                atualizarStatusFila();
                sincronizarFilaCadastro();
            });

            window.addEventListener('offline', function() {
                atualizarStatusFila();
            });

            timerFila = window.setInterval(sincronizarFilaCadastro, 10000);
        }

        async function btncadastrar(teste = false) {

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

            const payloadAtual = capturarPayloadFormulario();
            const msgValidacao = validarMinimoCadastro(payloadAtual);
            if (msgValidacao) {
                $('#btn_cadastrar').text('Cadastrar');
                $('#btn_cadastrar').prop('disabled', false);
                notificaErro(msgValidacao);
                return;
            }

            if (!navigator.onLine && !teste) {
                if (await enfileirarCadastro(payloadAtual, 'offline')) {
                    limparFormularioCadastro();
                    limparRascunho();
                    notificaSucesso('Sem internet. Cadastro salvo na fila para envio automático.');
                } else {
                    notificaErro('Sem internet e não foi possível salvar na fila local.');
                }
                $('#btn_cadastrar').text('Cadastrar');
                $('#btn_cadastrar').prop('disabled', false);
                return;
            }

            // Chamada AJAX
            ajaxDados('<?php echo BASE_URL . '?api=cadastro'; ?>', dados, function(ret) {
                // Para testes
                // console.log(ret);

                // Verifica se teve retorno ok.
                if (ret.ret) {

                    if (!teste) {

                        limparFormularioCadastro();
                        limparRascunho();
                    }


                    notificaSucesso(ret.msg);
                } else {
                    if (!teste && ret && ret.msg === 'Erro na chamada AJAX.') {
                        enfileirarCadastro(payloadAtual, 'erro-conexao').then(function(ok) {
                            if (ok) {
                                limparFormularioCadastro();
                                limparRascunho();
                                notificaSucesso('Cadastro salvo na fila por falha de conexão. Será reenviado automaticamente.');
                            } else {
                                notificaErro('Falha de conexão e não foi possível salvar fila local.');
                            }
                        });
                    } else {
                        notificaErro(ret.msg);
                    }
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

        function initCadastroOfflineUi() {
            initOfflineCadastro();

            $('#cadastro-btn-sync-agora').on('click', function() {
                sincronizarFilaCadastro();
            });

            $('#cadastro-fila-lista').on('click', '.fila-enviar', async function() {
                const id = $(this).data('id');
                await enviarItemFilaPorId(id, true);
            });
        }

        function startWhenJqueryReady() {
            if (typeof window.jQuery === 'undefined') {
                window.setTimeout(startWhenJqueryReady, 60);
                return;
            }
            window.jQuery(initCadastroOfflineUi);
        }

        startWhenJqueryReady();
    </script>

</form>