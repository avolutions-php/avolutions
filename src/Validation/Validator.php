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

use Exception;
use ReflectionClass;

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
    protected $property = null;

    /**
	 * TODO
	 */
    protected $Entity = null;

    /**
     * TODO
     */
    protected $message = null;

    /**
     * __construct
     *
     * TODO
     * @param array $options
     * @param null $property
     * @param null $Entity
     */
    public function __construct($options = [], $property = null, $Entity = null) {
        $this->setOptions($options, $property, $Entity);
    }

    /**
     * getSize
     *
     * TODO
     * @param $value
     * @return int|string
     */
    protected function getSize($value) {
        if (is_numeric($value)) {
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
     * @param $value
     */
    abstract public function isValid($value);

    /**
     * setOptions
     *
     * TODO
     * @param array $options
     * @param null $property
     * @param null $Entity
     */
    public function setOptions($options = [], $property = null, $Entity = null) {
        $this->options = $options;
        if (isset($options['message'])) {
            $this->message = $options['message'];
        }
        $this->property = $property;
        $this->Entity = $Entity;
    }

    /**
     * getValidatorName
     *
     * Returns the name of the validator.
     *
     * @return string The name of the validator.
     */
    protected function getValidatorName()
    {
        $validatorName = (new ReflectionClass($this))->getShortName();
        $validatorName = strtolower(str_replace(VALIDATOR, '', $validatorName));

        return $validatorName;
    }

    /**
     * TODO
     */
    public function getMessage() {
        if (!is_null($this->message)) {
            return $this->message;
        } else {
            $validatorKey = 'validation/'.$this->getValidatorName();

            try {
                if (!is_null($this->property)) {
                    if (!is_null($this->Entity)) {
                        return translate($validatorKey.'/'.$this->Entity->getEntityName().'/'.$this->property);
                    }

                    return translate($validatorKey.'/'.$this->property);
                }

                // TODO specify message for Entity and property?
                // TODO use name of validator
                return translate($validatorKey);
            } catch (Exception $ex) {
                // TODO use label of property?
                return $this->property.' is not valid';
            }
        }
    }
}