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
 * The ListenerCollection contains all registered event listener.
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
	 * Adds a listener for an event the ListenerCollection.
	 * 
	 * @param string $eventName The name of the event.
     * @param callable $listener A callable containing the Listener class and method.
	 */
    public function addListener($eventName, $listener)
    {
		$this->items[$eventName][] = $listener;
    }
    
    /**
	 * getListener
	 * 
     * Returns a callable listener for the given event from the ListenerCollection.
     * 
	 * @param string $eventName The name of the event.
     * 
     * @return callable The listener callable.
	 */
    public function getListener($eventName)
    {
        return $this->items[$eventName] ?? [];
    }
}