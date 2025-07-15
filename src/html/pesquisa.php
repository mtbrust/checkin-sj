<?php

$resultado = false;

if (isset($_GET['f-pesquisa']) && $_GET['f-pesquisa'] != '') {
    $BdVisitantes = new BdVisitantes();
    $resultado = $BdVisitantes->pesquisar($_GET['f-pesquisa']);
}

$user = Seguranca::getSession();
$ids = Seguranca::getCpfsAdmins();

$show = 'd-none';

if (in_array($user['id'], $ids)) {
  $show = '';
}

?>

<div class="container my-4">

    <div class="row">
        <div class="col-12">
            <h1>Pesquisa</h1>
        </div>
    </div>

    <div class="row">
        <?php

        if (!$resultado) {
            echo '<div class=" col-sm-3 col-6 mt-3"><h4>Necessário realizar a pesquisa no menu.</h4></div>';
        } else {
            foreach ($resultado as $key => $value) {
        ?>
                <div class=" col-sm-4 col-12 mt-3">
                    <div class="box_statistica shadow-sm">
                        <a class="<?php echo $show; ?>" href="<?php echo BASE_URL . '?page=cadastro_editar&id=' . $value['id']; ?>">
                            <i class="fas fa-user-edit"></i>
                        </a>
                        <h4 class="text-truncate"><?php echo $value['fullName']; ?></h4>
                        <div class="row">
                            <div class="col-4 pe-1">
                                <img src="<?php echo $value['foto']; ?>" alt="" class="rounded" width="100%">
                            </div>
                            <div class="col-8 ps-1">
                                <small style="font-size: 12px;">
                                    Pulseira: <?php echo $value['pulseira'] . ' [' . $value['tpulseira'] .']'; ?>
                                    <br>Telefone: <?php echo $value['telefone']; ?>
                                    <br>Nascimento: <?php echo $value['nascimento']; ?>
                                    <br><i class="fas fa-user-plus"></i> <?php echo $value['dtCreate']; ?>
                                    <br><i class="fas fa-user-edit"></i> <?php echo $value['dtUpdate']; ?>
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
        <?php

            }
        }

        ?>
    </div>
</div>