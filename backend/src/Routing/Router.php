<?php

declare(strict_types=1);

namespace RentEase\Routing;

use Closure;

final class Router
{
    /**
     * @var array<int, array{method: string, path: string, handler: callable|array}> */
    private array $routes = [];

    public function get(string $path, callable|array $handler): void
    {
        $this->add('GET', $path, $handler);
    }

    public function post(string $path, callable|array $handler): void
    {
        $this->add('POST', $path, $handler);
    }

    private function add(string $method, string $path, callable|array $handler): void
    {
        $path = '/' . ltrim($path, '/');
        $this->routes[] = [
            'method' => strtoupper($method),
            'path' => rtrim($path, '/'),
            'handler' => $handler,
        ];
    }

    public function dispatch(string $uri, string $method): bool
    {
        $uri = '/' . ltrim($uri, '/');
        $uri = rtrim($uri, '/');
        if ($uri === '') {
            $uri = '/';
        }

        $method = strtoupper($method);

        foreach ($this->routes as $route) {
            if ($route['method'] !== $method) {
                continue;
            }

            $params = [];
            if (!$this->match($route['path'], $uri, $params)) {
                continue;
            }

            $this->invoke($route['handler'], $params);
            return true;
        }

        return false;
    }

    /**
     * @param array<string,string> $params
     */
    private function match(string $routePath, string $uri, array &$params): bool
    {
        // exact match fast path
        if ($routePath === $uri) {
            return true;
        }

        // Convert route patterns with {param} into a regex.
        // Example: /api/orders/{id} => ^/api/orders/(?P<id>[^/]+)$
        $pattern = preg_replace_callback('/\{([a-zA-Z_][a-zA-Z0-9_]*)\}/', static function (array $m): string {
            return '(?P<' . $m[1] . '>[^/]+)';
        }, $routePath);

        if (!is_string($pattern)) {
            return false;
        }

        $pattern = '#^' . $pattern . '$#';

        $matches = [];
        if (!preg_match($pattern, $uri, $matches)) {
            return false;
        }

        foreach ($matches as $key => $value) {
            if (!is_string($key)) {
                continue;
            }
            if ($value === '' || $value === null) {
                continue;
            }
            $params[$key] = (string) $value;
        }

        return true;
    }

    /**
     * @param array<string,string> $params
     */
    private function invoke(callable|array $handler, array $params): void
    {
        // Handler can be a callable/Closure OR a controller-style array: [ClassName::class, 'method']
        if ($handler instanceof Closure || is_callable($handler)) {
            // If the closure expects an id-like param, we pass it positionally.
            // Our router provides named params; we map them to argument list by key order.
            // For common usage: /api/orders/{id} handler declared as function($id) ...
            $args = [];
            foreach ($params as $value) {
                $args[] = $value;
            }
            call_user_func_array($handler, $args);
            return;
        }

        if (is_array($handler) && count($handler) === 2 && is_string($handler[0]) && is_string($handler[1])) {
            $class = $handler[0];
            $method = $handler[1];

            if (!class_exists($class)) {
                throw new \RuntimeException("Controller class not found: {$class}");
            }
            if (!method_exists($class, $method)) {
                throw new \RuntimeException("Controller method not found: {$class}::{$method}");
            }

            $controller = new $class();

            // Try calling with route params if any.
            if ($params !== []) {
                $args = [];
                foreach ($params as $value) {
                    $args[] = $value;
                }
                $controller->{$method}(...$args);
            } else {
                $controller->{$method}();
            }

            return;
        }

        throw new \RuntimeException('Invalid route handler provided to Router');
    }
}

