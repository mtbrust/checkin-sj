<?php

$docResumo = 'Etapa inicial de interação com o visitante antes do cadastro no sistema.';

$docSecoes = [
    [
        'titulo' => 'Objetivo',
        'html' => '<p>O pré-cadastro realiza o primeiro contato com o visitante, organiza a fila e reduz o tempo na mesa de cadastro. Orienta o visitante sobre como irá funcionar o evento. Prepara o visitante para o cadastro, solicita que o visitante deixe fácil as informações para o cadastro. Nos demais dias, verifica se o visitante já possui pulseira ou cadastro anterior.</p>',
    ],
    [
        'titulo' => 'Checklist',
        'html' => '<ol>
            <li>Verificar postinhos e correntes de fila.</li>
            <li>Ajustar posição dos postinhos e correntes de fila.</li>
            <li>Verificar fluxo de entrada.</li>
            <li>Não deixar aglomerar visitantes e organizadores na área de cadastro.</li>
        </ol>',
    ],
    [
        'titulo' => 'Responsabilidades',
        'html' => '<ul>
            <li>Recepcionar o visitante com cordialidade.</li>
            <li>Informações sobre como irá funcionar o evento.</li>
            <li>Solicita que o visitante deixe fácil as informações para o cadastro.</li>
            <li>Verificar se já possui pulseira ou cadastro anterior.</li>
            <li>Encaminhar para cadastro ou diretamente para fila deentrada.</li>
            <li>Manter a fila organizada e sinalizar casos especiais (primeira vez, troca de pulseira, bloqueio, preferencial).</li>
        </ul>',
    ],
    [
        'titulo' => 'No sistema',
        'html' => '<p>Caso o visitante já tenha sido cadastrado, pesquise o número da pulseira que ele possui. É necessário cadastrar nova pulseira.</p>
        <div class="doc-dica"><strong>Dica:</strong> Sempre questionar se o visitante já possui pulseira ou cadastro desse evento.</div>
        <div class="doc-dica"><strong>Dica:</strong> Sempre verificar com o coordenador sobre possíveis alterações na orientação.</div>',
    ],
];

require __DIR__ . '/_layout.php';
