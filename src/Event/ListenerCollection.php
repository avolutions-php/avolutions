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

namespace Avolutions\Event;

use Avolutions\Collection\CollectionInterface;
use Avolutions\Collection\CollectionTrait;

/**
 * ListenerCollection class
 *
 * The ListenerCollection contains all registered event listener.
 *
 * @author  Alexander Vogt <alexander.vogt@avolutions.org>
 * @since   0.3.0
 */
class ListenerCollection implements CollectionInterface
{
    use CollectionTrait;

    /**
     * addListener
     *
     * Adds a listener for an event the ListenerCollection.
     *
     * @param string $eventName The name of the event.
     * @param array $listener An array containing the Listener class and method.
     */
    public function addListener(string $eventName, array $listener)
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
     * @return callable|array The listener callable.
     */
    public function getListener(string $eventName): callable|array
    {
        return $this->items[$eventName] ?? [];
    }
}