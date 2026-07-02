<?php

class BdVisitantes extends DataBase
{

    /**
     * Atribui a variavel tableName o valor do nome da tabela.
     * É usado em todas as funções para identificar qual a tabela das querys.
     *
     * @var string
     */
    protected $tableName = 'visitantes';


    /**
     * Conexão padrão do banco de dados.
     * Verificar conexão na config.
     *
     * @var int
     */
    protected $conn = 0;


    /**
     * createTable
     * 
     * Cria tabela no banco de dados.
     * Função genérica para criação de tabelas conforme os parâmetros passados.
     * Preencha o nome da tabela.
     * Preencha o array $fields com "nome_campo" => "tipo_campo".
     * Cria se não existir.
     *
     * @param array $fields
     * @return bool
     */
    public function createTable($fields = null)
    {
        // Monta os campos da tabela.
        $fields = [
            // Identificador Padrão (obrigatório).
            "id" => "INT NOT NULL AUTO_INCREMENT primary key",


            "tpulseira"   => "VARCHAR(64) NULL",    // Tipo ou cor da pulseira.
            "pulseira"    => "INT NOT NULL",        // Número da pulseira.
            "oldPulseira" => "INT NULL",            // Número da pulseira antiga.
            "fullName"    => "VARCHAR(160) NULL",   // Nome Completo.
            "name"        => "VARCHAR(160) NULL",   // Primeiro Nome.
            "telefone"    => "VARCHAR(16) NULL",    // Telefone (numero only).
            "cpf"         => "VARCHAR(11) NULL",    // CPF.
            "email"       => "VARCHAR(160) NULL",   // E-mail principal.
            "nascimento"  => "DATE NULL",           // Data de Nascimento. (yyyy-mm-dd)
            "sexo"        => "VARCHAR(1) NULL",     // F/M.
            "foto"        => "LONGTEXT NULL",       // URL da foto.

            "whatsapp" => "VARCHAR(3) NULL DEFAULT 'NAO'",   // SIM/NAO.
            "info"     => "VARCHAR(3) NULL DEFAULT 'NAO'",   // SIM/NAO.
            "fe"       => "VARCHAR(3) NULL DEFAULT 'NAO'",   // SIM/NAO.
            "contato"  => "VARCHAR(3) NULL DEFAULT 'NAO'",   // SIM/NAO.
            "palco"    => "VARCHAR(3) NULL DEFAULT 'NAO'",   // SIM/NAO.
            "calouro"  => "VARCHAR(3) NULL DEFAULT 'NAO'",   // SIM/NAO.

            "religiao" => "VARCHAR(255) NULL",        // Igreja que frequenta ou religião.

            "cidade"   => "VARCHAR(255) NULL",   // Endereço.
            "bairro"   => "VARCHAR(255) NULL",
            "endereco" => "VARCHAR(255) NULL",
            "status"   => "INT NULL",            // [1] OK, [2] Atualizar, [3] Atenção, [4] Bloqueado



            // CRIADO AUTOMATICAMENTE
            // // Observações do registro (obrigatório)
            // "obs" => "VARCHAR(255) NULL",

            // // Controle padrão do registro (obrigató
            // "idStatus"      => "INT NULL",
            // "idLoginCreate" => "INT NULL",
            // "dtCreate"      => "DATETIME NULL",
            // "idLoginUpdate" => "INT NULL",
            // "dtUpdate"      => "DATETIME NULL",

        ];
        return parent::createTable($fields);
    }


    /**
     * dropTable
     * 
     * Deleta tabela no banco de dados.
     *
     * @return bool
     */
    public function dropTable()
    {
        // Deleta a tabela.
        return parent::dropTable();
    }

    public function upDateTable()
    {
        // ALTER TABLE `checkin_visitantes` ADD `oldPulseira` INT NULL AFTER `pulseira`;
        
        return true;
    }


    /**
     * insert
     * 
     * Função genérica para inserts.
     * Preencha o nome da tabela.
     * Preencha o array $fields com "nome_campo" => "valor_campo".
     *
     * @param array $fields
     * @return int
     */
    public function insert($fields)
    {
        // Retorno da função insert préviamente definida. (true, false)
        return parent::insert($fields);
    }


