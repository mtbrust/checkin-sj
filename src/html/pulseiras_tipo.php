<?php

if (!isset($visitante)) {
    $visitante = [];
}

$tpulseiraAtual = 'amarela';

if (isset($visitante['tpulseira']) && $visitante['tpulseira']) {
    $tp = strtolower($visitante['tpulseira']);
    if (in_array($tp, ['amarela', 'azul'], true)) {
        $tpulseiraAtual = $tp;
    }
}

$pulseiraAmarelaChecked = $tpulseiraAtual === 'amarela' ? 'checked' : '';
$pulseiraAzulChecked = $tpulseiraAtual === 'azul' ? 'checked' : '';

?>

<div class="col-12 col-sm-6 mb-3">
    <label class="form-label">Tipo Pulseira (Obrigatório)</label>
    <div class="row g-2">
        <div class="col-6">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="f-tpulseira" id="f-amarela" value="amarela" required <?php echo $pulseiraAmarelaChecked; ?>>
                <label class="form-check-label" for="f-amarela">
                    <i class="fas fa-square text-warning"></i> Amarela
                </label>
            </div>
        </div>
        <div class="col-6">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="f-tpulseira" id="f-azul" value="azul" required <?php echo $pulseiraAzulChecked; ?>>
                <label class="form-check-label" for="f-azul">
                    <i class="fas fa-square text-primary"></i> Azul
                </label>
            </div>
        </div>
    </div>
    <div class="form-text">Cor da pulseira.</div>
</div>
