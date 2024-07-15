<?php

// Mensagens padrão de retorno.
$ret = '';
$msg = 'Execução não retornou resultados.';
$html = '';
$post = $_POST;
$get = $_GET;

if (!isset($_POST['f-fullName'])) {
    $resultado = [
        'ret' => false,
        'msg' => $msg,
        'dados' => [],
        'post' => $post,
        'get' => $get,
    ];
    echo json_encode($resultado);
}


$BdVisitantes = new BdVisitantes();

// Monta os campos de login.
$fields = [
    'tpulseira' => strtoupper($_POST['f-tpulseira']),
    'pulseira' => strtoupper($_POST['f-pulseira']),
    'telefone' => strtoupper($_POST['f-telefone']),
    'fullName' => strtoupper($_POST['f-fullName']),
    'sexo' => strtoupper($_POST['f-sexo']),
    'religiao' => strtoupper($_POST['f-religiao']),
    'email' => strtoupper($_POST['f-email']),
    'cidade' => strtoupper($_POST['f-cidade']),
    'bairro' => strtoupper($_POST['f-bairro']),
    'endereco' => strtoupper($_POST['f-endereco']),
    'nascimento' => $_POST['f-nascimento-ano'] . '-' . $_POST['f-nascimento-mes'] . '-' . $_POST['f-nascimento-dia'],
    'idStatus'  => 1,
    'status'  => 1, // Cadastro
];
// Insere os login.
$id = $BdVisitantes->insert($fields);

if ($id) {
    $msg = 'Cadastro realizado com sucesso.';
}

$resultado = [
    'ret' => $id,
    'msg' => $msg,
    'dados' => $fields,
    'post' => $post,
    'get' => $get,
];

echo json_encode($resultado);