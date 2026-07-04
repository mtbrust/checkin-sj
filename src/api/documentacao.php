<?php

$acao = isset($_GET['acao']) ? $_GET['acao'] : (isset($_POST['acao']) ? $_POST['acao'] : '');

switch ($acao) {
    case 'pdf':
        $slug = Documentacao::slugValido($_GET['doc'] ?? '');
        Documentacao::downloadPdf($slug);
        break;

    default:
        http_response_code(400);
        header('Content-Type: text/plain; charset=utf-8');
        echo 'Ação de documentação inválida.';
        break;
}
