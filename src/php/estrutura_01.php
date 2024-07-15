<?php

// Página
$page = (isset($_GET["page"])?$_GET["page"]:"");

// Página
$api = (isset($_GET["api"])?$_GET["api"]:"");
     
// Trás conteúdo da api.
if ($api) {
    header('Content-Type: application/json; charset=utf-8');
    require_once(BASE_DIR . 'src/api/' . $api . '.php');
    exit;
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

    <link href="src/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="src/css/foto3.css">
    <link rel="stylesheet" href="src/css/sweetalert2.min.css">
</head>
<body>
    <?php

        // Trás cabeçalho da página.
        require_once(BASE_DIR . 'src/html/cabecalho.php');

        // Trás conteúdo da página.
        if ($page) {
            require_once(BASE_DIR . 'src/html/' . $page . '.php');
        }

        // Trás rodapé da página.
        require_once(BASE_DIR . 'src/html/rodape.php');

    ?>

    <script src="src/js/jquery.min.js"></script>
    <script src="src/js/jquery.mask.min.js"></script>
    <script src="src/js/default-min.js"></script>
    <script src="src/js/mask-min.js"></script>
    <script src="src/js/bootstrap.bundle.min.js"></script>
    <!-- <script src="src/js/script_cam.js"></script> -->
    <script src="src/js/fontawesome.js"></script>
    <script src="src/js/html2canvas.min.js"></script>
    <script src="src/js/sweetalert2.min.js"></script>
</body>
</html>