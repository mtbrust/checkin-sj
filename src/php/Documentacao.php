<?php

class Documentacao
{
    private static function itens()
    {
        return [
            'pre-cadastro' => [
                'titulo' => 'Pré-cadastro',
                'grupo' => 'Fluxo de visitante',
            ],
            'assistente-pre-cadastro' => [
                'titulo' => 'Assistente de pré-cadastro',
                'grupo' => 'Fluxo de visitante',
            ],
            'cadastro' => [
                'titulo' => 'Cadastro',
                'grupo' => 'Fluxo de visitante',
            ],
            'assistente-cadastro' => [
                'titulo' => 'Assistente de cadastro',
                'grupo' => 'Fluxo de visitante',
            ],
            'pre-entrada' => [
                'titulo' => 'Pré-entrada',
                'grupo' => 'Fluxo de visitante',
            ],
            'assistente-pre-entrada' => [
                'titulo' => 'Assistente de pré-entrada',
                'grupo' => 'Fluxo de visitante',
            ],
            'entrada-checkin' => [
                'titulo' => 'Entrada (check-in)',
                'grupo' => 'Fluxo de visitante',
            ],
            'organizador' => [
                'titulo' => 'Organizador',
                'grupo' => 'Equipe e funções',
            ],
            'coordenador' => [
                'titulo' => 'Coordenador',
                'grupo' => 'Equipe e funções',
            ],
            'assistente-coordenador' => [
                'titulo' => 'Assistente do coordenador',
                'grupo' => 'Equipe e funções',
            ],
            'facilitador' => [
                'titulo' => 'Facilitador',
                'grupo' => 'Equipe e funções',
            ],
            'mestre-supremo' => [
                'titulo' => 'Mestre supremo',
                'grupo' => 'Equipe e funções',
            ],
        ];
    }

    public static function listar()
    {
        return self::itens();
    }

    public static function slugValido($slug)
    {
        $itens = self::itens();
        return isset($itens[$slug]) ? $slug : null;
    }

    public static function slugPadrao()
    {
        $itens = array_keys(self::itens());
        return $itens ? $itens[0] : '';
    }

    public static function titulo($slug)
    {
        $itens = self::itens();
        return $itens[$slug]['titulo'] ?? 'Documentação';
    }

    public static function agrupados()
    {
        $grupos = [];

        foreach (self::itens() as $slug => $meta) {
            $grupo = $meta['grupo'] ?? 'Geral';
            if (!isset($grupos[$grupo])) {
                $grupos[$grupo] = [];
            }
            $grupos[$grupo][$slug] = $meta['titulo'];
        }

        return $grupos;
    }

    public static function caminhoBloco($slug)
    {
        $slug = self::slugValido($slug);
        if (!$slug) {
            return null;
        }

        $path = BASE_DIR . 'src/html/docs/' . $slug . '.php';

        return is_file($path) ? $path : null;
    }

    public static function renderBloco($slug)
    {
        $path = self::caminhoBloco($slug);

        if (!$path) {
            echo '<div class="alert alert-warning mb-0">Conteúdo ainda não disponível para este tópico.</div>';
            return;
        }

        include $path;
    }

    public static function url($slug = null)
    {
        $url = BASE_URL . '?page=documentacao';
        if ($slug) {
            $url .= '&doc=' . rawurlencode($slug);
        }
        return $url;
    }
}
