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
use function implode;

/**
 * TypeValidator
 *
 * The TypeValidator validates the data type of the value.
 *
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.6.0
 */
class TypeValidator extends AbstractValidator
{
    /**
     * @var string $type The data type to compare.
     */
    private $type;

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

        $validTypes = ['int', 'integer', 'string', 'bool', 'boolean', 'array'];
        if (
            !isset($options['type'])
            || !in_array($options['type'], $validTypes)
        ) {
            throw new InvalidArgumentException('Invalid type, must be either '.implode($validTypes, ', '));
        } else {
            $this->type = $options['type'];
        }
    }

    /**
     * isValid
     *
     * Checks if the passed value is valid considering the validator type and passed options.
     *
     * @param $value The value to validate.
     *
     * @return bool Data is valid (true) or not (false).
     */
    public function isValid($value) {
        switch ($this->type) {
            case 'int':
            case 'integer':
                return is_int($value);
            case 'string':
                return is_string($value);
            case 'bool':
            case 'boolean':
                return is_bool($value);
            case 'array':
                return is_array($value);
            default:
                return false;
        }
    }
}