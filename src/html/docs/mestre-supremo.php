<?php

$docResumo = 'Responsável técnico no evento: montagem da infraestrutura local, rede Wi‑Fi, acompanhamento das estatísticas, acesso ao banco e ao código para correções emergenciais.';

$docSecoes = [
    [
        'titulo' => 'Papel do Mestre supremo',
        'html' => '<p>Você garante que o sistema Check-In SJ funcione do primeiro ao último dia do evento. Não precisa estar em cada mesa de cadastro o tempo todo, mas deve:</p>
        <ul>
            <li>Montar e testar servidor, rede e banco <strong>antes</strong> da abertura.</li>
            <li>Manter um notebook reservado para estatísticas e monitoramento.</li>
            <li>Atender chamados de voluntários (foto, offline, erro de conexão).</li>
            <li>Fazer backup diário do banco e saber restaurar se necessário.</li>
            <li>Corrigir bugs pontuais no código ou orientar workaround até o fim do evento.</li>
        </ul>
        <p>No sistema, use perfil admin (CPF em <code>Seguranca::getCpfsAdmins()</code>): <strong>Estatísticas</strong>, <strong>Check-in em andamento</strong>, <strong>Configurações</strong> e relatórios PDF/CSV.</p>',
    ],
    [
        'titulo' => 'Arquitetura recomendada no evento',
        'html' => '<p>Modelo simples e robusto para uso em igreja/auditório:</p>
        <table class="table table-sm table-bordered align-middle">
            <thead><tr><th>Equipamento</th><th>Função</th></tr></thead>
            <tbody>
                <tr><td><strong>Servidor</strong> (PC fixo ou notebook dedicado)</td><td>Apache + PHP + MySQL com o projeto <code>checkin-sj</code>. IP fixo na rede local (ex.: <code>192.168.0.12</code>).</td></tr>
                <tr><td><strong>Notebook de acompanhamento</strong></td><td>Só para admin: estatísticas, check-in em andamento, pesquisa, relatórios. Conectado na mesma Wi‑Fi ou cabo.</td></tr>
                <tr><td><strong>Roteador Wi‑Fi</strong></td><td>Rede exclusiva do evento para celulares/tablets dos voluntários (cadastro e presença).</td></tr>
                <tr><td><strong>Voluntários</strong></td><td>Celular ou tablet com navegador (Chrome/Safari). Acesso via <code>https://IP-DO-SERVIDOR/</code> ou URL curta anotada na mesa.</td></tr>
            </tbody>
        </table>
        <div class="doc-dica"><strong>Dica:</strong> evite usar a internet do prédio como única rede — instabilidade ou firewall externo pode derrubar o evento. Prefira roteador próprio ligado só ao servidor e aos aparelhos da equipe.</div>',
    ],
    [
        'titulo' => 'Montagem do servidor (antes do evento)',
        'html' => '<h4 class="h6 mt-2">Software</h4>
        <ul>
            <li><strong>Windows:</strong> XAMPP 8.x (Apache + MySQL/MariaDB + PHP 8.x) ou stack equivalente.</li>
            <li><strong>Linux:</strong> Apache, PHP 8.x, MariaDB — pasta do projeto em <code>/var/www/...</code> ou similar.</li>
            <li>Na pasta do projeto: <code>composer install</code> (dependência <strong>mpdf/mpdf</strong> para PDF).</li>
        </ul>
        <h4 class="h6 mt-3">Código e configuração</h4>
        <ol>
            <li>Copiar/clonar o repositório para o servidor (ex.: <code>C:\\xampp\\htdocs\\checkin-sj</code> ou <code>/www/wwwroot/checkin-js</code>).</li>
            <li><code>cp config-default.php config.php</code> — ajustar <code>BASE_BDS</code> (host, usuário, senha, banco <code>desv_sj</code>, prefixo <code>sj_</code>).</li>
            <li>Criar banco: <code>CREATE DATABASE desv_sj CHARACTER SET utf8 COLLATE utf8_general_ci;</code></li>
            <li>Rodar criação de tabelas (<code>App::init(); App::createTables();</code>) se for instalação nova.</li>
            <li>Testar no navegador do próprio servidor: cadastro, presença, login equipe.</li>
        </ol>
        <h4 class="h6 mt-3">Permissões de pasta (Linux/servidor web)</h4>
        <ul>
            <li><code>src/midia/visitantes/</code> — fotos dos visitantes (gravável pelo PHP).</li>
            <li><code>src/midia/users/</code> — fotos da equipe.</li>
            <li><code>data/tmp/mpdf/</code> — temporários do relatório PDF (fallback: <code>/tmp/checkin-js-mpdf/</code>).</li>
        </ul>
        <pre class="bg-light p-2 rounded small mb-0">chmod -R 775 src/midia data/tmp
chown -R www:www src/midia data/tmp</pre>',
    ],
    [
        'titulo' => 'Rede Wi‑Fi e URL para voluntários',
        'html' => '<h4 class="h6 mt-2">Configurar o roteador</h4>
        <ul>
            <li>SSID claro (ex.: <strong>SJ-CheckIn</strong>) e senha simples repassada só à equipe.</li>
            <li>IP fixo no servidor (reserva DHCP ou IP estático, ex.: <code>192.168.0.12</code>).</li>
            <li>Desative “isolamento de cliente” (AP isolation) se existir — aparelhos precisam alcançar o servidor.</li>
        </ul>
        <h4 class="h6 mt-3">HTTPS no evento</h4>
        <p>Câmera e recursos modernos exigem contexto seguro. Use certificado no Apache (autoassinado ou Let’s Encrypt se houver domínio). Em <strong>Configurações</strong>, ajuste HTTP/HTTPS em <code>data/site-settings.json</code> ou deixe <strong>Automático</strong>.</p>
        <div class="doc-alerta"><strong>Mixed content:</strong> não use URLs <code>http://localhost/...</code> salvas no banco para fotos. Fotos devem ser caminhos relativos (<code>src/midia/users/...</code>) ou URL do IP/HTTPS atual.</div>
        <h4 class="h6 mt-3">O que passar aos voluntários</h4>
        <ul>
            <li>URL de acesso: <code>https://192.168.0.12/</code> (substituir pelo IP real).</li>
            <li>Fluxo: <strong>Equipe</strong> → login CPF → <strong>Cadastro</strong> ou <strong>Presença</strong>.</li>
            <li>Colar QR Code na mesa apontando para a URL (gerador online ou impresso).</li>
        </ul>
        <p>Modo offline: cadastros ficam na fila do aparelho até a rede voltar; oriente usar <strong>Sincronizar agora</strong> quando possível.</p>',
    ],
    [
        'titulo' => 'Notebook de acompanhamento (estatísticas)',
        'html' => '<p>Mantenha um notebook (ou aba fixa no servidor) só para supervisão — não use o mesmo aparelho das mesas de cadastro.</p>
        <h4 class="h6 mt-2">Telas prioritárias</h4>
        <ul>
            <li><strong>Estatísticas</strong> — <code>?page=estatisticas</code>: KPIs, duplicados, sem cadastro, cadastros/presenças por dia.</li>
            <li><strong>Check-in em andamento</strong> — <code>?page=checkin-andamento</code>: feed ao vivo das entradas.</li>
            <li><strong>Pesquisa</strong> — resolver dúvidas de pulseira/nome na hora.</li>
            <li><strong>Configurações</strong> — <code>?page=config</code>: relatório PDF/CSV e protocolo HTTP/HTTPS.</li>
        </ul>
        <h4 class="h6 mt-3">Rotina durante o evento</h4>
        <ol>
            <li>Abrir check-in em andamento em tela cheia no início de cada sessão.</li>
            <li>A cada 1–2 h: conferir “sem cadastro” e duplicados nas estatísticas.</li>
            <li>Fim do dia: exportar CSV ou PDF como backup complementar (além do dump MySQL).</li>
        </ol>',
    ],
    [
        'titulo' => 'Acesso ao banco de dados',
        'html' => '<p>Banco padrão: <strong>desv_sj</strong>, prefixo de tabelas <strong>sj_</strong>.</p>
        <h4 class="h6 mt-2">Tabelas principais</h4>
        <ul>
            <li><code>sj_visitantes</code> — cadastros (pulseira + cor, foto, status).</li>
            <li><code>sj_presencas</code> — check-ins por dia.</li>
            <li><code>sj_logins</code> — equipe/voluntários.</li>
        </ul>
        <h4 class="h6 mt-3">Ferramentas</h4>
        <ul>
            <li><strong>phpMyAdmin</strong> (XAMPP) ou <strong>Adminer</strong> — consultas e correções manuais.</li>
            <li>Linha de comando: <code>mysqldump</code> para backup.</li>
        </ul>
        <h4 class="h6 mt-3">Backup diário (obrigatório)</h4>
        <pre class="bg-light p-2 rounded small">mysqldump -u root -p desv_sj > backup-sj-AAAA-MM-DD.sql</pre>
        <p>Guarde cópia em pendrive ou nuvem. Antes de reset de tabelas ou carga de teste, sempre dump completo.</p>
        <h4 class="h6 mt-3">Consultas úteis em emergência</h4>
        <pre class="bg-light p-2 rounded small">-- Visitante por pulseira e cor
SELECT * FROM sj_visitantes WHERE pulseira = 1234 AND tpulseira = \'AMARELA\';

-- Presenças de hoje
SELECT * FROM sj_presencas WHERE DATE(dtCreate) = CURDATE();</pre>',
    ],
    [
        'titulo' => 'Código-fonte e correção de bugs',
        'html' => '<p>O projeto fica na pasta raiz (onde está <code>index.php</code>). Estrutura útil no evento:</p>
        <ul>
            <li><code>src/html/</code> — páginas (cadastro, presença, estatísticas, documentação).</li>
            <li><code>src/api/</code> — endpoints JSON (cadastro, presença, relatório).</li>
            <li><code>src/php/</code> — regras de negócio (<code>BdVisitantes</code>, <code>BdPresencas</code>, <code>RelatorioGeral</code>, etc.).</li>
            <li><code>config.php</code> — banco e ambiente (não versionar senhas no Git).</li>
        </ul>
        <h4 class="h6 mt-3">Fluxo seguro para ajuste no evento</h4>
        <ol>
            <li>Reproduzir o erro (anotar URL, pulseira, mensagem na tela).</li>
            <li>Backup do banco antes de qualquer alteração em massa.</li>
            <li>Correção mínima no arquivo certo; testar em aba anônima ou outro aparelho.</li>
            <li>Se possível, anotar o que mudou para levar de volta ao repositório Git depois.</li>
        </ol>
        <h4 class="h6 mt-3">Problemas frequentes e onde olhar</h4>
        <table class="table table-sm table-bordered">
            <thead><tr><th>Sintoma</th><th>Causa provável</th><th>Ação</th></tr></thead>
            <tbody>
                <tr><td>Foto visitante não salva</td><td>Pasta sem permissão</td><td><code>chmod 775 src/midia/visitantes</code></td></tr>
                <tr><td>PDF estoura memória</td><td>Limite PHP 128M</td><td><code>memory_limit = 512M</code> no PHP</td></tr>
                <tr><td>Mixed content / foto quebrada</td><td>URL localhost no banco</td><td>Limpar <code>fotoUrl</code> legado; reenviar foto</td></tr>
                <tr><td>Cadastro offline não sobe</td><td>Rede ou erro API</td><td>Fila no aparelho → Forçar cadastro</td></tr>
                <tr><td>mpdf tmp not writable</td><td>Temp sem escrita</td><td><code>data/tmp/mpdf</code> ou <code>/tmp/checkin-js-mpdf</code></td></tr>
            </tbody>
        </table>
        <p>Editor recomendado no notebook: VS Code, Cursor ou similar com acesso SSH/FTP ao servidor se o código não estiver local.</p>',
    ],
    [
        'titulo' => 'Checklist — véspera do evento',
        'html' => '<ul>
            <li>Servidor liga, Apache e MySQL sobem automaticamente (ou script de inicialização).</li>
            <li>URL HTTPS abre nos celulares de teste na Wi‑Fi do evento.</li>
            <li>Login equipe, cadastro com foto, presença e estatísticas testados.</li>
            <li>Relatório PDF gera sem erro.</li>
            <li>Backup inicial do banco feito.</li>
            <li>IP, senha Wi‑Fi e URL impressos para coordenadores.</li>
            <li>Contato técnico (DESV / Mestre supremo) visível para organizador.</li>
        </ul>',
    ],
    [
        'titulo' => 'Checklist — fim do evento',
        'html' => '<ul>
            <li>Exportar Relatório Geral PDF e CSV em Configurações.</li>
            <li>Dump final MySQL (<code>mysqldump</code>).</li>
            <li>Arquivar pasta <code>src/midia/visitantes/</code> se política do evento permitir.</li>
            <li>Documentar incidentes e correções feitas no código para merge no Git.</li>
        </ul>
        <div class="doc-dica"><strong>Suporte DESV:</strong> contato@desv.com.br · desenvolvimento e manutenção do sistema Check-In SJ.</div>',
    ],
];

require __DIR__ . '/_layout.php';
