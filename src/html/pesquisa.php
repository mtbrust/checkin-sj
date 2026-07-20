<?php

$resultado = false;
$termoPesquisa = isset($_GET['f-pesquisa']) ? trim((string) $_GET['f-pesquisa']) : '';

if ($termoPesquisa !== '') {
    $BdVisitantes = new BdVisitantes();
    $resultado = $BdVisitantes->pesquisar($termoPesquisa);
}

$user = Seguranca::getSession();
$podeEditar = Seguranca::isAdmin($user);

$statusLabels = [
    2 => ['label' => 'Atualizar', 'class' => 'text-bg-warning'],
    3 => ['label' => 'Atenção', 'class' => 'text-bg-warning'],
    4 => ['label' => 'Bloqueado', 'class' => 'text-bg-danger'],
];

function pesquisaBadgePulseira($tpulseira)
{
    $tp = strtolower(trim((string) $tpulseira));
    if ($tp === 'amarela') {
        return 'pesquisa-badge-amarela';
    }
    return 'pesquisa-badge-azul';
}

function pesquisaIconeSexo($sexo)
{
    $sx = strtoupper(trim((string) $sexo));
    if ($sx === 'M') {
        return '<i class="fas fa-mars pesquisa-sexo-m" title="Masculino"></i>';
    }
    if ($sx === 'F') {
        return '<i class="fas fa-venus pesquisa-sexo-f" title="Feminino"></i>';
    }
    return '';
}

function pesquisaTelefoneFormatado($telefone, $dddPadrao = '35')
{
    $digits = preg_replace('/\D/', '', (string) $telefone);
    if ($digits === '') {
        return '';
    }

    if (strlen($digits) <= 9) {
        $digits = $dddPadrao . $digits;
    }

    if (strlen($digits) === 11) {
        return sprintf(
            '(%s) %s-%s',
            substr($digits, 0, 2),
            substr($digits, 2, 5),
            substr($digits, 7, 4)
        );
    }

    if (strlen($digits) === 10) {
        return sprintf(
            '(%s) %s-%s',
            substr($digits, 0, 2),
            substr($digits, 2, 4),
            substr($digits, 6, 4)
        );
    }

    return $telefone;
}

function pesquisaNascimentoInfo($nascimento)
{
    if (empty($nascimento) || $nascimento === '0000-00-00') {
        return null;
    }

    try {
        $dt = new DateTime($nascimento);
    } catch (Exception $e) {
        return null;
    }

    $hoje = new DateTime('today');
    if ($dt > $hoje) {
        return null;
    }

    return [
        'data' => $dt->format('d/m/Y'),
        'idade' => (int) $dt->diff($hoje)->y,
    ];
}

$totalResultados = is_array($resultado) ? count($resultado) : 0;

?>

