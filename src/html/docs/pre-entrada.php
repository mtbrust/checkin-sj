<?php

$docResumo = 'Organização da fila de entrada e conferência final antes do visitante entrar no auditório ou área principal.';

$docSecoes = [
    [
        'titulo' => 'Objetivo',
        'html' => '<p>Garantir que o visitante já está cadastrado e com pulseira válida antes da entrada definitiva. Garantir a segurança e o fluxo de entrada.</p>',
    ],
    [
        'titulo' => 'Função',
        'html' => '<p>Organiza a fila de entrada e confere a pulseira do visitante. Verifica se o visitante está cadastrado e com pulseira válida. Verifica se o visitante está bloqueado ou em atenção deve ser encaminhado ao coordenador. Verifica se existe fura fila. Verifica se estão organizados nos limite da calçada. Verifica se existe visitantes prioritários. Orienta caso haja alguma divergência.</p>',
    ],
    [
        'titulo' => 'Checklist',
        'html' => '<ol>
            <li>Verificar postinhos e correntes de fila.</li>
            <li>Ajustar posição dos postinhos e correntes de fila.</li>
            <li>Verificar fluxo de entrada.</li>
            <li>Não deixar aglomerar visitantes e organizadores na área de entrada.</li>
        </ol>',
    ],
    [
        'titulo' => 'Procedimento',
        'html' => '<ol>
            <li>Conferir pulseira (número + cor).</li>
            <li>Confirmar cadastro — use pesquisa se necessário.</li>
            <li>Verificar status: visitante bloqueado ou em atenção deve ser encaminhado ao coordenador.</li>
            <li>Liberar para fila de check-in (entrada).</li>
            <li>Verificar estado físico do visitante.</li>
            <li>Verificar vestimenta do visitante.</li>
            <li>Qualquer suspeita de roubo ou fraude, informar ao coordenador e aos seguranças.</li>
        </ol>',
    ],
    [
        'titulo' => 'Sem cadastro',
        'html' => '<p>Encaminhe imediatamente a fila de cadastro. Não registre presença de pulseira sem cadastro, salvo orientação expressa do coordenador (casos excepcionais).</p>
        <div class="doc-dica"><strong>Dica:</strong> Sempre verificar com o coordenador sobre possíveis alterações na orientação.</div>',
    ],
];

require __DIR__ . '/_layout.php';
