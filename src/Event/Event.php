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

use ReflectionClass;

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
     * The name of the Event.
     *
     * @var string $name
     */
    protected string $name;

    /**
	 * getName
     *
     * Returns the name of the Event.
     * This is either the name of the class or if defined the value of the name property.
     *
     * @return string The name of the Event.
	 */
    public function getName(): string
    {
		return $this->name ?? (new ReflectionClass($this))->getName();
	}
}