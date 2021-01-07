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

namespace Avolutions\Validation\Validator;

use Avolutions\Validation\Validator;

/**
 * RangeValidator
 *
 * TODO
 *
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.6.0
 */
class RangeValidator extends Validator
{
    /**
     * TODO
     */
    private $range = [];

    /**
     * TODO
     */
    private $not = false;

    /**
     * TODO
     */
    private $strict = false;

    /**
     * setOptions
     *
     * TODO
     */
    public function setOptions($options = [], $property = null, $Entity = null) {
        if (isset($options['range'])) {
            if (!is_array($options['range'])) {
                throw new \InvalidArgumentException('Option "range" must be of type array.');
            } else {
                $this->range = $options['range'];
            }
        } elseif (isset($options['attribute'])) {
            if (!is_string($options['attribute']) || !property_exists($Entity, $options['attribute'])) {
                throw new \InvalidArgumentException('Attribute does not exist in entity.');
            } else {
                $attribute = $options['attribute'];
                $this->range = $Entity->$attribute;
            }
        } else {
            throw new \InvalidArgumentException('Either option "range" or "attribute" must be set.');
        }

        if (isset($options['not'])) {
            if (!is_bool($options['not'])) {
                throw new \InvalidArgumentException('Option "not" must be of type boolean.');
            } else {
                $this->not = $options['not'];
            }
        }

        if (isset($options['strict'])) {
            if (!is_bool($options['strict'])) {
                throw new \InvalidArgumentException('Option "strict" must be of type boolean.');
            } else {
                $this->strict = $options['strict'];
            }
        }
    }

    /**
     * isValid
     *
     * TODO
     *
     * @return bool TODO
     */
    public function isValid($value) {
        if ($this->not) {
            return !in_array($value, $this->range, $this->strict);
        } else {
            return in_array($value, $this->range, $this->strict);
        }
    }
}