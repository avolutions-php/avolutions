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

use Avolutions\Orm\Entity;
use InvalidArgumentException;

use function implode;

/**
 * CompareValidator
 *
 * The CompareValidator performs validations using the common comparison validators.
 *
 * @author  Alexander Vogt <alexander.vogt@avolutions.org>
 * @since   0.6.0
 */
class CompareValidator extends AbstractValidator
{
    /**
     * A comparison operator.
     *
     * @var string $operator
     */
    private string $operator = '==';

    /**
     * A static value to compare to.
     *
     * @var mixed $compareValue
     */
    private mixed $compareValue;

    /**
     * setOptions
     *
     * Set the passed options, property and Entity to internal properties.
     *
     * @param array $options An associative array with options.
     * @param string|null $property The property of the Entity to validate.
     * @param Entity|null $Entity The Entity to validate.
     */
    public function setOptions(array $options = [], ?string $property = null, ?Entity $Entity = null)
    {
        parent::setOptions($options, $property, $Entity);

        $validOperators = ['==', '===', '!=', '!==', '>', '>=', '<', '<='];
        if (isset($options['operator']) && !in_array($options['operator'], $validOperators)) {
            throw new InvalidArgumentException('Invalid operator, must be either ' . implode(' ', $validOperators));
        } else {
            $this->operator = $options['operator'];
        }

        if (isset($options['value'])) {
            $this->compareValue = $options['value'];
        } elseif (isset($options['attribute'])) {
            if (!is_string($options['attribute']) || !property_exists($Entity, $options['attribute'])) {
                throw new InvalidArgumentException('Attribute does not exist in entity.');
            } else {
                $attribute = $options['attribute'];
                $this->compareValue = $Entity->$attribute;
            }
        } else {
            throw new InvalidArgumentException('Either option "value" or "attribute" must be set.');
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
    public function isValid(mixed $value): bool
    {
        return match ($this->operator) {
            '==' => $value == $this->compareValue,
            '===' => $value === $this->compareValue,
            '!=' => $value != $this->compareValue,
            '!==' => $value !== $this->compareValue,
            '>' => $value > $this->compareValue,
            '>=' => $value >= $this->compareValue,
            '<' => $value < $this->compareValue,
            '<=' => $value <= $this->compareValue,
            default => false,
        };
    }
}