<?php

class Auth
{
    private const Publicpages = ['/', '/login']; // pages public not authentication

    public static function check(string $path): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $pathsummary = self::cleanpath(parse_url($path, PHP_URL_PATH) ?? '/');

        if (in_array($pathsummary, self::Publicpages, true)) {
            return;
        }

        if (empty($_SESSION['user'])) {
            header('Location: /GEM_mvc/public/login');
            exit;
        }
    }

    private static function cleanpath(string $path): string
    {
        $path = '/' . ltrim($path, '/');
        $basePath = defined('BASE_URL') ? rtrim(BASE_URL, '/') : '';

        if (
            $basePath !== '' && $basePath !== '/' && strpos($path, $basePath) === 0
        ) {
            $path = substr($path, strlen($basePath));
            $path = '/' . ltrim($path, '/');
        }

        $path = rtrim($path, '/');

        if ($path === '') {
            $path = '/';
        }

        return $path;

    }
}