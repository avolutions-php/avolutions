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

namespace Avolutions\Core;

/**
 * Collection interface
 *
 * A interface which declares the base collection functionality.
 * 
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.1.0
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