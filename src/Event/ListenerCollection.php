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

namespace Avolutions\Event;

use Avolutions\Collection\CollectionInterface;
use Avolutions\Collection\CollectionTrait;
use Avolutions\Core\AbstractSingleton;

/**
 * ListenerCollection class
 *
 * TODO
 *
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.3.0
 */
class ListenerCollection extends AbstractSingleton implements CollectionInterface
{
	use CollectionTrait;
	
	/**
	 * addListener
	 * 
	 * TODO
	 */
    public function addListener($event, $listener)
    {
		$this->items[$event] = $listener;
    }
    
    /**
	 * getListener
	 * 
	 * TODO
	 */
    public function getListener($eventName)
    {
        return $this->items[$eventName] ?? [];
    }
}