    /**
     * update
     * 
     * Função genérica para update.
     * Preencha o nome da tabela.
     * Preencha o array com nome_campo => valor_campo somenta das colunas que vão ser alteradas.
     *
     * @param  mixed $id
     * @param  mixed $fields
     * @param  mixed $where
     * @return bool
     */
    public function update($id, $fields, $where = null)
    {
        // Retorno da função update préviamente definida. (true, false)
        return parent::update($id, $fields, $where);
    }


    /**
     * delete
     * 
     * Função que deleta registro por id ou where.
     * É necessário preencher um dos dois parâmetros.
     *
     * @param int $id
     * @param string $where
     * @return bool
     */
    public function delete($id = null, $where = null)
    {
        // Retorno da função delete préviamente definida. (true, false)
        return parent::delete($id, $where);
    }


    /**
     * deleteStatus
     * 
     * Função que deleta registro por status (0) id ou where.
     * É necessário preencher um dos dois parâmetros.
     *
     * @param int $id
     * @param string $where
     * @return bool
     */
    public function deleteStatus($id = null, $where = null)
    {
        // Retorno da função delete préviamente definida. (true, false)
        return parent::deleteStatus($id, $where);
    }


    /**
     * selecionarTudo
     * 
     * Função selecionar tudo, retorna todos os registros.
     * É possível passar a posição inicial que exibirá os registros.
     * É possível passar a quantidade de registros retornados.
     *
     * @param integer $posicao
     * @param integer $qtd
     * @return bool
     */
    public function selectAll($qtd = 10, $posicao = 0)
    {
        // Retorno da função selectAll préviamente definida. (true, false)
        return parent::selectAll($qtd, $posicao);
    }


    /**
     * selectById
     * 
     * Função que busca registro por id.
     * Retorna um array da linha.
     * Retorna um array com os campos da linha.
     * É necessário preencher um dos dois parâmetros.
     *
     * @param int $id
     * @param string $where
     * @return bool|array
     */
    public function selectById($id = null, $where = null)
    {
        // Função que busca registro por id.
        return parent::selectById($id, $where);
    }


    /**
     * count
     * 
     * Função genérica para retornar a quantidade de registros da tabela.
     *
     * @return int
     */
    public function count()
    {
        // Retorna a quantidade de registros na tabela.
        return parent::count();
    }

    public function cadastros($dataIni, $dataFim)
    {
        // Nome completo da tabela.
        $table = parent::fullTableName();

        // Monta SQL.
        $sql = "SELECT COUNT(*) as qtd FROM (SELECT count(*) FROM $table WHERE dtCreate >= '$dataIni' and dtCreate < '$dataFim' GROUP BY pulseira, tpulseira) tbl";

        // Executa o select
        $r = parent::executeQuery($sql);

        // Verifica se não teve retorno.
        if (!$r)
            return false;

        // Retorna primeira linha.
        return $r[0]['qtd'];
    }

    public function qtdCadastrosPulseira()
    {
        // Nome completo da tabela.
        $table = parent::fullTableName();

        // Monta SQL.
        $sql = "SELECT COUNT(*) as qtd from ( SELECT COUNT(*) as qtd, pulseira, tpulseira, DAY(dtCreate) as dia FROM $table GROUP BY pulseira, tpulseira, DAY(dtCreate)) tbl;";

        // Executa o select
        $r = parent::executeQuery($sql);

        // Verifica se não teve retorno.
        if (!$r)
            return false;

        // Retorna primeira linha.
        return $r[0]['qtd'];
    }

    public function cadastrosDiarios()
    {
        // Nome completo da tabela.
        $table = parent::fullTableName();

        // Obtenho todos os dias que teve cadastro.
        $sql = "SELECT day(dtCreate) as dia, DATE_FORMAT(dtCreate,'%Y-%m-%d') as data FROM $table where 1 group by day(dtCreate)";
        
        // Executa o select
        $dias = parent::executeQuery($sql);

        // Verifica se não teve retorno e finaliza.
        if (!$dias)
            return false;

        foreach ($dias as $key => $value) {

            $data = $dias[$key]['data'];

            // Obtenho os cadastros do dia.
            $select = "COUNT(*) as qtd FROM (SELECT COUNT(*) as qtd FROM $table";
            $sql = "SELECT $select WHERE dtCreate >= '$data 00:00:00' AND dtCreate <= '$data 23:59:59' GROUP BY pulseira, tpulseira)tbl";

            $cadastros = parent::executeQuery($sql);

            // $cadastros
            $dias[$key]['qtd'] = $cadastros[0]['qtd'];
        };

        return $dias;
    }
    

