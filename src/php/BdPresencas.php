<?php

class BdPresencas extends DataBase
{

    /**
     * Atribui a variavel tableName o valor do nome da tabela.
     * É usado em todas as funções para identificar qual a tabela das querys.
     *
     * @var string
     */
    protected $tableName = 'presencas';


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
            
            
            "tpulseira" => "VARCHAR(64) NULL",   // Tipo ou cor da pulseira.
            "pulseira"  => "INT NULL",           // Número da pulseira.

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

    

    public function presencas($dataIni, $dataFim)
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

    
    public function qtdpresencaspulseiras()
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

    public function qtdPulseirasSemCadastro()
    {
        $table = parent::fullTableName();
        $tableVisitantes = parent::fullTableName('visitantes');

        $sql = "SELECT COUNT(*) as qtd FROM (
            SELECT DISTINCT p.pulseira, p.tpulseira
            FROM $table p
            LEFT JOIN $tableVisitantes v ON v.pulseira = p.pulseira AND v.tpulseira = p.tpulseira
            WHERE v.id IS NULL
        ) tbl";

        $r = parent::executeQuery($sql);

        if (!$r) {
            return 0;
        }

        return (int) $r[0]['qtd'];
    }

    public function qtdPulseirasSemCadastroDia($dia)
    {
        $table = parent::fullTableName();
        $tableVisitantes = parent::fullTableName('visitantes');
        $dia = preg_replace('/[^0-9\-]/', '', $dia);

        $sql = "SELECT COUNT(*) as qtd FROM (
            SELECT p.pulseira, p.tpulseira
            FROM $table p
            LEFT JOIN $tableVisitantes v ON v.pulseira = p.pulseira AND v.tpulseira = p.tpulseira
            WHERE v.id IS NULL
            AND DATE(p.dtCreate) = '$dia'
            GROUP BY p.pulseira, p.tpulseira
        ) tbl";

        $r = parent::executeQuery($sql);

        if (!$r) {
            return 0;
        }

        return (int) $r[0]['qtd'];
    }
    

    public function qtdpresencaspulseirasDia($dia)
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

    
    public function qtdPresencasPorUsuario($idUser)
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
            COUNT(*) as presencas_total,
            SUM(CASE WHEN DATE(dtCreate) = '$hoje' THEN 1 ELSE 0 END) as presencas_hoje
            FROM $table
            WHERE idLoginCreate = '$idUser'";

        $r = parent::executeQuery($sql);

        if (!$r) {
            return [
                'presencas_total' => 0,
                'presencas_hoje' => 0,
            ];
        }

        return array_map('intval', $r[0]);
    }

    public function ultimasPresencasPorUsuario($idUser, $qtd = 5)
    {
        $idUser = (int) $idUser;
        $qtd = max(1, min(20, (int) $qtd));
        $table = parent::fullTableName();
        $tableVisitantes = parent::fullTableName('visitantes');

        $sql = "SELECT p.pulseira, p.tpulseira, p.dtCreate, v.id, v.fullName
            FROM $table p
            LEFT JOIN $tableVisitantes v ON v.pulseira = p.pulseira AND v.tpulseira = p.tpulseira
            WHERE p.idLoginCreate = '$idUser'
            ORDER BY p.dtCreate DESC
            LIMIT $qtd";

        return parent::executeQuery($sql) ?: [];
    }

    public function ultimoIdPresenca()
    {
        $table = parent::fullTableName();
        $sql = "SELECT COALESCE(MAX(id), 0) as ultimoId FROM $table";

        $r = parent::executeQuery($sql);

        if (!$r) {
            return 0;
        }

        return (int) $r[0]['ultimoId'];
    }

    public function presencasAndamentoComFoto($ultimoIdPresenca = 0, $qtd = 8)
    {
        $ultimoIdPresenca = (int) $ultimoIdPresenca;
        $qtd = max(1, min(20, (int) $qtd));

        if ($ultimoIdPresenca <= 0) {
            return [];
        }

        $table = parent::fullTableName();
        $tableVisitantes = parent::fullTableName('visitantes');

        $joinVisitante = "LEFT JOIN $tableVisitantes v ON v.id = (
            SELECT v2.id FROM $tableVisitantes v2
            WHERE v2.pulseira = p.pulseira
            AND UPPER(v2.tpulseira) = UPPER(p.tpulseira)
            ORDER BY v2.id DESC
            LIMIT 1
        )";

        $select = "SELECT p.id as idPresenca, p.pulseira, p.tpulseira, p.dtCreate,
            v.id as idVisitante, v.fullName, v.foto, v.status";

        $sql = "$select
            FROM $table p
            $joinVisitante
            WHERE p.id > $ultimoIdPresenca
            ORDER BY p.id ASC
            LIMIT $qtd";

        return parent::executeQuery($sql) ?: [];
    }

    public function dias($pulseira, $tpulseira = null)
    {
        // Nome completo da tabela.
        $table = parent::fullTableName();

        // Monta SQL.
        $where = "pulseira = '$pulseira'";
        if ($tpulseira !== null && $tpulseira !== '') {
            $tpulseira = strtoupper($tpulseira);
            $where .= " AND UPPER(tpulseira) = '$tpulseira'";
        }
        $sql = "SELECT day(dtCreate) as dia FROM $table WHERE $where GROUP BY day(dtCreate)";

        // Executa o select
        $r = parent::executeQuery($sql);

        // Verifica se não teve retorno.
        if (!$r)
            return false;

        // Retorna primeira linha.
        return $r;
    }


    public function visitasDiarias()
    {
        // Nome completo da tabela.
        $table = parent::fullTableName();

        // Obtenho todos os dias que teve presença.
        $sql = "SELECT day(dtCreate) as dia, DATE_FORMAT(dtCreate,'%Y-%m-%d') as data FROM $table where 1 group by day(dtCreate)";
        
        // Executa o select
        $dias = parent::executeQuery($sql);

        // Verifica se não teve retorno e finaliza.
        if (!$dias)
            return false;

        foreach ($dias as $key => $value) {

            $data = $dias[$key]['data'];

            // Obtenho as pesenças do dia.
            $select = "COUNT(*) as qtd FROM (SELECT COUNT(*) as qtd FROM $table";
            $sql = "SELECT $select WHERE dtCreate >= '$data 00:00:00' AND dtCreate <= '$data 23:59:59' GROUP BY pulseira, tpulseira)tbl";

            $presencas = parent::executeQuery($sql);

            // $presencas
            $dias[$key]['qtd'] = $presencas[0]['qtd'];
        };

        return $dias;
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