<div class="container my-4">

    <div class="row">
        <div class="col-12">
            <h1>Pesquisa</h1>
            <p class="text-muted small mb-0">
                Texto: nome, tipo de pulseira ou endereço.<br>
                Número: pulseira, pulseira antiga ou telefone / parte do telefone (exibe presenças).
            </p>
            <?php if ($termoPesquisa !== ''): ?>
                <p class="small mt-2 mb-0">
                    Termo: <strong><?php echo htmlspecialchars($termoPesquisa, ENT_QUOTES, 'UTF-8'); ?></strong>
                    · <span id="pesquisa-qtd-visivel"><?php echo $totalResultados; ?></span> de <?php echo $totalResultados; ?> resultado(s)
                </p>
            <?php endif; ?>
        </div>
    </div>

    <?php if ($resultado): ?>
        <div class="row g-2 mt-3" id="pesquisa-filtros">
            <div class="col-12 col-sm-6 col-lg-3">
                <label for="filtro-nome" class="form-label small mb-1">Nome</label>
                <input type="text" class="form-control form-control-sm" id="filtro-nome" placeholder="Filtrar nome">
            </div>
            <div class="col-6 col-sm-3 col-lg-2">
                <label for="filtro-sexo" class="form-label small mb-1">Sexo</label>
                <select class="form-select form-select-sm" id="filtro-sexo">
                    <option value="">Todos</option>
                    <option value="M">Masculino</option>
                    <option value="F">Feminino</option>
                </select>
            </div>
            <div class="col-6 col-sm-3 col-lg-3">
                <label for="filtro-telefone" class="form-label small mb-1">Telefone</label>
                <input type="text" class="form-control form-control-sm" id="filtro-telefone" placeholder="Parte do número" inputmode="numeric">
            </div>
            <div class="col-6 col-sm-3 col-lg-2">
                <label for="filtro-pulseira" class="form-label small mb-1">Pulseira</label>
                <input type="text" class="form-control form-control-sm" id="filtro-pulseira" placeholder="Nº" inputmode="numeric">
            </div>
            <div class="col-6 col-sm-3 col-lg-2 d-flex align-items-end">
                <button type="button" class="btn btn-sm btn-outline-secondary w-100" id="filtro-limpar">Limpar filtros</button>
            </div>
        </div>
    <?php endif; ?>

    <div class="row g-2 mt-2" id="pesquisa-lista">
        <?php if (!$resultado): ?>
            <div class="col-12 mt-2">
                <?php if ($termoPesquisa !== ''): ?>
                    <p class="text-muted mb-0">Nenhum resultado para “<?php echo htmlspecialchars($termoPesquisa, ENT_QUOTES, 'UTF-8'); ?>”.</p>
                <?php else: ?>
                    <p class="text-muted mb-0">Realize a pesquisa pelo campo no menu.</p>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <?php foreach ($resultado as $value): ?>
                <?php
                $statusInfo = $statusLabels[$value['status']] ?? null;
                $cardClass = (int) $value['status'] === 4 ? 'pesquisa-card-bloqueado' : '';

                $presencasHtml = '';
                if (($value['presencas'] ?? '') == 'texto') {
                    $presencasHtml = '';
                } else {
                    $presencas = array_filter(array_unique(explode(',', (string) ($value['presencas'] ?? ''))));
                    sort($presencas);
                    if ($presencas) {
                        $presencasHtml = '<div class="pesquisa-card-presencas"><i class="fas fa-user-check"></i> ' . count($presencas) . ' presença(s)</div>';
                    }
                }

                $telefoneFmt = pesquisaTelefoneFormatado($value['telefone'] ?? '');
                $telefoneDigits = preg_replace('/\D+/', '', (string) ($value['telefone'] ?? ''));
                $nascimentoInfo = pesquisaNascimentoInfo($value['nascimento'] ?? '');
                $sexo = strtoupper(trim((string) ($value['sexo'] ?? '')));
                ?>
                <div class="col-6 pesquisa-item"
                    data-nome="<?php echo htmlspecialchars(mb_strtolower((string) ($value['fullName'] ?? ''), 'UTF-8'), ENT_QUOTES, 'UTF-8'); ?>"
                    data-sexo="<?php echo htmlspecialchars($sexo, ENT_QUOTES, 'UTF-8'); ?>"
                    data-telefone="<?php echo htmlspecialchars($telefoneDigits, ENT_QUOTES, 'UTF-8'); ?>"
                    data-pulseira="<?php echo htmlspecialchars((string) ($value['pulseira'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>"
                >
                    <div class="pesquisa-card shadow-sm <?php echo $cardClass; ?>">
                        <div class="pesquisa-card-top">
                            <div class="pesquisa-card-top-esq">
                                <?php if ($podeEditar): ?>
                                    <a class="pesquisa-card-editar me-1" href="<?php echo BASE_URL . '?page=cadastro_editar&id=' . (int) $value['id']; ?>" title="Editar">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                <?php endif; ?>
                                <?php if (!empty($value['id'])): ?>
                                    <a class="pesquisa-card-editar text-muted js-visitante-foto" href="#" data-visitante-id="<?php echo (int) $value['id']; ?>" title="Ver foto">
                                        <i class="fas fa-camera"></i>
                                    </a>
                                <?php endif; ?>
                                <span class="badge <?php echo pesquisaBadgePulseira($value['tpulseira']); ?>">
                                    <?php echo htmlspecialchars($value['pulseira'], ENT_QUOTES, 'UTF-8'); ?>
                                </span>
                            </div>
                            <div class="pesquisa-card-sexo">
                                <?php echo pesquisaIconeSexo($value['sexo'] ?? ''); ?>
                            </div>
                        </div>

                        <?php if ($statusInfo): ?>
                        <div class="pesquisa-card-linha">
                            <span class="badge <?php echo $statusInfo['class']; ?>"><?php echo $statusInfo['label']; ?></span>
                        </div>
                        <?php endif; ?>

                        <div class="pesquisa-card-nome text-truncate fw-bold" title="<?php echo htmlspecialchars($value['fullName'], ENT_QUOTES, 'UTF-8'); ?>">
                            <?php echo htmlspecialchars($value['fullName'], ENT_QUOTES, 'UTF-8'); ?>
                        </div>

                        <div class="pesquisa-card-info">
                            <?php if ($nascimentoInfo): ?>
                                <div class="text-truncate">
                                    <?php echo htmlspecialchars($nascimentoInfo['data'], ENT_QUOTES, 'UTF-8'); ?>
                                    <span class="text-muted">(<?php echo $nascimentoInfo['idade']; ?> anos)</span>
                                </div>
                            <?php endif; ?>
                            <?php if ($telefoneFmt !== ''): ?>
                                <div class="text-truncate"><?php echo htmlspecialchars($telefoneFmt, ENT_QUOTES, 'UTF-8'); ?></div>
                            <?php endif; ?>
                            <?php if (!empty($value['cidade'])): ?>
                                <div class="text-truncate text-muted"><?php echo htmlspecialchars($value['cidade'], ENT_QUOTES, 'UTF-8'); ?></div>
                            <?php endif; ?>
                        </div>

                        <?php echo $presencasHtml; ?>
                    </div>
                </div>
            <?php endforeach; ?>
            <div class="col-12 d-none" id="pesquisa-sem-filtro">
                <p class="text-muted mb-0">Nenhum resultado com os filtros aplicados.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
    .pesquisa-card {
        position: relative;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 10px;
        height: 100%;
        background: #fff;
    }

    .pesquisa-card-bloqueado {
        background: #fff5f5;
        border-color: #f1aeb5;
    }

    .pesquisa-card-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 6px;
        margin-bottom: 4px;
    }

    .pesquisa-card-top-esq {
        display: flex;
        align-items: center;
        gap: 6px;
        min-width: 0;
    }

    .pesquisa-card-editar {
        color: #198754;
        font-size: 0.75rem;
        line-height: 1;
        flex-shrink: 0;
    }

    .pesquisa-card-top-esq .badge {
        font-size: 0.72rem;
        font-weight: 600;
    }

    .pesquisa-card-sexo {
        flex-shrink: 0;
        font-size: 0.85rem;
        line-height: 1;
    }

    .pesquisa-sexo-m {
        color: #0d6efd;
    }

    .pesquisa-sexo-f {
        color: #e83e8c;
    }

    .pesquisa-badge-amarela {
        background-color: #ffc107;
        color: #212529;
    }

    .pesquisa-badge-azul {
        background-color: #0d6efd;
        color: #fff;
    }

    .pesquisa-card-nome {
        font-size: 0.8rem;
        margin-bottom: 4px;
    }

    .pesquisa-card-linha {
        display: flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 6px;
    }

    .pesquisa-card-linha .badge {
        font-size: 0.65rem;
    }

    .pesquisa-card-info {
        font-size: 0.72rem;
        line-height: 1.35;
    }

    .pesquisa-card-presencas {
        margin-top: 6px;
        font-size: 0.68rem;
        color: #198754;
    }
