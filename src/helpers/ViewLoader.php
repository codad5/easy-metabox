<?php
namespace Codad5\EasyMetabox\helpers;

/**
 * Class ViewLoader
 *
 * A simple view loader similar to WordPress' get_template_part.
 * This class loads template files from a defined base path, supports multiple file extensions,
 * extracts provided data into the template's scope, and buffers the output.
 *
 * @package Codad5\EasyMetabox\helpers
 */
class ViewLoader
{
    /**
     * Base path for the templates.
     *
     * @var string
     */
    const BASE_VIEW_PATH = __DIR__ . '/../../templates';

    /**
     * Load a view file with optional data and echoing.
     *
     * This method attempts to resolve the provided view name by checking for a file
     * with an extension. If no extension is provided, it will try appending '.php' or '.html'.
     * If the view is a directory, it looks for an index.php file inside that directory.
     * Data provided in the $data array is extracted so that each key becomes a variable
     * available in the view file.
     *
     * @param string $view The relative view path (e.g., 'partials/header').
     * @param array  $data Optional. Data to be extracted as variables within the view.
     * @param bool   $echo Optional. Whether to echo the output. Default true.
     *
     * @return string|bool The rendered output if found, or false if the file is not found.
     */
    public static function load(string $view, array $data = [], bool $echo = true): bool|string
    {
        // Resolve the absolute base path.
        $basePath = realpath(self::BASE_VIEW_PATH);
        if (!$basePath) {
            if ($echo) {
                echo "Base view path not found";
            }
            return false;
        }

        // Build the full view path.
        $view = ltrim($view, '/');
        $fullPath = $basePath . '/' . $view;
        $finalPath = null;

        // If a file extension is provided, check that file or its directory index.
        if (pathinfo($fullPath, PATHINFO_EXTENSION)) {
            $finalPath = (is_file($fullPath))
                ? $fullPath
                : (is_dir($fullPath) && is_file($fullPath . '/index.php')
                    ? $fullPath . '/index.php'
                    : null);
        } else {
            // Try available extensions.
            foreach (['.php', '.html'] as $ext) {
                if (is_file($fullPath . $ext)) {
                    $finalPath = $fullPath . $ext;
                    break;
                }
            }
            // Check if it's a directory with an index.php.
            if (!$finalPath && is_dir($fullPath) && is_file($fullPath . '/index.php')) {
                $finalPath = $fullPath . '/index.php';
            }
        }

        if (!$finalPath) {
            if ($echo) {
                echo "Template file not found: $view";
            }
            return false;
        }

        // Extract data and buffer the output.
        extract($data, EXTR_OVERWRITE);
        ob_start();
        include $finalPath;
        $output = ob_get_clean();

        if ($echo) {
            echo $output;
        }
        return $output;
    }
}
