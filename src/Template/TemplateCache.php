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
use FilesystemIterator;
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
    /**
     * TODO
     *
     * @var string
     */
    private string $directory;

    /**
     * __construct
     *
     * TODO
     */
    public function __construct()
    {
        $this->directory = Application::getViewPath() . Config::get('template/cache/directory') . DIRECTORY_SEPARATOR;
    }

    /**
     * isCached
     *
     * TODO
     *
     * @param string $templateFile TODO
     *
     * @return bool TODO
     */
    public function isCached(string $templateFile): bool
    {
        return file_exists($this->directory . $templateFile);
    }

    /**
     * getCachedFilename
     *
     * TODO
     *
     * @param string $templateFile TODO
     *
     * @return string TODO
     */
    public function getCachedFilename(string $templateFile): string
    {
        return $this->directory . $templateFile;
    }

    /**
     * cache
     *
     * TODO
     *
     * @param string $filename TODO
     * @param string $content TODO
     */
    public function cache(string $filename, string $content)
    {
        $filename = $this->directory . $filename;

        $directory = dirname($filename);
        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }

        $content = '<?php' . PHP_EOL . $content;

        file_put_contents($filename, $content);
    }

    /**
     * clear
     *
     * TODO
     *
     * @param string|null $file TODO
     *
     * @return bool TODO
     *
     * @throws Exception
     */
    public function clear(?string $file = null): bool
    {
        $fullFilename = $this->directory;

        if ($file !== null) {
            // TODO
            $fullFilename .= $file . '.php';
        }

        // TODO handle errors on delete
        if (is_dir($fullFilename)) {
            $DirectoryIterator = new RecursiveDirectoryIterator($fullFilename, FilesystemIterator::SKIP_DOTS);
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

    /**
     * deleteFile
     *
     * TODO
     *
     * @param string $file TODO
     *
     * @throws Exception
     */
    private function deleteFile(string $file)
    {
        if (!unlink($file)) {
            throw new Exception('Unable to delete ' . $file);
        }
    }
}