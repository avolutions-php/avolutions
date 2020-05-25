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
 * EntityEvent class
 *
 * TODO
 *
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.3.0
 */
class EntityEvent extends Event
{
    /**
     * 
     */
    protected $name = null;

    /**
     * 
     */
    public $Entity = null;

    /**
     * 
     */
    public $EntityBeforeChange = null;


    function __construct($name, $Entity, $EntityBeforeChange = null)
    {
        $this->name = $name;
        $this->Entity = $Entity;
        $this->EntityBeforeChange = $EntityBeforeChange;
    }
}