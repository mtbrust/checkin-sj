<?php

class MidiaVisitante
{
    const DIR = 'src/midia/visitantes/';

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

    public static function urlDoVisitante($visitante)
    {
        if (empty($visitante['foto'])) {
            return '';
        }

        $caminho = $visitante['foto'];

        if (strpos($caminho, 'data:') === 0) {
            return $caminho;
        }

        if (strpos($caminho, 'http') === 0) {
            return $caminho;
        }

        return BASE_URL . ltrim($caminho, '/');
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

        $data = base64_decode($base64, true);

        if ($data === false || $data === '') {
            return false;
        }

        return self::salvarArquivo($data, $identificador, $ext);
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
        return $id ? ('v' . $id) : ('v_' . time());
    }

    public static function removerPorIdentificador($identificador)
    {
        $id = self::idArquivo($identificador);
        if (!$id) {
            return;
        }

        foreach (glob(self::dirPath() . $id . '.*') ?: [] as $file) {
            @unlink($file);
        }
    }
}
