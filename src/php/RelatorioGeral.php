<?php

class RelatorioGeral
{
    public static function infoEvento()
    {
        return [
            'nome' => 'Semana Jovem 2026',
            'periodo' => '20 a 25 de Julho',
            'tema' => 'Justiça quem é o juiz?',
            'edicao' => '13º evento',
            'instagram_evento' => '@semanajovemgetup',
            'instagram_evento_url' => 'https://www.instagram.com/semanajovemgetup/',
            'instituicao' => 'Juventude GetUp',
            'instagram_instituicao' => '@juventude_getup',
            'instagram_instituicao_url' => 'https://www.instagram.com/juventude_getup/',
        ];
    }

    public static function infoCreditos()
    {
        return [
            'voluntario' => 'Mateus Brust',
            'lider' => 'Prebítero Mário Augusto da Costa',
            'parceira' => [
                'nome' => 'desV.',
                'razao_social' => 'DESV Desenvolvimento LTDA',
                'cnpj' => '33.322.210/0001-55',
                'site' => 'https://desv.com.br/',
                'email' => 'contato@desv.com.br',
                'telefone' => '(35) 99709-7670',
                'whatsapp' => 'https://wa.me/5535997097670',
                'tagline' => 'Soluções completas em tecnologia para empresas',
                'logo' => 'src/midia/desv-logo.png',
            ],
        ];
    }

    public static function coletarDados()
    {
        $bdVisitantes = new BdVisitantes();
        $bdPresencas = new BdPresencas();
        $bdLogins = new BdLogins();
        $hoje = date('Y-m-d');
        $resumo = $bdVisitantes->estatisticasResumo();

        $cadastrosDiarios = $bdVisitantes->cadastrosDiarios() ?: [];
        $presencasDiarias = $bdPresencas->visitasDiarias() ?: [];

        $mapaCadastros = [];
        foreach ($cadastrosDiarios as $row) {
            $mapaCadastros[$row['data']] = (int) ($row['qtd'] ?? 0);
        }

        $mapaPresencas = [];
        foreach ($presencasDiarias as $row) {
            $mapaPresencas[$row['data']] = (int) ($row['qtd'] ?? 0);
        }

        $datas = array_unique(array_merge(array_keys($mapaCadastros), array_keys($mapaPresencas)));
        sort($datas);

        $porDia = [];
        foreach ($datas as $data) {
            $porDia[] = [
                'data' => $data,
                'cadastros' => $mapaCadastros[$data] ?? 0,
                'presencas' => $mapaPresencas[$data] ?? 0,
            ];
        }

        return [
            'gerado_em' => date('d/m/Y H:i'),
            'evento' => self::infoEvento(),
            'subtitulo' => 'Relatório geral de cadastros e presenças',
            'resumo' => [
                'cadastros_total' => (int) ($bdVisitantes->qtdCadastrosPulseira() ?: 0),
                'cadastros_hoje' => (int) ($bdVisitantes->qtdCadastrosPulseiraDia($hoje) ?: 0),
                'presencas_total' => (int) ($bdPresencas->qtdpresencaspulseiras() ?: 0),
                'presencas_hoje' => (int) ($bdPresencas->qtdpresencaspulseirasDia($hoje) ?: 0),
                'duplicados' => (int) ($bdVisitantes->qtdCadastrosDuplicados() ?: 0),
                'sem_cadastro' => (int) ($bdPresencas->qtdPulseirasSemCadastro() ?: 0),
                'sem_cadastro_hoje' => (int) ($bdPresencas->qtdPulseirasSemCadastroDia($hoje) ?: 0),
                'equipe' => (int) ($bdLogins->count() ?: 0),
                'registros' => (int) ($resumo['registros'] ?? 0),
                'visitantes' => (int) ($resumo['visitantes'] ?? 0),
                'amarela' => (int) ($resumo['amarela'] ?? 0),
                'azul' => (int) ($resumo['azul'] ?? 0),
                'calouros' => (int) ($resumo['calouros'] ?? 0),
                'palco' => (int) ($resumo['palco'] ?? 0),
                'atualizar' => (int) ($resumo['atualizar'] ?? 0),
                'atencao' => (int) ($resumo['atencao'] ?? 0),
                'bloqueado' => (int) ($resumo['bloqueado'] ?? 0),
            ],
            'por_dia' => $porDia,
            'cadastros_diarios' => $cadastrosDiarios,
            'presencas_diarias' => $presencasDiarias,
            'visitantes' => $bdVisitantes->listarRelatorioCompleto(),
            'equipe_usuarios' => self::carregarEquipe($bdLogins),
        ];
    }

