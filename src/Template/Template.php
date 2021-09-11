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

use Avolutions\View\View;
use Exception;

/**
 * Template class
 *
 * TODO
 *
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.9.0
 */
class Template
{
    /**
     * Content of the template file.
     *
     * @var string $template
     */
    // TODO rename to $content
    private string $template = '';

    private ?Template $MasterTemplate = null;

    private TemplateCache $TemplateCache;

    private string $file;

    private array $data = [];

    private array $sections = [];

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
        $this->data = $data;
        $this->file = $templateFile;
        $this->TemplateCache = new TemplateCache();

        if (!Config::get('template/cache/use') || !$this->isCached()) {
            // TODO find better solution
            $templateFile = Application::getViewPath() . $templateFile;
            if (file_exists($templateFile)) {
                $this->template = file_get_contents($templateFile);
            } else {
                throw new Exception('Template file "' . $templateFile . '" can not be found.');
            }

            $this->setMasterTemplate();
            $this->setSections();
        }
    }

    public function parse()
    {
        $TemplateParser = new TemplateParser($this);

        return $TemplateParser->parse();
    }

    public function isCached()
    {
        return $this->TemplateCache->isCached($this->file);
    }

    public function render()
    {
        $data = $this->data;
        ob_start();

        if (Config::get('template/cache/use')) {
            if (!$this->isCached()) {
                $this->TemplateCache->cache($this->file, $this->parse());
            }

            include $this->TemplateCache->getCachedFilename($this->file);
        } else {
            eval($this->parse());
        }

        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }

    private function setMasterTemplate() {
        preg_match('@{{ master \'([a-zA-z0-9/_-]*)\' }}@', $this->template, $matches);
        if (!empty($matches)) {
            // template uses master template
            $this->MasterTemplate = new Template($matches[1] . '.php');
        }
    }

    public function hasMasterTemplate()
    {
        return $this->MasterTemplate !== null;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->template;
    }

    public function getMasterTemplate()
    {
        return $this->MasterTemplate;
    }

    public function setSections()
    {
        preg_match_all('/{{ section ([a-zA-z0-9_-]*) }}(.*?){{ \/section }}/is', $this->template, $sections, PREG_SET_ORDER);
        if (!empty($sections)) {
            // template has sections
            $this->sections = $sections;
        }
    }

    /**
     * @return array
     */
    public function getSections(): array
    {
        return $this->sections;
    }
}