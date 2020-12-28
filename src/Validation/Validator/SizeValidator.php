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
     * isValid
     * 
     * TODO
     * 
     * @return bool TODO
     */
    public function isValid($value) {
        $size = $this->getSize($value);

        // min & max value
        if(\is_array($this->options) && count($this->options) == 2) {
            return $size > $this->options[0] && $size < $this->options[1];
        } else {
            return $size == $this->options;
        }
    }
}