<?php

$user = Seguranca::getSession();
$isAdmin = Seguranca::isAdmin($user);
$logado = (int) $user['id'] > 0;

$show = $isAdmin ? '' : 'd-none';

$userFoto = $logado ? MidiaUsuario::urlDoUsuario($user) : '';

$primeiroNome = $logado ? explode(' ', trim($user['fullName']))[0] : '';

?>

<nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top border-bottom header-nav">
    <div class="container-fluid px-2">

        <a class="navbar-brand header-brand mb-0" href="<?php echo BASE_URL; ?>">SJ 2025</a>

        <div class="header-user-mini ms-2">
            <?php if ($logado): ?>
                <img src="<?php echo htmlspecialchars($userFoto, ENT_QUOTES, 'UTF-8'); ?>" alt="" class="header-user-foto">
                <span class="header-user-nome"><?php echo htmlspecialchars($primeiroNome, ENT_QUOTES, 'UTF-8'); ?></span>
            <?php else: ?>
                <a class="header-user-entrar" href="<?php echo BASE_URL; ?>">Entrar</a>
            <?php endif; ?>
        </div>

        <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Abrir menu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo BASE_URL; ?>">Início</a>
                </li>
                <?php if ($logado): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL . '?page=cadastro'; ?>">Cadastro</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL . '?page=presenca'; ?>">Presença</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL . '?page=cadastrados'; ?>">Cadastrados</a>
                    </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo BASE_URL . '?page=equipe'; ?>">Equipe</a>
                </li>
                <li class="nav-item <?php echo $show; ?>">
                    <a class="nav-link" href="<?php echo BASE_URL . '?page=estatisticas'; ?>">Estatísticas</a>
                </li>
                <li class="nav-item <?php echo $show; ?>">
                    <a class="nav-link" href="<?php echo BASE_URL . '?page=config'; ?>">Configurações</a>
                </li>
                <?php if ($logado): ?>
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="<?php echo BASE_URL . '?api=login&acao=sair'; ?>">Sair</a>
                    </li>
                <?php endif; ?>
            </ul>
            <?php if ($logado): ?>
                <form class="d-flex header-search" action="<?php echo BASE_URL . '?page=pesquisa'; ?>" method="GET">
                    <input type="hidden" name="page" value="pesquisa">
                    <input class="form-control form-control-sm me-2" type="search" name="f-pesquisa" placeholder="Buscar..." aria-label="Buscar visitante">
                    <button class="btn btn-sm btn-outline-success" type="submit">OK</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</nav>

<style>
    .header-nav {
        z-index: 1030;
    }

    .header-brand {
        font-size: 1rem;
        font-weight: 700;
        white-space: nowrap;
        padding-top: 0.4rem;
        padding-bottom: 0.4rem;
    }

    .header-user-mini {
        display: flex;
        align-items: center;
        gap: 6px;
        min-width: 0;
        flex: 1;
        overflow: hidden;
    }

    .header-user-foto {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        object-fit: cover;
        flex-shrink: 0;
    }

    .header-user-foto-placeholder {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #dee2e6;
        color: #6c757d;
        font-size: 12px;
    }

    .header-user-nome {
        font-size: 0.85rem;
        font-weight: 600;
        color: #495057;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .header-user-entrar {
        font-size: 0.85rem;
        font-weight: 600;
        color: #0d6efd;
        text-decoration: none;
        white-space: nowrap;
    }

    .header-user-entrar:hover {
        text-decoration: underline;
    }

    .header-nav .navbar-toggler {
        padding: 0.2rem 0.45rem;
    }

    .header-search {
        width: 100%;
    }

    @media (min-width: 992px) {
        .header-user-mini {
            flex: 0 1 auto;
            max-width: 160px;
            margin-left: 1rem !important;
        }

        .header-search {
            max-width: 240px;
        }
    }
</style>
