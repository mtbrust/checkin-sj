<?php

// Mensagens padrão de retorno.
$ret = '';
$msg = 'Execução não retornou resultados.';
$acao = 'ND';
$dados = [];
$post = $_POST;
$get = $_GET;

if (isset($_POST['acao'])) {

    // ação solicitada na config.
    $acao = $_POST['acao'];
    $msg = 'Ação realizada';
    $ret = true;

    switch ($acao) {
        case 'teste':
            $msg = "Teste realizado com sucesso.";
            break;

        case 'resetarbanco':
            App::dropTables();
            App::createTables();
            $msg = 'Banco resetado.';
            break;

        case 'resetarvisitantes':
            $BdVisitantes = new BdVisitantes();
            $BdVisitantes->dropTable();
            $BdVisitantes = new BdVisitantes();
            $BdVisitantes->createTable();
            $msg = 'Visitantes resetado.';
            break;

        case 'resetarpresencas':
            $BdPresencas = new BdPresencas();
            $BdPresencas->dropTable();
            $BdPresencas = new BdPresencas();
            $BdPresencas->createTable();
            $msg = 'Presenças resetado.';
            break;

        default:
            # code...
            break;
    }
}

$resultado = [
    'ret' => $ret,
    'acao' => $acao,
    'msg' => $msg,
    'dados' => $dados,
    'post' => $post,
    'get' => $get,
];

echo json_encode($resultado);
