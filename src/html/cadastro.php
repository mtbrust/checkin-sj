<?php

Seguranca::check();

$user = Seguranca::getSession();

$visitante = [];
if (isset($_GET['pulseira'])) {
    $visitante['pulseira'] = $_GET['pulseira'];
}

?>

<div class="container my-4">
    <div class="row">
        <div class="col-12">
            <h1>Cadastro</h1>
        </div>
    </div>

    <?php require_once(BASE_DIR . 'src/html/form_visitante.php'); ?>
</div>