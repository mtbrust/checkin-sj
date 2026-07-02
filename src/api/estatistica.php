<?php

// Mensagens padrão de retorno.
$ret = '';
$msg = 'Sem resposta.';
$acao = 'ND';
$dados = [];
$post = $_POST;
$get = $_GET;

if (isset($_POST['acao'])) {

    $acao = $_POST['acao'];
    $msg = 'Ação realizada';
    $ret = true;

    switch ($acao) {
        case 'teste':
            $msg = 'Teste realizado com sucesso.';
            break;

        case 'resumo':
            $BdVisitantes = new BdVisitantes();
            $BdPresencas = new BdPresencas();
            $BdLogins = new BdLogins();
            $hoje = date('Y-m-d');
            $detalhes = $BdVisitantes->estatisticasResumo();

            $ret = [
                'cadastros_total' => (int) ($BdVisitantes->qtdCadastrosPulseira() ?: 0),
                'cadastros_hoje' => (int) ($BdVisitantes->qtdCadastrosPulseiraDia($hoje) ?: 0),
                'presencas_total' => (int) ($BdPresencas->qtdpresencaspulseiras() ?: 0),
                'presencas_hoje' => (int) ($BdPresencas->qtdpresencaspulseirasDia($hoje) ?: 0),
                'duplicados' => (int) ($BdVisitantes->qtdCadastrosDuplicados() ?: 0),
                'sem_cadastro' => (int) ($BdPresencas->qtdPulseirasSemCadastro() ?: 0),
                'sem_cadastro_hoje' => (int) ($BdPresencas->qtdPulseirasSemCadastroDia($hoje) ?: 0),
                'equipe' => (int) ($BdLogins->count() ?: 0),
                'registros' => $detalhes['registros'],
                'visitantes' => $detalhes['visitantes'],
                'amarela' => $detalhes['amarela'],
                'azul' => $detalhes['azul'],
                'calouros' => $detalhes['calouros'],
                'palco' => $detalhes['palco'],
                'atualizar' => $detalhes['atualizar'],
                'atencao' => $detalhes['atencao'],
                'bloqueado' => $detalhes['bloqueado'],
            ];
            $msg = 'OK.';
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
            $ret = $BdPresencas->visitasDiarias() ?: [];
            $msg = 'OK.';
            break;

        case 'cadastrosDiarios':
            $bdVisitantes = new BdVisitantes();
            $ret = $bdVisitantes->cadastrosDiarios() ?: [];
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

        case 'checkinandamento':
            $bdPresencas = new BdPresencas();

            if (isset($_POST['inicializar']) && (int) $_POST['inicializar'] === 1) {
                $ret = [
                    'itens' => [],
                    'ultimo_id_imagem' => $bdPresencas->ultimoIdPresenca(),
                ];
                $msg = 'OK.';
                break;
            }

            $ultimoIdPresenca = isset($_POST['ultimo_id_imagem']) ? (int) $_POST['ultimo_id_imagem'] : 0;
            $qtd = isset($_POST['qtd']) ? (int) $_POST['qtd'] : 8;

            $lista = $bdPresencas->presencasAndamentoComFoto($ultimoIdPresenca, $qtd) ?: [];
            $itens = [];
            $novoUltimoIdPresenca = $ultimoIdPresenca;

            foreach ($lista as $row) {
                $idPresenca = (int) $row['idPresenca'];
                if ($idPresenca > $novoUltimoIdPresenca) {
                    $novoUltimoIdPresenca = $idPresenca;
                }

                $fotoUrl = '';
                if (!empty($row['foto'])) {
                    $fotoUrl = MidiaVisitante::urlDoVisitante(['foto' => $row['foto']]);
                }

                $itens[] = [
                    'idPresenca' => $idPresenca,
                    'idVisitante' => isset($row['idVisitante']) ? (int) $row['idVisitante'] : 0,
                    'pulseira' => $row['pulseira'],
                    'tpulseira' => $row['tpulseira'],
                    'fullName' => $row['fullName'] ?? 'Não cadastrado',
                    'status' => isset($row['status']) ? (int) $row['status'] : 0,
                    'dtCreate' => $row['dtCreate'],
                    'fotoUrl' => $fotoUrl,
                ];
            }

            $ret = [
                'itens' => $itens,
                'ultimo_id_imagem' => $novoUltimoIdPresenca,
            ];
            $msg = 'OK.';
            break;

        default:
            $ret = false;
            $msg = 'Ação não encontrada.';
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