    public function qtdCadastrosPulseiraDia($dia)
    {
        // Nome completo da tabela.
        $table = parent::fullTableName();

        // Monta SQL.
        $sql = "SELECT COUNT(*) as qtd FROM (SELECT COUNT(*) as qtd FROM $table WHERE dtCreate >= '$dia 00:00:00' AND dtCreate <= '$dia 23:59:59' GROUP BY pulseira, tpulseira)tbl";

        // Executa o select
        $r = parent::executeQuery($sql);

        // Verifica se não teve retorno.
        if (!$r)
            return false;

        // Retorna primeira linha.
        return $r[0]['qtd'];
    }

    public function qtdCadastrosPorUsuario($idUser)
    {
        // Ajusta nome real da tabela.
        $table = parent::fullTableName();
        // $tableInnerMidia = parent::fullTableName('midia');
        // $tableInnerLogin = parent::fullTableName('login');
        // $tableInnerUsers = parent::fullTableName('users');

        // Monta SQL.
        $sql = "SELECT count(*) as qtd FROM $table WHERE idLoginCreate = '$idUser' LIMIT 1;";

        // Executa o select
        $r = parent::executeQuery($sql);

        // Verifica se não teve retorno.
        if (!$r)
            return false;

        // Retorna primeira linha.
        return $r[0]['qtd'];
    }

    public function estatisticasPorUsuario($idUser)
    {
        $idUser = (int) $idUser;
        $table = parent::fullTableName();
        $hoje = date('Y-m-d');

        $sql = "SELECT
            COUNT(*) as cadastros_total,
            SUM(CASE WHEN DATE(dtCreate) = '$hoje' THEN 1 ELSE 0 END) as cadastros_hoje,
            SUM(CASE WHEN UPPER(tpulseira) = 'AMARELA' THEN 1 ELSE 0 END) as amarela,
            SUM(CASE WHEN UPPER(tpulseira) = 'AZUL' THEN 1 ELSE 0 END) as azul,
            SUM(CASE WHEN calouro = 'SIM' THEN 1 ELSE 0 END) as calouros,
            SUM(CASE WHEN palco = 'SIM' THEN 1 ELSE 0 END) as palco
            FROM $table
            WHERE idLoginCreate = '$idUser'";

        $r = parent::executeQuery($sql);

        if (!$r) {
            return [
                'cadastros_total' => 0,
                'cadastros_hoje' => 0,
                'amarela' => 0,
                'azul' => 0,
                'calouros' => 0,
                'palco' => 0,
            ];
        }

        return array_map('intval', $r[0]);
    }

    public function ultimosCadastrosPorUsuario($idUser, $qtd = 5)
    {
        $idUser = (int) $idUser;
        $qtd = max(1, min(20, (int) $qtd));
        $table = parent::fullTableName();

        $sql = "SELECT id, pulseira, tpulseira, fullName, dtCreate
            FROM $table
            WHERE idLoginCreate = '$idUser'
            ORDER BY dtCreate DESC
            LIMIT $qtd";

        return parent::executeQuery($sql) ?: [];
    }

    public function pesquisar($termo)
    {
        // Ajusta nome real da tabela.
        $table = parent::fullTableName();

        // Caso o termo seja texto.
        $select = "'texto' as presencas, vi.*";
        $where = "vi.fullName like '%$termo%' OR vi.tpulseira = '$termo' OR vi.endereco like '%$termo%'";
        $inner = '';
        $group = '';
        $order = '';

        // Caso o termo seja número.
        if (is_numeric($termo)){
            $where = "vi.telefone = '$termo' OR vi.pulseira = '$termo' OR vi.oldPulseira = '$termo'";

            $select = "GROUP_CONCAT(DATE(p.dtCreate) SEPARATOR ',') as presencas, vi.*";
            $inner = "left join sj_presencas p on vi.pulseira = p.pulseira and UPPER(vi.tpulseira) = UPPER(p.tpulseira)";
            $group = "GROUP by vi.pulseira, vi.tpulseira";
            $order = "ORDER by p.dtcreate";
        }

        // Monta SQL.
        $sql = "SELECT $select FROM $table vi $inner WHERE $where $group $order;";

        // Executa o select
        $r = parent::executeQuery($sql);

        // Verifica se não teve retorno.
        if (!$r)
            return false;

        // Retorna primeira linha.
        return $r;
    }

