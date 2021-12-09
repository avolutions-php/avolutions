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

use Avolutions\Core\Application;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

use function is_callable;

/**
 * EventDispatcher class
 *
 * The EventDispatcher is responsible to call all relevant listener for the dispatched Event.
 *
 * @author  Alexander Vogt <alexander.vogt@avolutions.org>
 * @since   0.3.0
 */
class EventDispatcher
{
    /**
     * Application instance.
     *
     * @var Application $Application
     */
    private Application $Application;

    /**
     * ListenerCollection instance.
     *
     * @var ListenerCollection $ListenerCollection
     */
    private ListenerCollection $ListenerCollection;

    /**
     * __construct
     *
     * Creates a new EventDispatcher instance.
     *
     * @param Application $Application
     * @param ListenerCollection $ListenerCollection
     */
    public function __construct(Application $Application, ListenerCollection $ListenerCollection)
    {
        $this->Application = $Application;
        $this->ListenerCollection = $ListenerCollection;
    }

    /**
     * dispatch
     *
     * Find and calls all relevant listener from the ListenerCollection for the passed Event.
     *
     * @param Event $Event The Event to dispatch
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function dispatch(Event $Event)
    {
        if ($Event instanceof EntityEvent) {
            $entityName = $Event->Entity->getEntityName();
            $listenerName = $this->Application->getListenerNamespace() . $entityName . 'Listener';
            if (class_exists($listenerName)) {
                $Listener = $this->Application->get($listenerName);
                $method = 'handle' . $Event->getName();

                $callable = [$Listener, $method];

                if (is_callable($callable)) {
                    call_user_func($callable, $Event);
                }
            }

            return;
        }

        foreach ($this->ListenerCollection->getListener($Event->getName()) as $listener) {
            $Listener = $this->Application->get($listener[0]);
            $method = $listener[1];

            $callable = [$Listener, $method];

            if (is_callable($callable)) {
                call_user_func($callable, $Event);
            }
        }
    }
}