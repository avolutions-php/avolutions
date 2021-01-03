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
     * TODO
     */
    private $not = false;

    /**
     * setOptions
     * 
     * TODO
     */
    public function setOptions($options = null, $Entity = null) {
        if(!isset($options['pattern']) || !is_string($options['pattern'])) {
            // TODO
        } else {
            $this->pattern = $options['pattern'];
        }

        if(isset($options['not'])) {
            if(!is_bool($options['not'])) {
                // TODO
            } else {
                $this->not = $options['not'];
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
        if($this->not) {
            return !preg_match($this->pattern, $value);
        } else {
            return preg_match($this->pattern, $value);
        }
    }
}