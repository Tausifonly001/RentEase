<?php

declare(strict_types=1);

namespace RentEase\Routing;

/**
 * Class Router
 *
 * A simple Vanilla PHP router that maps HTTP methods and URIs to specific Controller actions.
 * Supports basic exact matching and simple regex for variables (e.g., /products/1).
 */
class Router
{
    private array $routes = [];

    /**
     * Add a GET route
     *
     * @param string $uri The URI to match
     * @param callable|array $action The controller action
     */
    public function get(string $uri, callable|array $action): void
    {
        $this->addRoute('GET', $uri, $action);
    }

    /**
     * Add a POST route
     *
     * @param string $uri The URI to match
     * @param callable|array $action The controller action
     */
    public function post(string $uri, callable|array $action): void
    {
        $this->addRoute('POST', $uri, $action);
    }

    /**
     * Add a PUT route
     *
     * @param string $uri The URI to match
     * @param callable|array $action The controller action
     */
    public function put(string $uri, callable|array $action): void
    {
        $this->addRoute('PUT', $uri, $action);
    }

    /**
     * Add a DELETE route
     *
     * @param string $uri The URI to match
     * @param callable|array $action The controller action
     */
    public function delete(string $uri, callable|array $action): void
    {
        $this->addRoute('DELETE', $uri, $action);
    }

    /**
     * Internal method to add a route
     *
     * @param string $method The HTTP method
     * @param string $uri The URI pattern
     * @param callable|array $action The action to execute
     */
    private function addRoute(string $method, string $uri, callable|array $action): void
    {
        // Convert simple patterns like {id} to regex
        $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<\1>[a-zA-Z0-9_-]+)', $uri);
        $pattern = '#^' . $pattern . '$#';

        $this->routes[] = [
            'method' => $method,
            'pattern' => $pattern,
            'action' => $action
        ];
    }

    /**
     * Dispatch the current request to the matched route
     *
     * @param string $requestUri The requested URI
     * @param string $requestMethod The HTTP method
     * @return bool True if a route was matched and executed, false otherwise.
     */
    public function dispatch(string $requestUri, string $requestMethod): bool
    {
        // Strip query string from URI
        $uri = parse_url($requestUri, PHP_URL_PATH);
        // Normalize base path if project is in a subfolder (like /rentease)
        $basePath = '/rentease'; // Need a better way to handle dynamic base paths, but sticking to this for now.
        if (str_starts_with($uri, $basePath)) {
            $uri = substr($uri, strlen($basePath));
        }
        if ($uri === '') {
            $uri = '/';
        }

        foreach ($this->routes as $route) {
            if ($route['method'] === $requestMethod && preg_match($route['pattern'], $uri, $matches)) {
                // Filter out integer keys from preg_match
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

                $action = $route['action'];

                if (is_callable($action)) {
                    call_user_func_array($action, $params);
                    return true;
                }

                if (is_array($action) && count($action) === 2) {
                    [$class, $method] = $action;
                    if (class_exists($class)) {
                        $controller = new $class();
                        if (method_exists($controller, $method)) {
                            call_user_func_array([$controller, $method], $params);
                            return true;
                        }
                    }
                }
            }
        }

        return false;
    }
}
