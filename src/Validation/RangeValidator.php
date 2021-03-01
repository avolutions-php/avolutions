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

namespace Avolutions\Validation;

use InvalidArgumentException;

/**
 * RangeValidator
 *
 * The RangeValidator validates if a value is inside a specific range (array).
 *
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.6.0
 */
class RangeValidator extends AbstractValidator
{
    /**
     * @var array $range A static array to check the value against.
     */
    private $range = [];

    /**
     * @var bool $not Inverts the result of the validation.
     */
    private $not = false;

    /**
     * @var bool $strict Indicates if data type should be considered.
     */
    private $strict = false;

    /**
     * setOptions
     *
     * Set the passed options, property and Entity to internal properties.
     *
     * @param array $options An associative array with options.
     * @param string $property The property of the Entity to validate.
     * @param null $Entity The Entity to validate.
     */
    public function setOptions($options = [], $property = null, $Entity = null) {
        parent::setOptions($options, $property, $Entity);

        if (isset($options['range'])) {
            if (!is_array($options['range'])) {
                throw new InvalidArgumentException('Option "range" must be of type array.');
            } else {
                $this->range = $options['range'];
            }
        } elseif (isset($options['attribute'])) {
            if (!is_string($options['attribute']) || !property_exists($Entity, $options['attribute'])) {
                throw new InvalidArgumentException('Attribute does not exist in entity.');
            } else {
                $attribute = $options['attribute'];
                $this->range = $Entity->$attribute;
            }
        } else {
            throw new InvalidArgumentException('Either option "range" or "attribute" must be set.');
        }

        if (isset($options['not'])) {
            if (!is_bool($options['not'])) {
                throw new InvalidArgumentException('Option "not" must be of type boolean.');
            } else {
                $this->not = $options['not'];
            }
        }

        if (isset($options['strict'])) {
            if (!is_bool($options['strict'])) {
                throw new InvalidArgumentException('Option "strict" must be of type boolean.');
            } else {
                $this->strict = $options['strict'];
            }
        }
    }

    /**
     * isValid
     *
     * Checks if the passed value is valid considering the validator type and passed options.
     *
     * @param mixed $value The value to validate.
     *
     * @return bool Data is valid (true) or not (false).
     */
    public function isValid($value) {
        if ($this->not) {
            return !in_array($value, $this->range, $this->strict);
        } else {
            return in_array($value, $this->range, $this->strict);
        }
    }
}