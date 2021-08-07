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

/**
 * CreateMigrationCommand class
 *
 * Creates a new Migration.
 *
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.8.0
 */
class CreateMigrationCommand extends AbstractCommand
{
    /**
     * @inheritdoc
     */
    protected static string $name = 'create-migration';

    /**
     * @inheritdoc
     */
    protected static string $description = 'Creates a new Migration.';

    /**
     * @inheritdoc
     */
    public function initialize(): void
    {
        $this->addArgumentDefinition(new Argument('name', 'The name of the Migration class.'));
        $this->addArgumentDefinition(new Argument('version', 'The unique version of the Migration. If none is passed the current DateTime (YmdHis) is used.', true));
        $this->addOptionDefinition(new Option('force', 'f', 'Migration will be overwritten if it already exists.'));
    }

    /**
     * @inheritdoc
     */
    public function execute(): int
    {
        $migrationName = ucfirst($this->getArgument('name'));
        $version = $this->getArgument('version');
        $migrationFile = Application::getDatabasePath() . $migrationName . '.php';

        if (file_exists($migrationFile) && !$this->getOption('force')) {
            $this->Console->writeLine($migrationName . ' migration already exists. If you want to override, please use force mode (-f).', 'error');
            return ExitStatus::ERROR;
        }

        $Template = new Template('migration');
        $Template->assign('namespace', rtrim(Application::getDatabaseNamespace(), '\\'));
        $Template->assign('name', $migrationName);
        $Template->assign('version', $version);

        if ($Template->save($migrationFile)) {
            $this->Console->writeLine('Migration created successfully.', 'success');
            return ExitStatus::SUCCESS;
        } else {
            $this->Console->writeLine('Error when creating Migration.', 'error');
            return ExitStatus::ERROR;
        }
    }
}