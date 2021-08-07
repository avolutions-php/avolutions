<?php
/**
 * TODO
 */
namespace Avolutions\Command;

use Avolutions\Core\Application;

/**
 * TODO
 */
class CreateMappingCommand extends Command
{
    /**
     * @inheritdoc
     */
    protected static string $name = 'create-mapping';

    /**
     * @inheritdoc
     */
    protected static string $description = 'Creates a new Entity mapping file.';

    /**
     * @inheritdoc
     */
    public function initialize(): void
    {
        $this->addArgumentDefinition(new Argument('name', 'TODO'));
        $this->addOptionDefinition(new Option('force', 'f', 'TODO'));
    }

    /**
     * @inheritdoc
     */
    public function execute(): int
    {
        $mappingName = ucfirst($this->getArgument('name'));
        $mappingFile = Application::getMappingPath() . $mappingName . 'Mapping.php';

        if (file_exists($mappingFile) && !$this->getOption('force')) {
            $this->Console->writeLine('Mapping file "' . $mappingName . '" already exists. If you want to override, please use force mode (-f).', 'error');
            return 0;
        }

        $Template = new Template('mapping');
        $Template->assign('name', $mappingName);

        if ($Template->save($mappingFile)) {
            $this->Console->writeLine('Mapping file created successfully.', 'success');
            return 1;
        } else {
            $this->Console->writeLine('Error when creating mapping file.', 'error');
            return 0;
        }
    }
}