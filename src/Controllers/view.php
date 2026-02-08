<?php

namespace App\Controllers;

class view
{
    public static function render(string $view, array $data = [], $cms = false): string
    {
        global $config;
        extract($data);

        ob_start();
        include __DIR__ . "/../../views/$view.php";
        $content = ob_get_clean();

        ob_start();
        if($cms){
            include __DIR__ . "/../../views/cms/cmslayout.php";
        } else {
            include __DIR__ . "/../../views/layout.php";
        }
        return ob_get_clean();
    }
}