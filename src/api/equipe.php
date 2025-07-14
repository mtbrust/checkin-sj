<?php

// Mensagens padrão de retorno.
$ret = '';
$msg = 'Execução não retornou resultados.';
$html = '';
$post = $_POST;
$get = $_GET;

$fullName = '';
$telefone = '';
$cpf = '';

if ($_POST) {
    $ret = true;
    $msg = 'Tudo certo';

    if (isset($_POST['f-cpf'])) {
        $cpf = $_POST['f-cpf'] = str_replace(['.', '-', '(', ')', ' '], [''], $_POST['f-cpf']);
    }

    if (isset($_POST['f-telefone'])) {
        $telefon = $_POST['f-telefone'] = str_replace(['.', '-', '(', ')', ' '], [''], $_POST['f-telefone']);
    }

    if (isset($_POST['f-fullName'])) {
        $fullName = $_POST['f-fullName'] = mb_strtoupper($_POST['f-fullName'], "UTF-8");
    }

    $dados = json_encode($_POST, true);
}

$BdLogins = new BdLogins();

// Busco algum login com esse cpf.
$login = $BdLogins->selectByCpf($cpf);

// Caso não tenha o cpf cadastrado, realiza o cadastro.
if (!$login) {
    // Monta os campos de login para inserir.
    $fields = [
        'fullName' => $fullName,
        'telefone' => $telefone,
        'cpf'      => $cpf,
        'idStatus' => 1,
        'senha'    => '123456',
    ];
    // Insere os login.
    unset($login);
    $login['id'] = $BdLogins->insert($fields);
}

$user = $BdLogins->selectById($login['id']);

// Crio a sessão com o usuário.
Seguranca::setSession($user);

$resultado = [
    'ret' => $ret,
    'msg' => $msg,
    'dados' => $user,
    'post' => $post,
    'get' => $get,
];

echo json_encode($resultado);

header('Location: ' . BASE_URL . '?page=home');
