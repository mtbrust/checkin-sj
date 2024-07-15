<?php

class Seguranca
{

    public static function init()
    {
        session_start();
    }

    public static function check()
    {
        if (!$_SESSION['usuario']) {
            // Redireciona para a página inicial.
            header('Location: ' . BASE_URL . '?page=home');
        }
    }

    public static function checkAdmin()
    {
        // Verifica se está logado.
        self::check();

        // Ids de administradores.
        $ids = self::getIdsAdmins();

        $adm = false;

        if (in_array($_SESSION['usuario']['id'], $ids)) {
            $adm = true;
        }

        if (!$adm) {
            // Redireciona para a página inicial.
            header('Location: ' . BASE_URL . '?page=home');
        }
    }

    public static function getSession()
    {
        if (isset($_SESSION['usuario'])) {
            return $_SESSION['usuario'];
        } else {
            return [
                'fullName' => 'ND',
                'id' => 0,
            ];
        }
    }

    public static function clearSession()
    {
        $_SESSION['usuario'] = null;
        session_destroy();
        // Redireciona para a página inicial.
        header('Location: ' . BASE_URL . '?page=home');
    }

    public static function setSession($user)
    {
        return $_SESSION['usuario'] = $user;
    }

    public static function getIdsAdmins()
    {
        return [1,2];
    }
}
