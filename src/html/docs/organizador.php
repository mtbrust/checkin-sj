<?php

$docResumo = 'Visão geral do check-in, equipes, metas de cadastro/presença e ferramentas.';

$docSecoes = [
    [
        'titulo' => 'Função',
        'html' => '<p>Realizar a preparação do ambiente de check-in, para que o check-in funcione de forma eficiente e segura. Limpar a área de check-in, verificar a presença dos facilitadores e assistentes de coordenação. Verificar a presença dos voluntários. Verificar a presença dos coordenadores. Verificar a presença dos seguranças.</p>',
    ],
    [
        'titulo' => 'Checklist',
        'html' => '<ol>
            <li>Orientar motoristas sobre a presença de veículos em local proibido.</li>
            <li>Verificar ferramentar de fila (postinhos, correntes, pulseiras, etc).</li>
            <li>Distribuir equipamentos entre os voluntários.</li>
            <li>Ajustar posição das correntes de fila.</li>
            <li>Verificar presença dos facilitadores e assistentes de coordenação.</li>
            <li>Verificar presença dos voluntários.</li>
            <li>Informar status aos coordenadores.</li>
            <li>Limpeza do local.</li>
            <li>Iniciar o checklist novamente.</li>
        </ol>',
    ],
    [
        'titulo' => 'Decisões operacionais',
        'html' => '<ul>
            <li>Abrir mais mesas de cadastro ou check-in conforme fila.</li>
            <li>Definir exceções (entrada sem cadastro temporário).</li>
            <li>Validar bloqueios e status de atenção com coordenadores.</li>
        </ul>',
    ],
];

require __DIR__ . '/_layout.php';
