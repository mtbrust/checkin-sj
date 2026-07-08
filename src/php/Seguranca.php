<?php

class Seguranca
{
    const ADMIN_USER_ID = 1;

    public static function init()
    {
        session_start();
    }

    public static function isAdmin($user = null)
    {
        if ($user === null) {
            $user = $_SESSION['usuario'] ?? null;
        }

        return is_array($user) && (int) ($user['id'] ?? 0) === self::ADMIN_USER_ID;
    }

    public static function check()
    {
        if (empty($_SESSION['usuario'])) {
            header('Location: ' . BASE_URL . '?page=home');
            exit;
        }
    }

    public static function checkAdmin()
    {
        self::check();

        if (!self::isAdmin()) {
            header('Location: ' . BASE_URL . '?page=home');
            exit;
        }
    }

    public static function checkAdminApi()
    {
        if (empty($_SESSION['usuario'])) {
            header('Content-Type: application/json; charset=utf-8');
            http_response_code(401);
            echo json_encode(['ret' => false, 'msg' => 'Não autenticado.']);
            exit;
        }

        if (!self::isAdmin()) {
            header('Content-Type: application/json; charset=utf-8');
            http_response_code(403);
            echo json_encode(['ret' => false, 'msg' => 'Acesso negado.']);
            exit;
        }
    }

    public static function getSession()
    {
        if (isset($_SESSION['usuario'])) {
            return $_SESSION['usuario'];
        }

        return [
            'fullName' => 'NÃO LOGADO',
            'id' => 0,
        ];
    }

    public static function clearSession()
    {
        $_SESSION['usuario'] = null;
        session_destroy();
        header('Location: ' . BASE_URL . '?page=home');
        exit;
    }

    public static function setSession($user)
    {
        return $_SESSION['usuario'] = $user;
    }

    /**
     * @deprecated Use isAdmin() — admin é somente o usuário id 1.
     */
    public static function getCpfsAdmins()
    {
        return ['10401141640'];
    }
}
