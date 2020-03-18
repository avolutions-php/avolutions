<?php
/**
 * AVOLUTIONS
 * 
 * Just another open source PHP framework.
 * 
 * @copyright	Copyright (c) 2019 - 2020 AVOLUTIONS
 * @license		MIT License (http://avolutions.org/license)
 * @link		http://avolutions.org
 */

namespace Avolutions\Database;

/**
 * Migration class
 *
 * An abstract class which has to be extended by every Migration.
 * 
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.1.1

 */
abstract class AbstractMigration implements MigrationInterface
{		    
    /**
	 * @var int version The version of the migration
	 */
    public $version = null;
}