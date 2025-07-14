<?php

// Mensagens padrão de retorno.
$ret = '';
$msg = 'Sem resposta.';
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

        case 'qtdCadastrosPulseira':
            $BdVisitantes = new BdVisitantes();
            $ret = $BdVisitantes->qtdCadastrosPulseira();
            $msg = 'OK.';
            break;

        case 'qtdCadastrosPulseira22':
            $BdVisitantes = new BdVisitantes();
            $ret = $BdVisitantes->qtdCadastrosPulseiraDia('2025-07-14');
            $msg = 'OK.';
            break;

        case 'qtdCadastrosPulseira23':
            $BdVisitantes = new BdVisitantes();
            $ret = $BdVisitantes->qtdCadastrosPulseiraDia('2025-07-23');
            $msg = 'OK.';
            break;

        case 'qtdCadastrosPulseira24':
            $BdVisitantes = new BdVisitantes();
            $ret = $BdVisitantes->qtdCadastrosPulseiraDia('2025-07-24');
            $msg = 'OK.';
            break;

        case 'qtdCadastrosPulseira25':
            $BdVisitantes = new BdVisitantes();
            $ret = $BdVisitantes->qtdCadastrosPulseiraDia('2025-07-25');
            $msg = 'OK.';
            break;

        case 'qtdCadastrosPulseira26':
            $BdVisitantes = new BdVisitantes();
            $ret = $BdVisitantes->qtdCadastrosPulseiraDia('2025-07-26');
            $msg = 'OK.';
            break;

        case 'qtdCadastrosPulseira27':
            $BdVisitantes = new BdVisitantes();
            $ret = $BdVisitantes->qtdCadastrosPulseiraDia('2025-07-27');
            $msg = 'OK.';
            break;

        case 'qtdpresencaspulseiras':
            $BdPresencas = new BdPresencas();
            $ret = $BdPresencas->qtdpresencaspulseiras();
            $msg = 'OK.';
            break;

        case 'qtdpresencaspulseiras22':
            $BdPresencas = new BdPresencas();
            $ret = $BdPresencas->qtdpresencaspulseirasDia('2025-07-14');
            $msg = 'OK.';
            break;

        case 'qtdpresencaspulseiras23':
            $BdPresencas = new BdPresencas();
            $ret = $BdPresencas->qtdpresencaspulseirasDia('2025-07-23');
            $msg = 'OK.';
            break;

        case 'qtdpresencaspulseiras24':
            $BdPresencas = new BdPresencas();
            $ret = $BdPresencas->qtdpresencaspulseirasDia('2025-07-24');
            $msg = 'OK.';
            break;

        case 'qtdpresencaspulseiras25':
            $BdPresencas = new BdPresencas();
            $ret = $BdPresencas->qtdpresencaspulseirasDia('2025-07-25');
            $msg = 'OK.';
            break;

        case 'qtdpresencaspulseiras26':
            $BdPresencas = new BdPresencas();
            $ret = $BdPresencas->qtdpresencaspulseirasDia('2025-07-26');
            $msg = 'OK.';
            break;

        case 'qtdpresencaspulseiras27':
            $BdPresencas = new BdPresencas();
            $ret = $BdPresencas->qtdpresencaspulseirasDia('2025-07-27');
            $msg = 'OK.';
            break;

        case 'qtdcadastrosduplicados':
            $BdVisitantes = new BdVisitantes();
            $ret = $BdVisitantes->qtdCadastrosDuplicados();
            $msg = 'OK.';
            break;

        case 'ultimoscadastros':
            $BdVisitantes = new BdVisitantes();
            $ret = $BdVisitantes->ultimosCadastros();
            $msg = 'OK.';
            break;

        case 'ultimaspresencas':
            $BdVisitantes = new BdVisitantes();
            $ret = $BdVisitantes->ultimasPresencas();
            $msg = 'OK.';
            break;

        case 'participantespalco':
            $BdVisitantes = new BdVisitantes();
            $ret = $BdVisitantes->participantespalco();
            $msg = 'OK.';
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
