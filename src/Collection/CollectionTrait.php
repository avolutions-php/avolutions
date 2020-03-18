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

namespace Avolutions\Collection;

/**
 * Collection trait
 *
 * A default implementation of the CollectionInterface
 * 
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.1.0
 */
trait CollectionTrait
{		
    /**
	 * @var array $items The items of the Collection.
	 */
	public $items = [];

	/**
	 * getAll
	 * 
	 * Returns all items of the Collection.
	 * 
	 * @return array An array of all items of the Collection
	 */
    public function getAll()
    {
        return $this->items;
    }
    
    /**
	 * count
	 * 
	 * Returns the number of items in the Collection.
	 * 
	 * @return int The number of items in the Collection.
	 */
    public function count()
    {
        return count($this->items);
    }
}