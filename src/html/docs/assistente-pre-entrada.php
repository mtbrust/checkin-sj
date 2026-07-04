<?php

$docResumo = 'Suporte na ponta da fila de pré-entrada e organização do fluxo.';

$docSecoes = [
    [
        'titulo' => 'Função',
        'html' => '<p>Mantém a ordem da fila, separa visitantes já cadastrados dos que precisam voltar ao cadastro e sinaliza prioridades definidas pelo coordenador. Orienta como será o fluxo de entrada. Monta as filas de entrada 10 min antes do início do evento. Organiza para que o fluxo da fila de pré-entrada seja distribuida nas filas de entrada (check-in).</p>',
    ],
    [
        'titulo' => 'Sinais visuais',
        'html' => '<ul>
            <li>Pulseira amarela e azul — cores diferentes, números podem se repetir entre cores.</li>
            <li>Visitante sem pulseira — retorno ao pré-cadastro ou cadastro.</li>
            <li>Orientar o visitante a deixar sempre visível a pulseira.</li>
        </ul>',
    ],
    [
        'titulo' => '',
        'html' => '<div class="doc-dica"><strong>Dica:</strong> Sempre verificar com o coordenador sobre possíveis alterações na orientação.</div>',
    ],
];

require __DIR__ . '/_layout.php';
