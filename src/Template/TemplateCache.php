<?php
/**
 * AVOLUTIONS
 *
 * Just another open source PHP framework.
 *
 * @copyright   Copyright (c) 2019 - 2021 AVOLUTIONS
 * @license     MIT License (https://avolutions.org/license)
 * @link        https://avolutions.org
 */

namespace Avolutions\Template;

use Avolutions\Config\Config;
use Avolutions\Core\Application;

use Exception;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

/**
 * Template class
 *
 * TODO
 *
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.9.0
 */
class TemplateCache
{
    private string $directory;

    public function __construct()
    {
        $this->directory = Application::getViewPath() . Config::get('template/cache/directory') . DIRECTORY_SEPARATOR;
    }

    public function isCached(string $templateFile)
    {
        return file_exists($this->directory . $templateFile);
    }

    public function getCachedFilename(string $templateFile)
    {
        return $this->directory . $templateFile;
    }

    public function cache(string $filename, string $content)
    {
        $filename = $this->directory . $filename;

        $directory = dirname($filename);
        if (!file_exists($directory)) {
            mkdir($directory);
        }

        $content = '<?php' . PHP_EOL . $content;

        file_put_contents($filename, $content);
    }

    public function clear(?string $file = null): bool
    {
        $fullFilename = $this->directory;

        if ($file !== null) {
            // TODO
            $fullFilename .= $file . '.php';
        }

        // TODO handle errors on delete
        if (is_dir($fullFilename)) {
            $DirectoryIterator = new RecursiveDirectoryIterator($fullFilename, RecursiveDirectoryIterator::SKIP_DOTS);
            $Iterator = new RecursiveIteratorIterator($DirectoryIterator);

            foreach ($Iterator as $file) {
                $this->deleteFile($file);
            }

            return true;
        }

        if (is_file($fullFilename)) {
            $this->deleteFile($fullFilename);
            return true;
        }

        throw new Exception($fullFilename . ' is not a valid cached template file');
    }

    private function deleteFile($file)
    {
        if (!unlink($file)) {
            throw new Exception('Unable to delete ' . $file);
        }
    }
}