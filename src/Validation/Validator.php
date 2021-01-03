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
    protected $options = [];	

    /**
	 * TODO
	 */
    protected $property = [];	

    /**
	 * TODO
	 */
    protected $Entity = null;
    
    /**
     * __construct
     * 
     * TODO
     */
    public function __construct($options = [], $property = null, $Entity = null) {
        $this->setOptions($options, $property, $Entity);
    }

    /**
     * getSize
     * 
     * TODO
     */
    protected function getSize($value) {
        if(\is_numeric($value)) {
            return $value;
        } elseif (is_array($value)) {
            return count($value); 
        } else {
            return strlen($value);
        }
    }

    /**
     * isValid
     * 
     * TODO
     */
    public abstract function isValid($values);

    /**
     * setOptions
     * 
     * TODO
     */
    public function setOptions($options = [], $property = null, $Entity = null) {
        $this->options = $options;
        $this->property = $property;
        $this->Entity = $Entity;
    }
}