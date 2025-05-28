<?php
if (!function_exists('view')) {
    /**
     * Load a view or partial file from app/Views and pass data to it.
     *
     * @param string $view Path to the view file (e.g., 'partials/header' or 'users/show')
     * @param array $data Data to extract into the view
     * @return void
     * @throws \Exception If the view file is not found
     */
    function view(string $view, array $data = []): void {
        $viewPath = __DIR__ . '/../app/Views/' . str_replace('.', '/', $view) . '.php';
        error_log("Loading view: $viewPath");
        if (!file_exists($viewPath)) {
            throw new \Exception("View file not found: $viewPath");
        }
        extract($data, EXTR_SKIP);
        require $viewPath;
    }
}

if (!function_exists('redirect')) {
    /**
     * Redirect to a given URL.
     *
     * @param string $url The URL to redirect to
     * @param int $status HTTP status code (e.g., 302)
     * @return void
     */
    function redirect(string $url, int $status = 302): void {
        header("Location: $url", true, $status);
        exit;
    }
}

if (!function_exists('url')) {
    /**
     * Generate a full URL for the application.
     *
     * @param string $path The path (e.g., 'users/7')
     * @return string The full URL
     */
    function url(string $path = ''): string {
        $baseUrl = rtrim($_ENV['APP_URL'] ?? 'http://localhost/ROUND64/PHP/new-skeleton/php-boilerplate', '/');
        return $baseUrl . '/' . ltrim($path, '/');
    }
}

if (!function_exists('escape')) {
    /**
     * Escape HTML special characters.
     *
     * @param string $string The string to escape
     * @return string The escaped string
     */
    function escape(string $string): string {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }
}