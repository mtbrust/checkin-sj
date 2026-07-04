<?php

/**
 * Layout opcional para blocos em src/html/docs/*.php
 * Variáveis: $docResumo, $docSecoes (array de ['titulo' => '', 'html' => ''])
 */
if (!isset($docResumo)) {
    $docResumo = '';
}
if (!isset($docSecoes) || !is_array($docSecoes)) {
    $docSecoes = [];
}

if ($docResumo !== '') {
    echo '<p class="doc-meta">' . htmlspecialchars($docResumo, ENT_QUOTES, 'UTF-8') . '</p>';
}

foreach ($docSecoes as $secao) {
    $titulo = $secao['titulo'] ?? '';
    $html = $secao['html'] ?? '';

    if ($titulo !== '') {
        echo '<h3>' . htmlspecialchars($titulo, ENT_QUOTES, 'UTF-8') . '</h3>';
    }
    echo $html;
}
