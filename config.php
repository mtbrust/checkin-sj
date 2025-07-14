<?php 

/**
 * * BASE_NAME
 * Nome do Framework
 * Não usar espaços e caracteres especiais.
 */
define('BASE_NAME', 'Check-In');


/**
 * * BASE_DOMAIN
 * Nome do Domínio
 * (localhost, www.dominio.com.br, etc.)
 */
define('BASE_DOMAIN', $_SERVER['SERVER_NAME']);


/**
 * * BASE_URL
 * URL Atual do projeto 
 * Exemplos do que pode conter:
 * (localhost, vhost, www.domínio.com.br, localhost/pasta/, www.domínio.com.br/pasta/, etc.)
 * Usado para definir variáveis de ambiente (DEV, HOMOLOG, PROD)
 */
define('BASE_URL', 'http' . ((isset($_SERVER['HTTPS'])) ? 's' : '') . '://' . $_SERVER['SERVER_NAME'] . str_replace('index.php', '', $_SERVER['SCRIPT_NAME']));


/**
 * * BASE_DIR
 * Diretório Atual do projeto. 
 * (Caminho completo para pasta raíz deste projeto)
 */
define('BASE_DIR', str_replace('\\', '/', realpath(dirname(__FILE__))) . '/');


/**
 * * BASE_DIR_RELATIVE
 * Diretório relativo do projeto. 
 * (Caminho relativo deste projeto, caso não seja um dómínio direto, pega o caminho para a index.)
 */
define('BASE_DIR_RELATIVE', str_replace('index.php', '', $_SERVER['SCRIPT_NAME']));


/**
 * * BANCO DE DADOS
 * Conexão com os bancos de dados de acordo com ambiente.
 */
define("BASE_BDS", [
    0 => [
        'TITLE'     => 'BD Principal',
        'ACTIVE'    => true,
        'DBMANAGER' => 'mysql',
        'HOST'      => 'localhost',
        'PORT'      => '3306',
        'USERNAME'  => 'desv_sj',
        'PASSWORD'  => 'desv_sj',
        'DATABASE'  => 'desv_sj',
        'CHARSET'   => 'utf8',
        'PREFIX'    => 'sj_',
    ],
]);


/**
 * * ERRO CONEXÃO BANCO DE DADOS
 * Exibe ou oculta os erros gerados na execução de sql.
 */
define("BASE_ERRO_SQL", true);

