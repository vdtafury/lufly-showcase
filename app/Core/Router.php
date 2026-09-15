<?php
declare(strict_types=1);

namespace App\Core;

use App\Helpers\I18n;

class Router
{
    private array $routes = [];

    public function get(string $path, string $handler): void
    {
        $this->addRoute('GET', $path, $handler);
    }

    public function post(string $path, string $handler): void
    {
        $this->addRoute('POST', $path, $handler);
    }

    private function addRoute(string $method, string $path, string $handler): void
    {
        // Convert {param} to named regex pattern
        $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[^/]+)', $path);
        $pattern = '#^' . $pattern . '$#';

        $this->routes[] = [
            'method'  => $method,
            'path'    => $path,
            'pattern' => $pattern,
            'handler' => $handler
        ];
    }

    public function dispatch(string $uri, string $method): void
    {
        // Strip query string
        $cleanUri = parse_url($uri, PHP_URL_PATH) ?? '/';
        $cleanUri = '/' . trim($cleanUri, '/');
        if ($cleanUri === '//') {
            $cleanUri = '/';
        }

        // Multi-lingual locale resolution
        $locale = 'tr'; // Default Turkish
        if ($cleanUri === '/en' || str_starts_with($cleanUri, '/en/')) {
            $locale = 'en';
            $cleanUri = substr($cleanUri, 3);
            $cleanUri = '/' . ltrim($cleanUri, '/');
        } elseif ($cleanUri === '/cs' || str_starts_with($cleanUri, '/cs/')) {
            $locale = 'cs';
            $cleanUri = substr($cleanUri, 3);
            $cleanUri = '/' . ltrim($cleanUri, '/');
        } elseif ($cleanUri === '/tr' || str_starts_with($cleanUri, '/tr/')) {
            $locale = 'tr';
            $cleanUri = substr($cleanUri, 3);
            $cleanUri = '/' . ltrim($cleanUri, '/');
        }

        if ($cleanUri === '//' || $cleanUri === '') {
            $cleanUri = '/';
        }

        I18n::setLocale($locale);

        foreach ($this->routes as $route) {
            if ($route['method'] === $method && preg_match($route['pattern'], $cleanUri, $matches)) {
                // Filter out numerical keys from matches
                $params = array_filter($matches, fn($k) => !is_int($k), ARRAY_FILTER_USE_KEY);

                [$controllerName, $action] = explode('@', $route['handler']);
                $fullController = "App\\Controllers\\{$controllerName}";

                if (!class_exists($fullController)) {
                    throw new \RuntimeException("Controller class {$fullController} not found.");
                }

                $controller = new $fullController();
                if (!method_exists($controller, $action)) {
                    throw new \RuntimeException("Action {$action} not found in {$fullController}.");
                }

                $controller->$action(...$params);
                return;
            }
        }

        // No route matched: 404
        http_response_code(404);
        $fullController = "App\\Controllers\\HomeController";
        if (class_exists($fullController)) {
            $controller = new $fullController();
            $controller->notFound("The page '{$cleanUri}' could not be located.");
        } else {
            echo "<h1>404 Not Found</h1>";
        }
    }
}
