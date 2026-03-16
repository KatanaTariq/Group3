<?php

class BaseController
{
    /**
     * Render a view file with optional data.
     *
     * Example:
     *   $this->render('/src/view/pages/home.php', ['name' => 'Katana']);
     */
    protected function render(string $viewPath, array $data = []): void
    {
        // Make $data keys available as variables in the view
        extract($data);

        require $viewPath;
    }

    /**
     * Simple redirect helper.
     */
    protected function redirect(string $path): void
    {
        header('Location: ' . $path);
        exit;
    }
}
