<?php
/**
 * TODO
 */
namespace Avolutions\Command;

use Exception;

/**
 * TODO
 */
class Template
{
    /**
     * TODO
     *
     * @var string TODO
     */
    private string $template;

    /**
     * TODO
     *
     * @param string $templateFile TODO
     *
     * @throws Exception
     */
    public function __construct(string $templateFile)
    {
        // TODO search in application path
        $fileNameWithExtension = $templateFile . '.tpl';
        $fileNameWithPath = __DIR__ . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . $fileNameWithExtension;

        if(file_exists($fileNameWithPath)) {
            $this->template = file_get_contents($fileNameWithPath);
        } else {
            throw new Exception('Template file "' . $fileNameWithExtension . '" can not be found.');
        }
    }

    /**
     * TODO
     *
     * @param string $key TODO
     * @param string $value TODO
     */
    public function assign(string $key, string $value)
    {
        $this->template = str_replace('{{ ' . $key . ' }}', $value, $this->template);
    }

    /**
     * TODO
     *
     * @param string $file TODO
     *
     * @return bool|int TODO
     */
    public function save(string $file): bool|int
    {
        $directory = dirname($file);
        if (!file_exists($directory)) {
            mkdir($directory);
        };

        return file_put_contents($file, $this->template);
    }
}