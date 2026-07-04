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

    public static function capturarBlocoHtml($slug)
    {
        ob_start();
        self::renderBloco($slug);
        return ob_get_clean();
    }

    public static function url($slug = null)
    {
        $url = BASE_URL . '?page=documentacao';
        if ($slug) {
            $url .= '&doc=' . rawurlencode($slug);
        }
        return $url;
    }

    public static function urlPdf($slug = null)
    {
        $url = BASE_URL . '?api=documentacao&acao=pdf';
        if ($slug) {
            $url .= '&doc=' . rawurlencode($slug);
        }
        return $url;
    }

    public static function downloadPdf($slug = null)
    {
        @ini_set('memory_limit', '256M');
        @set_time_limit(120);

        $slug = $slug ? self::slugValido($slug) : null;
        $html = self::montarHtmlPdf($slug);
        $css = self::cssPdf();

        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'margin_top' => 16,
            'margin_bottom' => 16,
            'margin_header' => 8,
            'margin_footer' => 8,
            'tempDir' => self::dirTempMpdf(),
        ]);

        if ($slug) {
            $mpdf->SetTitle('Documentação — ' . self::titulo($slug));
            $nome = 'documentacao-' . $slug . '.pdf';
        } else {
            $mpdf->SetTitle('Manual de documentação — Check-In SJ');
            $nome = 'documentacao-manual-completo.pdf';
        }

        $mpdf->SetHTMLFooter(
            '<div style="font-size:8pt;color:#888;text-align:center;border-top:1px solid #ddd;padding-top:4px;">'
            . 'Check-In SJ · Documentação · Página {PAGENO} / {nbpg}</div>'
        );

        $mpdf->WriteHTML($css, \Mpdf\HTMLParserMode::HEADER_CSS);
        $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);
        $mpdf->Output($nome, 'D');
        exit;
    }

    private static function dirTempMpdf()
    {
        $candidatos = [
            BASE_DIR . 'data/tmp/mpdf/',
            rtrim(sys_get_temp_dir(), '/\\') . DIRECTORY_SEPARATOR . 'checkin-js-mpdf' . DIRECTORY_SEPARATOR,
        ];

        foreach ($candidatos as $dir) {
            if (SiteConfig::garantirDirGravavel($dir)) {
                return $dir;
            }
        }

        throw new RuntimeException('Diretório temporário do PDF indisponível.');
    }

    private static function montarHtmlPdf($slugUnico = null)
    {
        $ev = class_exists('RelatorioGeral') ? RelatorioGeral::infoEvento() : [];
        $h = function ($val) {
            return htmlspecialchars((string) $val, ENT_QUOTES, 'UTF-8');
        };

        $html = '<h1 style="font-size:16pt;margin:0 0 4px 0;">Documentação — Check-In SJ</h1>';
        if (!empty($ev['nome'])) {
            $html .= '<p style="font-size:9pt;color:#555;margin:0 0 12px 0;">'
                . $h($ev['nome']) . ' · ' . $h($ev['instituicao'] ?? '') . '<br>'
                . 'Gerado em: ' . date('d/m/Y H:i') . '</p>';
        } else {
            $html .= '<p style="font-size:9pt;color:#555;margin:0 0 12px 0;">Gerado em: ' . date('d/m/Y H:i') . '</p>';
        }

        if ($slugUnico) {
            $html .= self::secaoPdf($slugUnico);
            return $html;
        }

        foreach (self::agrupados() as $grupo => $itens) {
            $html .= '<h2 style="font-size:12pt;color:#0d6efd;margin:16px 0 8px 0;border-bottom:1px solid #dee2e6;padding-bottom:4px;">'
                . $h($grupo) . '</h2>';

            foreach (array_keys($itens) as $slug) {
                $html .= self::secaoPdf($slug);
            }
        }

        return $html;
    }

    private static function secaoPdf($slug)
    {
        $h = function ($val) {
            return htmlspecialchars((string) $val, ENT_QUOTES, 'UTF-8');
        };

        $corpo = self::capturarBlocoHtml($slug);

        return '<div style="margin-bottom:14px;page-break-inside:avoid;">'
            . '<h2 style="font-size:11pt;margin:0 0 6px 0;">' . $h(self::titulo($slug)) . '</h2>'
            . '<div class="doc-pdf-corpo">' . $corpo . '</div>'
            . '</div>';
    }

    private static function cssPdf()
    {
        return '
            body { font-family: sans-serif; font-size: 9.5pt; color: #222; line-height: 1.45; }
            .doc-pdf-corpo h3 { font-size: 10pt; margin: 10px 0 4px 0; }
            .doc-pdf-corpo h4 { font-size: 9.5pt; margin: 8px 0 4px 0; }
            .doc-pdf-corpo ul, .doc-pdf-corpo ol { padding-left: 16px; margin: 4px 0 8px 0; }
            .doc-pdf-corpo p { margin: 0 0 6px 0; }
            .doc-pdf-corpo .doc-meta { font-size: 8.5pt; color: #666; margin-bottom: 8px; }
            .doc-pdf-corpo .doc-dica { border-left: 3px solid #ffc107; background: #fff9e6; padding: 6px 8px; margin: 8px 0; font-size: 9pt; }
            .doc-pdf-corpo .doc-alerta { border-left: 3px solid #dc3545; background: #fff5f5; padding: 6px 8px; margin: 8px 0; font-size: 9pt; }
            .doc-pdf-corpo table { width: 100%; border-collapse: collapse; font-size: 8.5pt; margin: 6px 0; }
            .doc-pdf-corpo table th, .doc-pdf-corpo table td { border: 1px solid #ccc; padding: 4px 5px; vertical-align: top; }
            .doc-pdf-corpo table th { background: #f5f5f5; }
            .doc-pdf-corpo pre { background: #f8f9fa; padding: 6px 8px; font-size: 8pt; border: 1px solid #e9ecef; white-space: pre-wrap; }
            .doc-pdf-corpo code { font-size: 8.5pt; }
        ';
    }
}
