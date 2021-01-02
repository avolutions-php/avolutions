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
 * RegexValidator
 *
 * TODO
 * 
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.6.0
 */
class RegexValidator extends Validator
{
    /**
     * TODO
     */
    private $pattern;

    /**
     * setOptions
     * 
     * TODO
     */
    public function setOptions($options = null) {
        if(!isset($options['pattern']) || !is_string($options['pattern'])) {
            // TODO
        } else {
            $this->pattern = $options['pattern'];
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
        return preg_match($this->pattern, $value);
    }
}