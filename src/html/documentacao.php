<?php

require_once BASE_DIR . 'src/php/Documentacao.php';

$docAtual = Documentacao::slugValido($_GET['doc'] ?? '') ?: Documentacao::slugPadrao();
$grupos = Documentacao::agrupados();
$tituloAtual = Documentacao::titulo($docAtual);

?>

<div class="container my-4 doc-page">
    <div class="row mb-3">
        <div class="col-12">
            <h1 class="h3 mb-1">Documentação</h1>
            <p class="text-muted small mb-0">Manual de funções e fluxos da Semana Jovem. Selecione um tópico ao lado (ou abaixo no celular).</p>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-12 d-lg-none">
            <label for="doc-select-mobile" class="form-label small text-muted mb-1">Tópico</label>
            <select id="doc-select-mobile" class="form-select form-select-sm">
                <?php foreach ($grupos as $grupo => $itens): ?>
                    <optgroup label="<?php echo htmlspecialchars($grupo, ENT_QUOTES, 'UTF-8'); ?>">
                        <?php foreach ($itens as $slug => $titulo): ?>
                            <option value="<?php echo htmlspecialchars($slug, ENT_QUOTES, 'UTF-8'); ?>" <?php echo $slug === $docAtual ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($titulo, ENT_QUOTES, 'UTF-8'); ?>
                            </option>
                        <?php endforeach; ?>
                    </optgroup>
                <?php endforeach; ?>
            </select>
        </div>

        <aside class="col-lg-3 d-none d-lg-block">
            <nav class="doc-nav sticky-top" aria-label="Tópicos da documentação">
                <?php foreach ($grupos as $grupo => $itens): ?>
                    <div class="doc-nav-grupo"><?php echo htmlspecialchars($grupo, ENT_QUOTES, 'UTF-8'); ?></div>
                    <ul class="list-unstyled doc-nav-lista mb-3">
                        <?php foreach ($itens as $slug => $titulo): ?>
                            <li>
                                <a
                                    href="<?php echo htmlspecialchars(Documentacao::url($slug), ENT_QUOTES, 'UTF-8'); ?>"
                                    class="doc-nav-link<?php echo $slug === $docAtual ? ' active' : ''; ?>"
                                ><?php echo htmlspecialchars($titulo, ENT_QUOTES, 'UTF-8'); ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endforeach; ?>
            </nav>
        </aside>

        <div class="col-lg-9">
            <article class="doc-conteudo card border-0 shadow-sm">
                <div class="card-header bg-white py-3 border-bottom">
                    <h2 class="h5 mb-0"><?php echo htmlspecialchars($tituloAtual, ENT_QUOTES, 'UTF-8'); ?></h2>
                </div>
                <div class="card-body doc-corpo">
                    <?php Documentacao::renderBloco($docAtual); ?>
                </div>
            </article>
        </div>
    </div>
</div>

<style>
    .doc-nav {
        top: 4.5rem;
        max-height: calc(100vh - 5.5rem);
        overflow-y: auto;
        padding-right: 4px;
    }

    .doc-nav-grupo {
        font-size: 0.68rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: #6c757d;
        margin-bottom: 0.35rem;
    }

    .doc-nav-link {
        display: block;
        padding: 0.4rem 0.65rem;
        margin-bottom: 0.15rem;
        border-radius: 6px;
        font-size: 0.88rem;
        color: #212529;
        text-decoration: none;
        border-left: 3px solid transparent;
    }

    .doc-nav-link:hover {
        background: #f8f9fa;
        color: #0d6efd;
    }

    .doc-nav-link.active {
        background: #e7f1ff;
        color: #0d6efd;
        font-weight: 600;
        border-left-color: #0d6efd;
    }

    .doc-corpo {
        font-size: 0.95rem;
        line-height: 1.55;
    }

    .doc-corpo h3 {
        font-size: 1.05rem;
        margin-top: 1.25rem;
        margin-bottom: 0.5rem;
    }

    .doc-corpo h3:first-child {
        margin-top: 0;
    }

    .doc-corpo ul,
    .doc-corpo ol {
        padding-left: 1.25rem;
    }

    .doc-corpo .doc-meta {
        font-size: 0.85rem;
        color: #6c757d;
        margin-bottom: 1rem;
    }

    .doc-corpo .doc-dica {
        border-left: 4px solid #ffc107;
        background: #fff9e6;
        padding: 0.65rem 0.85rem;
        border-radius: 0 6px 6px 0;
        margin: 1rem 0;
        font-size: 0.9rem;
    }

    .doc-corpo .doc-alerta {
        border-left: 4px solid #dc3545;
        background: #fff5f5;
        padding: 0.65rem 0.85rem;
        border-radius: 0 6px 6px 0;
        margin: 1rem 0;
        font-size: 0.9rem;
    }
</style>

<script>
    (function() {
        var sel = document.getElementById('doc-select-mobile');
        if (!sel) return;
        sel.addEventListener('change', function() {
            if (!sel.value) return;
            window.location.href = '<?php echo BASE_URL; ?>?page=documentacao&doc=' + encodeURIComponent(sel.value);
        });
    })();
</script>
