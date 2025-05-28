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
        // Convert dot or slash notation to path (e.g., partials.header -> app/Views/partials/header.php)
        $viewPath = __DIR__ . '/../app/Views/' . str_replace('.', '/', $view) . '.php';

        // Debug: Log the view path
        error_log("Loading view: $viewPath");

        // Check if the view file exists
        if (!file_exists($viewPath)) {
            throw new \Exception("View file not found: $viewPath");
        }

        // Extract data to make variables available in the view
        extract($data, EXTR_SKIP);

        // Include the view file
        require $viewPath;
    }
}