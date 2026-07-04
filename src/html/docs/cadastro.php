<?php

$docResumo = 'Registro do visitante no sistema Check-In SJ.';

$docSecoes = [
    [
        'titulo' => 'Função',
        'html' => '<p>Realizar o preenchimento dos dados do visitante no sistema.</p>',
    ],
    [
        'titulo' => 'Acesso',
        'html' => '<p>Menu <strong>Cadastro</strong>. É necessário estar logado na equipe.</p>',
    ],
    [
        'titulo' => 'Checklist',
        'html' => '<ol>
            <li>Verificar bateria do celular.</li>
            <li>Realizar conexão com wifi do sistema.</li>
            <li>Verificar se o sistema está online.</li>
            <li>Combinar sequência das perguntas com o cadastrador.</li>
        </ol>',
    ],
    [
        'titulo' => 'Campos obrigatórios',
        'html' => '<ul>
            <li><strong>Nome completo</strong></li>
            <li><strong>Número da pulseira</strong></li>
            <li><strong>Cor da pulseira</strong> (amarela ou azul)</li>
        </ul>
        <p>A chave única do visitante é <strong>pulseira + cor</strong>.</p>',
    ],
    [
        'titulo' => 'Campos recomendados',
        'html' => '<ul>
            <li>Telefone (com link WhatsApp no relatório)</li>
            <li>Sexo, nascimento, cidade, bairro, igreja</li>
            <li>Foto (câmera — reduzida automaticamente)</li>
            <li>Flags: palco, primeira vez, etc.</li>
        </ul>',
    ],
    [
        'titulo' => 'Modo offline',
        'html' => '<p>Sem internet, o formulário salva rascunho e enfileira o cadastro no aparelho. Use <strong>Sincronizar agora</strong> ou <strong>Forçar cadastro</strong> quando a rede voltar.</p>
        <div class="doc-alerta"><strong>Atenção:</strong> Caso perca a conexão, não atualize a página. Continue preenchendo o formulário.</div>
        <div class="doc-alerta"><strong>Atenção:</strong> após cadastro online bem-sucedido, o formulário é limpo. Rascunhos antigos podem ser recuperados ou descartados pelo banner no topo.</div>',
    ],
    [
        'titulo' => 'Pulseira antiga',
        'html' => '<p>Use o campo <strong>Pulseira Antiga</strong> quando o visitante perdeu a pulseira e recebeu outra. Isso ajuda na rastreabilidade.</p>
        <div class="doc-dica"><strong>Dica:</strong> Antecipe informações do formulário para ganhar tempo.</div>
        <div class="doc-dica"><strong>Dica:</strong> Combine a sequência com o assistente de cadastro.</div>',
    ],
];

require __DIR__ . '/_layout.php';
