<?php
declare(strict_types=1);

namespace App\Core;

/**
 * Class View
 * Moteur de vue PHP minimaliste (layouts + variables)
 */
final class View {
    public static function render(string $view, array $params = [], string $layout = 'layouts/main'): string {
        $viewFile   = dirname(__DIR__, 2) . '/views/' . $view . '.php';
        $layoutFile = dirname(__DIR__, 2) . '/views/' . $layout . '.php';

        if (!file_exists($viewFile)) {
            throw new \RuntimeException("View introuvable : {$viewFile}");
        }

        extract($params, EXTR_SKIP);

        ob_start();
        require $viewFile;
        $content = ob_get_clean();

        ob_start();
        require $layoutFile;
        return (string) ob_get_clean();
    }
}
