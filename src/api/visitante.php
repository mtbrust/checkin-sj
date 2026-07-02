<?php

Seguranca::check();

$acao = isset($_POST['acao']) ? $_POST['acao'] : 'ND';
$ret = false;
$msg = 'Ação não encontrada.';
$dados = [];

switch ($acao) {
    case 'foto':
        $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
        if ($id <= 0) {
            $msg = 'Visitante inválido.';
            break;
        }

        $bdVisitantes = new BdVisitantes();
        $visitante = $bdVisitantes->selectById($id);

        if (!$visitante) {
            $msg = 'Visitante não encontrado.';
            break;
        }

        $fotoUrl = '';
        if (!empty($visitante['foto'])) {
            $fotoUrl = MidiaVisitante::urlDoVisitante($visitante);
        }

        $ret = true;
        $msg = $fotoUrl ? 'OK.' : 'Visitante sem foto.';
        $dados = [
            'id' => (int) $visitante['id'],
            'fullName' => $visitante['fullName'] ?? '',
            'fotoUrl' => $fotoUrl,
        ];
        break;
}

echo json_encode([
    'ret' => $ret,
    'acao' => $acao,
    'msg' => $msg,
    'dados' => $dados,
    'post' => $_POST,
    'get' => $_GET,
]);
