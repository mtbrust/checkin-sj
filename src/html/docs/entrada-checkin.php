<?php

$docResumo = 'Registro de presença (check-in) por pulseira + cor.';

$docSecoes = [
    [
        'titulo' => 'Acesso',
        'html' => '<p>Menu <strong>Presença</strong>. Requer login na equipe.</p>',
    ],
    [
        'titulo' => 'Como registrar',
        'html' => '<ol>
            <li>Selecione a <strong>cor da pulseira</strong> (amarela ou azul).</li>
            <li>Digite o <strong>número da pulseira</strong>.</li>
            <li>Toque em <strong>Presença</strong>.</li>
        </ol>
        <p>O retorno mostra status: cadastrado, bloqueado, sem cadastro, etc., com dados resumidos do visitante.</p>',
    ],
    [
        'titulo' => 'Boas práticas',
        'html' => '<ul>
            <li>Confirme a cor antes de confirmar — número sozinho não identifica o visitante.</li>
            <li>Em caso de bloqueio ou divergência, chame o facilitador para acompanhar o visitante ao assistente de coordenação; não discuta com o visitante na fila.</li>
            <li>Mantenha o foco no campo pulseira para agilizar (layout mobile otimizado).</li>
        </ul>
        <div class="doc-dica"><strong>Dica:</strong> após cada registro, o campo pulseira é limpo para o próximo visitante.</div>',
    ],
];

require __DIR__ . '/_layout.php';
