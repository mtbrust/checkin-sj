<?php

$user = Seguranca::getSession();
$logado = (int) $user['id'] > 0;

function homeBadgePulseira($tpulseira)
{
    $tp = strtolower(trim((string) $tpulseira));
    if ($tp === 'amarela') {
        return 'home-badge-amarela';
    }
    return 'home-badge-azul';
}

?>

<div class="container my-4 home-page">
    <?php if (!$logado): ?>
        <?php require_once(BASE_DIR . 'src/html/bloco_logins.php'); ?>

        <div class="row mt-4">
            <div class="col-12 text-center">
                <p class="text-muted mb-2">Primeiro acesso?</p>
                <a class="btn btn-outline-primary" href="<?php echo BASE_URL . '?page=equipe'; ?>">Cadastrar na equipe</a>
            </div>
        </div>
    <?php else: ?>
        <?php
        $BdVisitantes = new BdVisitantes();
        $BdPresencas = new BdPresencas();

        $statsCadastro = $BdVisitantes->estatisticasPorUsuario($user['id']);
        $statsPresenca = $BdPresencas->estatisticasPorUsuario($user['id']);
        $ultimosCadastros = $BdVisitantes->ultimosCadastrosPorUsuario($user['id'], 5);
        $ultimasPresencas = $BdPresencas->ultimasPresencasPorUsuario($user['id'], 5);

        $userFoto = MidiaUsuario::urlDoUsuario($user);
        $primeiroNome = explode(' ', trim($user['fullName']))[0];
        $totalAtividades = $statsCadastro['cadastros_total'] + $statsPresenca['presencas_total'];
        $totalHoje = $statsCadastro['cadastros_hoje'] + $statsPresenca['presencas_hoje'];
        ?>

        <div class="d-flex flex-wrap align-items-center gap-3 mb-3">
            <img src="<?php echo htmlspecialchars($userFoto, ENT_QUOTES, 'UTF-8'); ?>" alt="" class="home-user-foto">
            <div>
                <h1 class="h4 mb-1">Olá, <?php echo htmlspecialchars($primeiroNome, ENT_QUOTES, 'UTF-8'); ?>!</h1>
                <p class="text-muted small mb-0">Suas estatísticas no evento</p>
            </div>
        </div>

        <div class="d-flex flex-wrap gap-2 mb-3">
            <a class="btn btn-sm btn-success" href="<?php echo BASE_URL . '?page=cadastro'; ?>">Novo cadastro</a>
            <a class="btn btn-sm btn-primary" href="<?php echo BASE_URL . '?page=presenca'; ?>">Registrar presença</a>
            <a class="btn btn-sm btn-outline-secondary" href="<?php echo BASE_URL . '?page=cadastrados'; ?>">Ver cadastrados</a>
        </div>

        <div class="row g-2 mb-3">
            <div class="col-6 col-md-4 col-lg-3">
                <div class="home-kpi">
                    <span class="home-kpi-label">Cadastros</span>
                    <strong class="home-kpi-valor"><?php echo $statsCadastro['cadastros_total']; ?></strong>
                    <small class="text-muted">Hoje: <?php echo $statsCadastro['cadastros_hoje']; ?></small>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-3">
                <div class="home-kpi">
                    <span class="home-kpi-label">Presenças</span>
                    <strong class="home-kpi-valor"><?php echo $statsPresenca['presencas_total']; ?></strong>
                    <small class="text-muted">Hoje: <?php echo $statsPresenca['presencas_hoje']; ?></small>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-3">
                <div class="home-kpi">
                    <span class="home-kpi-label">Atividades</span>
                    <strong class="home-kpi-valor"><?php echo $totalAtividades; ?></strong>
                    <small class="text-muted">Hoje: <?php echo $totalHoje; ?></small>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-3">
                <div class="home-kpi home-kpi-amarela">
                    <span class="home-kpi-label">Pulseira amarela</span>
                    <strong class="home-kpi-valor"><?php echo $statsCadastro['amarela']; ?></strong>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-3">
                <div class="home-kpi home-kpi-azul">
                    <span class="home-kpi-label">Pulseira azul</span>
                    <strong class="home-kpi-valor"><?php echo $statsCadastro['azul']; ?></strong>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-3">
                <div class="home-kpi">
                    <span class="home-kpi-label">Primeira vez</span>
                    <strong class="home-kpi-valor"><?php echo $statsCadastro['calouros']; ?></strong>
                    <small class="text-muted">Cadastros seus</small>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-3">
                <div class="home-kpi">
                    <span class="home-kpi-label">Interesse no palco</span>
                    <strong class="home-kpi-valor"><?php echo $statsCadastro['palco']; ?></strong>
                    <small class="text-muted">Cadastros seus</small>
                </div>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-12 col-lg-6">
                <div class="home-painel">
                    <h2 class="h6 mb-2">Seus últimos cadastros</h2>
                    <?php if (!$ultimosCadastros): ?>
                        <p class="text-muted small mb-0">Nenhum cadastro registrado por você ainda.</p>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-sm table-striped align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>Pulseira</th>
                                        <th>Nome</th>
                                        <th></th>
                                        <th class="d-none d-md-table-cell">Data</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($ultimosCadastros as $row): ?>
                                        <tr>
                                            <td>
                                                <span class="badge <?php echo homeBadgePulseira($row['tpulseira']); ?>">
                                                    <?php echo htmlspecialchars($row['pulseira'], ENT_QUOTES, 'UTF-8'); ?>
                                                </span>
                                            </td>
                                            <td class="text-truncate" style="max-width: 140px;">
                                                <a href="<?php echo BASE_URL . '?page=cadastro_editar&id=' . (int) $row['id']; ?>">
                                                    <?php echo htmlspecialchars($row['fullName'], ENT_QUOTES, 'UTF-8'); ?>
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <a href="#" class="js-visitante-foto text-muted" data-visitante-id="<?php echo (int) $row['id']; ?>" title="Ver foto">
                                                    <i class="fas fa-camera"></i>
                                                </a>
                                            </td>
                                            <td class="d-none d-md-table-cell"><small><?php echo htmlspecialchars($row['dtCreate'], ENT_QUOTES, 'UTF-8'); ?></small></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="home-painel">
                    <h2 class="h6 mb-2">Suas últimas presenças</h2>
                    <?php if (!$ultimasPresencas): ?>
                        <p class="text-muted small mb-0">Nenhuma presença registrada por você ainda.</p>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-sm table-striped align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>Pulseira</th>
                                        <th>Visitante</th>
                                        <th></th>
                                        <th class="d-none d-md-table-cell">Horário</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($ultimasPresencas as $row): ?>
                                        <tr>
                                            <td>
                                                <span class="badge <?php echo homeBadgePulseira($row['tpulseira']); ?>">
                                                    <?php echo htmlspecialchars($row['pulseira'], ENT_QUOTES, 'UTF-8'); ?>
                                                </span>
                                            </td>
                                            <td class="text-truncate" style="max-width: 140px;">
                                                <?php if (!empty($row['id'])): ?>
                                                    <a href="<?php echo BASE_URL . '?page=cadastro_editar&id=' . (int) $row['id']; ?>">
                                                        <?php echo htmlspecialchars($row['fullName'], ENT_QUOTES, 'UTF-8'); ?>
                                                    </a>
                                                <?php else: ?>
                                                    <span class="text-muted">Não cadastrado</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <?php if (!empty($row['id'])): ?>
                                                    <a href="#" class="js-visitante-foto text-muted" data-visitante-id="<?php echo (int) $row['id']; ?>" title="Ver foto">
                                                        <i class="fas fa-camera"></i>
                                                    </a>
                                                <?php endif; ?>
                                            </td>
                                            <td class="d-none d-md-table-cell"><small><?php echo htmlspecialchars($row['dtCreate'], ENT_QUOTES, 'UTF-8'); ?></small></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<style>
    .home-user-foto {
        width: 52px;
        height: 52px;
        border-radius: 50%;
        object-fit: cover;
        flex-shrink: 0;
    }

    .home-kpi {
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 10px 12px;
        background: #fff;
        height: 100%;
    }

    .home-kpi-label {
        display: block;
        font-size: 0.68rem;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.02em;
        margin-bottom: 2px;
    }

    .home-kpi-valor {
        display: block;
        font-size: 1.35rem;
        line-height: 1.2;
        margin-bottom: 2px;
    }

    .home-kpi small {
        font-size: 0.68rem;
    }

    .home-kpi-amarela {
        border-left: 4px solid #ffc107;
    }

    .home-kpi-azul {
        border-left: 4px solid #0d6efd;
    }

    .home-painel {
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 12px;
        background: #fff;
        height: 100%;
    }

    .home-page .table {
        font-size: 0.78rem;
    }

    .home-badge-amarela {
        background-color: #ffc107;
        color: #212529;
    }

    .home-badge-azul {
        background-color: #0d6efd;
        color: #fff;
    }
</style>
