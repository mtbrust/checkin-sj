<?php

// Verifica se usuário está logado.
Seguranca::checkAdmin();

?>

<div class="container my-4">
    <div class="row mt-4">
        <div class="col-12">
            <h1>Estatísticas</h1>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <h2>Informações Atuais</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-12 mt-3">
            <div class="box_statistica">
                <a onclick="estatistica('ultimoscadastros', this, '#ultimoscadastros', true)">
                    <i class="fas fa-sync-alt"></i>
                </a>
                <h6>Últimos 10 cadastros</h6>
                <div id="ultimoscadastros"></div>
            </div>
        </div>
        
        <div class="col-12 mt-3">
            <div class="box_statistica">
                <a onclick="estatistica('ultimaspresencas', this, '#ultimaspresencas', true)">
                    <i class="fas fa-sync-alt"></i>
                </a>
                <h6>Últimas 10 presenças</h6>
                <div id="ultimaspresencas"></div>
            </div>
        </div>
        
        <div class="col-12 mt-3">
            <div class="box_statistica">
                <a onclick="estatistica('participantespalco', this, '#participantespalco', true)">
                    <i class="fas fa-sync-alt"></i>
                </a>
                <h6>Participantes palco</h6>
                <div id="participantespalco"></div>
            </div>
        </div>
    </div>

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


    <div class="row mt-4">
        <div class="col-12">
            <h2>Erros</h2>
        </div>
    </div>

    <div class="row">
        <div class=" col-sm-3 col-6 mt-3">
            <div class="box_statistica">
                <a onclick="estatistica('qtdcadastrosduplicados', this)">
                    <i class="fas fa-sync-alt"></i>
                </a>
                <h6>Pulseiras Duplicados</h6>
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
    function estatistica(acao, e, find = 'h1', lista = false) {

        // Preparação dos dados.
        dados = new FormData();
        dados.append('acao', acao); // Exemplo de inclusão de valores.

        // Chamada AJAX
        ajaxDados('<?php echo BASE_URL . '?api=estatistica'; ?>', dados, function(ret) {
            // Para testes
            console.log(ret);


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


            if (lista) {
                efind = $(find);
                $(efind).html(montaLista(ret.ret));
            } else {
                efind = $(e).parent().parent().find(find);
                $(efind).text(ret.ret);
            }
        })
    }

    function montaLista(lista) {
        html = '<table class="table table-striped">';
        lista.forEach(row => {
            html += '<tr>';
            html += '<td><img src="' + row.foto + '" style="width: 50px;"></td>';
            html += '<td>' + row.pulseira + '</td>';
            html += '<td>' + row.fullName + '</td>';
            html += '<td>' + row.dtCreate + '</td>';
            html += '<td><a href="<?php echo BASE_URL; ?>?page=cadastro_editar&id=' + row.id + '"><i class="fas fa-user-edit"></i></a></td>';
            html += '</tr>';
        });
        html += '</table>';
        return html;
    }
</script>