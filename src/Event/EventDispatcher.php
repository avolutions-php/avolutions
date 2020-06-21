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

use Avolutions\Event\EntityEvent;

/**
 * EventDispatcher class
 *
 * The EventDispatcher is responsible to call all relevant listener for the dispatched Event. 
 *
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.3.0
 */
class EventDispatcher
{
	/**
     * dispatch
     * 
     * Find and calls all relevant listener from the ListenerCollection for the passed Event. 
     * 
     * @param Event $Event The Event to dispatch
     */
    public static function dispatch($Event)
    {
        if ($Event instanceof EntityEvent) {            
            $entityName = $Event->Entity->getEntityName();
            $listener = APP_LISTENER_NAMESPACE.$entityName.'Listener';
            $Listener = new $listener();
            $method = 'handle'.$Event->getName();

            $callable = [$Listener, $method];

            if (\is_callable($callable)) {
                call_user_func($callable, $Event);
            }

            return;
        }

        $ListenerCollection = ListenerCollection::getInstance();
        foreach ($ListenerCollection->getListener($Event->getName()) as $listener) {
            $Listener = new $listener[0];
            $method = $listener[1];

            $callable = [$Listener, $method];

            if (\is_callable($callable)) {
                call_user_func($callable, $Event);
            }
        }
    }
}