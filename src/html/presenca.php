<?php
Seguranca::check();

$user = Seguranca::getSession();

?>

<div class="container my-3 presenca-page">
    <div class="row">
        <div class="col-12">
            <h1>Presença</h1>
        </div>
    </div>


    <div class="row">
        <div class="col-12 text-center mb-2" id="status">

        </div>
    </div>

    <form class="row g-2 pb-2" id="form_presenca" name="form_presenca" onsubmit="return false;" enctype="multipart/form-data">

            <?php require_once(BASE_DIR . 'src/html/pulseiras_tipo.php'); ?>

            <div class="col-12 col-sm-6 mb-2">
                <label for="f-pulseira" class="form-label">Pulseira (Obrigatório)</label>
                <input type="number" class="form-control" id="f-pulseira" name="f-pulseira" placeholder="" value="" required autofocus>
                <div class="form-text">Número da pulseira do visitante.</div>
            </div>

            <div class="col-12 mb-2 presenca-actions text-end">
                <button class="btn btn-success btn-presenca" onclick="executa()" id="btn_cadastrar">Presença</button>

                <?php
                if ($user['id'] == 1 and isset($_GET['stress'])) {
                    echo '<br><br><button class="btn btn-danger" onclick="testeStress()">Teste de Stress</button>';
                }
                ?>

            </div>
    </form>

</div>

<style>
    #status {
        min-height: 42px;
    }

    .presenca-status-box {
        display: grid;
        grid-template-columns: minmax(0, 1.4fr) auto auto;
        gap: 8px;
        align-items: center;
        width: 100%;
        font-size: 0.9rem;
        line-height: 1.2;
    }

    .presenca-status-col {
        min-width: 0;
    }

    .presenca-status-nome-col {
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .presenca-status-badge-col {
        text-align: center;
    }

    .presenca-status-dias-col {
        text-align: right;
        white-space: nowrap;
    }

    .presenca-status-nome {
        font-weight: 600;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .presenca-status-edit {
        color: #0d6efd;
        text-decoration: none;
    }

    .presenca-status-edit:hover {
        text-decoration: underline;
    }

    .presenca-status-dias {
        font-size: 0.82rem;
        color: #6c757d;
    }

    .presenca-actions {
        padding-top: 4px;
    }

    @media (max-width: 576px) {
        .presenca-page {
            padding-bottom: 86px;
        }

        .presenca-status-box {
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 4px;
            font-size: 0.78rem;
        }

        .presenca-status-box .badge {
            font-size: 0.68rem;
            padding: 0.25em 0.45em;
        }

        .presenca-status-dias {
            font-size: 0.72rem;
        }

        .presenca-actions {
            position: sticky;
            bottom: 0;
            z-index: 12;
            background: #fff;
            border-top: 1px solid #eee;
            padding: 10px 4px calc(10px + env(safe-area-inset-bottom, 0px));
            margin-top: 4px;
            margin-bottom: 0 !important;
            text-align: center !important;
        }

        .btn-presenca {
            width: 100%;
            max-width: 420px;
        }
    }
</style>


<script>
    let pulseira_teste = 5000;

    function renderStatusPresenca(ret) {
        const info = ret.status || {};
        const nome = info.fullName || ('Pulseira ' + (ret.dados?.pulseira || ''));
        const id = parseInt(info.id || 0, 10);
        const qtd = parseInt(info.qtdPresenca || 0, 10);
        const textoDias = '[' + qtd + '] Presenças';
        const linkEditar = id > 0
            ? '<a class="presenca-status-edit" href="<?php echo BASE_URL . '?page=cadastro_editar&id='; ?>' + id + '"><i class="fas fa-user-edit"></i></a>'
            : '';

        let statusClasse = 'text-bg-warning';
        let statusTexto = 'Não cadastrado';

        if (info.status == 1) {
            statusClasse = 'text-bg-success';
            statusTexto = 'OK';
        } else if (info.status == 2) {
            statusClasse = 'text-bg-warning';
            statusTexto = 'Atualizar';
        } else if (info.status == 3) {
            statusClasse = 'text-bg-warning';
            statusTexto = 'Atenção';
        } else if (info.status == 4) {
            statusClasse = 'text-bg-danger';
            statusTexto = 'Bloqueado';
        }

        $('#status').html(
            '<div class="presenca-status-box">' +
                '<div class="presenca-status-col presenca-status-nome-col">' +
                    linkEditar +
                    '<span class="presenca-status-nome" title="' + nome + '">' + nome + '</span>' +
                '</div>' +
                '<div class="presenca-status-col presenca-status-badge-col">' +
                    '<span class="badge ' + statusClasse + '">' + statusTexto + '</span>' +
                '</div>' +
                '<div class="presenca-status-col presenca-status-dias-col">' +
                    '<span class="presenca-status-dias">' + textoDias + '</span>' +
                '</div>' +
            '</div>'
        );
    }

    function executa(teste = false) {

        // Preparação dos dados.
        form = $('#form_presenca')[0];
        dados = new FormData(form);
        dados.append('acao', 'presenca'); // Exemplo de inclusão de valores.

        if (teste) {
            $("#f-pulseira").val(pulseira_teste++);

            switch (random(1, 2)) {
                case 1:
                    dados.set('f-tpulseira', 'amarela');
                    break;
                case 2:
                    dados.set('f-tpulseira', 'azul');
                    break;
            }

            // console.log(pulseira_teste);
        }

        // Chamada AJAX
        ajaxDados('<?php echo BASE_URL . '?api=presenca'; ?>', dados, function(ret) {
            // Para testes
            console.log(ret);

            // Verifica se teve retorno ok.
            if (ret.ret) {

                $('#status').html('');

                icon = "success";
                title = "Sucesso.";

                if (ret.msg == 'Bloqueado'){
                    icon = "danger";
                    title = "Cuidade";
                }

                if (ret.msg == 'Atenção' || ret.msg == 'Atualizar'){
                    icon = "warning";
                    title = "Atenção";
                }

                notificaToast(icon, title, ret.msg);

                if (!teste) {

                    $('#f-pulseira').focus();
                    $('#f-pulseira').val('');

                }

                renderStatusPresenca(ret);

            } else {

                notificaErro(ret.msg);
            }
        })
    }



    function testeStress() {
        qtqPulseiras = $("#f-pulseira").val();
        $("#f-pulseira").val(pulseira_teste);

        for (let i = 0; i < qtqPulseiras; i++) {
            executa(true);
        }
    }

    function random(min, max) {
        min = Math.ceil(min);
        max = Math.floor(max);
        return Math.floor(Math.random() * (max - min + 1)) + min;
    }
</script>