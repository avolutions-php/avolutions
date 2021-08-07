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

namespace Avolutions\Command;

use Avolutions\Core\Application;
use Exception;

/**
 * Template class
 *
 * Used to create classes/files from template files.
 *
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.8.0
 */
class Template
{
    /**
     * Content of the template file.
     *
     * @var string
     */
    private string $template;

    /**
     * __construct
     *
     * Creates an new template instance.
     *
     * @param string $templateFile Name of the template file.
     *
     * @throws Exception
     */
    public function __construct(string $templateFile)
    {
        $fileNameWithExtension = $templateFile . '.tpl';
        $fileNameWithAppPath = Application::getCommandTemplatePath() . $fileNameWithExtension;
        $fileNameWithPath = __DIR__ . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . $fileNameWithExtension;

        if (file_exists($fileNameWithAppPath)) {
            $this->template = file_get_contents($fileNameWithAppPath);
        } else {
            if (file_exists($fileNameWithPath)) {
                $this->template = file_get_contents($fileNameWithPath);
            } else {
                throw new Exception('Template file "' . $fileNameWithExtension . '" can not be found.');
            }
        }
    }

    /**
     * assign
     *
     * Replaces a variable/placeholder with a value.
     *
     * @param string $key Name of the variable/placeholder to assign.
     * @param string $value Value to assign.
     */
    public function assign(string $key, string $value)
    {
        $this->template = str_replace('{{ ' . $key . ' }}', $value, $this->template);
    }

    /**
     * save
     *
     * Saves the template including assigned values to a given file/directory.
     *
     * @param string $file Filename including path. Path and file will be created if not exists.
     *
     * @return bool|int Number of bytes that were written to the file, or false on failure.
     */
    public function save(string $file): bool|int
    {
        $directory = dirname($file);
        if (!file_exists($directory)) {
            mkdir($directory);
        }

        return file_put_contents($file, $this->template);
    }
}