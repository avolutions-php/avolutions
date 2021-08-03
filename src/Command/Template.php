<?php
/**
 * TODO
 */
namespace Avolutions\Command;

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
     */
    public function __construct(string $templateFile)
    {
        $this->template = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . $templateFile . '.tpl');
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