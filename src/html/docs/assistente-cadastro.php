<?php

$docResumo = 'Faz toda a interação com o visitante durante o cadastro.';

$docSecoes = [
    [
        'titulo' => 'Função',
        'html' => '<p>Inicia a interação com o visitante enquanto o cadastrador está preenchendo os dados no sistema. O assistente vai conversando e perguntando enquanto o cadastrador está preenchendo os dados no sistema.</p>',
    ],
    [
        'titulo' => 'Checklist',
        'html' => '<ol>
            <li>Verificar pulseiras.</li>
            <li>Manter várias pulseiras em mão para atender visitantes.</li>
            <li>Verificar com coordenador os campos obrigatórios e velocidade do cadastro.</li>
            <li>Fixar pulseira no visitante.</li>
            <li>Combinar sequência das perguntas com o cadastrador.</li>
        </ol>',
    ],
    [
        'titulo' => 'Durante o cadastro',
        'html' => '<ul>
            <li>A cada pergunta, repita a resposta do visitante para confirmação.</li>
            <li>Verifique se o cadastrador está acompanhando o desenvolvimento do cadastro.</li>
        </ul>',
    ],
    [
        'titulo' => 'Após cadastro',
        'html' => '<ul>
            <li>Oriente o visitante a seguir para pré-entrada. Em caso de erro do sistema, anote pulseira + nome e avise o coordenador.</li>
            <li>Informar ao assistente de pre-cadastro que está livre para atender outro visitante.</li>
        </ul>
        <div class="doc-dica"><strong>Dica:</strong> Combine a sequência com o cadastrador para melhorar a velocidade do cadastro.</div>',
    ],
];

require __DIR__ . '/_layout.php';
