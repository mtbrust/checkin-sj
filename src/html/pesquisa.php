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
            <p>
                Caso a pesquisa seja um texto, será procurado no Nome, Tipo de Pulseira e Endereço.
                <br>
                Os Tipos de Pulseiras são: branca, vermelha, amarela, azul.
                <br>
                Caso a pesquisa seja um número, será procurado nos campos de pulseira, pulseira antiga e telefone.
            </p>
        </div>
    </div>

    <div class="row">
        <?php

        if (!$resultado) {
            echo '<div class=" col-sm-3 col-6 mt-3"><h4>Necessário realizar a pesquisa no menu.</h4></div>';
        } else {
            foreach ($resultado as $key => $value) {

                $bgStatus = '';
                switch ($value['status']) {
                    case 1:
                        $status = 'OK';
                        break;
                    case 2:
                        $status = 'Atualizar';
                        break;
                    case 3:
                        $status = 'Atenção';
                        break;
                    case 4:
                        $status = 'Bloqueado';
                        $bgStatus = 'bg-danger bg-opacity-25';
                        break;
                }
        ?>
                <div class=" col-sm-4 col-12 mt-3">
                    <div class="box_statistica shadow-sm <?php echo $bgStatus; ?>">
                        <a class="<?php echo $show; ?>" href="<?php echo BASE_URL . '?page=cadastro_editar&id=' . $value['id']; ?>">
                            <i class="fas fa-user-edit"></i>
                        </a>
                        <h4 class="text-truncate">
                            <a class="text-success" href="<?php echo BASE_URL . '?page=cadastro_editar&id=' . $value['id']; ?>">
                                <i class="fas fa-user-edit"></i>
                            </a>
                            <?php echo ' [' . $value['sexo'] . ']' . $value['fullName']; ?>
                        </h4>
                        <div class="row">
                            <div class="col-6 pe-1">
                                <small style="font-size: 12px;">
                                    Pulseira: <?php echo $value['pulseira'] . ' [' . $value['tpulseira'] . ']'; ?>
                                    <br>
                                    Telefone: <?php echo $value['telefone']; ?>
                                    <br>
                                    Nascimento: <?php echo $value['nascimento']; ?>
                                    <br>
                                    <i class="fas fa-user-plus"></i> <?php echo $value['dtCreate']; ?>
                                </small>
                            </div>
                            <div class="col-6 ps-1">
                                <small style="font-size: 12px;">
                                    Pulseira Antiga: <?php echo $value['oldPulseira']; ?>
                                    <br>
                                    Cidade: <?php echo $value['cidade']; ?>
                                    <br>
                                    Bairro: <?php echo $value['bairro']; ?>
                                    <br>
                                    Rua: <?php echo $value['endereco']; ?>
                                    <br>
                                    Status: <?php echo $status; ?>
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