<?php

$bdLogins = new BdLogins();
$users = (array)$bdLogins->selectAll();

$users_html = '';

foreach ($users as $key => $user) {
    $users_html .= '<div class="col-6 col-sm-3">';
    // $users_html .= '<a href="#" onclick="executa(\'login\', ' . $user['id'] . ')">';
    $users_html .= '<div id="user" >';
    $users_html .= '<div id="user_id">' . $user['id'] . '</div>';
    $users_html .= '<div id="user_nome">' . $user['fullName'] . '</div>';
    $users_html .= '</div>';
    // $users_html .= '</a>';
    $users_html .= '</div>';
}

?>


<div class="container my-4">
    <div class="row">
        <div class="col">
            <h1>Equipe</h1>
        </div>
    </div>

    <form action="<?php echo BASE_URL . '?api=equipe'; ?>" class="row" method="post">
        <div class="col-sm-6">
            <div class="mb-3">
                <label for="f-cpf" class="form-label">CPF:</label>
                <input type="text" class="form-control" id="f-cpf" name="f-cpf">
                <span>Caso já tenha um cadastro, coloque apenas o CPF e clique em entrar.</span>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="mb-3">
                <label for="f-fullName" class="form-label">Nome completo:</label>
                <input type="text" class="form-control" id="f-fullName" name="f-fullName">
                <span>Coloque o nome completo caso não tenha cadastro.</span>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="mb-3">
                <label for="f-telefone" class="form-label">Telefone:</label>
                <input type="text" class="form-control" id="f-telefone" name="f-telefone">
                <span>Coloque o número de telefone caso não tenha cadastro.</span>
            </div>
        </div>
        <div class="col-12">
            <div class="mb-3 text-end">
                <button type="submit" class="btn btn-primary mb-3">ENTRAR</button>
            </div>
        </div>
    </form>


    <div class="row">
        <div class="col-12">
            Lista
        </div>

        <?php
            echo $users_html;
        ?>
    </div>
</div>

<style>
    div#user {
        border: 2px solid #cbcbcb;
        border-radius: 10px;
        margin: 5px;
        padding: 5px;
        box-shadow: #000 0 0 10px -5px;
        height: 100px;
    }
</style>

<script>
    function executa(acao, id) {

        // Preparação dos dados.
        dados = new FormData();
        dados.append('acao', acao); // Exemplo de inclusão de valores.
        dados.append('id', id); // Exemplo de inclusão de valores.

        // Chamada AJAX
        ajaxDados('<?php echo BASE_URL . '?api=login'; ?>', dados, function(ret) {
            // Para testes
            console.log(ret);

            // Verifica se teve retorno ok.
            if (ret.ret) {

                // Notificação.
                Swal.fire({
                    icon: "success",
                    title: "Sucesso.",
                    text: ret.msg,
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                });

                // window.location.reload(true);

            } else {

                // Notificação.
                Swal.fire({
                    icon: 'error',
                    title: 'Erro.',
                    text: ret.msg,
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                });
            }
        })
    }
</script>