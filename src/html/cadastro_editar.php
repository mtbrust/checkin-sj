<?php

Seguranca::check();

$BdVisitantes = new BdVisitantes();
$visitante = $BdVisitantes->selectById($_GET['id']);

?>

<div class="container my-4">

    <div class="row">
        <div class="col-12">
            <h1>Editar Cadastro</h1>
            <h3><?php echo '[' . $visitante['pulseira'] . '] - ' . $visitante['fullName']; ?></h3>
        </div>
    </div>

    <div class="row my-2">
        <?php require_once(BASE_DIR . 'src/html/form_visitante.php'); ?>
    </div>

</div>