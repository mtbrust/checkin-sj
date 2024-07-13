<?php

// Página
$page = (isset($_GET["page"])?$_GET["page"]:"home");

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

    <script src="src/js/bootstrap.bundle.min.js"></script>
</body>
</html>