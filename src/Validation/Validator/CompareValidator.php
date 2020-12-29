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

namespace Avolutions\Validation\Validator;

use Avolutions\Validation\Validator;

/**
 * CompareValidator
 *
 * TODO
 * 
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.6.0
 */
class CompareValidator extends Validator
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
     */
    public function setOptions($options = null) {
        $validOperators = ['==', '===', '!=', '!==', '>', '>=', '<', '<='];
        if(isset($options['operator']) && !in_array($options['operator'], $validOperators)) {
            throw new \Exception('Invalid operator, must be either '.\implode($validOperators, ' '));
        } else {
            $this->operator = $options['operator'];
        }

        $this->compareValue = $options['value'];
    }

    /**
     * isValid
     * 
     * TODO
     * 
     * @return bool TODO
     */
    public function isValid($value) {
        switch($this->operator) {
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