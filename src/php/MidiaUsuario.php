<?php

class MidiaUsuario
{
    const DIR = 'src/midia/users/';

    public static function dirPath()
    {
        return BASE_DIR . self::DIR;
    }

    public static function ensureDir()
    {
        $dir = self::dirPath();

        if (!is_dir($dir) && !mkdir($dir, 0755, true) && !is_dir($dir)) {
            return false;
        }

        return is_writable($dir) ? $dir : false;
    }

    public static function urlPublica($filename)
    {
        return BASE_URL . self::DIR . $filename;
    }

    public static function caminhoRelativo($filename)
    {
        return self::DIR . $filename;
    }

    public static function urlDoUsuario($user)
    {
        $caminho = '';

        if (!empty($user['fotoUrl']) && strpos($user['fotoUrl'], 'data:') !== 0) {
            $caminho = $user['fotoUrl'];
        } elseif (!empty($user['foto'])) {
            if (strpos($user['foto'], 'data:') === 0) {
                return $user['foto'];
            }
            $caminho = $user['foto'];
        }

        if ($caminho) {
            if (strpos($caminho, 'http') === 0) {
                return $caminho;
            }
            return BASE_URL . ltrim($caminho, '/');
        }

        return BASE_URL . 'src/midia/user.webp';
    }

    /**
     * Caminho absoluto ou data URI da foto para uso em PDF (mPDF).
     */
    public static function caminhoAbsolutoDoUsuario($user)
    {
        $resolver = function ($caminho) {
            if (!$caminho) {
                return '';
            }
            if (strpos($caminho, 'data:') === 0) {
                return $caminho;
            }
            if (strpos($caminho, 'http://') === 0 || strpos($caminho, 'https://') === 0) {
                if (defined('BASE_URL') && strpos($caminho, BASE_URL) === 0) {
                    $rel = ltrim(substr($caminho, strlen(BASE_URL)), '/');
                    $abs = BASE_DIR . str_replace('/', DIRECTORY_SEPARATOR, $rel);
                    if (is_file($abs)) {
                        return $abs;
                    }
                }
                return $caminho;
            }
            $abs = BASE_DIR . ltrim(str_replace('/', DIRECTORY_SEPARATOR, $caminho), DIRECTORY_SEPARATOR);
            return is_file($abs) ? $abs : '';
        };

        foreach (['fotoUrl', 'foto'] as $campo) {
            if (empty($user[$campo])) {
                continue;
            }
            $resolved = $resolver($user[$campo]);
            if ($resolved !== '') {
                return $resolved;
            }
        }

        $id = preg_replace('/\D/', '', (string) ($user['id'] ?? ''));
        if ($id) {
            foreach (glob(self::dirPath() . $id . '.*') ?: [] as $file) {
                if (is_file($file)) {
                    return $file;
                }
            }
        }

        $fallback = BASE_DIR . 'src' . DIRECTORY_SEPARATOR . 'midia' . DIRECTORY_SEPARATOR . 'user.webp';
        return is_file($fallback) ? $fallback : '';
    }

    public static function salvarDeBase64($base64, $identificador)
    {
        if (!is_string($base64) || trim($base64) === '') {
            return false;
        }

        $ext = 'jpg';

        if (strpos($base64, 'base64,') !== false) {
            $partes = explode(',', $base64, 2);
            $base64 = $partes[1];
        }

        if (preg_match('/^data:image\/(\w+);/', $base64, $matches)) {
            $ext = strtolower($matches[1]);
            if ($ext === 'jpeg') {
                $ext = 'jpg';
            }
        }

        $data = base64_decode($base64, true);

        if ($data === false || $data === '') {
            return false;
        }

        return self::salvarArquivo($data, $identificador, $ext);
    }

    public static function salvarDeUpload($file, $identificador)
    {
        if (!$file || !isset($file['error']) || $file['error'] !== UPLOAD_ERR_OK) {
            return false;
        }

        if (!is_uploaded_file($file['tmp_name'])) {
            return false;
        }

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif'], true)) {
            $ext = 'jpg';
        }
        if ($ext === 'jpeg') {
            $ext = 'jpg';
        }

        $dir = self::ensureDir();
        if (!$dir) {
            return false;
        }

        self::removerPorIdentificador($identificador);

        $id = self::idArquivo($identificador);
        $filename = $id . '.' . $ext;
        $path = $dir . $filename;

        if (!move_uploaded_file($file['tmp_name'], $path)) {
            return false;
        }

        return self::caminhoRelativo($filename);
    }

    private static function salvarArquivo($data, $identificador, $ext = 'jpg')
    {
        $dir = self::ensureDir();
        if (!$dir) {
            return false;
        }

        self::removerPorIdentificador($identificador);

        $id = self::idArquivo($identificador);
        $filename = $id . '.' . $ext;
        $path = $dir . $filename;

        if (file_put_contents($path, $data) === false) {
            return false;
        }

        return self::caminhoRelativo($filename);
    }

    private static function idArquivo($identificador)
    {
        $id = preg_replace('/\D/', '', (string) $identificador);
        return $id ?: ('user_' . time());
    }

    public static function removerPorIdentificador($identificador)
    {
        $id = preg_replace('/\D/', '', (string) $identificador);
        if (!$id) {
            return;
        }

        foreach (glob(self::dirPath() . $id . '.*') ?: [] as $file) {
            @unlink($file);
        }
    }
}
