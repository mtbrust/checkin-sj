<?php

// Verifica se usuário está logado.
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

    <?php require_once(BASE_DIR . 'src/html/form_visitante.php'); ?>

</div>