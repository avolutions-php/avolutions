<?php

namespace Avolutions\Command;

use Avolutions\Core\Application;

class CreateMigrationCommand extends Command
{
    protected static string $name = 'create-migration';
    protected static string $description = 'Creates a new Migration.';

    public function initialize(): void
    {
        $this->addOptionDefinition(new Option('force', 'f', 'TODO'));
    }

    public function execute(): int
    {
        $inputArg = 'CreateUserTable';
        $inputArg2 = 20210803220500;

        $migrationName = ucfirst($inputArg);
        $migrationFile = Application::getDatabasePath() . $migrationName . '.php';

        // TODO force option
        if (file_exists($migrationFile) && !$this->getOption('force')) {
            $this->Console->writeLine('Migration "' . $migrationName . '" already exists. If you want to override, please use force mode (-f).', 'error');
            return 0;
        }

        // TODO own class or own methods?
        $Template = new Template('migration');
        $Template->assign('namespace', rtrim(Application::getDatabaseNamespace(), '\\'));
        $Template->assign('migration', $migrationName);
        $Template->assign('version', $inputArg2);

        if($Template->save($migrationFile)) {
            $this->Console->writeLine('Migration created successfully.', 'success');
            return 1;
        } else {
            $this->Console->writeLine('Error when creating Migration.', 'error');
            return 0;
        }
    }
}