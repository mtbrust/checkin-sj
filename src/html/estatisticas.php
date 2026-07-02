<?php

Seguranca::checkAdmin();

$baseApi = BASE_URL . '?api=estatistica';
$baseUrl = BASE_URL;

?>

<div class="container my-4 estatisticas-page">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
        <div>
            <h1 class="h3 mb-1">Estatísticas</h1>
            <p class="text-muted small mb-0">Painel do evento — dados atualizados ao abrir a página.</p>
        </div>
        <button type="button" class="btn btn-sm btn-outline-success" id="btn-atualizar-tudo">
            <i class="fas fa-sync-alt"></i> Atualizar tudo
        </button>
    </div>

    <div class="row g-2" id="resumo-kpis">
        <div class="col-6 col-md-4 col-lg-3">
            <div class="estat-kpi estat-kpi-link" data-estat-filtros="{}" title="Ver todos os cadastros">
                <span class="estat-kpi-label">Cadastros (total)</span>
                <strong class="estat-kpi-valor" data-kpi="cadastros_total">-</strong>
                <small class="text-muted">Hoje: <span class="estat-kpi-sublink" data-estat-filtros='{"f-hoje":"1"}' data-kpi="cadastros_hoje">-</span></small>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3">
            <div class="estat-kpi">
                <span class="estat-kpi-label">Presenças (total)</span>
                <strong class="estat-kpi-valor" data-kpi="presencas_total">-</strong>
                <small class="text-muted">Hoje: <span data-kpi="presencas_hoje">-</span></small>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3">
            <div class="estat-kpi estat-kpi-link" data-estat-filtros="{}" title="Ver todos os cadastros">
                <span class="estat-kpi-label">Visitantes únicos</span>
                <strong class="estat-kpi-valor" data-kpi="visitantes">-</strong>
                <small class="text-muted">Registros: <span data-kpi="registros">-</span></small>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3">
            <div class="estat-kpi estat-kpi-link" data-estat-page="equipe" title="Ver equipe">
                <span class="estat-kpi-label">Equipe</span>
                <strong class="estat-kpi-valor" data-kpi="equipe">-</strong>
                <small class="text-muted">Voluntários cadastrados</small>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3">
            <div class="estat-kpi estat-kpi-amarela estat-kpi-link" data-estat-filtros='{"f-tpulseira":"amarela"}' title="Ver pulseira amarela">
                <span class="estat-kpi-label">Pulseira amarela</span>
                <strong class="estat-kpi-valor" data-kpi="amarela">-</strong>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3">
            <div class="estat-kpi estat-kpi-azul estat-kpi-link" data-estat-filtros='{"f-tpulseira":"azul"}' title="Ver pulseira azul">
                <span class="estat-kpi-label">Pulseira azul</span>
                <strong class="estat-kpi-valor" data-kpi="azul">-</strong>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3">
            <div class="estat-kpi estat-kpi-link" data-estat-filtros='{"f-calouro":"SIM"}' title="Ver primeira vez">
                <span class="estat-kpi-label">Primeira vez</span>
                <strong class="estat-kpi-valor" data-kpi="calouros">-</strong>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3">
            <div class="estat-kpi estat-kpi-link" data-estat-filtros='{"f-palco":"SIM"}' title="Ver interesse no palco">
                <span class="estat-kpi-label">Interesse no palco</span>
                <strong class="estat-kpi-valor" data-kpi="palco">-</strong>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3">
            <div class="estat-kpi estat-kpi-alerta estat-kpi-link" data-estat-filtros='{"f-status":"3"}' title="Ver atenção">
                <span class="estat-kpi-label">Atenção / Atualizar</span>
                <strong class="estat-kpi-valor">
                    <span class="estat-kpi-sublink" data-estat-filtros='{"f-status":"3"}' data-kpi="atencao">-</span>
                    /
                    <span class="estat-kpi-sublink" data-estat-filtros='{"f-status":"2"}' data-kpi="atualizar">-</span>
                </strong>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3">
            <div class="estat-kpi estat-kpi-perigo estat-kpi-link" data-estat-filtros='{"f-status":"4"}' title="Ver bloqueados">
                <span class="estat-kpi-label">Bloqueados</span>
                <strong class="estat-kpi-valor" data-kpi="bloqueado">-</strong>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3">
            <div class="estat-kpi estat-kpi-perigo estat-kpi-link" data-estat-filtros='{"f-duplicados":"1"}' title="Ver cadastros duplicados">
                <span class="estat-kpi-label">Cadastros duplicados</span>
                <strong class="estat-kpi-valor" data-kpi="duplicados">-</strong>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3">
            <div class="estat-kpi estat-kpi-perigo estat-kpi-link" data-estat-scroll="#ultimaspresencas" title="Ver últimas presenças">
                <span class="estat-kpi-label">Pulseiras sem cadastro</span>
                <strong class="estat-kpi-valor" data-kpi="sem_cadastro">-</strong>
                <small class="text-muted">Hoje: <span data-kpi="sem_cadastro_hoje">-</span></small>
            </div>
        </div>
    </div>

    <div class="row g-3 mt-2">
        <div class="col-12 col-lg-6">
            <div class="estat-painel">
                <div class="estat-painel-titulo">
                    <h2 class="h6 mb-0">Cadastros por dia</h2>
                    <button type="button" class="btn btn-link btn-sm p-0 estat-btn-recarregar" data-acao="cadastrosDiarios" data-alvo="#cadastrosDiarios">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                </div>
                <div class="row g-2" id="cadastrosDiarios"></div>
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="estat-painel">
                <div class="estat-painel-titulo">
                    <h2 class="h6 mb-0">Presenças por dia</h2>
                    <button type="button" class="btn btn-link btn-sm p-0 estat-btn-recarregar" data-acao="visitasDiarias" data-alvo="#visitasDiarias">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                </div>
                <div class="row g-2" id="visitasDiarias"></div>
            </div>
        </div>
    </div>

    <div class="row g-3 mt-1">
        <div class="col-12 col-lg-6">
            <div class="estat-painel">
                <div class="estat-painel-titulo">
                    <h2 class="h6 mb-0">Últimos cadastros</h2>
                    <button type="button" class="btn btn-link btn-sm p-0 estat-btn-recarregar" data-acao="ultimoscadastros" data-alvo="#ultimoscadastros" data-lista="cadastros">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                </div>
                <div class="table-responsive" id="ultimoscadastros"></div>
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="estat-painel">
                <div class="estat-painel-titulo">
                    <h2 class="h6 mb-0">Últimas presenças</h2>
                    <button type="button" class="btn btn-link btn-sm p-0 estat-btn-recarregar" data-acao="ultimaspresencas" data-alvo="#ultimaspresencas" data-lista="presencas">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                </div>
                <div class="table-responsive" id="ultimaspresencas"></div>
            </div>
        </div>
    </div>

    <div class="row g-3 mt-1">
        <div class="col-12">
            <div class="estat-painel">
                <div class="estat-painel-titulo">
                    <div>
                        <h2 class="h6 mb-0">Participantes do palco (hoje)</h2>
                        <p class="text-muted small mb-0">Presentes hoje com interesse no palco. Sorteio destaca 5 linhas em verde.</p>
                    </div>
                    <button type="button" class="btn btn-link btn-sm p-0 estat-btn-recarregar" data-acao="participantespalco" data-alvo="#participantespalco" data-lista="palco">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                </div>
                <div class="table-responsive" id="participantespalco"></div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-12 text-end">
            <a class="btn btn-outline-primary btn-sm" href="<?php echo BASE_URL . '?page=checkin-andamento'; ?>">
                <i class="fas fa-images"></i> Check-in em andamento
            </a>
        </div>
    </div>
