<?php

// Mensagens padrão de retorno.
$ret = '';
$msg = 'Execução não retornou resultados.';
$acao = 'ND';
$dados = [];
$post = $_POST;
$get = $_GET;

if (isset($_GET['acao']) && $_GET['acao'] = 'sair') {
    $_POST['acao'] = 'sair';
}

if (isset($_POST['acao'])) {

    // ação solicitada na config.
    $acao = $_POST['acao'];
    $msg = 'Ação realizada';
    $ret = true;

    switch ($acao) {
        case 'teste':
            $msg = "Teste realizado com sucesso.";
            break;

        case 'login':
            $bdLogins = new BdLogins();
            $user = $bdLogins->selectById($_POST['id']);
            $dados = Seguranca::setSession($user);
            $msg = 'Usuário logado: [' . $dados['id'] . '] ' . $dados['fullName'];
            break;

        case 'sair':
            $dados = Seguranca::getSession();
            $dados = Seguranca::clearSession();
            $msg = 'Usuário deslogado: [' . $dados['id'] . '] ' . $dados['fullName'];
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
