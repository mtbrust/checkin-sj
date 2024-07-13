<?php

class Seguranca
{
    private static $session;

    public static function init()
    {
        session_start();
        
        self::$session['usuario'] = [
            'nome' => 'VISITANTE',
            'id' => '0',
        ];
    }

    public static function check()
    {
        if (!$_SESSION['usuario']) {
            // Redireciona para a página inicial.
            header('Location: ' . BASE_URL);
        }
    }

    public static function getSession()
    {
        return self::$session['usuario'];
    }
}
