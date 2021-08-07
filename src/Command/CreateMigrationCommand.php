<?php
/**
 * TODO
 */
namespace Avolutions\Command;

use Avolutions\Core\Application;

/**
 * TODO
 */
class CreateMigrationCommand extends Command
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
        $this->addArgumentDefinition(new Argument('name', 'TODO'));
        $this->addArgumentDefinition(new Argument('version', 'TODO'));
        $this->addOptionDefinition(new Option('force', 'f', 'TODO'));
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
            return 0;
        }

        $Template = new Template('migration');
        $Template->assign('namespace', rtrim(Application::getDatabaseNamespace(), '\\'));
        $Template->assign('name', $migrationName);
        $Template->assign('version', $version);

        if ($Template->save($migrationFile)) {
            $this->Console->writeLine('Migration created successfully.', 'success');
            return 1;
        } else {
            $this->Console->writeLine('Error when creating Migration.', 'error');
            return 0;
        }
    }
}