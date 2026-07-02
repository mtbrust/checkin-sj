<?php

Seguranca::check();

$user = Seguranca::getSession();
$podeEditar = isset($user['cpf']) && in_array($user['cpf'], Seguranca::getCpfsAdmins());

$filtros = [
    'nome'        => isset($_GET['f-nome']) ? trim($_GET['f-nome']) : '',
    'pulseira'    => isset($_GET['f-pulseira']) ? trim($_GET['f-pulseira']) : '',
    'oldPulseira' => isset($_GET['f-oldPulseira']) ? trim($_GET['f-oldPulseira']) : '',
    'tpulseira'   => isset($_GET['f-tpulseira']) ? trim($_GET['f-tpulseira']) : '',
    'telefone'    => isset($_GET['f-telefone']) ? trim($_GET['f-telefone']) : '',
    'cidade'      => isset($_GET['f-cidade']) ? trim($_GET['f-cidade']) : '',
    'bairro'      => isset($_GET['f-bairro']) ? trim($_GET['f-bairro']) : '',
    'sexo'        => isset($_GET['f-sexo']) ? trim($_GET['f-sexo']) : '',
    'status'      => isset($_GET['f-status']) ? trim($_GET['f-status']) : '',
    'calouro'     => isset($_GET['f-calouro']) ? trim($_GET['f-calouro']) : '',
    'palco'       => isset($_GET['f-palco']) ? trim($_GET['f-palco']) : '',
    'duplicados'  => isset($_GET['f-duplicados']) ? trim($_GET['f-duplicados']) : '',
    'data'        => isset($_GET['f-data']) ? trim($_GET['f-data']) : '',
    'hoje'        => isset($_GET['f-hoje']) ? trim($_GET['f-hoje']) : '',
];

$pagina = isset($_GET['p']) ? max(1, (int) $_GET['p']) : 1;
$porPagina = isset($_GET['qtd']) ? max(10, min(100, (int) $_GET['qtd'])) : 25;

$BdVisitantes = new BdVisitantes();
$total = $BdVisitantes->contarFiltrado($filtros);
$lista = $BdVisitantes->listarFiltrado($filtros, $pagina, $porPagina);
$totalPaginas = $total > 0 ? (int) ceil($total / $porPagina) : 1;

$statusLabels = [
    1 => 'OK',
    2 => 'Atualizar',
    3 => 'Atenção',
    4 => 'Bloqueado',
];

function cadastradosQueryBase($filtros, $porPagina)
{
    $params = ['page' => 'cadastrados', 'qtd' => $porPagina];

    if ($filtros['nome'] !== '') {
        $params['f-nome'] = $filtros['nome'];
    }
    if ($filtros['pulseira'] !== '') {
        $params['f-pulseira'] = $filtros['pulseira'];
    }
    if ($filtros['oldPulseira'] !== '') {
        $params['f-oldPulseira'] = $filtros['oldPulseira'];
    }
    if ($filtros['tpulseira'] !== '') {
        $params['f-tpulseira'] = $filtros['tpulseira'];
    }
    if ($filtros['telefone'] !== '') {
        $params['f-telefone'] = $filtros['telefone'];
    }
    if ($filtros['cidade'] !== '') {
        $params['f-cidade'] = $filtros['cidade'];
    }
    if ($filtros['bairro'] !== '') {
        $params['f-bairro'] = $filtros['bairro'];
    }
    if ($filtros['sexo'] !== '') {
        $params['f-sexo'] = $filtros['sexo'];
    }
    if ($filtros['status'] !== '') {
        $params['f-status'] = $filtros['status'];
    }
    if ($filtros['calouro'] !== '') {
        $params['f-calouro'] = $filtros['calouro'];
    }
    if ($filtros['palco'] !== '') {
        $params['f-palco'] = $filtros['palco'];
    }
    if ($filtros['duplicados'] !== '') {
        $params['f-duplicados'] = $filtros['duplicados'];
    }
    if ($filtros['data'] !== '') {
        $params['f-data'] = $filtros['data'];
    }
    if ($filtros['hoje'] !== '') {
        $params['f-hoje'] = $filtros['hoje'];
    }

    return $params;
}

function cadastradosUrlPagina($params, $pagina)
{
    $params['p'] = $pagina;
    return BASE_URL . '?' . http_build_query($params);
}

$queryBase = cadastradosQueryBase($filtros, $porPagina);

?>

