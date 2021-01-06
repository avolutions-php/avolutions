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
        if(!isset($options['size']) && !isset($options['min']) && !isset($options['max'])) {
            throw new \InvalidArgumentException('Either option "size", "min" or "max" must be set.');
        }

        if(isset($options['size'])) {
            if(!is_int($options['size'])) {
                throw new \InvalidArgumentException('Size must be of type integer.');
            } else {
                $this->size = $options['size'];
            }
        }

        if(isset($options['min'])) {
            if(!is_int($options['min'])) {
                throw new \InvalidArgumentException('Min must be of type integer.');
            } else {
                $this->min = $options['min'];
            }
        }

        if(isset($options['max'])) {
            if(!is_int($options['max'])) {
                throw new \InvalidArgumentException('Max must be of type integer.');
            } else {
                $this->max = $options['max'];
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
        $size = $this->getSize($value);

        if(!is_null($this->size)) {
            return $size == $this->size;
        } if(!is_null($this->min) && !is_null($this->max)) {
            return $size >= $this->min && $size <= $this->max;
        } elseif (!is_null($this->min) && is_null($this->max)) {
            return $size >= $this->min;
        } elseif (is_null($this->min) && !is_null($this->max)) {
            return $size <= $this->max;
        } else {
            return false;
        }
    }
}