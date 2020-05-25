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

/**
 * Event class
 *
 * TODO
 *
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.3.0
 */
class Event
{
    /**
	 * getName
     * 
     * TODO
	 */
    public function getName()
    {
		return $this->name ?? (new \ReflectionClass($this))->getName();
	}	
}