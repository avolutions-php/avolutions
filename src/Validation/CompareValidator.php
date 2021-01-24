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

namespace Avolutions\Validation;

use InvalidArgumentException;
use function implode;

/**
 * CompareValidator
 *
 * TODO
 *
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.6.0
 */
class CompareValidator extends AbstractValidator
{
    /**
     * TODO
     */
    private $operator = '==';

    /**
     * TODO
     */
    private $compareValue;

    /**
     * setOptions
     *
     * TODO
     * @param array $options
     * @param null $property
     * @param null $Entity
     */
    public function setOptions($options = [], $property = null, $Entity = null) {
        parent::setOptions($options, $property, $Entity);

        $validOperators = ['==', '===', '!=', '!==', '>', '>=', '<', '<='];
        if (isset($options['operator']) && !in_array($options['operator'], $validOperators)) {
            throw new InvalidArgumentException('Invalid operator, must be either '.implode($validOperators, ' '));
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
     * TODO
     *
     * @param $value
     * @return bool TODO
     */
    public function isValid($value) {
        switch ($this->operator) {
            case '==':
                return $value == $this->compareValue;
            case '===':
                return $value === $this->compareValue;
            case '!=':
                return $value != $this->compareValue;
            case '!==':
                return $value !== $this->compareValue;
            case '>':
                return $value > $this->compareValue;
            case '>=':
                return $value >= $this->compareValue;
            case '<':
                return $value < $this->compareValue;
            case '<=':
                return $value <= $this->compareValue;
            default:
                return false;
        }
    }
}