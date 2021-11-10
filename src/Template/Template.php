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
     * @var string $content
     */
    private string $content = '';

    /**
     * TODO
     *
     * @var Template|null $MasterTemplate
     */
    private ?Template $MasterTemplate = null;

    /**
     * TODO
     *
     * @var TemplateCache $TemplateCache
     */
    private TemplateCache $TemplateCache;

    /**
     * TODO
     *
     * @var string $file
     */
    private string $file;

    /**
     * TODO
     *
     * @var array
     */
    private array $data;

    /**
     * TODO
     *
     * @var array
     */
    private array $sections = [];

    /**
     * __construct
     *
     * Creates a new template instance.
     *
     * @param string $templateFile Name of the template file.
     * @param array $data TODO
     *
     * @throws Exception
     */
    public function __construct(string $templateFile, array $data = [])
    {
        $this->data = $data;
        $this->file = $templateFile;
        $this->TemplateCache = new TemplateCache();

        $useCache = Config::get('template/cache/use');
        $isCached = $this->isCached();

        if (!$useCache || !$isCached) {
            // TODO find better solution
            $templateFile = Application::getViewPath() . $templateFile;
            if (file_exists($templateFile)) {
                $this->content = file_get_contents($templateFile);
            } else {
                throw new Exception('Template file "' . $templateFile . '" can not be found.');
            }

            $this->setMasterTemplate();
            $this->setSections();
        }
    }

    /**
     * parse
     *
     * TODO
     */
    public function parse()
    {
        $useCache = Config::get('template/cache/use');
        $isCached = $this->isCached();

        if (($useCache && !$isCached) || !$useCache) {
            $TemplateParser = new TemplateParser($this);
            $this->content = $TemplateParser->parse($this->content);

            if ($useCache && !$isCached) {
                $this->cache();
            }
        }
    }

    /**
     * isCached
     *
     * TODO
     *
     * @return bool
     */
    public function isCached(): bool
    {
        return $this->TemplateCache->isCached($this->file);
    }

    /**
     * cache
     *
     * TODO
     *
     */
    public function cache()
    {
        $this->TemplateCache->cache($this->file, $this->content);
    }

    /**
     * render
     *
     * TODO
     *
     * @return string TODO
     */
    public function render(): string
    {
        $this->parse();

        $data = $this->data;

        ob_start();

        if (Config::get('template/cache/use')) {
            include $this->TemplateCache->getCachedFilename($this->file);
        } else {
            eval($this->content);
        }

        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }

    /**
     * setMasterTemplate
     *
     * TODO
     *
     * @throws Exception
     */
    private function setMasterTemplate() {
        preg_match('@{{ master \'([a-zA-z0-9/_-]*)\' }}@', $this->content, $matches);
        if (!empty($matches)) {
            // template uses master template
            $this->MasterTemplate = new Template($matches[1] . '.php');
        }
    }

    /**
     * hasMasterTemplate
     *
     * TODO
     *
     * @return bool TODO
     */
    public function hasMasterTemplate(): bool
    {
        return $this->MasterTemplate !== null;
    }

    /**
     * getContent
     *
     * TODO
     *
     * @return string TODO
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * getParsedContent
     *
     * TODO
     *
     * @return string TODO
     */
    public function getParsedContent(): string
    {
        $this->parse();

        // TODO as properties?
        $useCache = Config::get('template/cache/use');
        $isCached = $this->isCached();

        if ($useCache && $isCached) {
            return str_replace(['<?php', '?>', '<?='], '', file_get_contents($this->TemplateCache->getCachedFilename($this->file)));
        }
    }

    /**
     * getMasterTemplate
     *
     * TODO
     *
     * @return Template|null TODO
     */
    public function getMasterTemplate(): ?Template
    {
        return $this->MasterTemplate;
    }

    /**
     * setSections
     *
     * TODO
     */
    public function setSections()
    {
        // TODO handle end section
        preg_match_all('/{{ section ([a-zA-z0-9_-]*) }}(.*?){{ \/section }}/is', $this->content, $sections, PREG_SET_ORDER);
        if (!empty($sections)) {
            // template has sections
            $TemplateParser = new TemplateParser();
            foreach ($sections as $section) {
                $this->sections[$section[1]] = $TemplateParser->parse($section[2]);
            }
        }
    }

    /**
     * getSections
     *
     * TODO
     *
     * @return array TODO
     */
    public function getSections(): array
    {
        return $this->sections;
    }
}