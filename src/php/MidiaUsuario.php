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
