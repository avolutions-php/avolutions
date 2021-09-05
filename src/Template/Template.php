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

use Avolutions\Core\Application;

use Avolutions\View\View;
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
     * @var string $template
     */
    private string $template;

    private array $data = [];

    /**
     * __construct
     *
     * Creates an new template instance.
     *
     * @param string $templateFile Name of the template file.
     *
     * @throws Exception
     */
    public function __construct(string $templateFile, array $data = [])
    {
        if (file_exists($templateFile)) {
            $this->template = file_get_contents($templateFile);
        } else {
            throw new Exception('Template file "' . $templateFile . '" can not be found.');
        }

        $this->data = $data;

        $TemplateParser = new TemplateParser();
        $Tokens = $TemplateParser->tokenize($this->template);
        $Tokens = $TemplateParser->parse($Tokens);

        $test = '';
        foreach ($Tokens as $Token) {
            $test .= $Token->value;
        }
        print $test;
        print eval($test);
    }

    /**
     * assign
     *
     * Replaces a variable/placeholder with a value.
     *
     * @param string $key Name of the variable/placeholder to assign.
     * @param string $value Value to assign.
     */
    public function assign(string $key, string $value): void
    {
        $this->template = str_replace('{{ $' . $key . ' }}', $value, $this->template);
        $this->template = str_replace('$' . $key, $value, $this->template);
    }

    public function __set(string $name, $value): void
    {
        $this->assign($name, $value);
    }

    private function parse()
    {
        /*$this->template = preg_replace('/{{ \$([a-zA-Z]*) }}/', '<?php print \$${1}; ?>', $this->template);
        $this->template = str_replace('{{', '<?=', $this->template);
        $this->template = str_replace('}}', '?>', $this->template);*/

        $this->parseMaster();
    }

    private function parseMaster()
    {
        preg_match('@{{ master \'([a-zA-z0-9/_-]*)\' }}@', $this->template, $matches);
        if (!empty($matches)) {
            // template uses master template
            $MasterTemplate = new Template(Application::getViewPath() . $matches[1] . '.php');

            preg_match_all('/{{ section ([a-zA-z0-9_-]*) }}(.*?){{ \/section }}/is', $this->template, $sections, PREG_SET_ORDER);

            if (!empty($sections)) {
                // template has sections
                $this->template = $MasterTemplate->parseSections($sections);
            }
        }
    }

    public function parseSections(array $sections): string
    {
        foreach ($sections as $section) {
            $this->template = str_replace('{{ section ' . $section[1] . ' }}', $section[2], $this->template);
        }

        return $this->template;
    }

    public function render(): string
    {
        //$this->parse();
        return $this->template;
    }
}