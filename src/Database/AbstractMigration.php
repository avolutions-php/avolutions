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

namespace Avolutions\Database;

use Avolutions\Core\Application;
use ReflectionException;

/**
 * AbstractMigration class
 *
 * An abstract class which has to be extended by every Migration.
 *
 * @author  Alexander Vogt <alexander.vogt@avolutions.org>
 * @since   0.1.1
 */
abstract class AbstractMigration implements MigrationInterface
{
    /**
     * The version of the migration
     *
     * @var int $version
     */
    public int $version;

    /**
     * Application instance.
     *
     * @var Application $Application
     */
    private Application $Application;

    /**
     * __construct
     *
     * Creates a new Migration instance.
     *
     * @param Application $Application Application instance.
     */
    public function __construct(Application $Application)
    {
        $this->Application = $Application;
    }

    /**
     * table
     *
     * Returns a new Table object.
     *
     * @param string $name Name of the table.
     *
     * @return Table A Table object.
     *
     * @throws ReflectionException
     */
    public function table(string $name): Table
    {
        return $this->Application->make(Table::class, ['name' => $name]);
    }
}