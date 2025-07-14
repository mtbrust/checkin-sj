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
    'tpulseira' => mb_strtoupper($_POST['f-tpulseira'], "UTF-8"),
    'pulseira' => $_POST['f-pulseira'],
    // 'fullName' => mb_strtoupper($_POST['f-fullName']),
    'fullName' => mb_strtoupper($_POST['f-fullName'], "UTF-8"),
    'telefone' => isset($_POST['f-telefone']) ? mb_strtoupper($_POST['f-telefone'], "UTF-8") : '',
    'sexo' => isset($_POST['f-sexo']) ? mb_strtoupper($_POST['f-sexo'], "UTF-8") : '',
    'religiao' => isset($_POST['f-religiao']) ? mb_strtoupper($_POST['f-religiao'], "UTF-8") : '',
    'email' => isset($_POST['f-email']) ? mb_strtoupper($_POST['f-email'], "UTF-8") : '',
    'cidade' => isset($_POST['f-cidade']) ? mb_strtoupper($_POST['f-cidade'], "UTF-8") : '',
    'bairro' => isset($_POST['f-bairro']) ? mb_strtoupper($_POST['f-bairro'], "UTF-8") : '',
    'endereco' => isset($_POST['f-endereco']) ? mb_strtoupper($_POST['f-endereco'], "UTF-8") : '',

    'whatsapp' => isset($_POST['f-whatsapp']) ? mb_strtoupper($_POST['f-whatsapp'], "UTF-8") : '',
    'info' => isset($_POST['f-info']) ? mb_strtoupper($_POST['f-info'], "UTF-8") : '',
    'fe' => isset($_POST['f-fe']) ? mb_strtoupper($_POST['f-fe'], "UTF-8") : '',
    'contato' => isset($_POST['f-contato']) ? mb_strtoupper($_POST['f-contato'], "UTF-8") : '',
    'palco' => isset($_POST['f-palco']) ? mb_strtoupper($_POST['f-palco'], "UTF-8") : '',
    'calouro' => isset($_POST['f-calouro']) ? mb_strtoupper($_POST['f-calouro'], "UTF-8") : '',

    'nascimento' => '',
    'idStatus'  => 1,
    'status'  => isset($_POST['f-status']) ? mb_strtoupper($_POST['f-status'], "UTF-8") : '1', // Cadastro
];

if (isset($_POST['f-nascimento-ano']) && isset($_POST['f-nascimento-mes']) && isset($_POST['f-nascimento-dia'])) {
    $fields['nascimento'] = $_POST['f-nascimento-ano'] . '-' . $_POST['f-nascimento-mes'] . '-' . $_POST['f-nascimento-dia'];
}

// Verifica se foi enviada nova foto de perfil.
if (isset($_POST['f-fotoPerfil']) && $_POST['f-fotoPerfil']) {
    $fields['foto'] = $_POST['f-fotoPerfil'];
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


function verificaObrigatorio($campo, $msg)
{
    if (!isset($_POST[$campo]) || empty($_POST[$campo])) {
        $resultado = [
            'ret' => false,
            'msg' => $msg
        ];
        echo json_encode($resultado);
        exit;
    }
}
