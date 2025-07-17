<?php
Seguranca::check();

$user = Seguranca::getSession();

?>

<div class="container my-4">
    <div class="row">
        <div class="col-12">
            <h1>Presença</h1>
        </div>
    </div>


    <div class="row">
        <div class="col-12 text-center" id="status">

        </div>
    </div>

    <div class="row my-2">

        <form class="row" id="form_presenca" name="form_presenca" onsubmit="return false;" enctype="multipart/form-data">

            <div class="col-12 mb-3">
                <label for="f-tpulseira" class="form-label">Tipo Pulseira</label><br>
                <div class="form-check form-check-inline tpulseira" style="border-color: #d1d1d1 !important;">
                    <input class="form-check-input" type="radio" name="f-tpulseira" id="f-branca" value="branca" required checked>
                    <label class="form-check-label" for="f-branca"><i class="fas fa-square text-light"></i>Branca</label>
                </div>
                <div class="form-check form-check-inline tpulseira" style="border-color: #FFEB3B !important;">
                    <input class="form-check-input" type="radio" name="f-tpulseira" id="f-amarela" value="amarela" required>
                    <label class="form-check-label" for="f-amarela"><i class="fas fa-square text-warning"></i>Amarela</label>
                </div>
                <div class="form-check form-check-inline tpulseira" style="border-color: #ff3b3b !important;">
                    <input class="form-check-input" type="radio" name="f-tpulseira" id="f-vermelha" value="vermelha" required>
                    <label class="form-check-label" for="f-vermelha"><i class="fas fa-square text-danger"></i>Vermelha</label>
                </div>
                <div class="form-check form-check-inline tpulseira" style="border-color: #1c37cf !important;">
                    <input class="form-check-input" type="radio" name="f-tpulseira" id="f-azul" value="azul" required>
                    <label class="form-check-label" for="f-azul"><i class="fas fa-square text-primary"></i>Azul</label>
                </div>
                <div id="tpulseiraHelp" class="form-text">Cor da pulseira.</div>
            </div>
            <div class="col-6 mb-3">
                <label for="f-pulseira" class="form-label">Pulseira</label>
                <input type="number" class="form-control" id="f-pulseira" name="f-pulseira" placeholder="" value="" required>
                <div id="pulseiraHelp" class="form-text">Número da pulseira do visitante.</div>
            </div>

            <div class="col-6 mb-3 mt-3 text-end">
                <button class="btn btn-success" onclick="executa()" id="btn_cadastrar">Presença</button>

                <?php
                if ($user['id'] == 1) {
                    echo '<br><br><button class="btn btn-danger" onclick="testeStress()">Teste de Stress</button>';
                }
                ?>

            </div>
        </form>
    </div>

</div>


<style>
    .tpulseira {
        border-bottom: solid;
        border-width: 3px;
        border-radius: 5px;
    }
</style>


<script>
    let pulseira_teste = 5000;

    function executa(teste = false) {

        // Preparação dos dados.
        form = $('#form_presenca')[0];
        dados = new FormData(form);
        dados.append('acao', 'presenca'); // Exemplo de inclusão de valores.

        if (teste) {
            $("#f-pulseira").val(pulseira_teste++);

            switch (random(1, 4)) {
                case 1:
                    dados.set('f-tpulseira', 'branca');
                    break;
                case 2:
                    dados.set('f-tpulseira', 'vermelha');
                    break;
                case 3:
                    dados.set('f-tpulseira', 'amarela');
                    break;
                case 4:
                    dados.set('f-tpulseira', 'azul');
                    break;

                default:
                    break;
            }

            // console.log(pulseira_teste);
        }

        // Chamada AJAX
        ajaxDados('<?php echo BASE_URL . '?api=presenca'; ?>', dados, function(ret) {
            // Para testes
            // console.log(ret);

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

                // Notificação.
                Swal.fire({
                    icon: icon,
                    title: title,
                    text: ret.msg,
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                });

                if (!teste) {

                    $('#f-pulseira').focus();
                    $('#f-pulseira').val('');

                }

                //status

                if (ret.status.status == 2) {
                    link = '<a href="<?php echo BASE_URL . '?page=cadastro_editar&id='; ?>' + ret.status.id + '"><i class="fas fa-user-edit"></i></a>';
                    console.log(link);
                    $('#status').html(link + ' Visitante: ' + ret.status.fullName + '<h4><span class="badge text-bg-warning">Atualizar Cadastro!</span></h4>');
                }

                if (ret.status.status == 3) {
                    $('#status').html('Visitante: ' + ret.status.fullName + '<h4><span class="badge text-bg-warning">Atenção!</span></h4>');
                }

                if (ret.status.status == 4) {
                    $('#status').html('Visitante: ' + ret.status.fullName + '<h4><span class="badge text-bg-danger">Bloqueado!</span></h4>');
                }

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