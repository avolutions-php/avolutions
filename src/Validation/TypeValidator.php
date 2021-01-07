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

use Avolutions\Validation\Validator;

/**
 * TypeValidator
 *
 * TODO
 *
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.6.0
 */
class TypeValidator extends Validator
{
    /**
     * TODO
     */
    private $type;

    /**
     * setOptions
     *
     * TODO
     */
    public function setOptions($options = [], $property = null, $Entity = null) {
        $validTypes = ['int', 'integer', 'string', 'bool', 'boolean', 'array'];
        if (
            !isset($options['type'])
            || !in_array($options['type'], $validTypes)
        ) {
            throw new \InvalidArgumentException('Invalid type, must be either '.\implode($validTypes, ', '));
        } else {
            $this->type = $options['type'];
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