<?php

class SiteConfig
{
    const SETTINGS_FILE = 'data/site-settings.json';

    private static $settings = null;

    public static function projectDir()
    {
        return dirname(__DIR__, 2) . '/';
    }

    public static function settingsPath()
    {
        return self::projectDir() . self::SETTINGS_FILE;
    }

    public static function load()
    {
        if (self::$settings !== null) {
            return self::$settings;
        }

        $defaults = [
            'force_https' => 'auto',
        ];

        $path = self::settingsPath();

        if (!is_file($path)) {
            self::$settings = $defaults;
            return self::$settings;
        }

        $json = file_get_contents($path);
        $data = json_decode($json, true);

        if (!is_array($data)) {
            self::$settings = $defaults;
            return self::$settings;
        }

        self::$settings = array_merge($defaults, $data);

        return self::$settings;
    }

    public static function getForceHttps()
    {
        $modo = self::load()['force_https'] ?? 'auto';

        if (in_array($modo, ['auto', 'https', 'http'], true)) {
            return $modo;
        }

        return 'auto';
    }

    public static function setForceHttps($modo)
    {
        if (!in_array($modo, ['auto', 'https', 'http'], true)) {
            return false;
        }

        $settings = self::load();
        $settings['force_https'] = $modo;

        $dir = dirname(self::settingsPath());
        if (!is_dir($dir) && !mkdir($dir, 0755, true) && !is_dir($dir)) {
            return false;
        }

        $json = json_encode($settings, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        if ($json === false) {
            return false;
        }

        if (file_put_contents(self::settingsPath(), $json, LOCK_EX) === false) {
            return false;
        }

        self::$settings = $settings;

        return true;
    }

    public static function detectHttps()
    {
        if (!empty($_SERVER['HTTPS']) && strtolower((string) $_SERVER['HTTPS']) !== 'off') {
            return true;
        }

        if (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && strtolower((string) $_SERVER['HTTP_X_FORWARDED_PROTO']) === 'https') {
            return true;
        }

        if (!empty($_SERVER['HTTP_X_FORWARDED_SSL']) && strtolower((string) $_SERVER['HTTP_X_FORWARDED_SSL']) === 'on') {
            return true;
        }

        if (isset($_SERVER['SERVER_PORT']) && (int) $_SERVER['SERVER_PORT'] === 443) {
            return true;
        }

        return false;
    }

    public static function urlScheme()
    {
        $modo = self::getForceHttps();

        if ($modo === 'https') {
            return 'https';
        }

        if ($modo === 'http') {
            return 'http';
        }

        return self::detectHttps() ? 'https' : 'http';
    }

    public static function montarBaseUrl()
    {
        $host = $_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME'] ?? 'localhost';
        $path = str_replace('index.php', '', $_SERVER['SCRIPT_NAME'] ?? '/');

        return self::urlScheme() . '://' . $host . $path;
    }

    public static function aplicarRedirecionamento()
    {
        if (PHP_SAPI === 'cli' || headers_sent()) {
            return;
        }

        $modo = self::getForceHttps();

        if ($modo === 'auto') {
            return;
        }

        $isHttps = self::detectHttps();
        $querHttps = $modo === 'https';

        if ($querHttps && !$isHttps) {
            self::redirecionar('https');
        }

        if (!$querHttps && $isHttps) {
            self::redirecionar('http');
        }
    }

    private static function redirecionar($scheme)
    {
        $host = $_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME'] ?? 'localhost';
        $uri = $_SERVER['REQUEST_URI'] ?? '/';

        header('Location: ' . $scheme . '://' . $host . $uri, true, 301);
        exit;
    }

    public static function rotuloForceHttps($modo = null)
    {
        $modo = $modo ?? self::getForceHttps();

        switch ($modo) {
            case 'https':
                return 'Forçar HTTPS';
            case 'http':
                return 'Forçar HTTP';
            default:
                return 'Automático';
        }
    }
}