<div class="container my-4">
    <div class="row">
        <div class="col-12">
            <h1>Cadastrados</h1>
            <p class="text-muted mb-0">Listagem de todos os visitantes cadastrados.</p>
        </div>
    </div>

    <form class="row g-2 mt-3" method="GET" action="<?php echo BASE_URL; ?>">
        <input type="hidden" name="page" value="cadastrados">
        <?php if ($filtros['calouro'] !== ''): ?><input type="hidden" name="f-calouro" value="<?php echo htmlspecialchars($filtros['calouro'], ENT_QUOTES, 'UTF-8'); ?>"><?php endif; ?>
        <?php if ($filtros['palco'] !== ''): ?><input type="hidden" name="f-palco" value="<?php echo htmlspecialchars($filtros['palco'], ENT_QUOTES, 'UTF-8'); ?>"><?php endif; ?>
        <?php if ($filtros['duplicados'] !== ''): ?><input type="hidden" name="f-duplicados" value="<?php echo htmlspecialchars($filtros['duplicados'], ENT_QUOTES, 'UTF-8'); ?>"><?php endif; ?>
        <?php if ($filtros['data'] !== ''): ?><input type="hidden" name="f-data" value="<?php echo htmlspecialchars($filtros['data'], ENT_QUOTES, 'UTF-8'); ?>"><?php endif; ?>
        <?php if ($filtros['hoje'] !== ''): ?><input type="hidden" name="f-hoje" value="<?php echo htmlspecialchars($filtros['hoje'], ENT_QUOTES, 'UTF-8'); ?>"><?php endif; ?>

        <div class="col-12 col-md-6 col-lg-4">
            <label for="f-nome" class="form-label">Nome</label>
            <input type="text" class="form-control" id="f-nome" name="f-nome" value="<?php echo htmlspecialchars($filtros['nome'], ENT_QUOTES, 'UTF-8'); ?>">
        </div>

        <div class="col-6 col-md-3 col-lg-2">
            <label for="f-pulseira" class="form-label">Pulseira</label>
            <input type="number" class="form-control" id="f-pulseira" name="f-pulseira" value="<?php echo htmlspecialchars($filtros['pulseira'], ENT_QUOTES, 'UTF-8'); ?>">
        </div>

        <div class="col-6 col-md-3 col-lg-2">
            <label for="f-oldPulseira" class="form-label">Pulseira antiga</label>
            <input type="number" class="form-control" id="f-oldPulseira" name="f-oldPulseira" value="<?php echo htmlspecialchars($filtros['oldPulseira'], ENT_QUOTES, 'UTF-8'); ?>">
        </div>

        <div class="col-6 col-md-3 col-lg-2">
            <label for="f-tpulseira" class="form-label">Tipo pulseira</label>
            <select class="form-select" id="f-tpulseira" name="f-tpulseira">
                <option value="">Todas</option>
                <option value="amarela" <?php echo strtolower($filtros['tpulseira']) === 'amarela' ? 'selected' : ''; ?>>Amarela</option>
                <option value="azul" <?php echo strtolower($filtros['tpulseira']) === 'azul' ? 'selected' : ''; ?>>Azul</option>
            </select>
        </div>

        <div class="col-6 col-md-3 col-lg-2">
            <label for="f-telefone" class="form-label">Telefone</label>
            <input type="text" class="form-control" id="f-telefone" name="f-telefone" value="<?php echo htmlspecialchars($filtros['telefone'], ENT_QUOTES, 'UTF-8'); ?>">
        </div>

        <div class="col-6 col-md-4 col-lg-3">
            <label for="f-cidade" class="form-label">Cidade</label>
            <input type="text" class="form-control" id="f-cidade" name="f-cidade" value="<?php echo htmlspecialchars($filtros['cidade'], ENT_QUOTES, 'UTF-8'); ?>">
        </div>

        <div class="col-6 col-md-4 col-lg-3">
            <label for="f-bairro" class="form-label">Bairro</label>
            <input type="text" class="form-control" id="f-bairro" name="f-bairro" value="<?php echo htmlspecialchars($filtros['bairro'], ENT_QUOTES, 'UTF-8'); ?>">
        </div>

        <div class="col-6 col-md-2 col-lg-2">
            <label for="f-sexo" class="form-label">Sexo</label>
            <select class="form-select" id="f-sexo" name="f-sexo">
                <option value="">Todos</option>
                <option value="M" <?php echo strtoupper($filtros['sexo']) === 'M' ? 'selected' : ''; ?>>Masculino</option>
                <option value="F" <?php echo strtoupper($filtros['sexo']) === 'F' ? 'selected' : ''; ?>>Feminino</option>
            </select>
        </div>

        <div class="col-6 col-md-3 col-lg-2">
            <label for="f-status" class="form-label">Status</label>
            <select class="form-select" id="f-status" name="f-status">
                <option value="">Todos</option>
                <option value="1" <?php echo $filtros['status'] === '1' ? 'selected' : ''; ?>>OK</option>
                <option value="2" <?php echo $filtros['status'] === '2' ? 'selected' : ''; ?>>Atualizar</option>
                <option value="3" <?php echo $filtros['status'] === '3' ? 'selected' : ''; ?>>Atenção</option>
                <option value="4" <?php echo $filtros['status'] === '4' ? 'selected' : ''; ?>>Bloqueado</option>
            </select>
        </div>

        <div class="col-6 col-md-2 col-lg-2">
            <label for="qtd" class="form-label">Por página</label>
            <select class="form-select" id="qtd" name="qtd">
                <?php foreach ([25, 50, 100] as $opcao): ?>
                    <option value="<?php echo $opcao; ?>" <?php echo $porPagina === $opcao ? 'selected' : ''; ?>><?php echo $opcao; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-12 d-flex flex-wrap gap-2 align-items-end">
            <button type="submit" class="btn btn-success">Filtrar</button>
            <a class="btn btn-outline-secondary" href="<?php echo BASE_URL . '?page=cadastrados'; ?>">Limpar</a>
        </div>
    </form>

    <div class="row mt-4">
        <div class="col-12">
            <p class="mb-2">
                <strong><?php echo $total; ?></strong> registro(s) encontrado(s)
                <?php if ($total > 0): ?>
                    — página <?php echo $pagina; ?> de <?php echo $totalPaginas; ?>
                <?php endif; ?>
            </p>

            <div class="table-responsive">
                <table class="table table-striped table-sm align-middle">
                    <thead>
                        <tr>
                            <th>Pulseira</th>
                            <th>Cor</th>
                            <th>Nome</th>
                            <th class="d-none d-md-table-cell">Telefone</th>
                            <th class="d-none d-lg-table-cell">Cidade</th>
                            <th class="d-none d-lg-table-cell">Bairro</th>
                            <th class="d-none d-md-table-cell">Sexo</th>
                            <th class="d-none d-xl-table-cell">Cadastro</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!$lista): ?>
                            <tr>
                                <td colspan="10" class="text-center text-muted py-4">Nenhum cadastro encontrado.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($lista as $row): ?>
                                <?php
                                $status = isset($statusLabels[$row['status']]) ? $statusLabels[$row['status']] : '-';
                                $rowClass = (int) $row['status'] === 4 ? 'table-danger' : '';
                                ?>
                                <tr class="<?php echo $rowClass; ?>">
                                    <td><?php echo htmlspecialchars($row['pulseira'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($row['tpulseira'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td class="text-truncate" style="max-width: 180px;"><?php echo htmlspecialchars($row['fullName'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td class="d-none d-md-table-cell"><?php echo htmlspecialchars($row['telefone'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td class="d-none d-lg-table-cell"><?php echo htmlspecialchars($row['cidade'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td class="d-none d-lg-table-cell"><?php echo htmlspecialchars($row['bairro'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td class="d-none d-md-table-cell"><?php echo htmlspecialchars($row['sexo'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td class="d-none d-xl-table-cell"><small><?php echo htmlspecialchars($row['dtCreate'], ENT_QUOTES, 'UTF-8'); ?></small></td>
                                    <td><?php echo $status; ?></td>
                                    <td class="text-nowrap">
                                        <a href="#" class="js-visitante-foto text-muted me-2" data-visitante-id="<?php echo (int) $row['id']; ?>" title="Ver foto">
                                            <i class="fas fa-camera"></i>
                                        </a>
                                        <?php if ($podeEditar): ?>
                                            <a href="<?php echo BASE_URL . '?page=cadastro_editar&id=' . (int) $row['id']; ?>" title="Editar">
                                                <i class="fas fa-user-edit"></i>
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if ($totalPaginas > 1): ?>
                <nav aria-label="Paginação">
                    <ul class="pagination pagination-sm flex-wrap">
                        <li class="page-item <?php echo $pagina <= 1 ? 'disabled' : ''; ?>">
                            <a class="page-link" href="<?php echo cadastradosUrlPagina($queryBase, max(1, $pagina - 1)); ?>">Anterior</a>
                        </li>
                        <?php
                        $inicio = max(1, $pagina - 2);
                        $fim = min($totalPaginas, $pagina + 2);
                        for ($i = $inicio; $i <= $fim; $i++):
                        ?>
                            <li class="page-item <?php echo $i === $pagina ? 'active' : ''; ?>">
                                <a class="page-link" href="<?php echo cadastradosUrlPagina($queryBase, $i); ?>"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>
                        <li class="page-item <?php echo $pagina >= $totalPaginas ? 'disabled' : ''; ?>">
                            <a class="page-link" href="<?php echo cadastradosUrlPagina($queryBase, min($totalPaginas, $pagina + 1)); ?>">Próxima</a>
                        </li>
                    </ul>
                </nav>
            <?php endif; ?>
        </div>
    </div>
</div>
