<?php

// Mensagens padrão de retorno.
$ret = '';
$msg = 'Execução não retornou resultados.';
$html = '';
$post = $_POST;
$get = $_GET;

if ($_POST) {
    $ret = true;
    $msg = 'Tudo certo';
    $dados = json_encode($_POST);
}


$BdLogins = new BdLogins();

// Monta os campos de login.
$fields = [
    'fullName' => strtoupper($_POST['f-fullName']),
    'idStatus'  => 1,
    'senha'    => '123456',
];
// Insere os login.
$id = $BdLogins->insert($fields);

$dados = $BdLogins->selectById($id);

$resultado = [
    'ret' => $ret,
    'msg' => $msg,
    'dados' => $dados,
    'post' => $post,
    'get' => $get,
];

echo json_encode($resultado);

header('Location: ' . BASE_URL . '?page=equipe');