<?php

Seguranca::checkAdmin();

$user = Seguranca::getSession();

if ((int) $user['id'] !== 1) {
    echo json_encode([
        'ret' => false,
        'acao' => isset($_POST['acao']) ? $_POST['acao'] : 'ND',
        'msg' => 'Ação permitida apenas para o usuário principal.',
        'dados' => [],
        'post' => $_POST,
        'get' => $_GET,
    ]);
    exit;
}

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
            $ret = true;
            $msg = 'Teste realizado com sucesso.';
            break;

        case 'resetarbanco':
            App::dropTables();
            App::createTables();
            $msg = 'Banco resetado.';
            break;

        case 'resetarvisitantes':
            $BdVisitantes = new BdVisitantes();
            $BdVisitantes->dropTable();
            $BdVisitantes = new BdVisitantes();
            $BdVisitantes->createTable();
            $msg = 'Visitantes resetado.';
            break;

        case 'resetarpresencas':
            $BdPresencas = new BdPresencas();
            $BdPresencas->dropTable();
            $BdPresencas = new BdPresencas();
            $BdPresencas->createTable();
            $msg = 'Presenças resetado.';
            break;

        case 'resetarlogins':
            $bdLogins = new BdLogins();
            $bdLogins->dropTable();
            $bdLogins->createTable();
            $msg = 'Logins resetados.';
            break;

        case 'cargadetestes':
            $carga = new CargaTeste();
            $resumo = $carga->executar();
            $dados = $resumo;
            $msg = sprintf(
                'Carga concluída: %d usuários, %d visitantes, %d presenças (%d sem cadastro). Cadastros corrigidos: %d.',
                $resumo['usuarios'],
                $resumo['visitantes'],
                $resumo['presencas'],
                $resumo['presenca_sem_cadastro'],
                $resumo['cadastros_corrigidos']
            );
            break;

        case 'salvarforcehttps':
            $modo = isset($_POST['force_https']) ? $_POST['force_https'] : 'auto';
            if (!SiteConfig::setForceHttps($modo)) {
                $ret = false;
                $msg = 'Não foi possível salvar a configuração de protocolo.';
            } else {
                $dados = [
                    'force_https' => SiteConfig::getForceHttps(),
                ];
                $msg = 'Protocolo atualizado: ' . SiteConfig::rotuloForceHttps() . '.';
            }
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
