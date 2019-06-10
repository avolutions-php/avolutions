<?php
/**
 * AVOLUTIONS
 * 
 * An open source PHP framework.
 * 
 * @author		Alexander Vogt <alexander.vogt@avolutions.de>
 * @copyright	2019 avolutions (http://avolutions.de)
 * @license		MIT License (https://opensource.org/licenses/MIT)
 * @link		http://framework.avolutions.de
 * @since		Version 1.0.0 
 */

namespace core;

/**
 * Collection class
 *
 * A abstract class which implements the base collection functionality.
 * 
 * @package		avolutions\core
 * @subpackage	Core
 * @author		Alexander Vogt <alexander.vogt@avolutions.de>
 * @link		http://framework.avolutions.de/documentation/collection
 * @since		Version 1.0.0
 */
interface CollectionInterface
{		
	/**
	 * getAll
	 * 
	 * Returns all items of the Collection.
	 * 
	 * @return array An array of all items of the Collection
	 */
	public function getAll();
}
?>