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
 * SizeValidator
 *
 * TODO
 * 
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.6.0
 */
class SizeValidator extends Validator
{
    /**
     * TODO
     */
    private $size;

    /**
     * TODO
     */
    private $min;

    /**
     * TODO
     */
    private $max;

    /**
     * setOptions
     * 
     * TODO
     */
    public function setOptions($options = [], $property = null, $Entity = null) {
        if(isset($options['size']) && is_int($options['size'])) {
            $this->size = $options['size'];
        }
        if(isset($options['min']) && is_int($options['min']) &&
           isset($options['max']) && is_int($options['max'])) {
            $this->min = $options['min'];
            $this->max = $options['max'];
        }


        // TODO
    }

    /**
     * isValid
     * 
     * TODO
     * 
     * @return bool TODO
     */
    public function isValid($value) {
        $size = $this->getSize($value);

        // min & max value
        if(!is_null($this->min) && !is_null($this->max)) {
            return $size > $this->min && $size < $this->max;
        } else {
            return $size == $this->size;
        }
    }
}