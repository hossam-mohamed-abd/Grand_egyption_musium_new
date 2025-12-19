<?php

class Router
{
    private array $routes = [];
    private string $basePath;

    public function __construct(string $basePath = '/')
    {
        $this->basePath = rtrim($basePath, '/');
    }

    public function get(string $path, callable $action): void
    {
        $this->addRoute('GET', $path, $action);
    }

    public function post(string $path, callable $action): void
    {
        $this->addRoute('POST', $path, $action);
    }

    private function addRoute(string $method, string $path, callable $action): void
    {
        $pathsummary = $this->cleanpath($path); //pathsummary==> storage a path after clanning
        $this->routes[$method][$pathsummary] = $action;
    }


    private function cleanpath(string $path): string
    {
        $path = '/' . ltrim($path, '/');

        if ($this->basePath && strpos($path, $this->basePath) === 0) {
            $path = substr($path, strlen($this->basePath));
            $path = '/' . ltrim($path, '/');
        }

        $path = rtrim($path, '/');

        if ($path === '') {
            $path = '/';
        }

        return $path;

    }

    public function dispatch(string $uri, string $method = 'GET'): void
    {
        $method = strtoupper($method);
        $path = $this->cleanpath(parse_url($uri, PHP_URL_PATH) ?? '/');

        if (isset($this->routes[$method][$path])) {
            ($this->routes[$method][$path])();
            return;
        }

        http_response_code(404);
        require VIEW_PATH . 'home.php';
    }

}