    /**
     * Monta cláusula WHERE a partir dos filtros de listagem.
     *
     * @param array $filtros
     * @return string
     */
    private function montaWhereListagem($filtros = [])
    {
        $where = ['1=1'];

        if (!empty($filtros['nome'])) {
            $nome = addslashes($filtros['nome']);
            $where[] = "fullName LIKE '%$nome%'";
        }

        if (!empty($filtros['pulseira'])) {
            $pulseira = parent::limpaInject($filtros['pulseira']);
            if ($pulseira !== '') {
                $where[] = "pulseira = '$pulseira'";
            }
        }

        if (!empty($filtros['oldPulseira'])) {
            $oldPulseira = parent::limpaInject($filtros['oldPulseira']);
            if ($oldPulseira !== '') {
                $where[] = "oldPulseira = '$oldPulseira'";
            }
        }

        if (!empty($filtros['tpulseira']) && in_array(strtolower($filtros['tpulseira']), ['amarela', 'azul'], true)) {
            $tpulseira = strtoupper(addslashes($filtros['tpulseira']));
            $where[] = "tpulseira = '$tpulseira'";
        }

        if (!empty($filtros['telefone'])) {
            $telefone = addslashes(preg_replace('/\D/', '', $filtros['telefone']));
            if ($telefone !== '') {
                $where[] = "telefone LIKE '%$telefone%'";
            }
        }

        if (!empty($filtros['cidade'])) {
            $cidade = addslashes($filtros['cidade']);
            $where[] = "cidade LIKE '%$cidade%'";
        }

        if (!empty($filtros['bairro'])) {
            $bairro = addslashes($filtros['bairro']);
            $where[] = "bairro LIKE '%$bairro%'";
        }

        if (!empty($filtros['sexo']) && in_array(strtoupper($filtros['sexo']), ['M', 'F'], true)) {
            $sexo = strtoupper(addslashes($filtros['sexo']));
            $where[] = "sexo = '$sexo'";
        }

        if (isset($filtros['status']) && $filtros['status'] !== '' && in_array((int) $filtros['status'], [1, 2, 3, 4], true)) {
            $status = (int) $filtros['status'];
            $where[] = "status = '$status'";
        }

        if (!empty($filtros['calouro']) && strtoupper($filtros['calouro']) === 'SIM') {
            $where[] = "calouro = 'SIM'";
        }

        if (!empty($filtros['palco']) && strtoupper($filtros['palco']) === 'SIM') {
            $where[] = "palco = 'SIM'";
        }

        if (!empty($filtros['duplicados'])) {
            $table = parent::fullTableName();
            $where[] = "(pulseira, UPPER(tpulseira)) IN (
                SELECT pulseira, UPPER(tpulseira)
                FROM $table
                GROUP BY pulseira, UPPER(tpulseira)
                HAVING COUNT(*) > 1
            )";
        }

        if (!empty($filtros['hoje'])) {
            $hoje = date('Y-m-d');
            $where[] = "DATE(dtCreate) = '$hoje'";
        } elseif (!empty($filtros['data'])) {
            $data = preg_replace('/[^0-9\-]/', '', $filtros['data']);
            if ($data !== '') {
                $where[] = "DATE(dtCreate) = '$data'";
            }
        }

