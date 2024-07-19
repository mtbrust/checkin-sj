<?php

$resultado = false;

if (isset($_GET['f-pesquisa']) && $_GET['f-pesquisa'] != '') {
    $BdVisitantes = new BdVisitantes();
    $resultado = $BdVisitantes->pesquisar($_GET['f-pesquisa']);
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
                <div class=" col-sm-3 col-6 mt-3">
                    <div class="box_statistica shadow-sm">
                        <a href="<?php echo BASE_URL . '?page=cadastro_editar&id=' . $value['id']; ?>">
                            <i class="fas fa-user-edit"></i>
                        </a>
                        <h6 class="text-truncate"><?php echo $value['fullName']; ?></h6>
                        <h1>-</h1>
                    </div>
                </div>
        <?php

            }
        }

        ?>
    </div>
</div>