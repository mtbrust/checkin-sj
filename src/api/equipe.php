<?php

$ret = false;
$msg = 'Execução não retornou resultados.';
$post = $_POST;
$get = $_GET;
$login = null;

$fullName = '';
$telefone = '';
$cpf = '';
$fotoUrl = '';

if ($_POST) {
    if (isset($_POST['f-cpf'])) {
        $cpf = $_POST['f-cpf'] = str_replace(['.', '-', '(', ')', ' '], '', $_POST['f-cpf']);
    }

    if (isset($_POST['f-telefone'])) {
        $telefone = $_POST['f-telefone'] = preg_replace('/\D+/', '', (string) $_POST['f-telefone']);
    }

    if (isset($_POST['f-fullName'])) {
        $fullName = $_POST['f-fullName'] = mb_strtoupper($_POST['f-fullName'], 'UTF-8');
    }

    if (!$cpf) {
        $msg = 'CPF é obrigatório.';
    } else {
        $fotoEnviada = !empty($_FILES['f-foto']['tmp_name']) || !empty($_POST['f-fotoBase64']);

        if ($fotoEnviada) {
            if (!empty($_FILES['f-foto']['tmp_name'])) {
                $fotoUrl = MidiaUsuario::salvarDeUpload($_FILES['f-foto'], $cpf);
            } elseif (!empty($_POST['f-fotoBase64'])) {
                $fotoUrl = MidiaUsuario::salvarDeBase64($_POST['f-fotoBase64'], $cpf);
            }

            if (!$fotoUrl) {
                $msg = 'Não foi possível salvar a foto de perfil.';
            }
        }

        if ($msg === 'Execução não retornou resultados.') {
            $BdLogins = new BdLogins();
            $login = $BdLogins->selectByCpf($cpf);

            if (!$login) {
                if (!$fullName) {
                    $msg = 'Nome completo é obrigatório para novo cadastro.';
                } else {
                    $fields = [
                        'fullName' => $fullName,
                        'telefone' => $telefone,
                        'cpf'      => $cpf,
                        'idStatus' => 1,
                        'senha'    => '123456',
                    ];

                    if ($fotoUrl) {
                        $fields['fotoUrl'] = $fotoUrl;
                        $fields['foto'] = '';
                    }

                    $id = $BdLogins->insert($fields);
                    $login = $BdLogins->selectById($id);
                }
            } else {
                $fields = [];

                if ($fullName) {
                    $fields['fullName'] = $fullName;
                }

                if ($telefone) {
                    $fields['telefone'] = $telefone;
                }

                if ($fotoUrl) {
                    $fields['fotoUrl'] = $fotoUrl;
                    $fields['foto'] = '';
                }

                if ($fields) {
                    $BdLogins->update($login['id'], $fields);
                }

                $login = $BdLogins->selectById($login['id']);
            }

            if ($login) {
                Seguranca::setSession($login);
                $ret = true;
                $msg = 'Usuário logado: [' . $login['id'] . '] ' . $login['fullName'];
            }
        }
    }
}

$resultado = [
    'ret' => $ret,
    'msg' => $msg,
    'dados' => $login,
    'post' => $post,
    'get' => $get,
];

header('Content-Type: application/json; charset=utf-8');
echo json_encode($resultado);
