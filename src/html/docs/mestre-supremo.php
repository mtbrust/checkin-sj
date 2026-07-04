<?php

$docResumo = 'Responsável técnico no evento: montar servidor e rede, acompanhar estatísticas e resolver problemas do sistema.';

$docSecoes = [
    [
        'titulo' => 'Sua função',
        'html' => '<ul>
            <li>Montar e testar tudo <strong>antes</strong> do evento abrir.</li>
            <li>Manter um notebook só para monitoramento (estatísticas e check-in ao vivo).</li>
            <li>Atender voluntários (foto, offline, erro de conexão).</li>
            <li>Fazer <strong>backup diário</strong> do banco.</li>
        </ul>
        <p>Acesso admin: <strong>Estatísticas</strong>, <strong>Check-in em andamento</strong>, <strong>Configurações</strong> e relatórios PDF/CSV.</p>',
    ],
    [
        'titulo' => 'Montagem no evento',
        'html' => '<ul>
            <li><strong>Servidor</strong> — PC com Apache, PHP 8 e MySQL. Projeto <code>checkin-sj</code>, IP fixo (ex.: <code>192.168.0.12</code>).</li>
            <li><strong>Wi‑Fi próprio</strong> — roteador do evento; celulares dos voluntários acessam <code>https://IP-DO-SERVIDOR/</code>.</li>
            <li><strong>Notebook admin</strong> — mesma rede; telas de estatísticas e pesquisa.</li>
        </ul>
        <div class="doc-dica">Prefira rede própria. Desative isolamento de cliente no roteador. Use HTTPS (câmera exige). Imprima QR Code com a URL para as mesas.</div>',
    ],
    [
        'titulo' => 'Instalação rápida',
        'html' => '<ol>
            <li><code>composer install</code> na pasta do projeto.</li>
            <li><code>cp config-default.php config.php</code> — ajustar banco <code>desv_sj</code>.</li>
            <li>Criar tabelas se for instalação nova (<code>App::createTables()</code>).</li>
            <li>Testar: login equipe, cadastro com foto, presença.</li>
            <li>Pastas graváveis: <code>src/midia/visitantes</code>, <code>src/midia/users</code>, <code>data/tmp/mpdf</code>.</li>
        </ol>',
    ],
    [
        'titulo' => 'Durante o evento',
        'html' => '<ul>
            <li><code>?page=checkin-andamento</code> — entradas ao vivo.</li>
            <li><code>?page=estatisticas</code> — KPIs, duplicados, sem cadastro.</li>
            <li><code>?page=pesquisa</code> — achar visitante por pulseira ou nome.</li>
            <li>Cadastro offline: fila no aparelho → <strong>Sincronizar agora</strong> quando a rede voltar.</li>
        </ul>',
    ],
    [
        'titulo' => 'Banco e código',
        'html' => '<p>Tabelas: <code>sj_visitantes</code>, <code>sj_presencas</code>, <code>sj_logins</code>. Backup:</p>
        <pre class="bg-light p-2 rounded small mb-2">mysqldump -u root -p desv_sj > backup-sj-AAAA-MM-DD.sql</pre>
        <p>Código em <code>src/html/</code> (telas), <code>src/api/</code> (JSON) e <code>src/php/</code> (regras). Antes de alterar em massa: backup do banco.</p>',
    ],
    [
        'titulo' => 'Problemas comuns',
        'html' => '<ul>
            <li><strong>Foto não salva</strong> — permissão em <code>src/midia/visitantes</code>.</li>
            <li><strong>PDF falha</strong> — <code>memory_limit 512M</code> e pasta <code>data/tmp/mpdf</code> gravável.</li>
            <li><strong>Foto quebrada / mixed content</strong> — evitar URL <code>localhost</code> no banco; reenviar foto.</li>
            <li><strong>Offline não sincroniza</strong> — Forçar cadastro na fila do aparelho.</li>
        </ul>',
    ],
    [
        'titulo' => 'Checklist',
        'html' => '<p><strong>Véspera:</strong> servidor e Wi‑Fi ok · HTTPS nos celulares · cadastro, presença e PDF testados · backup inicial · URL e senha Wi‑Fi repassadas.</p>
        <p><strong>Fim do evento:</strong> exportar PDF/CSV · backup final do banco.</p>
        <div class="doc-dica"><strong>Suporte DESV:</strong> contato@desv.com.br</div>',
    ],
];

require __DIR__ . '/_layout.php';
