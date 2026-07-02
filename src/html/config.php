<?php

Seguranca::checkAdmin();

$user = Seguranca::getSession();
$mostrarManutencao = (int) $user['id'] === 1;
$httpsModo = SiteConfig::getForceHttps();
$httpsRotulo = SiteConfig::rotuloForceHttps($httpsModo);
$httpsAtual = SiteConfig::detectHttps() ? 'HTTPS' : 'HTTP';

?>

<div class="container my-4">
    <h1>Config</h1>

    <div class="config-relatorios mt-4">
        <h2 class="h6 mb-2">Relatórios</h2>
        <p class="text-muted small mb-2">Exportação completa com estatísticas e lista de visitantes.</p>
        <div class="config-relatorios-acoes">
            <button type="button" class="btn btn-primary btn-sm" onclick="downloadRelatorio('pdf')">
                <i class="fas fa-file-pdf"></i> Relatório Geral
            </button>
            <button type="button" class="btn btn-success btn-sm" onclick="downloadRelatorio('csv')">
                <i class="fas fa-file-excel"></i> Relatório excel
            </button>
        </div>
    </div>

    <?php if ($mostrarManutencao): ?>

        <p class="text-muted">Ferramentas de manutenção disponíveis apenas para o usuário principal.</p>
        <div class="config-https mt-4">
            <h2 class="h6 mb-2">Protocolo do site</h2>
            <p class="text-muted small mb-2">
                Conexão atual: <strong><?php echo htmlspecialchars($httpsAtual, ENT_QUOTES, 'UTF-8'); ?></strong>.
                Configuração ativa: <strong><?php echo htmlspecialchars($httpsRotulo, ENT_QUOTES, 'UTF-8'); ?></strong>.
            </p>
            <label for="config-force-https" class="form-label small mb-1">Forçar uso de HTTPS em todo o site</label>
            <select id="config-force-https" class="form-select form-select-sm mb-2">
                <option value="auto"<?php echo $httpsModo === 'auto' ? ' selected' : ''; ?>>Automático (detectar)</option>
                <option value="https"<?php echo $httpsModo === 'https' ? ' selected' : ''; ?>>Forçar HTTPS</option>
                <option value="http"<?php echo $httpsModo === 'http' ? ' selected' : ''; ?>>Forçar HTTP</option>
            </select>
            <button type="button" class="btn btn-outline-primary btn-sm" onclick="salvarHttps()">Salvar protocolo</button>
            <p class="text-muted small mt-2 mb-0">Ao forçar HTTPS, o visitante em HTTP é redirecionado. Em ambiente local sem certificado, use Automático ou HTTP.</p>
        </div>
        <div class="config-acoes">
            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="executa('teste')">Teste</button>
            <button type="button" class="btn btn-outline-primary btn-sm" onclick="executa('cargadetestes')">Carga de teste</button>
            <button type="button" class="btn btn-outline-danger btn-sm" onclick="executa('resetarbanco')">Resetar Banco</button>
            <button type="button" class="btn btn-outline-danger btn-sm" onclick="executa('resetarvisitantes')">Resetar Visitantes</button>
            <button type="button" class="btn btn-outline-danger btn-sm" onclick="executa('resetarpresencas')">Resetar Presenças</button>
            <button type="button" class="btn btn-outline-danger btn-sm" onclick="executa('resetarlogins')">Resetar logins</button>
        </div>
    <?php endif; ?>

</div>

<style>
    .config-acoes {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
        margin-top: 1rem;
        max-width: 280px;
    }

    .config-acoes .btn {
        width: 100%;
        text-align: left;
    }

    .config-https {
        max-width: 360px;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 12px;
        background: #fff;
    }

    .config-relatorios {
        max-width: 360px;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 12px;
        background: #fff;
    }

    .config-relatorios-acoes {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .config-relatorios-acoes .btn {
        width: 100%;
        text-align: left;
    }
</style>

<script>
    const configConfirmacoes = {
        teste: {
            title: 'Executar teste?',
            text: 'Verifica se a API de configuração responde corretamente.',
            icon: 'question',
            confirmColor: '#198754'
        },
        cargadetestes: {
            title: 'Inserir carga de teste?',
            text: 'Serão criados 5 usuários, visitantes variados (3 duplicados, incompletos, por status), presenças com datas dos últimos 7 dias e 1 presença sem cadastro.',
            icon: 'question',
            confirmColor: '#0d6efd'
        },
        resetarbanco: {
            title: 'Resetar banco?',
            text: 'Apaga e recria TODAS as tabelas do sistema. Esta ação é irreversível.',
            icon: 'warning',
            confirmColor: '#dc3545'
        },
        resetarvisitantes: {
            title: 'Resetar visitantes?',
            text: 'Apaga todos os cadastros de visitantes. Esta ação é irreversível.',
            icon: 'warning',
            confirmColor: '#dc3545'
        },
        resetarpresencas: {
            title: 'Resetar presenças?',
            text: 'Apaga todos os registros de presença. Esta ação é irreversível.',
            icon: 'warning',
            confirmColor: '#dc3545'
        },
        resetarlogins: {
            title: 'Resetar logins?',
            text: 'Apaga todos os usuários da equipe. Esta ação é irreversível.',
            icon: 'warning',
            confirmColor: '#dc3545'
        }
    };

    function executa(acao) {
        const conf = configConfirmacoes[acao];
        if (!conf) {
            return;
        }

        Swal.fire({
            title: conf.title,
            text: conf.text,
            icon: conf.icon,
            showCancelButton: true,
            confirmButtonText: 'Confirmar',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: conf.confirmColor,
            reverseButtons: true
        }).then(function(result) {
            if (!result.isConfirmed) {
                return;
            }

            const dados = new FormData();
            dados.append('acao', acao);

            ajaxDados('<?php echo BASE_URL . '?api=config'; ?>', dados, function(ret) {
                setTimeout(function() {
                    if (ret.ret) {
                        notificaSucesso(ret.msg);
                    } else {
                        notificaErro(ret.msg);
                    }
                }, 300);
            });
        });
    }

    function downloadRelatorio(tipo) {
        const acao = tipo === 'csv' ? 'csv' : 'pdf';
        window.location.href = '<?php echo BASE_URL; ?>?api=relatorio&acao=' + acao;
    }

    function salvarHttps() {
        const modo = document.getElementById('config-force-https').value;
        const textos = {
            auto: 'O site usará o protocolo detectado em cada acesso (HTTP ou HTTPS).',
            https: 'Todas as páginas serão redirecionadas para HTTPS.',
            http: 'Todas as páginas serão redirecionadas para HTTP.'
        };

        Swal.fire({
            title: 'Salvar protocolo?',
            text: textos[modo] || 'Confirma a alteração?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Salvar',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#0d6efd',
            reverseButtons: true
        }).then(function(result) {
            if (!result.isConfirmed) {
                return;
            }

            const dados = new FormData();
            dados.append('acao', 'salvarforcehttps');
            dados.append('force_https', modo);

            ajaxDados('<?php echo BASE_URL . '?api=config'; ?>', dados, function(ret) {
                setTimeout(function() {
                    if (ret.ret) {
                        notificaSucesso(ret.msg);
                        window.setTimeout(function() {
                            window.location.reload();
                        }, 800);
                    } else {
                        notificaErro(ret.msg);
                    }
                }, 300);
            });
        });
    }
</script>
