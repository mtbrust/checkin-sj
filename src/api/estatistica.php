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

        case 'qtdpresencaspulseiras':
            $BdPresencas = new BdPresencas();
            $ret = $BdPresencas->qtdpresencaspulseiras();
            $msg = 'OK.';
            break;

        case 'visitasDiarias':
            $BdPresencas = new BdPresencas();
            $visitas = $BdPresencas->visitasDiarias();

            $ret = '';
            foreach ($visitas as $key => $value) {
                $ret .= '<div class=" col-sm-3 col-6 mt-3">';
                $ret .= '    <div class="box_statistica">';
                $ret .= '        <h6>Presenças dia '. $value['dia'] .'</h6>';
                $ret .= '        <span>'. $value['data'] .'</span>';
                $ret .= '        <h1>'. $value['qtd'] .'</h1>';
                $ret .= '    </div>';
                $ret .= '</div>';
            }

            $msg = 'OK.';
            break;

        case 'cadastrosDiarios':
            $bdVisitantes = new BdVisitantes();
            $visitas = $bdVisitantes->cadastrosDiarios();

            $ret = '';
            foreach ($visitas as $key => $value) {
                $ret .= '<div class=" col-sm-3 col-6 mt-3">';
                $ret .= '    <div class="box_statistica">';
                $ret .= '        <h6>Cadastros dia '. $value['dia'] .'</h6>';
                $ret .= '        <span>'. $value['data'] .'</span>';
                $ret .= '        <h1>'. $value['qtd'] .'</h1>';
                $ret .= '    </div>';
                $ret .= '</div>';
            }

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
