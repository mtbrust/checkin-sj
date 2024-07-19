<?php

// Mensagens padrão de retorno.
$ret = '';
$msg = 'Execução não retornou resultados.';
$html = '';
$post = $_POST;
$get = $_GET;


verificaObrigatorio('f-fullName', 'Nome é obrigatório.');
verificaObrigatorio('f-pulseira', 'Pulseira é obrigatório.');
verificaObrigatorio('f-tpulseira', 'Cor de Pulseira é obrigatório.');

// Verifico se é para editar um cadastro.
$editar = false;
if (isset($_POST['id']) && $_POST['id'] != 0) {
    $editar = true;
}


$BdVisitantes = new BdVisitantes();

// Monta os campos de login.
$fields = [
    'tpulseira' => strtoupper($_POST['f-tpulseira']),
    'pulseira' => $_POST['f-pulseira'],
    'fullName' => strtoupper($_POST['f-fullName']),
    'telefone' => isset($_POST['f-telefone'])?strtoupper($_POST['f-telefone']):'',
    'sexo' => isset($_POST['f-sexo'])?strtoupper($_POST['f-sexo']):'',
    'religiao' => isset($_POST['f-religiao'])?strtoupper($_POST['f-religiao']):'',
    'email' => isset($_POST['f-email'])?strtoupper($_POST['f-email']):'',
    'cidade' => isset($_POST['f-cidade'])?strtoupper($_POST['f-cidade']):'',
    'bairro' => isset($_POST['f-bairro'])?strtoupper($_POST['f-bairro']):'',
    'endereco' => isset($_POST['f-endereco'])?strtoupper($_POST['f-endereco']):'',

    'whatsapp' => isset($_POST['f-whatsapp'])?strtoupper($_POST['f-whatsapp']):'',
    'info' => isset($_POST['f-info'])?strtoupper($_POST['f-info']):'',
    'fe' => isset($_POST['f-fe'])?strtoupper($_POST['f-fe']):'',
    'contato' => isset($_POST['f-contato'])?strtoupper($_POST['f-contato']):'',
    'palco' => isset($_POST['f-palco'])?strtoupper($_POST['f-palco']):'',
    'calouro' => isset($_POST['f-calouro'])?strtoupper($_POST['f-calouro']):'',

    'nascimento' => '',
    'idStatus'  => 1,
    'status'  => isset($_POST['f-status'])?strtoupper($_POST['f-status']):'1', // Cadastro
];

if (isset($_POST['f-nascimento-ano']) && isset($_POST['f-nascimento-mes']) && isset($_POST['f-nascimento-dia'])) {
    $fields['nascimento'] = $_POST['f-nascimento-ano'] . '-' . $_POST['f-nascimento-mes'] . '-' . $_POST['f-nascimento-dia'];
}

if ($editar) {
    $id = $BdVisitantes->update($_POST['id'], $fields);
} else {
    // Insere os login.
    $id = $BdVisitantes->insert($fields);
}

if ($id) {
    $msg = 'Ação realizada com sucesso.';
}

$resultado = [
    'ret' => $id,
    'msg' => $msg,
    'dados' => $fields,
    'post' => $post,
    'get' => $get,
];

echo json_encode($resultado);


function verificaObrigatorio($campo, $msg) {
    if (!isset($_POST[$campo]) || empty($_POST[$campo])) {
        $resultado = [
            'ret' => false,
            'msg' => $msg
        ];
        echo json_encode($resultado);
        exit;
    }
}