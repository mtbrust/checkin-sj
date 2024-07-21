<?php

$user = Seguranca::getSession();
$logar = '';

$qtdCadastros = 0;
$qtdPresencas = 0;

if ($user['id'] == 0) {
    $logar = '<div class="col-12">
            <span class="badge text-bg-warning">Usuário não logado.</span>
            <p>Selecione seu perfil ou cadastre-se! Entre em <a class="link" href="' . BASE_URL . '?page=equipe' . '">Equipe</a>.</p>
        </div>';
}else {
    $logar = '<div class="col-12">Usuário logado: ['.$user['id'].'] ' . $user['fullName'] . '</div>';


    $BdVisitantes = new BdVisitantes();
    $qtdCadastros = $BdVisitantes->qtdCadastrosPorUsuario($user['id']);

    $BdPresencas = new BdPresencas();
    $qtdPresencas = $BdPresencas->qtdPresencasPorUsuario($user['id']);
}

?>

<div class="container my-4">
    <h1>Início</h1>
    <div class="row">
        <?php echo $logar; ?>
    </div>

    <div class="row mt-4">
        <div class="col-6 col-sm-3">
            <div class="box_statistica">
                <h6>Cadastros</h6>
                <h1><?php echo $qtdCadastros; ?></h1>
            </div>
        </div>
        <div class="col-sm-3 col-6">
            <div class="box_statistica">
                <h6>Presenças</h6>
                <h1><?php echo $qtdCadastros; ?></h1>
            </div>
        </div>
    </div>
</div>