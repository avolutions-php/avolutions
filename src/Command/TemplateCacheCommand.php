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
use Avolutions\Template\TemplateCache;

/**
 * TemplateCacheCommand class
 *
 * Used to clear or refresh the template cache..
 *
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.9.0
 */
class TemplateCacheCommand extends AbstractCommand
{
    protected static string $name = 'template-cache';

    protected static string $description = 'Clears the template cache.';

    public function initialize(): void
    {
        $this->addArgumentDefinition(new Argument('file', 'A specific template file (or directory) to clear. If none is given, all files will be cleared.', true));
    }

    public function execute(): int
    {
        $TemplateCache = new TemplateCache();
        if ($TemplateCache->clear($this->getArgument('file'))) {
            $this->Console->writeLine('Cache cleared successfully', 'success');
            return ExitStatus::SUCCESS;
        }
    }
}