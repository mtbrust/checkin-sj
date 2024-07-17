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


            "tpulseira"   => "VARCHAR(64) NULL",     // Tipo ou cor da pulseira.
            "pulseira"    => "INT NOT NULL",         // Número da pulseira.
            "oldPulseira" => "INT NULL",         // Número da pulseira antiga.
            "fullName"    => "VARCHAR(160) NULL",    // Nome Completo.
            "telefone"    => "VARCHAR(11) NULL",     // Telefone (numero only).
            "cpf"         => "VARCHAR(11) NULL",     // CPF.
            "email"       => "VARCHAR(160) NULL",    // E-mail principal.
            "nascimento"  => "DATE NULL",            // Data de Nascimento. (yyyy-mm-dd)
            "sexo"        => "VARCHAR(1) NULL",      // F/M.
            "fotoUrl"     => "VARCHAR(2048) NULL",   // URL da foto.

            "whatsapp"        => "VARCHAR(3) NULL DEFAULT 'NAO'",      // SIM/NAO.
            "info"        => "VARCHAR(3) NULL DEFAULT 'NAO'",      // SIM/NAO.
            "fe"        => "VARCHAR(3) NULL DEFAULT 'NAO'",      // SIM/NAO.
            "contato"        => "VARCHAR(3) NULL DEFAULT 'NAO'",      // SIM/NAO.
            "palco"        => "VARCHAR(3) NULL DEFAULT 'NAO'",      // SIM/NAO.
            "calouro"        => "VARCHAR(3) NULL DEFAULT 'NAO'",      // SIM/NAO.

            "religiao" => "VARCHAR(255) NULL",        // Igreja que frequenta ou religião.

            "cidade" => "VARCHAR(255) NULL",        // Endereço.
            "bairro" => "VARCHAR(255) NULL",
            "endereco" => "VARCHAR(255) NULL",
            "status" => "INT NULL", // [0] Normal, [1] Cadastro, [2] Atenção, [3] Bloqueado



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
        $sql = "SELECT COUNT(*) as qtd FROM (SELECT count(*) FROM $table WHERE dtCreate >= '$dataIni' and dtCreate < '$dataFim' GROUP BY pulseira) tbl";

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
        $sql = "SELECT COUNT(*) as qtd FROM (SELECT count(*) FROM $table GROUP BY pulseira, tpulseira) tbl";

        // Executa o select
        $r = parent::executeQuery($sql);

        // Verifica se não teve retorno.
        if (!$r)
            return false;

        // Retorna primeira linha.
        return $r[0]['qtd'];
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