    private static function carregarEquipe(BdLogins $bd)
    {
        $lista = $bd->selectAll(500) ?: [];
        $out = [];

        foreach ($lista as $user) {
            if ((int) ($user['idStatus'] ?? 1) === 2) {
                continue;
            }
            $out[] = $user;
        }

        usort($out, function ($a, $b) {
            return strcasecmp((string) ($a['fullName'] ?? ''), (string) ($b['fullName'] ?? ''));
        });

        return $out;
    }

    private static function dirTempMpdf()
    {
        $dir = BASE_DIR . 'data/tmp/mpdf/';

        if (!is_dir($dir) && !mkdir($dir, 0755, true) && !is_dir($dir)) {
            throw new RuntimeException('Não foi possível criar o diretório temporário do PDF.');
        }

        if (!is_writable($dir)) {
            throw new RuntimeException('Diretório temporário do PDF sem permissão de escrita: ' . $dir);
        }

        return $dir;
    }

    public static function downloadPdf()
    {
        $dados = self::coletarDados();
        $html = self::montarHtmlPdf($dados);
        $css = self::cssPdf();

        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'margin_top' => 6,
            'margin_bottom' => 38,
            'margin_header' => 6,
            'margin_footer' => 6,
            'setAutoTopMargin' => 'pad',
            'tempDir' => self::dirTempMpdf(),
        ]);

        $ev = $dados['evento'];
        $mpdf->SetTitle('Relatório Geral — ' . ($ev['nome'] ?? BASE_NAME));
        $mpdf->SetHTMLHeader(self::cabecalhoPdf($dados));
        $mpdf->SetHTMLFooter(self::rodapePdf($dados));
        $mpdf->WriteHTML($css, \Mpdf\HTMLParserMode::HEADER_CSS);
        $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);

        $nome = 'relatorio-geral-' . date('Y-m-d-His') . '.pdf';
        $mpdf->Output($nome, 'D');
        exit;
    }

    public static function downloadCsv()
    {
        $dados = self::coletarDados();
        $nome = 'relatorio-geral-' . date('Y-m-d-His') . '.csv';

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $nome . '"');
        header('Cache-Control: no-store, no-cache, must-revalidate');
        header('Pragma: no-cache');

        $out = fopen('php://output', 'w');
        fprintf($out, chr(0xEF) . chr(0xBB) . chr(0xBF));

        fputcsv($out, self::cabecalhoCsv(), ';');

        foreach ($dados['visitantes'] as $row) {
            fputcsv($out, self::linhaCsv($row), ';');
        }

        fclose($out);
        exit;
    }

    private static function cabecalhoPdf($dados)
    {
        $ev = $dados['evento'];
        $h = function ($val) {
            return htmlspecialchars((string) $val, ENT_QUOTES, 'UTF-8');
        };

        return '
            <table width="100%" style="border-bottom:1px solid #ccc;font-size:8pt;line-height:1.35;">
                <tr>
                    <td width="72%" valign="top">
                        <strong style="font-size:12pt;">' . $h($ev['nome']) . '</strong>
                        <span style="color:#444;"> — ' . $h($ev['periodo']) . '</span><br>
                        <span style="color:#333;"><strong>Tema:</strong> &quot;' . $h($ev['tema']) . '&quot;</span>
                        <span style="color:#666;"> · ' . $h($ev['edicao']) . '</span><br>
                        <span style="color:#555;">
                            Instagram evento:
                            <a href="' . $h($ev['instagram_evento_url']) . '">' . $h($ev['instagram_evento']) . '</a>
                        </span><br>
                        <span style="color:#555;">
                            <strong>' . $h($ev['instituicao']) . '</strong>
                            · Instagram:
                            <a href="' . $h($ev['instagram_instituicao_url']) . '">' . $h($ev['instagram_instituicao']) . '</a>
                        </span>
                    </td>
                    <td width="28%" align="right" valign="top" style="color:#666;font-size:7.5pt;">
                        ' . $h($dados['subtitulo']) . '<br>
                        Gerado em: ' . $h($dados['gerado_em']) . '
                    </td>
                </tr>
            </table>';
    }

    private static function rodapePdf($dados)
    {
        $ev = $dados['evento'];
        $cr = self::infoCreditos();
        $par = $cr['parceira'];
        $h = function ($val) {
            return htmlspecialchars((string) $val, ENT_QUOTES, 'UTF-8');
        };

        $logoPath = SiteConfig::projectDir() . ($par['logo'] ?? '');
        $logoHtml = '';
        if (is_file($logoPath)) {
            $logoHtml = '<img src="' . $h($logoPath) . '" alt="' . $h($par['nome']) . '" width="48" style="vertical-align:middle;" />';
        }

        return '
            <table width="100%" style="font-size:6.5pt;color:#666;border-top:1px solid #ddd;line-height:1.35;">
                <tr>
                    <td style="padding:2px 0;">
                        ' . $h($ev['nome']) . ' · ' . $h($ev['instituicao']) . ' · ' . $h($ev['instagram_evento']) . '
                    </td>
                    <td align="right" style="white-space:nowrap;padding:2px 0;">Página {PAGENO} / {nbpg}</td>
                </tr>
                <tr>
                    <td colspan="2" style="padding:3px 0;border-top:1px solid #eee;">
                        <strong>Voluntário:</strong> ' . $h($cr['voluntario']) . '
                        &nbsp;·&nbsp;
                        <strong>Líder:</strong> ' . $h($cr['lider']) . '
                    </td>
                </tr>
                <tr>
                    <td width="52" valign="middle" style="padding:3px 0;border-top:1px solid #eee;">' . $logoHtml . '</td>
                    <td valign="middle" style="padding:3px 0 2px 6px;border-top:1px solid #eee;">
                        <strong>Empresa parceira:</strong>
                        <a href="' . $h($par['site']) . '">' . $h($par['nome']) . '</a>
                        — ' . $h($par['tagline']) . '<br>
                        <span style="color:#888;">' . $h($par['razao_social']) . ' · CNPJ ' . $h($par['cnpj']) . '</span><br>
                        <a href="mailto:' . $h($par['email']) . '">' . $h($par['email']) . '</a>
                        · <a href="' . $h($par['whatsapp']) . '">' . $h($par['telefone']) . '</a>
                        · <a href="' . $h($par['site']) . '">desv.com.br</a>
                    </td>
                </tr>
            </table>';
    }

    private static function cssPdf()
    {
        return '
            body { font-family: sans-serif; font-size: 9pt; color: #222; }
            h2 { font-size: 11pt; margin: 0 0 6px 0; }
            .tbl-dia { width: 100%; border-collapse: collapse; font-size: 8pt; margin-bottom: 8px; }
            .tbl-dia th, .tbl-dia td { border: 1px solid #ddd; padding: 3px 5px; }
            .tbl-dia th { background: #f5f5f5; }
            .tbl-vis { width: 100%; border-collapse: collapse; font-size: 6.5pt; }
            .tbl-vis th, .tbl-vis td { border: 1px solid #ddd; padding: 1px 3px; vertical-align: middle; }
            .tbl-vis th { background: #f0f0f0; font-size: 6pt; }
            .legenda { width: 100%; border-collapse: collapse; font-size: 6.5pt; margin-bottom: 6px; }
            .legenda td { border: 1px solid #e9ecef; padding: 4px 5px; vertical-align: top; background: #fafafa; }
            .legenda-tit { font-size: 6pt; font-weight: bold; color: #555; text-transform: uppercase; margin-bottom: 3px; }
            .equipe-card { border: 1px solid #e9ecef; background: #fafafa; }
            .equipe-nome { font-size: 6.5pt; font-weight: bold; line-height: 1.2; }
            .equipe-info { font-size: 5.5pt; color: #666; line-height: 1.2; }
            .st { display: inline-block; padding: 1px 3px; border-radius: 2px; font-size: 5.5pt; font-weight: bold; color: #fff; }
            .st-1 { background: #198754; }
            .st-2 { background: #fd7e14; }
            .st-3 { background: #ffc107; color: #333; }
            .st-4 { background: #dc3545; }
            .pb { display: inline-block; min-width: 22px; text-align: center; padding: 1px 3px; border-radius: 2px; font-weight: bold; font-size: 6pt; color: #fff; }
            .pb-am { background: #ffc107; color: #333; }
            .pb-az { background: #0d6efd; }
            .ic { display: inline-block; min-width: 10px; text-align: center; font-size: 5.5pt; font-weight: bold; border-radius: 2px; margin-right: 1px; padding: 0 2px; }
            .ic-p { background: #6f42c1; color: #fff; }
            .ic-c { background: #20c997; color: #fff; }
            .ic-w { background: #25d366; color: #fff; }
            .sx { display: inline-block; min-width: 10px; text-align: center; font-size: 5.5pt; font-weight: bold; border-radius: 2px; padding: 0 2px; }
            .sx-m { background: #0d6efd; color: #fff; }
            .sx-f { background: #d63384; color: #fff; }
            .nome { font-weight: bold; font-size: 6.5pt; }
            .subinfo { font-size: 5.5pt; color: #666; line-height: 1.2; }
            .dias { text-align: center; font-weight: bold; }
            a { color: #0d6efd; text-decoration: none; font-size: 6.5pt; }
        ';
    }

    private static function celulaKpi($label, $valor, $sub = '', $acento = '')
    {
        $h = function ($val) {
            return htmlspecialchars((string) $val, ENT_QUOTES, 'UTF-8');
        };

        $borda = 'border:1px solid #e9ecef;';
        if ($acento === 'amarela') {
            $borda .= 'border-left:3px solid #ffc107;';
        } elseif ($acento === 'azul') {
            $borda .= 'border-left:3px solid #0d6efd;';
        } elseif ($acento === 'alerta') {
            $borda .= 'border-left:3px solid #ffc107;';
        } elseif ($acento === 'perigo') {
            $borda .= 'border-left:3px solid #dc3545;';
        }

        $subHtml = $sub !== ''
            ? '<tr><td align="center" style="font-size:7pt;color:#888;padding:0 4px 6px 4px;">' . $h($sub) . '</td></tr>'
            : '<tr><td style="font-size:7pt;padding-bottom:4px;">&nbsp;</td></tr>';

        return '<td width="25%" style="padding:2px;vertical-align:top;">'
            . '<table width="100%" style="' . $borda . 'background:#fff;">'
            . '<tr><td align="center" style="font-size:6.5pt;color:#6c757d;text-transform:uppercase;padding:6px 4px 2px 4px;">' . $h($label) . '</td></tr>'
            . '<tr><td align="center" style="font-size:15pt;font-weight:bold;color:#212529;padding:2px 4px;line-height:1.1;">' . $h($valor) . '</td></tr>'
            . $subHtml
            . '</table></td>';
    }

    private static function linhaKpis(array $kpis)
    {
        $html = '<tr>';
        $col = 0;
        foreach ($kpis as $kpi) {
            $html .= self::celulaKpi($kpi[0], $kpi[1], $kpi[2] ?? '', $kpi[3] ?? '');
            $col++;
        }
        while ($col % 4 !== 0) {
            $html .= '<td width="25%"></td>';
            $col++;
        }
        $html .= '</tr>';
        return $html;
    }

    private static function painelDiasHtml($titulo, $itens)
    {
        $h = function ($val) {
            return htmlspecialchars((string) $val, ENT_QUOTES, 'UTF-8');
        };

        $html = '<td width="50%" valign="top" style="padding:2px;">';
        $html .= '<table width="100%" style="border:1px solid #e9ecef;background:#fff;">';
        $html .= '<tr><td style="padding:6px 8px;font-size:9pt;font-weight:bold;border-bottom:1px solid #eee;">' . $h($titulo) . '</td></tr>';
        $html .= '<tr><td style="padding:6px 4px;">';

        if (!$itens) {
            $html .= '<table width="100%"><tr><td align="center" style="font-size:8pt;color:#888;padding:8px;">Sem dados</td></tr></table>';
        } else {
            $html .= '<table width="100%">';
            $col = 0;
            $html .= '<tr>';
            foreach ($itens as $item) {
                if ($col > 0 && $col % 4 === 0) {
                    $html .= '</tr><tr>';
                }
                $dataFmt = !empty($item['data']) ? date('d/m', strtotime($item['data'])) : ('Dia ' . (int) ($item['dia'] ?? 0));
                $html .= '<td width="25%" style="padding:2px;" valign="top">';
                $html .= '<table width="100%" style="border:1px solid #eee;background:#fafafa;">';
                $html .= '<tr><td align="center" style="font-size:6.5pt;color:#888;padding:4px 2px 0;">' . $h($dataFmt) . '</td></tr>';
                $html .= '<tr><td align="center" style="font-size:12pt;font-weight:bold;padding:0 2px 5px;">' . (int) ($item['qtd'] ?? 0) . '</td></tr>';
                $html .= '</table></td>';
                $col++;
            }
            while ($col % 4 !== 0) {
                $html .= '<td width="25%"></td>';
                $col++;
            }
            $html .= '</tr></table>';
        }

        $html .= '</td></tr></table></td>';
        return $html;
    }

    private static function montarHtmlPdf($dados)
    {
        $r = $dados['resumo'];
        $html = '<h2>Estatísticas gerais</h2>';
        $html .= '<table width="100%" cellspacing="0" cellpadding="0" style="margin-bottom:8px;">';

        $html .= self::linhaKpis([
            ['Cadastros (total)', $r['cadastros_total'], 'Hoje: ' . $r['cadastros_hoje'], ''],
            ['Presenças (total)', $r['presencas_total'], 'Hoje: ' . $r['presencas_hoje'], ''],
            ['Visitantes únicos', $r['visitantes'], 'Registros: ' . $r['registros'], ''],
            ['Equipe', $r['equipe'], 'Voluntários', ''],
        ]);

        $html .= self::linhaKpis([
            ['Pulseira amarela', $r['amarela'], '', 'amarela'],
            ['Pulseira azul', $r['azul'], '', 'azul'],
            ['Primeira vez', $r['calouros'], '', ''],
            ['Interesse palco', $r['palco'], '', ''],
        ]);

        $html .= self::linhaKpis([
            ['Atenção / Atualizar', $r['atencao'] . ' / ' . $r['atualizar'], '', 'alerta'],
            ['Bloqueados', $r['bloqueado'], '', 'perigo'],
            ['Duplicados', $r['duplicados'], '', 'perigo'],
            ['Sem cadastro', $r['sem_cadastro'], 'Hoje: ' . $r['sem_cadastro_hoje'], 'perigo'],
        ]);

        $html .= '</table>';

        $html .= '<table width="100%" cellspacing="0" cellpadding="0" style="margin-bottom:10px;"><tr>';
        $html .= self::painelDiasHtml('Cadastros por dia', $dados['cadastros_diarios'] ?? []);
        $html .= self::painelDiasHtml('Presenças por dia', $dados['presencas_diarias'] ?? []);
        $html .= '</tr></table>';

        $html .= self::painelEquipeHtml($dados['equipe_usuarios'] ?? []);

        $html .= '<pagebreak sheet-size="A4-L" />';
        $html .= '<h2>Visitantes (' . count($dados['visitantes']) . ')</h2>';
        $html .= self::legendaVisitantesPdf();
        $html .= '<table class="tbl-vis"><thead><tr>';
        $html .= '<th width="5%">St</th><th width="4%">Sx</th><th width="6%">Pls</th><th width="18%">Nome</th>';
        $html .= '<th width="9%">Nasc.</th><th width="11%">Telefone</th><th width="4%">D</th><th width="7%">Fl</th>';
        $html .= '<th width="18%">Igreja</th><th width="10%">Bairro</th><th width="8%">Cidade</th>';
        $html .= '</tr></thead><tbody>';

        foreach ($dados['visitantes'] as $v) {
            $html .= self::linhaVisitantePdf($v);
        }

        $html .= '</tbody></table>';

        return $html;
    }

    private static function painelEquipeHtml($usuarios)
    {
        $h = function ($val) {
            return htmlspecialchars((string) $val, ENT_QUOTES, 'UTF-8');
        };

        if (!$usuarios) {
            return '';
        }

        $colsPorLinha = 6;
        $largura = (int) floor(100 / $colsPorLinha);

        $html = '<h2 style="margin-top:8px;">Equipe / Voluntários (' . count($usuarios) . ')</h2>';
        $html .= '<table width="100%" cellspacing="0" cellpadding="0" style="margin-bottom:8px;">';
        $col = 0;
        $html .= '<tr>';

        foreach ($usuarios as $user) {
            if ($col > 0 && $col % $colsPorLinha === 0) {
                $html .= '</tr><tr>';
            }

            $fotoSrc = self::srcFotoUsuarioPdf($user);
            $nome = trim((string) ($user['fullName'] ?? '')) ?: '-';
            $tel = self::formatarTelefone(trim((string) ($user['telefone'] ?? '')));
            $userName = trim((string) ($user['userName'] ?? ''));

            $fotoHtml = $fotoSrc !== ''
                ? '<img src="' . $h($fotoSrc) . '" width="40" height="40" style="border-radius:50%;object-fit:cover;border:1px solid #dee2e6;" />'
                : '';

            $html .= '<td width="' . $largura . '%" valign="top" style="padding:2px;">';
            $html .= '<table width="100%" class="equipe-card"><tr>';
            $html .= '<td align="center" style="padding:5px 4px 2px;">' . $fotoHtml . '</td></tr>';
            $html .= '<tr><td align="center" class="equipe-nome" style="padding:0 3px 2px;">' . $h($nome) . '</td></tr>';

            if ($userName !== '') {
                $html .= '<tr><td align="center" class="equipe-info" style="padding:0 3px 1px;">@' . $h($userName) . '</td></tr>';
            }
            if ($tel !== '') {
                $html .= '<tr><td align="center" class="equipe-info" style="padding:0 3px 4px;">' . $h($tel) . '</td></tr>';
            } else {
                $html .= '<tr><td style="padding-bottom:4px;">&nbsp;</td></tr>';
            }

            $html .= '</table></td>';
            $col++;
        }

        while ($col % $colsPorLinha !== 0) {
            $html .= '<td width="' . $largura . '%"></td>';
            $col++;
        }

        $html .= '</tr></table>';

        return $html;
    }

    private static function srcFotoUsuarioPdf($user)
    {
        $src = MidiaUsuario::caminhoAbsolutoDoUsuario($user);
        if ($src === '') {
            return '';
        }
        if (strpos($src, 'data:') === 0) {
            return $src;
        }
        return str_replace('\\', '/', $src);
    }

    private static function legendaVisitantesPdf()
    {
        return '
            <table class="legenda" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="25%">
                        <div class="legenda-tit">Status (St)</div>
                        <span class="st st-1">OK</span> Cadastro regular &nbsp;
                        <span class="st st-2">AT</span> Atualizar &nbsp;
                        <span class="st st-3">A</span> Atenção &nbsp;
                        <span class="st st-4">BL</span> Bloqueado
                    </td>
                    <td width="25%">
                        <div class="legenda-tit">Pulseira (Pls)</div>
                        <span class="pb pb-am">123</span> Amarela &nbsp;
                        <span class="pb pb-az">123</span> Azul
                        <div class="legenda-tit" style="margin-top:4px;">Sexo (Sx)</div>
                        <span class="sx sx-m">M</span> Homem &nbsp;
                        <span class="sx sx-f">F</span> Mulher
                    </td>
                    <td width="25%">
                        <div class="legenda-tit">Flags (Fl)</div>
                        <span class="ic ic-p">P</span> Interesse no palco &nbsp;
                        <span class="ic ic-c">1</span> Primeira vez no evento &nbsp;
                        <span class="ic ic-w">W</span> WhatsApp
                    </td>
                    <td width="25%">
                        <div class="legenda-tit">Colunas</div>
                        <strong>D</strong> = dias com presença registrada<br>
                        <strong>Nasc.</strong> = data de nascimento e idade na mesma linha<br>
                        Telefone com link para WhatsApp quando houver número
                    </td>
                </tr>
            </table>';
    }

    private static function linhaVisitantePdf($v)
    {
        $status = (int) ($v['status'] ?? 1);
        $st = self::rotuloStatus($status);
        $cor = strtoupper((string) ($v['tpulseira'] ?? ''));
        $clsPb = $cor === 'AZUL' ? 'pb-az' : 'pb-am';
        $nome = htmlspecialchars($v['fullName'] ?? '-', ENT_QUOTES, 'UTF-8');
        $telRaw = trim((string) ($v['telefone'] ?? ''));
        $telFmt = self::formatarTelefone($telRaw);
        $wa = self::linkWhatsapp($telRaw);
        $telHtml = $telFmt !== ''
            ? '<a href="' . htmlspecialchars($wa, ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($telFmt, ENT_QUOTES, 'UTF-8') . '</a>'
            : '-';
        $dias = (int) ($v['qtdDiasPresenca'] ?? 0);
        $flags = self::iconesFlags($v);
        $sexo = self::htmlSexo($v['sexo'] ?? '');
        $nascHtml = self::htmlNascimentoIdade($v['nascimento'] ?? '');

        $igreja = htmlspecialchars(trim((string) ($v['religiao'] ?? '')) ?: '-', ENT_QUOTES, 'UTF-8');
        $bairro = htmlspecialchars(trim((string) ($v['bairro'] ?? '')) ?: '-', ENT_QUOTES, 'UTF-8');
        $cidade = htmlspecialchars(trim((string) ($v['cidade'] ?? '')) ?: '-', ENT_QUOTES, 'UTF-8');

        return '<tr>'
            . '<td align="center"><span class="st st-' . $status . '">' . $st . '</span></td>'
            . '<td align="center">' . $sexo . '</td>'
            . '<td align="center"><span class="pb ' . $clsPb . '">' . (int) ($v['pulseira'] ?? 0) . '</span></td>'
            . '<td class="nome">' . $nome . '</td>'
            . '<td align="center">' . $nascHtml . '</td>'
            . '<td>' . $telHtml . '</td>'
            . '<td class="dias">' . $dias . '</td>'
            . '<td align="center">' . $flags . '</td>'
            . '<td>' . $igreja . '</td>'
            . '<td>' . $bairro . '</td>'
            . '<td>' . $cidade . '</td>'
            . '</tr>';
    }

    private static function htmlSexo($sexo)
    {
        $sx = strtoupper(trim((string) $sexo));
        if ($sx === 'M') {
            return '<span class="sx sx-m" title="Homem">M</span>';
        }
        if ($sx === 'F') {
            return '<span class="sx sx-f" title="Mulher">F</span>';
        }
        return '-';
    }

    private static function htmlNascimentoIdade($nascimento)
    {
        if (!$nascimento || $nascimento === '0000-00-00') {
            return '-';
        }

        $ts = strtotime($nascimento);
        if (!$ts) {
            return '-';
        }

        $idade = self::calcularIdade($nascimento);
        $data = date('d/m/y', $ts);
        $idadeTxt = $idade !== null ? $idade . 'a' : '';

        if ($idadeTxt !== '') {
            return htmlspecialchars($data . ' · ' . $idadeTxt, ENT_QUOTES, 'UTF-8');
        }

        return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    }

    private static function calcularIdade($nascimento)
    {
        if (!$nascimento || $nascimento === '0000-00-00') {
            return null;
        }

        try {
            $dt = new DateTime($nascimento);
            $hoje = new DateTime('today');
            if ($dt > $hoje) {
                return null;
            }
            return (int) $dt->diff($hoje)->y;
        } catch (Exception $e) {
            return null;
        }
    }

    public static function formatarTelefone($telefone)
    {
        $d = preg_replace('/\D+/', '', (string) $telefone);
        if ($d === '') {
            return '';
        }

        if (strlen($d) === 11) {
            return sprintf('(%s) %s-%s', substr($d, 0, 2), substr($d, 2, 5), substr($d, 7, 4));
        }

        if (strlen($d) === 10) {
            return sprintf('(%s) %s-%s', substr($d, 0, 2), substr($d, 2, 4), substr($d, 6, 4));
        }

        return trim((string) $telefone);
    }

    private static function iconesFlags($v)
    {
        $html = '';
        if (strtoupper((string) ($v['palco'] ?? '')) === 'SIM') {
            $html .= '<span class="ic ic-p" title="Palco">P</span>';
        }
        if (strtoupper((string) ($v['calouro'] ?? '')) === 'SIM') {
            $html .= '<span class="ic ic-c" title="1ª vez">1</span>';
        }
        if (strtoupper((string) ($v['whatsapp'] ?? '')) === 'SIM') {
            $html .= '<span class="ic ic-w" title="WhatsApp">W</span>';
        }
        return $html !== '' ? $html : '-';
    }

    private static function rotuloStatus($status)
    {
        switch ((int) $status) {
            case 2: return 'AT';
            case 3: return 'A';
            case 4: return 'BL';
            default: return 'OK';
        }
    }

    public static function linkWhatsapp($telefone)
    {
        $digits = preg_replace('/\D+/', '', (string) $telefone);
        if ($digits === '') {
            return '';
        }
        if (strlen($digits) <= 11) {
            $digits = '55' . $digits;
        }
        return 'https://wa.me/' . $digits;
    }

    private static function cabecalhoCsv()
    {
        return [
            'id', 'pulseira', 'tpulseira', 'fullName', 'telefone', 'telefone_formatado', 'whatsapp_url',
            'sexo', 'sexo_rotulo', 'nascimento', 'idade', 'religiao', 'cidade', 'bairro', 'endereco', 'email', 'oldPulseira',
            'whatsapp', 'info', 'fe', 'contato', 'palco', 'calouro', 'status', 'qtd_dias_presenca', 'dtCreate',
        ];
    }

    private static function rotuloSexoTexto($sexo)
    {
        $sx = strtoupper(trim((string) $sexo));
        if ($sx === 'M') {
            return 'Homem';
        }
        if ($sx === 'F') {
            return 'Mulher';
        }
        return '';
    }

    private static function linhaCsv($v)
    {
        $tel = trim((string) ($v['telefone'] ?? ''));
        $idade = self::calcularIdade($v['nascimento'] ?? '');

        return [
            $v['id'] ?? '',
            $v['pulseira'] ?? '',
            $v['tpulseira'] ?? '',
            $v['fullName'] ?? '',
            $tel,
            self::formatarTelefone($tel),
            self::linkWhatsapp($tel),
            $v['sexo'] ?? '',
            self::rotuloSexoTexto($v['sexo'] ?? ''),
            $v['nascimento'] ?? '',
            $idade !== null ? $idade : '',
            $v['religiao'] ?? '',
            $v['cidade'] ?? '',
            $v['bairro'] ?? '',
            $v['endereco'] ?? '',
            $v['email'] ?? '',
            $v['oldPulseira'] ?? '',
            $v['whatsapp'] ?? '',
            $v['info'] ?? '',
            $v['fe'] ?? '',
            $v['contato'] ?? '',
            $v['palco'] ?? '',
            $v['calouro'] ?? '',
            $v['status'] ?? '',
            (int) ($v['qtdDiasPresenca'] ?? 0),
            $v['dtCreate'] ?? '',
        ];
    }
}
