<?php

// Mensagens padrão de retorno.
$ret = '';
$msg = 'Execução não retornou resultados.';
$acao = 'ND';
$dados = [];
$post = $_POST;
$get = $_GET;
$status = '';

if (isset($_POST['acao'])) {

    // ação solicitada na config.
    $acao = $_POST['acao'];
    $msg = 'Ação realizada';
    $ret = true;

    switch ($acao) {
        case 'teste':
            $msg = "Teste realizado com sucesso.";
            break;

        case 'presenca':


            verificaObrigatorio('f-pulseira', 'Pulseira é obrigatório.');
            verificaObrigatorio('f-tpulseira', 'Cor é obrigatório.');

            $msg = 'Presença realizada com sucesso.';

            $BdPresencas = new BdPresencas();

            // Monta os campos de login.
            $dados = [
                'tpulseira' => strtoupper($_POST['f-tpulseira']),
                'pulseira' => $_POST['f-pulseira']
            ];
            // Insere os login.
            $ret = $BdPresencas->insert($dados);

            // verifica o status do visitante.
            $BdVisitantes = new BdVisitantes();
            $status = $BdVisitantes->getStatus($_POST['f-pulseira'], $_POST['f-tpulseira']);

            if (!$ret) {
                $msg = 'Tente novamente.';
            }
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
    'status' => $status,
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