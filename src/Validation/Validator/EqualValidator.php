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
 * EqualValidator
 *
 * TODO
 * 
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.6.0
 */
class EqualValidator extends Validator
{
    /**
     * isValid
     * 
     * TODO
     * 
     * @return bool TODO
     */
    public function isValid($value) {
        return $value === $this->options;
    }
}