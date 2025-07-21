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
                <div id="ultimoscadastros" style="overflow-y: scroll;"></div>
            </div>
        </div>

        <div class="col-12 mt-3">
            <div class="box_statistica">
                <a onclick="estatistica('ultimaspresencas', this, '#ultimaspresencas', true)">
                    <i class="fas fa-sync-alt"></i>
                </a>
                <h6>Últimas 10 presenças</h6>
                <div id="ultimaspresencas" style="overflow-y: scroll;"></div>
            </div>
        </div>

        <div class="col-12 mt-3">
            <div class="box_statistica">
                <a onclick="estatistica('participantespalco', this, '#participantespalco', true)">
                    <i class="fas fa-sync-alt"></i>
                </a>
                <h6>Participantes palco</h6>
                <p>Relação de visitantes que vieram hj e que optaram por participar no palco. 5 pessoas já sorteadas com destaque em verde.</p>
                <div id="participantespalco" style="overflow-y: scroll;"></div>
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
                <a onclick="estatisticaCadastrosDiarios(this)">
                    <i class="fas fa-sync-alt"></i>
                </a>
                <h6>Cadastros</h6>
                <h1>-</h1>
            </div>
        </div>
    </div>
    <div class="row" id="cadastrosDiarios"></div>

    <div class="row mt-4">
        <div class="col-12">
            <h2>PRESENÇAS</h2>
        </div>
    </div>
    <div class="row">
        <div class=" col-sm-3 col-6 mt-3">
            <div class="box_statistica">
                <a onclick="estatisticaVisitasDiarias(this)">
                    <i class="fas fa-sync-alt"></i>
                </a>
                <h6>Presenças</h6>
                <h1>-</h1>
            </div>
        </div>
    </div>
    <div class="row" id="visitasDiarias"></div>

    <div class="row d-none">
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
                <h6>Pulseiras Duplicadas</h6>
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
    function estatisticaCadastrosDiarios(e) {

        estatistica('qtdCadastrosPulseira', e);

        // Preparação dos dados.
        dados = new FormData();
        dados.append('acao', 'cadastrosDiarios'); // Exemplo de inclusão de valores.

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

            $('#cadastrosDiarios').html(ret.ret);
        })

    }


    function estatisticaVisitasDiarias(e) {

        estatistica('qtdpresencaspulseiras', e);

        // Preparação dos dados.
        dados = new FormData();
        dados.append('acao', 'visitasDiarias'); // Exemplo de inclusão de valores.

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

            $('#visitasDiarias').html(ret.ret);
        })

    }

    function estatistica(acao, e, find = 'h1', lista = false) {

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


            if (lista) {
                efind = $(find);
                switch (acao) {
                    case 'ultimoscadastros':
                        $(efind).html(montaLista(ret.ret));
                        break;

                    case 'participantespalco':
                        $(efind).html(montaLista(ret.ret));
                        sortear();
                        break;

                    default:
                        $(efind).html(montaListaPresença(ret.ret));
                        break;
                }

            } else {
                efind = $(e).parent().parent().find(find);
                $(efind).text(ret.ret);
            }
        })
    }

    function montaLista(lista) {
        html = '<table class="table table-striped">';
        html += '<tr>';
        html += '<th>Pulseira</th>';
        html += '<th>COR</th>';
        html += '<th>Antiga</th>';
        html += '<th>Nome</th>';
        html += '<th>Sexo</th>';
        html += '<th>Telefone</th>';
        html += '<th>Data Nascimento</th>';
        html += '<th>Data Cadastro</th>';
        html += '<th>Status</th>';
        html += '<th>Ação</th>';
        html += '</tr>';
        lista.forEach(row => {
            switch (row.status) {
                case 1:
                    status = 'Ok';
                    break;
                case 2:
                    status = 'Atualizar';
                    break;
                case 3:
                    status = 'Atenção';
                    break;
                case 4:
                    status = 'Bloqueado';
                    break;
            }
            html += '<tr>';
            html += '<td>' + row.pulseira + '</td>';
            html += '<td>' + row.tpulseira + '</td>';
            html += '<td>' + row.oldPulseira + '</td>';
            html += '<td>' + row.fullName + '</td>';
            html += '<td>' + row.sexo + '</td>';
            html += '<td>' + row.telefone + '</td>';
            html += '<td>' + row.nascimento + '</td>';
            html += '<td>' + row.dtCreate + '</td>';
            html += '<td>' + status + '</td>';
            html += '<td><a href="<?php echo BASE_URL; ?>?page=cadastro_editar&id=' + row.id + '"><i class="fas fa-user-edit"></i></a></td>';
            html += '</tr>';
        });
        html += '</table>';
        return html;
    }

    function montaListaPresença(lista) {
        html = '<table class="table table-striped">';
        html += '<tr>';
        html += '<th>Pulseira</th>';
        html += '<th>COR</th>';
        html += '<th>Nome</th>';
        html += '<th>Data Cadastro</th>';
        html += '<th>Status</th>';
        html += '<th>Ação</th>';
        html += '</tr>';
        lista.forEach(row => {
            switch (row.status) {
                case 1:
                    status = 'Ok';
                    break;
                case 2:
                    status = 'Atualizar';
                    break;
                case 3:
                    status = 'Atenção';
                    break;
                case 4:
                    status = 'Bloqueado';
                    break;

                default:
                    break;
            }
            html += '<tr>';
            html += '<td>' + row.pulseira + '</td>';
            html += '<td>' + row.tpulseira + '</td>';
            html += '<td>' + row.fullName + '</td>';
            html += '<td>' + row.dtCreate + '</td>';
            html += '<td>' + status + '</td>';
            html += '<td><a href="<?php echo BASE_URL; ?>?page=cadastro_editar&id=' + row.id + '"><i class="fas fa-user-edit"></i></a></td>';
            html += '</tr>';
        });
        html += '</table>';
        return html;
    }

    function sortear(qtd = 5) {
        $(document).ready(function() {

            linhasSorteadas = [];

            for (let index = 0; index < qtd; index++) {
                linhasSorteadas[index] = random(1, $("#participantespalco tr").length);
            }

            let linha = 1;

            $("#participantespalco tr").each(function() {
                // `this` se refere à linha atual (<tr>)
                // var primeiraCelula = $(this).find("td:first").text();
                // var segundaCelula = $(this).find("td:eq(1)").text(); // Ou $(this).find("td").eq(1).text();

                if ($.inArray(linha, linhasSorteadas) != -1) {
                    $(this).addClass('sorteado');
                }

                linha++;
            });
        });
    }

    function random(min, max) {
        min = Math.ceil(min);
        max = Math.floor(max);
        return Math.floor(Math.random() * (max - min + 1)) + min;
    }
</script>


<style>
    .sorteado {
        background-color: #53df68;
    }
</style>