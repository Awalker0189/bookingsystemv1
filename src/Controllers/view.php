<?php

namespace App\Controllers;

class view
{
    public static function render(string $view, array $data = []): string
    {
        extract($data);

        ob_start();
        include __DIR__ . "/../../views/$view.php";
        $content = ob_get_clean();

        ob_start();
        include __DIR__ . "/../../views/layout.php";
        return ob_get_clean();
    }
}