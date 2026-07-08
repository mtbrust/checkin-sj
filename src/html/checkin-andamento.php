<div class="container my-4 checkin-andamento-page">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <div>
            <h1 class="h4 mb-1">Check-in em andamento</h1>
            <p class="text-muted small mb-0">Ao abrir a pagina, o feed comeca vazio e exibe apenas presencas novas a partir da ultima registrada.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <label for="checkin-delay" class="small text-muted mb-0">Delay (s)</label>
            <input id="checkin-delay" type="number" min="2" max="30" value="2" class="form-control form-control-sm" style="width: 84px;">
        </div>
    </div>

    <div class="checkin-status small text-muted mb-2" id="checkin-status">Aguardando atualizacao...</div>

    <div id="checkin-feed" class="checkin-feed"></div>
</div>

<style>
    .checkin-feed {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(170px, 1fr));
        gap: 10px;
    }

    .checkin-card {
        border: 1px solid #e9ecef;
        border-radius: 10px;
        padding: 8px;
        background: #fff;
    }

    .checkin-card img {
        width: 100%;
        height: 170px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #eee;
        background: #f8f9fa;
    }

    .checkin-nome {
        margin-top: 6px;
        font-size: 0.82rem;
        font-weight: 600;
        line-height: 1.2;
    }

    .checkin-card-bloqueado {
        border-color: #f1aeb5;
        background: #fff5f5;
    }

    .checkin-meta {
        font-size: 0.72rem;
        color: #6c757d;
    }
</style>

<script>
    (function() {
        const API_URL = '<?php echo BASE_URL . '?api=estatistica'; ?>';
        const FOTO_PADRAO = '<?php echo BASE_URL . 'src/midia/user.webp'; ?>';
        let ultimoIdPresenca = 0;
        const presencasExibidas = new Set();
        let timer = null;
        let buscando = false;
        let pronto = false;

        function feedEl(id) {
            return document.getElementById(id);
        }

        function limparFeed() {
            feedEl('checkin-feed').innerHTML = '';
            presencasExibidas.clear();
            ultimoIdPresenca = 0;
            pronto = false;
        }

        function formatDataHora(valor) {
            if (!valor) return '-';
            const dt = new Date(String(valor).replace(' ', 'T'));
            if (Number.isNaN(dt.getTime())) return valor;
            return dt.toLocaleString('pt-BR');
        }

        function delayMs() {
            const input = feedEl('checkin-delay');
            const sec = Math.max(2, Math.min(30, parseInt(input.value || '2', 10)));
            input.value = String(sec);
            return sec * 1000;
        }

        function statusTexto(txt) {
            feedEl('checkin-status').textContent = txt;
        }

        function renderItens(itens) {
            if (!itens || !itens.length) return;

            const feed = feedEl('checkin-feed');

            itens.forEach(function(item) {
                if (presencasExibidas.has(item.idPresenca)) {
                    return;
                }
                presencasExibidas.add(item.idPresenca);

                const fotoUrl = item.fotoUrl || FOTO_PADRAO;
                const bloqueado = parseInt(item.status, 10) === 4;

                const card = document.createElement('div');
                card.className = 'checkin-card' + (bloqueado ? ' checkin-card-bloqueado' : '');
                card.innerHTML =
                    '<img src="' + fotoUrl + '" alt="Foto visitante">' +
                    '<div class="checkin-nome text-truncate" title="' + (item.fullName || '') + '">' + (item.fullName || 'Sem nome') + '</div>' +
                    '<div class="checkin-meta">Pulseira ' + item.pulseira + ' • ' + (item.tpulseira || '-') + (bloqueado ? ' • Bloqueado' : '') + '</div>' +
                    '<div class="checkin-meta">' + formatDataHora(item.dtCreate) + '</div>';

                feed.prepend(card);
            });

            while (feed.children.length > 24) {
                feed.removeChild(feed.lastChild);
            }
        }

        function buscar() {
            if (buscando || !pronto) return;
            buscando = true;

            const dados = new FormData();
            dados.append('acao', 'checkinandamento');
            dados.append('ultimo_id_imagem', String(ultimoIdPresenca));
            dados.append('qtd', '8');

            ajaxDados(API_URL, dados, function(ret) {
                buscando = false;
                if (!ret || !ret.ret) {
                    statusTexto('Falha ao atualizar feed.');
                    return;
                }

                const payload = ret.ret || {};
                const itens = payload.itens || [];
                const novoUltimo = parseInt(payload.ultimo_id_imagem || ultimoIdPresenca, 10);
                ultimoIdPresenca = Number.isNaN(novoUltimo) ? ultimoIdPresenca : Math.max(ultimoIdPresenca, novoUltimo);

                renderItens(itens);

                if (!feedEl('checkin-feed').children.length) {
                    statusTexto('Aguardando novas presencas...');
                } else {
                    statusTexto('Atualizado em ' + new Date().toLocaleTimeString('pt-BR') + '.');
                }
            });
        }

        function inicializar(callback) {
            limparFeed();
            statusTexto('Inicializando...');

            const dados = new FormData();
            dados.append('acao', 'checkinandamento');
            dados.append('inicializar', '1');

            ajaxDados(API_URL, dados, function(ret) {
                if (!ret || !ret.ret) {
                    statusTexto('Falha ao inicializar feed.');
                    return;
                }

                const payload = ret.ret || {};
                const novoUltimo = parseInt(payload.ultimo_id_imagem || 0, 10);
                ultimoIdPresenca = Number.isNaN(novoUltimo) ? 0 : novoUltimo;
                pronto = true;
                statusTexto('Aguardando novas presencas...');

                if (typeof callback === 'function') {
                    callback();
                }
            });
        }

        function iniciarLoop() {
            if (timer) {
                window.clearInterval(timer);
            }

            inicializar(function() {
                buscar();
                timer = window.setInterval(buscar, delayMs());
            });
        }

        function init() {
            const delayInput = feedEl('checkin-delay');
            delayInput.addEventListener('change', iniciarLoop);
            delayInput.addEventListener('keyup', function(e) {
                if (e.key === 'Enter') iniciarLoop();
            });

            window.addEventListener('pageshow', function(e) {
                if (e.persisted) {
                    iniciarLoop();
                }
            });

            iniciarLoop();
        }

        if (typeof window.jQuery === 'undefined') {
            window.setTimeout(init, 40);
        } else {
            window.jQuery(init);
        }
    })();
</script>
