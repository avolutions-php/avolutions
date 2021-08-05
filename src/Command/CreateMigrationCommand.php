<?php

namespace Avolutions\Command;

use Avolutions\Core\Application;

class CreateMigrationCommand extends Command
{
    protected static string $name = 'create-migration';
    protected static string $description = 'Creates a new Migration.';

    public function initialize(): void
    {
        $this->addArgumentDefinition(new Argument('name', 'TODO'));
        $this->addArgumentDefinition(new Argument('version', 'TODO'));
        $this->addOptionDefinition(new Option('force', 'f', 'TODO'));
    }

    public function execute(): int
    {
        $migrationName = ucfirst($this->getArgument('name'));
        $version = $this->getArgument('version');
        $migrationFile = Application::getDatabasePath() . $migrationName . '.php';

        if (file_exists($migrationFile) && !$this->getOption('force')) {
            $this->Console->writeLine('Migration "' . $migrationName . '" already exists. If you want to override, please use force mode (-f).', 'error');
            return 0;
        }

        $Template = new Template('migration');
        $Template->assign('namespace', rtrim(Application::getDatabaseNamespace(), '\\'));
        $Template->assign('migration', $migrationName);
        $Template->assign('version', $version);

        if($Template->save($migrationFile)) {
            $this->Console->writeLine('Migration created successfully.', 'success');
            return 1;
        } else {
            $this->Console->writeLine('Error when creating Migration.', 'error');
            return 0;
        }
    }
}