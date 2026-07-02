<?php

$bloco_logins_titulo = 'Equipe';
$bloco_logins_subtitulo = 'Clique na sua foto ou no seu nome para entrar. Não é necessário senha.';

?>

<div class="container my-4">
    <?php require_once(BASE_DIR . 'src/html/bloco_logins.php'); ?>

    <div class="row mt-5">
        <div class="col-12">
            <h2 class="h5">Primeiro acesso?</h2>
            <p class="text-muted">Preencha o formulário abaixo para se cadastrar na equipe.</p>
        </div>
    </div>

    <div class="row my-2">
        <?php require_once(BASE_DIR . 'src/html/form_equipe.php'); ?>
    </div>
</div>
