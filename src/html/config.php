<?php

// Verifica se usuário está logado.
Seguranca::checkAdmin();

?>

<div class="container">
    <h1>Config</h1>

    <a href="#" onclick="executa('teste')">Teste</a>
    <a href="#" onclick="executa('resetarbanco')">Resetar Banco</a>

</div>

<style>
    .container a {
        margin: 10px;
        display: table;
    }
</style>

<script>
    function executa(acao) {

        // Preparação dos dados.
        dados = new FormData();
        dados.append('acao', acao); // Exemplo de inclusão de valores.

        // Chamada AJAX
        ajaxDados('<?php echo BASE_URL . '?api=config'; ?>', dados, function(ret) {
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