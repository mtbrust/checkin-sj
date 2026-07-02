<?php

Seguranca::checkAdmin();

$acao = isset($_GET['acao']) ? $_GET['acao'] : (isset($_POST['acao']) ? $_POST['acao'] : '');

switch ($acao) {
    case 'pdf':
        RelatorioGeral::downloadPdf();
        break;

    case 'csv':
        RelatorioGeral::downloadCsv();
        break;

    default:
        http_response_code(400);
        header('Content-Type: text/plain; charset=utf-8');
        echo 'Ação de relatório inválida.';
        break;
}