</div>

<style>
    .estatisticas-page     .estat-kpi {
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 10px 12px;
        background: #fff;
        height: 100%;
    }

    .estat-kpi-link {
        cursor: pointer;
        transition: box-shadow 0.15s ease, transform 0.15s ease;
    }

    .estat-kpi-link:hover {
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        transform: translateY(-1px);
    }

    .estat-kpi-sublink {
        cursor: pointer;
        text-decoration: underline;
        text-decoration-style: dotted;
    }

    .estat-dia-card.estat-kpi-link {
        cursor: pointer;
    }

    .estat-dia-card.estat-kpi-link:hover {
        background: #f0f7ff;
        border-color: #0d6efd;
    }

    .estat-kpi-label {
        display: block;
        font-size: 0.68rem;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.02em;
        margin-bottom: 2px;
    }

    .estat-kpi-valor {
        display: block;
        font-size: 1.35rem;
        line-height: 1.2;
        margin-bottom: 2px;
    }

    .estat-kpi small {
        font-size: 0.68rem;
    }

    .estat-kpi-amarela {
        border-left: 4px solid #ffc107;
    }

    .estat-kpi-azul {
        border-left: 4px solid #0d6efd;
    }

    .estat-kpi-alerta {
        border-left: 4px solid #ffc107;
    }

    .estat-kpi-perigo {
        border-left: 4px solid #dc3545;
    }

    .estat-painel {
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 12px;
        background: #fff;
        height: 100%;
    }

    .estat-painel-titulo {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 8px;
        margin-bottom: 10px;
    }

    .estat-dia-card {
        border: 1px solid #eee;
        border-radius: 8px;
        padding: 8px 10px;
        text-align: center;
        background: #fafafa;
    }

    .estat-dia-card strong {
        display: block;
        font-size: 1.2rem;
        line-height: 1.1;
    }

    .estat-dia-card span {
        font-size: 0.68rem;
        color: #6c757d;
    }

    .estatisticas-page .table {
        font-size: 0.78rem;
        margin-bottom: 0;
    }

    .estatisticas-page .table th {
        white-space: nowrap;
    }

    .estat-badge-amarela {
        background-color: #ffc107;
        color: #212529;
    }

    .estat-badge-azul {
        background-color: #0d6efd;
        color: #fff;
    }

    .sorteado {
        background-color: #53df68 !important;
    }
