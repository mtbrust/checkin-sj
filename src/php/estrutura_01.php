<?php

// Página
$page = (isset($_GET["page"]) && $_GET["page"] !== '') ? $_GET["page"] : 'home';

// Página
$api = (isset($_GET["api"])?$_GET["api"]:"");
     
// Trás conteúdo da api.
if ($api) {
    if ($api !== 'relatorio' && $api !== 'documentacao') {
        header('Content-Type: application/json; charset=utf-8');
    }
    require_once(BASE_DIR . 'src/api/' . $api . '.php');
    exit;
}

$paginasAdmin = ['estatisticas', 'config', 'checkin-andamento'];
if (in_array($page, $paginasAdmin, true)) {
    Seguranca::checkAdmin();
}

// Título da página html.
$page_name = BASE_NAME . ' - ' . $page;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_name; ?></title>

    <link rel="icon" href="<?php echo BASE_URL; ?>favicon.ico" sizes="any">
    <link rel="icon" type="image/svg+xml" href="<?php echo BASE_URL; ?>favicon.svg">
    <link rel="icon" type="image/png" href="<?php echo BASE_URL; ?>favicon.png">
    <link rel="apple-touch-icon" href="<?php echo BASE_URL; ?>favicon.png">

    <link href="<?php echo BASE_URL; ?>src/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>src/css/foto3.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>src/css/sweetalert2.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>src/css/default-min.css">
</head>
<body>
    <?php

        // Trás cabeçalho da página.
        require_once(BASE_DIR . 'src/html/cabecalho.php');

        // Trás conteúdo da página.
        require_once(BASE_DIR . 'src/html/' . $page . '.php');

        // Trás rodapé da página.
        require_once(BASE_DIR . 'src/html/rodape.php');

    ?>

    <script src="<?php echo BASE_URL; ?>src/js/jquery.min.js"></script>
    <script src="<?php echo BASE_URL; ?>src/js/jquery.mask.min.js"></script>
    <script>window.SITE_BASE_URL = '<?php echo BASE_URL; ?>';</script>
    <script src="<?php echo BASE_URL; ?>src/js/default-min.js"></script>
    <script src="<?php echo BASE_URL; ?>src/js/visitante-popup.js"></script>
    <script src="<?php echo BASE_URL; ?>src/js/mask-min.js"></script>
    <script src="<?php echo BASE_URL; ?>src/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo BASE_URL; ?>src/js/fontawesome.js"></script>
    <script src="<?php echo BASE_URL; ?>src/js/html2canvas.min.js"></script>
    <script src="<?php echo BASE_URL; ?>src/js/sweetalert2.min.js"></script>
</body>
</html>