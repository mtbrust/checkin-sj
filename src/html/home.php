<?php

$user = Seguranca::getSession();
$logar = '';
if ($user['id'] == 0) {
    $logar = '<div class="col-12">
            <span class="badge text-bg-warning">Usuário não logado.</span>
            <p>Selecione seu perfil ou cadastre-se! Entre em <a class="link" href="' . BASE_URL . '?page=equipe' . '">Equipe</a>.</p>
        </div>';
}else {
    $logar = '<div class="col-12">Usuário logado: ' . $user['fullName'] . '</div>';
}

?>

<div class="container">
    <h1>Início</h1>
    <div class="row">
        <?php echo $logar; ?>
    </div>
</div>