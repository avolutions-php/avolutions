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

namespace Avolutions\Validation;

use Avolutions\Core\Application;
use Avolutions\Orm\Entity;
use Avolutions\Orm\EntityCollection;
use ReflectionException;

/**
 * UniqueValidator
 *
 * The UniqueValidator validates if the value of an Entity attribute is unique in database.
 *
 * @author  Alexander Vogt <alexander.vogt@avolutions.org>
 * @since   0.6.0
 */
class UniqueValidator extends AbstractValidator
{
    /**
     * Application instance.
     *
     * @var Application $Application
     */
    private Application $Application;

    /**
     * __construct
     *
     * Creates an new Validator object and set the options.
     *
     * @param Application $Application Application instance.
     * @param array $options An associative array with options.
     * @param string|null $property The property of the Entity to validate.
     * @param Entity|null $Entity $Entity The Entity to validate.
     */
    public function __construct(
        Application $Application,
        array $options = [],
        ?string $property = null,
        ?Entity $Entity = null
    ) {
        $this->Application = $Application;
        parent::__construct($options, $property, $Entity);
    }

    /**
     * isValid
     *
     * Checks if the passed value is valid considering the validator type and passed options.
     *
     * @param mixed $value The value to validate.
     *
     * @return bool Data is valid (true) or not (false).
     *
     * @throws ReflectionException
     */
    public function isValid(mixed $value): bool
    {
        $EntityCollection = $this->Application->make(
            EntityCollection::class,
            ['entity' => $this->Entity->getEntityName()]
        );
        $exists = $EntityCollection->where($this->property . ' = \'' . $value . '\'')->getFirst();

        return ($exists == null);
    }
}