</style>

<script>
    const ESTAT_API = '<?php echo $baseApi; ?>';
    const ESTAT_BASE = '<?php echo $baseUrl; ?>';

    function estatAjax(acao, callback) {
        const dados = new FormData();
        dados.append('acao', acao);
        ajaxDados(ESTAT_API, dados, callback);
    }

    function estatStatusLabel(status) {
        switch (parseInt(status, 10)) {
            case 1: return 'OK';
            case 2: return 'Atualizar';
            case 3: return 'Atenção';
            case 4: return 'Bloqueado';
            default: return '-';
        }
    }

    function estatBadgeCor(tpulseira) {
        const tp = (tpulseira || '').toLowerCase();
        if (tp === 'amarela') {
            return 'badge estat-badge-amarela';
        }
        return 'badge estat-badge-azul';
    }

    function estatIrCadastrados(filtros) {
        const params = new URLSearchParams();
        params.set('page', 'cadastrados');
        Object.keys(filtros || {}).forEach(function(chave) {
            if (filtros[chave] !== '' && filtros[chave] != null) {
                params.set(chave, filtros[chave]);
            }
        });
        window.location.href = ESTAT_BASE + '?' + params.toString();
    }

    function estatParseFiltros(el) {
        try {
            return JSON.parse(el.getAttribute('data-estat-filtros') || '{}');
        } catch (e) {
            return {};
        }
    }

    function estatRenderDias(lista, alvo, tipo) {
        const $alvo = $(alvo);
        if (!lista || !lista.length) {
            $alvo.html('<div class="col-12"><p class="text-muted small mb-0">Sem dados.</p></div>');
            return;
        }

        let html = '';
        lista.forEach(function(item) {
            const linkClass = tipo === 'cadastro' ? ' estat-kpi-link' : '';
            const filtrosAttr = tipo === 'cadastro'
                ? ' data-estat-filtros=\'' + JSON.stringify({ 'f-data': item.data }) + '\''
                : '';
            const titleAttr = tipo === 'cadastro' ? ' title="Ver cadastros do dia"' : '';

            html += '<div class="col-4 col-sm-3">';
            html += '  <div class="estat-dia-card' + linkClass + '"' + filtrosAttr + titleAttr + '>';
            html += '    <span>Dia ' + item.dia + '</span>';
            html += '    <strong>' + item.qtd + '</strong>';
            html += '  </div>';
            html += '</div>';
        });
        $alvo.html(html);
    }

    function estatRenderResumo(resumo) {
        Object.keys(resumo).forEach(function(chave) {
            $('[data-kpi="' + chave + '"]').text(resumo[chave]);
        });
    }

    function estatMontaTabelaCadastros(lista) {
        if (!lista || !lista.length) {
            return '<p class="text-muted small mb-0">Sem cadastros recentes.</p>';
        }

        let html = '<table class="table table-sm table-striped align-middle">';
        html += '<thead><tr>';
        html += '<th>Pulseira</th><th>Nome</th><th class="d-none d-md-table-cell">Tel.</th><th class="d-none d-lg-table-cell">Cadastro</th><th></th>';
        html += '</tr></thead><tbody>';

        lista.forEach(function(row) {
            html += '<tr>';
            html += '<td><span class="' + estatBadgeCor(row.tpulseira) + '">' + row.pulseira + '</span></td>';
            html += '<td class="text-truncate" style="max-width:120px">' + (row.fullName || '-') + '</td>';
            html += '<td class="d-none d-md-table-cell">' + (row.telefone || '-') + '</td>';
            html += '<td class="d-none d-lg-table-cell"><small>' + (row.dtCreate || '-') + '</small></td>';
            html += '<td class="text-end text-nowrap">';
            if (row.id != null) {
                html += '<a href="#" class="js-visitante-foto text-muted me-2" data-visitante-id="' + row.id + '" title="Ver foto"><i class="fas fa-camera"></i></a>';
                html += '<a href="' + ESTAT_BASE + '?page=cadastro_editar&id=' + row.id + '" title="Editar"><i class="fas fa-pen"></i></a>';
            }
            html += '</td>';
            html += '</tr>';
        });

        html += '</tbody></table>';
        return html;
    }

    function estatMontaTabelaPresencas(lista) {
        if (!lista || !lista.length) {
            return '<p class="text-muted small mb-0">Sem presenças recentes.</p>';
        }

        let html = '<table class="table table-sm table-striped align-middle">';
        html += '<thead><tr>';
        html += '<th>Pulseira</th><th>Nome</th><th>Horário</th><th>Status</th><th></th>';
        html += '</tr></thead><tbody>';

        lista.forEach(function(row) {
            html += '<tr>';
            html += '<td><span class="' + estatBadgeCor(row.tpulseira) + '">' + row.pulseira + '</span></td>';
            html += '<td class="text-truncate" style="max-width:120px">' + (row.fullName || 'Não cadastrado') + '</td>';
            html += '<td><small>' + (row.dtCreate || '-') + '</small></td>';
            html += '<td><small>' + estatStatusLabel(row.status) + '</small></td>';
            if (row.id == null) {
                html += '<td class="text-end"><a href="' + ESTAT_BASE + '?page=cadastro&pulseira=' + row.pulseira + '" title="Cadastrar"><i class="fas fa-user-plus text-success"></i></a></td>';
            } else {
                html += '<td class="text-end text-nowrap">';
                html += '<a href="#" class="js-visitante-foto text-muted me-2" data-visitante-id="' + row.id + '" title="Ver foto"><i class="fas fa-camera"></i></a>';
                html += '<a href="' + ESTAT_BASE + '?page=cadastro_editar&id=' + row.id + '" title="Editar"><i class="fas fa-pen"></i></a>';
                html += '</td>';
            }
            html += '</tr>';
        });

        html += '</tbody></table>';
        return html;
    }

    function estatMontaTabelaPalco(lista) {
        if (!lista || !lista.length) {
            return '<p class="text-muted small mb-0">Nenhum participante do palco hoje.</p>';
        }

        let html = '<table class="table table-sm table-striped align-middle">';
        html += '<thead><tr>';
        html += '<th>Pulseira</th><th>Nome</th><th class="d-none d-md-table-cell">Sexo</th><th class="d-none d-lg-table-cell">Presença</th><th></th>';
        html += '</tr></thead><tbody>';

        lista.forEach(function(row) {
            html += '<tr>';
            html += '<td><span class="' + estatBadgeCor(row.tpulseira) + '">' + row.pulseira + '</span></td>';
            html += '<td class="text-truncate" style="max-width:140px">' + (row.fullName || '-') + '</td>';
            html += '<td class="d-none d-md-table-cell">' + (row.sexo || '-') + '</td>';
            html += '<td class="d-none d-lg-table-cell"><small>' + (row.dtCreate || '-') + '</small></td>';
            html += '<td class="text-end text-nowrap">';
            if (row.id != null) {
                html += '<a href="#" class="js-visitante-foto text-muted me-2" data-visitante-id="' + row.id + '" title="Ver foto"><i class="fas fa-camera"></i></a>';
                html += '<a href="' + ESTAT_BASE + '?page=cadastro_editar&id=' + row.id + '" title="Editar"><i class="fas fa-pen"></i></a>';
            }
            html += '</td>';
            html += '</tr>';
        });

        html += '</tbody></table>';
        return html;
    }

    function estatSortearPalco(qtd) {
        qtd = qtd || 5;
        const $linhas = $('#participantespalco tbody tr');
        if (!$linhas.length) {
            return;
        }

        $linhas.removeClass('sorteado');
        const total = $linhas.length;
        const sorteados = [];

        while (sorteados.length < Math.min(qtd, total)) {
            const n = Math.floor(Math.random() * total) + 1;
            if (sorteados.indexOf(n) === -1) {
                sorteados.push(n);
            }
        }

        let linha = 1;
        $linhas.each(function() {
            if (sorteados.indexOf(linha) !== -1) {
                $(this).addClass('sorteado');
            }
            linha++;
        });
    }

    function estatCarregarResumo(notificar) {
        estatAjax('resumo', function(ret) {
            if (ret.ret) {
                estatRenderResumo(ret.ret);
                if (notificar) {
                    notificaSucesso(ret.msg);
                }
            } else if (notificar) {
                notificaErro(ret.msg);
            }
        });
    }

    function estatCarregarDias(acao, alvo, tipo, notificar) {
        estatAjax(acao, function(ret) {
            if (ret.ret !== false && ret.ret !== '') {
                estatRenderDias(ret.ret, alvo, tipo);
                if (notificar) {
                    notificaSucesso(ret.msg);
                }
            } else if (notificar) {
                notificaErro(ret.msg);
            }
        });
    }

    function estatCarregarLista(acao, alvo, tipo, notificar) {
        estatAjax(acao, function(ret) {
            if (!ret.ret) {
                if (notificar) {
                    notificaErro(ret.msg);
                }
                return;
            }

            let html = '';
            if (tipo === 'cadastros') {
                html = estatMontaTabelaCadastros(ret.ret);
            } else if (tipo === 'presencas') {
                html = estatMontaTabelaPresencas(ret.ret);
            } else if (tipo === 'palco') {
                html = estatMontaTabelaPalco(ret.ret);
                $(alvo).html(html);
                estatSortearPalco();
                if (notificar) {
                    notificaSucesso(ret.msg);
                }
                return;
            }

            $(alvo).html(html);
            if (notificar) {
                notificaSucesso(ret.msg);
            }
        });
    }

    function estatCarregarTudo(notificar) {
        estatCarregarResumo(notificar);
        estatCarregarDias('cadastrosDiarios', '#cadastrosDiarios', 'cadastro', false);
        estatCarregarDias('visitasDiarias', '#visitasDiarias', 'presenca', false);
        estatCarregarLista('ultimoscadastros', '#ultimoscadastros', 'cadastros', false);
        estatCarregarLista('ultimaspresencas', '#ultimaspresencas', 'presencas', false);
        estatCarregarLista('participantespalco', '#participantespalco', 'palco', notificar);
    }

    function estatIniciarPagina() {
        estatCarregarTudo(false);

        $('#btn-atualizar-tudo').on('click', function() {
            estatCarregarTudo(true);
        });

        $('.estat-btn-recarregar').on('click', function() {
            const $btn = $(this);
            const acao = $btn.data('acao');
            const alvo = $btn.data('alvo');
            const lista = $btn.data('lista');

            if (acao === 'cadastrosDiarios') {
                estatCarregarDias(acao, alvo, 'cadastro', true);
            } else if (acao === 'visitasDiarias') {
                estatCarregarDias(acao, alvo, 'presenca', true);
            } else {
                estatCarregarLista(acao, alvo, lista, true);
            }
        });

        $(document).on('click', '.estat-kpi-link[data-estat-filtros]', function(e) {
            if ($(e.target).closest('.estat-kpi-sublink, .estat-btn-recarregar').length) {
                return;
            }
            estatIrCadastrados(estatParseFiltros(this));
        });

        $(document).on('click', '.estat-kpi-sublink[data-estat-filtros]', function(e) {
            e.preventDefault();
            e.stopPropagation();
            estatIrCadastrados(estatParseFiltros(this));
        });

        $(document).on('click', '.estat-kpi-link[data-estat-page]', function() {
            const page = $(this).data('estat-page');
            if (page) {
                window.location.href = ESTAT_BASE + '?page=' + page;
            }
        });

        $(document).on('click', '.estat-kpi-link[data-estat-scroll]', function() {
            const alvo = $(this).data('estat-scroll');
            const $alvo = $(alvo);
            if ($alvo.length) {
                $('html, body').animate({
                    scrollTop: $alvo.offset().top - 80
                }, 300);
            }
        });
    }

    (function estatAguardarJquery() {
        if (typeof window.jQuery === 'undefined') {
            window.setTimeout(estatAguardarJquery, 30);
            return;
        }
        window.jQuery(estatIniciarPagina);
    })();
</script>
