<?php

class App
{
    public static function init()
    {
        // configurações
        require_once('config.php');

        // Carrega as dependências do composer;
        require_once "vendor/autoload.php";

        // Carrega banco de dados.
        require_once('src/php/DataBase.php');
        require_once('src/php/BdModelo.php');
        require_once('src/php/BdLogDb.php');
        require_once('src/php/BdLogins.php');
        require_once('src/php/BdVisitantes.php');
        require_once('src/php/BdComentarios.php');
        require_once('src/php/BdMidias.php');
        require_once('src/php/BdPresencas.php');

        // Segurança.
        require_once(BASE_DIR . 'src/php/Seguranca.php');

        Seguranca::init();
    }

    public static function createTables()
    {
        $bdModelo = new BdModelo();
        $bdModelo->createTable();
        $bdLog = new BdLogDb();
        $bdLog->createTable();
        $bdLogins = new BdLogins();
        $bdLogins->createTable();
        $BdVisitantes = new BdVisitantes();
        $BdVisitantes->createTable();
        $bdComentarios = new BdComentarios();
        $bdComentarios->createTable();
        $BdPresencas = new BdPresencas();
        $BdPresencas->createTable();
    }

    public static function dropTables()
    {
        $bdModelo = new BdModelo();
        $bdModelo->dropTable();
        $bdLog = new BdLogDb();
        $bdLog->dropTable();
        $bdLogins = new BdLogins();
        $bdLogins->dropTable();
        $BdVisitantes = new BdVisitantes();
        $BdVisitantes->dropTable();
        $bdComentarios = new BdComentarios();
        $bdComentarios->dropTable();
        $BdPresencas = new BdPresencas();
        $BdPresencas->dropTable();
    }
}