</style>

<?php if ($resultado): ?>
<script>
(function () {
    var total = <?php echo (int) $totalResultados; ?>;

    function digitos(v) {
        return String(v || '').replace(/\D+/g, '');
    }

    function aplicarFiltros() {
        var nome = (document.getElementById('filtro-nome').value || '').toLowerCase().trim();
        var sexo = (document.getElementById('filtro-sexo').value || '').toUpperCase();
        var telefone = digitos(document.getElementById('filtro-telefone').value);
        var pulseira = digitos(document.getElementById('filtro-pulseira').value);

        var itens = document.querySelectorAll('.pesquisa-item');
        var visiveis = 0;

        itens.forEach(function (el) {
            var okNome = !nome || (el.getAttribute('data-nome') || '').indexOf(nome) !== -1;
            var okSexo = !sexo || (el.getAttribute('data-sexo') || '') === sexo;
            var okTel = !telefone || (el.getAttribute('data-telefone') || '').indexOf(telefone) !== -1;
            var okPulseira = !pulseira || (el.getAttribute('data-pulseira') || '').indexOf(pulseira) !== -1;
            var show = okNome && okSexo && okTel && okPulseira;
            el.classList.toggle('d-none', !show);
            if (show) visiveis++;
        });

        var qtd = document.getElementById('pesquisa-qtd-visivel');
        if (qtd) qtd.textContent = String(visiveis);

        var vazio = document.getElementById('pesquisa-sem-filtro');
        if (vazio) vazio.classList.toggle('d-none', visiveis > 0);
    }

    ['filtro-nome', 'filtro-sexo', 'filtro-telefone', 'filtro-pulseira'].forEach(function (id) {
        var el = document.getElementById(id);
        if (!el) return;
        el.addEventListener('input', aplicarFiltros);
        el.addEventListener('change', aplicarFiltros);
    });

    var btnLimpar = document.getElementById('filtro-limpar');
    if (btnLimpar) {
        btnLimpar.addEventListener('click', function () {
            document.getElementById('filtro-nome').value = '';
            document.getElementById('filtro-sexo').value = '';
            document.getElementById('filtro-telefone').value = '';
            document.getElementById('filtro-pulseira').value = '';
            aplicarFiltros();
        });
    }
})();
</script>
<?php endif; ?>
