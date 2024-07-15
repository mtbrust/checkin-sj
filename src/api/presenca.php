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

        case 'presenca':

            $msg = 'Presença realizada com sucesso.';

            $BdPresencas = new BdPresencas();

            // Monta os campos de login.
            $dados = [
                'tpulseira' => strtoupper($_POST['f-tpulseira']),
                'pulseira' => $_POST['f-pulseira']
            ];
            // Insere os login.
            $ret = $BdPresencas->insert($dados);

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
];

echo json_encode($resultado);
