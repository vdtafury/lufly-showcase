<?php
declare(strict_types=1);

namespace App\Core;

use RuntimeException;

abstract class Controller
{
    /**
     * Render a view file inside app/Views/ with optional layout wrapper
     */
    protected function render(string $view, array $data = [], string $layout = 'main'): void
    {
        $viewPath = dirname(__DIR__) . '/Views/' . $view . '.php';
        if (!file_exists($viewPath)) {
            throw new RuntimeException("View file not found: {$viewPath}");
        }

        // Extract variables into view scope
        extract($data, EXTR_SKIP);

        // Capture view content buffer
        ob_start();
        require $viewPath;
        $content = ob_get_clean();

        if ($layout === '') {
            echo $content;
            return;
        }

        $layoutPath = dirname(__DIR__) . '/Views/layouts/' . $layout . '.php';
        if (!file_exists($layoutPath)) {
            throw new RuntimeException("Layout file not found: {$layoutPath}");
        }

        require $layoutPath;
    }

    protected function json(mixed $data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit;
    }

    protected function redirect(string $url, int $statusCode = 302): void
    {
        http_response_code($statusCode);
        header("Location: {$url}");
        exit;
    }

    public function notFound(string $message = 'Page not found'): void
    {
        http_response_code(404);
        $this->render('404', [
            'pageTitle' => '404 - Page Not Found | Lufly Architectural Ceramics',
            'metaDescription' => 'The requested page could not be found.',
            'errorMessage' => $message,
            'canonicalUrl' => '/404'
        ]);
        exit;
    }
}
