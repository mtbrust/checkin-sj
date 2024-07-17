<?php

// Verifica se usuário está logado.
Seguranca::checkAdmin();

?>

<div class="container my-4">
    <h1>Estatísticas</h1>

    <div class="row mt-4">
        <div class="col-12">
            <h2>CADASTROS</h2>
        </div>
    </div>

    <div class="row">
        <div class=" col-sm-3 col-6 mt-3">
            <div class="box_statistica">
                <a onclick="estatistica('qtdCadastrosPulseira', this)">
                    <i class="fas fa-sync-alt"></i>
                </a>
                <h6>Cadastros</h6>
                <h1>-</h1>
            </div>
        </div>
        <div class=" col-sm-3 col-6 mt-3">
            <div class="box_statistica">
                <a onclick="estatistica('qtdCadastrosPulseira22', this)">
                    <i class="fas fa-sync-alt"></i>
                </a>
                <h6>Cadastros dia 22</h6>
                <h1>-</h1>
            </div>
        </div>
        <div class=" col-sm-3 col-6 mt-3">
            <div class="box_statistica">
                <a onclick="estatistica('qtdCadastrosPulseira23', this)">
                    <i class="fas fa-sync-alt"></i>
                </a>
                <h6>Cadastros dia 23</h6>
                <h1>-</h1>
            </div>
        </div>
        <div class=" col-sm-3 col-6 mt-3">
            <div class="box_statistica">
                <a onclick="estatistica('qtdCadastrosPulseira24', this)">
                    <i class="fas fa-sync-alt"></i>
                </a>
                <h6>Cadastros dia 24</h6>
                <h1>-</h1>
            </div>
        </div>
        <div class=" col-sm-3 col-6 mt-3">
            <div class="box_statistica">
                <a onclick="estatistica('qtdCadastrosPulseira25', this)">
                    <i class="fas fa-sync-alt"></i>
                </a>
                <h6>Cadastros dia 25</h6>
                <h1>-</h1>
            </div>
        </div>
        <div class=" col-sm-3 col-6 mt-3">
            <div class="box_statistica">
                <a onclick="estatistica('qtdCadastrosPulseira26', this)">
                    <i class="fas fa-sync-alt"></i>
                </a>
                <h6>Cadastros dia 26</h6>
                <h1>-</h1>
            </div>
        </div>
        <div class=" col-sm-3 col-6 mt-3">
            <div class="box_statistica">
                <a onclick="estatistica('qtdCadastrosPulseira27', this)">
                    <i class="fas fa-sync-alt"></i>
                </a>
                <h6>Cadastros dia 27</h6>
                <h1>-</h1>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <h2>PRESENÇAS</h2>
        </div>
    </div>

    <div class="row">
        <div class=" col-sm-3 col-6 mt-3">
            <div class="box_statistica">
                <a onclick="estatistica('qtdpresencaspulseiras', this)">
                    <i class="fas fa-sync-alt"></i>
                </a>
                <h6>Presenças</h6>
                <h1>-</h1>
            </div>
        </div>
        <div class=" col-sm-3 col-6 mt-3">
            <div class="box_statistica">
                <a onclick="estatistica('qtdpresencaspulseiras22', this)">
                    <i class="fas fa-sync-alt"></i>
                </a>
                <h6>Presenças dia 22</h6>
                <h1>-</h1>
            </div>
        </div>
        <div class=" col-sm-3 col-6 mt-3">
            <div class="box_statistica">
                <a onclick="estatistica('qtdpresencaspulseiras23', this)">
                    <i class="fas fa-sync-alt"></i>
                </a>
                <h6>Presenças dia 23</h6>
                <h1>-</h1>
            </div>
        </div>
        <div class=" col-sm-3 col-6 mt-3">
            <div class="box_statistica">
                <a onclick="estatistica('qtdpresencaspulseiras24', this)">
                    <i class="fas fa-sync-alt"></i>
                </a>
                <h6>Presenças dia 24</h6>
                <h1>-</h1>
            </div>
        </div>
        <div class=" col-sm-3 col-6 mt-3">
            <div class="box_statistica">
                <a onclick="estatistica('qtdpresencaspulseiras25', this)">
                    <i class="fas fa-sync-alt"></i>
                </a>
                <h6>Presenças dia 25</h6>
                <h1>-</h1>
            </div>
        </div>
        <div class=" col-sm-3 col-6 mt-3">
            <div class="box_statistica">
                <a onclick="estatistica('qtdpresencaspulseiras26', this)">
                    <i class="fas fa-sync-alt"></i>
                </a>
                <h6>Presenças dia 26</h6>
                <h1>-</h1>
            </div>
        </div>
        <div class=" col-sm-3 col-6 mt-3">
            <div class="box_statistica">
                <a onclick="estatistica('qtdpresencaspulseiras27', this)">
                    <i class="fas fa-sync-alt"></i>
                </a>
                <h6>Presenças dia 27</h6>
                <h1>-</h1>
            </div>
        </div>
    </div>
</div>

<style>
    .container a {
        margin: 10px;
        display: table;
    }
</style>

<script>
    function estatistica(acao, e) {

        // Preparação dos dados.
        dados = new FormData();
        dados.append('acao', acao); // Exemplo de inclusão de valores.

        // Chamada AJAX
        ajaxDados('<?php echo BASE_URL . '?api=estatistica'; ?>', dados, function(ret) {
            // Para testes
            // console.log(ret);


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

            h1 = $(e).parent().parent().find('h1');
            $(h1).text(ret.ret);
        })
    }
</script>