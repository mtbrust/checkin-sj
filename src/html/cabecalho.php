<?php

$user = Seguranca::getSession();
$ids = Seguranca::getIdsAdmins();

$show = 'd-none';

if (in_array($user['id'], $ids)) {
  $show = '';
}

?>

<nav class="navbar navbar-expand-lg bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="<?php echo BASE_URL . '?page=home'; ?>">SJ 2024</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="<?php echo BASE_URL . '?page=home'; ?>">Início</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo BASE_URL . '?page=cadastro'; ?>">Cadastro</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo BASE_URL . '?page=presenca'; ?>">Presença</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo BASE_URL . '?page=equipe'; ?>">Equipe</a>
        </li>
        <li class="nav-item <?php echo $show; ?>">
          <a class="nav-link" href="<?php echo BASE_URL . '?page=estatisticas'; ?>">Estatísticas</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo BASE_URL . '?api=login&acao=sair'; ?>">Sair</a>
        </li>
        <li class="nav-item <?php echo $user['id'] == 1?'':'d-none'; ?>">
          <a class="nav-link" href="<?php echo BASE_URL . '?page=config'; ?>">Configurações</a>
        </li>
      </ul>
      <form class="d-flex" action="<?php echo BASE_URL . '?page=pesquisa'; ?>" method="GET">
        <input type="text" hidden name="page" value="pesquisa">
        <input class="form-control me-2" type="search" name="f-pesquisa" placeholder="" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Pesquisar</button>
      </form>
    </div>
  </div>
</nav>