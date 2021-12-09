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

/**
 * Migration interface
 *
 * An interface which declares the base methods for Migrations.
 *
 * @author  Alexander Vogt <alexander.vogt@avolutions.org>
 * @since   0.1.1
 */
interface MigrationInterface
{
    /**
     * migrate
     *
     * Executes the migration of the database.
     */
    public function migrate();
}