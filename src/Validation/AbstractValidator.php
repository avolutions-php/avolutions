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
 * AbstractValidator
 *
 * An abstract class which has to be extended by every Validator.
 *
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.6.0
 */
abstract class AbstractValidator implements ValidatorInterface
{
    /**
	 * @var array $options An associative array with options.
	 */
    protected $options = [];

    /**
	 * @var array $property The property of the Entity to validate.
	 */
    protected $property = null;

    /**
	 * @var Entity $Entity The Entity to validate.
	 */
    protected $Entity = null;

    /**
     * @var string $message A custom error message.
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

                return translate($validatorKey);
            } catch (Exception $ex) {
                // TODO use label of property?
                // TODO how to handle AdHoc Validation?
                return $this->property.' is not valid';
            }
        }
    }
}