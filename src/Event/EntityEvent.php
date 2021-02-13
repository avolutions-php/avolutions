<?php
/**
 * AVOLUTIONS
 * 
 * Just another open source PHP framework.
 * 
 * @copyright	Copyright (c) 2019 - 2021 AVOLUTIONS
 * @license		MIT License (http://avolutions.org/license)
 * @link		http://avolutions.org
 */
 
namespace Avolutions\Event;

/**
 * EntityEvent class
 *
 * The EntityEvent is used for all Events dispatched by an Entity.
 *
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.3.0
 */
class EntityEvent extends Event
{
    /**
     * @var string $name The name of the Event. 
     */
    protected $name = null;

    /**
     * @var Entity $Entity The Entity which dispatched the Event.
     */
    public $Entity = null;

    /**
     * @var Entity $EntityBeforeChange The Entity before the changes are made.
     */
    public $EntityBeforeChange = null;


    /**
     * __construct
     * 
     * Creates a new EntityEvent object.
     * 
     * @param string $name The name of the EntityEvent.
     * @param Entity $Entity The Entity which dispatched the Event.
     * @param Entity $EntityBeforeChange The Entity before the changes are made.
     */
    function __construct($name, $Entity, $EntityBeforeChange = null)
    {
        $this->name = $name;
        $this->Entity = $Entity;
        $this->EntityBeforeChange = $EntityBeforeChange;
    }
}