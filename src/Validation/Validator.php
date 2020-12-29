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

namespace Avolutions\Validation;

use Avolutions\Validation\ValidatorInterface;

/**
 * Validator
 *
 * TODO
 * 
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.6.0
 */
abstract class Validator implements ValidatorInterface
{		
    /**
	 * TODO
	 */
    protected $options;

    public function __construct($options = null) {
        $this->setOptions($options);
    }

    public function setOptions($options = null) {
        $this->options = $options; 
    }

    public abstract function isValid($values);

    protected function getSize($value) {
        if(\is_numeric($value)) {
            return $value;
        } elseif (is_array($value)) {
            return count($value); 
        } else {
            return strlen($value);
        }
    }
}