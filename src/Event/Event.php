<?php
/**
 * AVOLUTIONS
 *
 * Just another open source PHP framework.
 *
 * @copyright   Copyright (c) 2019 - 2021 AVOLUTIONS
 * @license     MIT License (http://avolutions.org/license)
 * @link        http://avolutions.org
 */

namespace Avolutions\Event;

/**
 * Event class
 *
 * The Event is the base class for every event class.
 *
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.3.0
 */
class Event
{
    /**
	 * getName
     *
     * Returns the name of the Event.
     * This is either the name of the class or if defined the value of the name property.
     *
     * @return string The name of the Event.
	 */
    public function getName()
    {
		return $this->name ?? (new \ReflectionClass($this))->getName();
	}
}