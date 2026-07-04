<?php

$docResumo = 'Liderança de área (cadastro, entrada ou pré-evento) e resolução de exceções.';

$docSecoes = [
    [
        'titulo' => 'Papel',
        'html' => '<p>Coordena voluntários, resolve conflitos de pulseira, valida cadastros duplicados e comunica-se com o organizador. Define e faz o repasse de informações e orientações para os assistentes de coordenaçãoe para os voluntários. Toma decisões de exceções (entrada sem cadastro temporário, entrada, saída, cadastro de pulseria ou não, etc.).</p>',
    ],
    [
        'titulo' => 'Ferramentas',
        'html' => '<ul>
            <li><strong>Pesquisa</strong> — localizar visitante por nome, pulseira ou telefone.</li>
            <li><strong>Editar cadastro</strong> — corrigir dados ou alterar status (OK, Atualizar, Atenção, Bloqueado).</li>
            <li><strong>Estatísticas</strong>.</li>
        </ul>',
    ],
    [
        'titulo' => 'Status do visitante',
        'html' => '<ul>
            <li><strong>OK</strong> — fluxo normal.</li>
            <li><strong>Atualizar</strong> — dados incompletos; priorizar revisão.</li>
            <li><strong>Atenção</strong> — situação especial; tratar antes da entrada.</li>
            <li><strong>Bloqueado</strong> — não registrar presença; acionar organizador.</li>
        </ul>',
    ],
    [
        'titulo' => 'Escalonamento',
        'html' => '<p>Problemas técnicos (servidor, foto, offline): anotar pulseira + horário e acionar <strong>Mestre supremo</strong>.</p>',
    ],
];

require __DIR__ . '/_layout.php';