        return implode(' AND ', $where);
    }

    /**
     * Lista visitantes com filtros e paginação.
     *
     * @param array $filtros
     * @param int $pagina
     * @param int $qtd
     * @return bool|array
     */
    public function listarFiltrado($filtros = [], $pagina = 1, $qtd = 25)
    {
        $table = parent::fullTableName();
        $pagina = max(1, (int) $pagina);
        $qtd = max(1, min(100, (int) $qtd));
        $offset = ($pagina - 1) * $qtd;
        $where = $this->montaWhereListagem($filtros);

        $sql = "SELECT * FROM $table WHERE $where ORDER BY id DESC LIMIT $offset, $qtd";

        return parent::executeQuery($sql);
    }

    /**
     * Conta visitantes com os mesmos filtros da listagem.
     *
     * @param array $filtros
     * @return int
     */
    public function contarFiltrado($filtros = [])
    {
        $table = parent::fullTableName();
        $where = $this->montaWhereListagem($filtros);
        $sql = "SELECT COUNT(*) as qtd FROM $table WHERE $where";
        $r = parent::executeQuery($sql);

        if (!$r) {
            return 0;
        }

        return (int) $r[0]['qtd'];
    }

    public function getStatus($pulseira, $tpulseira)
    {
        // Ajusta nome real da tabela.
        $table = parent::fullTableName();
        $tablePresenca = parent::fullTableName('presencas');

        $tpulseira = strtoupper($tpulseira);

        // Monta SQL.
        // $sql = "SELECT v.id, v.fullName, v.status, count(p.id) as qtdPresenca FROM $table v left join $tablePresenca p on v.pulseira = p.pulseira and v.tpulseira = p.tpulseira WHERE p.pulseira = '$pulseira' AND p.tpulseira = '$tpulseira' AND v.status > 1 GROUP BY DATE(p.dtCreate);";

        $select = "SELECT v.id as id, v.fullName as fullName, v.pulseira as pulseira, v.tpulseira as tpulseira, v.status as status, DATE(p.dtCreate) as presencas"; 
        $from = "FROM `sj_presencas` p LEFT JOIN `sj_visitantes` v on p.pulseira = v.pulseira and UPPER(v.tpulseira) = UPPER(p.tpulseira)";
        $where = "where p.pulseira = '$pulseira' AND p.tpulseira = '$tpulseira'";
        $group = "GROUP BY p.pulseira, p.tpulseira, DATE(p.dtCreate)";
        $tbl1 = "$select $from $where $group";

        $sql = "SELECT id, fullName, status, pulseira, tpulseira, count(*) as qtdPresenca from ($tbl1) tbl1 GROUP BY pulseira, tpulseira;";

        // echo $sql;
        // exit;

        // Executa o select
        $r = parent::executeQuery($sql);

        // Verifica se não teve retorno.
        if (!$r)
            return false;

        // Retorna primeira linha.
        return $r[0];
    }

    public function listarRelatorioCompleto()
    {
        $table = parent::fullTableName();
        $tablePresenca = parent::fullTableName('presencas');

        $sql = "SELECT v.*,
            (
                SELECT COUNT(DISTINCT DATE(p.dtCreate))
                FROM $tablePresenca p
                WHERE p.pulseira = v.pulseira
                AND UPPER(p.tpulseira) = UPPER(v.tpulseira)
            ) AS qtdDiasPresenca
            FROM $table v
            ORDER BY v.fullName ASC, v.pulseira ASC, v.tpulseira ASC";

        return parent::executeQuery($sql) ?: [];
    }

    public function estatisticasResumo()
    {
        $table = parent::fullTableName();

        $sql = "SELECT
            COUNT(*) as registros,
            COUNT(DISTINCT pulseira) as visitantes,
            SUM(CASE WHEN UPPER(tpulseira) = 'AMARELA' THEN 1 ELSE 0 END) as amarela,
            SUM(CASE WHEN UPPER(tpulseira) = 'AZUL' THEN 1 ELSE 0 END) as azul,
            SUM(CASE WHEN calouro = 'SIM' THEN 1 ELSE 0 END) as calouros,
            SUM(CASE WHEN palco = 'SIM' THEN 1 ELSE 0 END) as palco,
            SUM(CASE WHEN status = 2 THEN 1 ELSE 0 END) as atualizar,
            SUM(CASE WHEN status = 3 THEN 1 ELSE 0 END) as atencao,
            SUM(CASE WHEN status = 4 THEN 1 ELSE 0 END) as bloqueado
            FROM $table";

        $r = parent::executeQuery($sql);

        if (!$r) {
            return [
                'registros' => 0,
                'visitantes' => 0,
                'amarela' => 0,
                'azul' => 0,
                'calouros' => 0,
                'palco' => 0,
                'atualizar' => 0,
                'atencao' => 0,
                'bloqueado' => 0,
            ];
        }

        return array_map('intval', $r[0]);
    }

    public function qtdCadastrosDuplicados()
    {
        // Ajusta nome real da tabela.
        $table = parent::fullTableName();
        // $tableInnerMidia = parent::fullTableName('midia');
        // $tableInnerLogin = parent::fullTableName('login');
        // $tableInnerUsers = parent::fullTableName('users');

        // Monta SQL.
        $sql = "SELECT count(*) as qtd FROM (SELECT pulseira, count(*) as qtd FROM $table group by pulseira) tbl WHERE qtd > 1;";

        // Executa o select
        $r = parent::executeQuery($sql);

        // Verifica se não teve retorno.
        if (!$r)
            return false;

        // Retorna primeira linha.
        return $r[0]['qtd'];
    }

    public function ultimosCadastros($qtd = 10)
    {
        // Ajusta nome real da tabela.
        $table = parent::fullTableName();

        // Monta SQL.
        $sql = "SELECT tbl.*  FROM $table tbl ORDER BY tbl.dtCreate desc LIMIT $qtd;";

        // Executa o select
        $r = parent::executeQuery($sql);

        // Verifica se não teve retorno.
        if (!$r)
            return false;

        // Retorna primeira linha.
        return $r;
    }


    public function ultimasPresencas($qtd = 10)
    {
        // Ajusta nome real da tabela.
        $table = parent::fullTableName();
        $tableInnerPresenca = parent::fullTableName('presencas');

        // Monta SQL.
        $sql = "SELECT tbl.id, tp.pulseira, tp.tpulseira, tbl.status, tbl.fullName, tp.dtCreate  FROM $tableInnerPresenca tp left JOIN $table tbl ON tp.pulseira = tbl.pulseira and UPPER(tp.tpulseira) = UPPER(tbl.tpulseira) ORDER BY tp.dtCreate desc LIMIT $qtd;";

        // Executa o select
        $r = parent::executeQuery($sql);

        // Verifica se não teve retorno.
        if (!$r)
            return false;

        // Retorna primeira linha.
        return $r;
    }


    public function participantespalco($qtd = 300)
    {
        // Ajusta nome real da tabela.
        $table = parent::fullTableName();
        $tableInnerPresenca = parent::fullTableName('presencas');

        // Monta SQL.
        $sql = "SELECT tbl.id, tbl.pulseira, tbl.tpulseira, tbl.status, tbl.fullName, tbl.sexo, tbl.telefone, tbl.nascimento, tbl.foto, tp.dtCreate  FROM $tableInnerPresenca tp left JOIN $table tbl ON tp.pulseira = tbl.pulseira and UPPER(tp.tpulseira) = UPPER(tbl.tpulseira) WHERE DAY(tp.dtCreate) = DAY(CURRENT_DATE()) AND tbl.palco = 'SIM' GROUP BY id ORDER BY tp.dtCreate ASC LIMIT $qtd;";

        // Executa o select
        $r = parent::executeQuery($sql);

        // Verifica se não teve retorno.
        if (!$r)
            return false;

        // Retorna primeira linha.
        return $r;
    }


    /**
     * consultaPersonalizada
     * 
     * Modelo para criação de uma consulta personalizada.
     * É possível fazer inner joins e filtros personalizados.
     * User sempre que possível a função "select()" em vez de "executeQuery()".
     * ATENÇÃO: Não deixar brechas para SQL Injection.
     *
     * @param PDO $conn
     * @return bool|array
     */
    public function consultaPersonalizada($id)
    {
        // Ajusta nome real da tabela.
        $table = parent::fullTableName();
        // $tableInnerMidia = parent::fullTableName('midia');
        // $tableInnerLogin = parent::fullTableName('login');
        // $tableInnerUsers = parent::fullTableName('users');

        // Monta SQL.
        $sql = "SELECT * FROM $table WHERE id = '$id' LIMIT 1;";

        // Executa o select
        $r = parent::executeQuery($sql);

        // Verifica se não teve retorno.
        if (!$r)
            return false;

        // Retorna primeira linha.
        return $r[0];
    }


    /**
     * insertsIniciais
     * 
     * Realização dos inserts iniciais.
     *
     * @return bool|array
     */
    public function seeds()
    {
        // Retorno padrão.
        $r = false;

        // Insert 1.
        $r = parent::insert([
            // Observações do registro (obrigatório).
            'obs' => 'Status ativo Geral',
        ]);


        // Finaliza a função.
        return $r;
    }
}
