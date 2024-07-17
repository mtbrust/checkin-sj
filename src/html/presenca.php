<?php
Seguranca::check();
?>

<div class="container my-4">
    <h1>Presença</h1>

    <div class="my-2">

        <form class="row" id="form_presenca" name="form_presenca" onsubmit="return false;" enctype="multipart/form-data">

            <div class="col-12 mb-3">
                <label for="f-tpulseira" class="form-label">Tipo Pulseira</label><br>
                <div class="form-check form-check-inline tpulseira" style="border-color: #d1d1d1 !important;">
                    <input class="form-check-input" type="radio" name="f-tpulseira" id="f-branca" value="branca" required>
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
            <div class="col-5 mb-3">
                <label for="f-pulseira" class="form-label">Pulseira</label>
                <input type="number" class="form-control" id="f-pulseira" name="f-pulseira" placeholder="" value="">
                <div id="pulseiraHelp" class="form-text">Número da pulseira do visitante.</div>
            </div>

            <div class="mb-3 mt-3 text-end">
                <button class="btn btn-success" onclick="executa()" id="btn_cadastrar">Presença</button>
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
    function executa() {

        // Preparação dos dados.
        form = $('#form_presenca')[0];
        dados = new FormData(form);
        dados.append('acao', 'presenca'); // Exemplo de inclusão de valores.

        // Chamada AJAX
        ajaxDados('<?php echo BASE_URL . '?api=presenca'; ?>', dados, function(ret) {
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