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

use Avolutions\Orm\Entity;

/**
 * EntityEvent class
 *
 * The EntityEvent is used for all Events dispatched by an Entity.
 *
 * @author  Alexander Vogt <alexander.vogt@avolutions.org>
 * @since   0.3.0
 */
class EntityEvent extends Event
{
    /**
     * The Entity which dispatched the Event.
     *
     * @var Entity $Entity
     */
    public Entity $Entity;

    /**
     * The Entity before the changes are made.
     *
     * @var Entity|null $EntityBeforeChange
     */
    public ?Entity $EntityBeforeChange = null;


    /**
     * __construct
     *
     * Creates a new EntityEvent object.
     *
     * @param string $name The name of the EntityEvent.
     * @param Entity $Entity The Entity which dispatched the Event.
     * @param Entity|null $EntityBeforeChange The Entity before the changes are made.
     */
    public function __construct(string $name, Entity $Entity, ?Entity $EntityBeforeChange = null)
    {
        $this->name = $name;
        $this->Entity = $Entity;
        $this->EntityBeforeChange = $EntityBeforeChange;
    }
}