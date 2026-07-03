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
        return SiteConfig::garantirDirGravavel(self::dirPath()) ?: false;
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
        foreach (['fotoUrl', 'foto'] as $campo) {
            if (empty($user[$campo])) {
                continue;
            }

            if (strpos($user[$campo], 'data:') === 0) {
                return $user[$campo];
            }

            $url = self::resolverUrlPublica($user[$campo]);
            if ($url !== null) {
                return $url;
            }
        }

        $urlArquivo = self::urlPorArquivoLocal($user);
        if ($urlArquivo !== null) {
            return $urlArquivo;
        }

        return BASE_URL . 'src/midia/user.webp';
    }

    /**
     * Converte caminho relativo ou URL absoluta legada para URL pública do ambiente atual.
     */
    public static function resolverUrlPublica($caminho)
    {
        $relativo = self::normalizarCaminhoRelativo($caminho);
        if ($relativo === null) {
            return null;
        }

        if (preg_match('#^https?://#i', $relativo)) {
            return $relativo;
        }

        return BASE_URL . ltrim($relativo, '/');
    }

    private static function normalizarCaminhoRelativo($caminho)
    {
        $caminho = trim((string) $caminho);
        if ($caminho === '' || strpos($caminho, 'data:') === 0) {
            return $caminho;
        }

        if (preg_match('#^https?://#i', $caminho)) {
            $path = parse_url($caminho, PHP_URL_PATH) ?: '';

            if (preg_match('#/(src/midia/.+)$#i', $path, $m)) {
                return $m[1];
            }

            if (preg_match('#^https?://(localhost|127\.0\.0\.1)#i', $caminho)) {
                return null;
            }

            $hostAtual = parse_url(BASE_URL, PHP_URL_HOST);
            $hostUrl = parse_url($caminho, PHP_URL_HOST);
            if ($hostAtual && $hostUrl && strcasecmp($hostAtual, $hostUrl) === 0 && $path !== '') {
                return ltrim($path, '/');
            }

            return $caminho;
        }

        return ltrim($caminho, '/');
    }

    private static function urlPorArquivoLocal($user)
    {
        $identificadores = [];

        if (!empty($user['id'])) {
            $identificadores[] = preg_replace('/\D/', '', (string) $user['id']);
        }
        if (!empty($user['cpf'])) {
            $identificadores[] = preg_replace('/\D/', '', (string) $user['cpf']);
        }

        foreach (array_unique(array_filter($identificadores)) as $id) {
            foreach (glob(self::dirPath() . $id . '.*') ?: [] as $file) {
                if (is_file($file)) {
                    return self::urlPublica(basename($file));
                }
            }
        }

        return null;
    }

    /**
     * Caminho absoluto ou data URI da foto para uso em PDF (mPDF).
     */
    public static function caminhoAbsolutoDoUsuario($user)
    {
        foreach (['fotoUrl', 'foto'] as $campo) {
            if (empty($user[$campo]) || strpos($user[$campo], 'data:') === 0) {
                if (!empty($user[$campo]) && strpos($user[$campo], 'data:') === 0) {
                    return $user[$campo];
                }
                continue;
            }

            $relativo = self::normalizarCaminhoRelativo($user[$campo]);
            if ($relativo === null || preg_match('#^https?://#i', $relativo)) {
                continue;
            }

            $abs = BASE_DIR . str_replace('/', DIRECTORY_SEPARATOR, ltrim($relativo, '/'));
            if (is_file($abs)) {
                return $abs;
            }
        }

        $identificadores = [];
        if (!empty($user['id'])) {
            $identificadores[] = preg_replace('/\D/', '', (string) $user['id']);
        }
        if (!empty($user['cpf'])) {
            $identificadores[] = preg_replace('/\D/', '', (string) $user['cpf']);
        }

        foreach (array_unique(array_filter($identificadores)) as $id) {
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
