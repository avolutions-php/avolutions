<?php
/**
 * AVOLUTIONS
 *
 * Just another open source PHP framework.
 *
 * @copyright   Copyright (c) 2019 - 2021 AVOLUTIONS
 * @license     MIT License (https://avolutions.org/license)
 * @link        https://avolutions.org
 */

namespace Avolutions\Validation;

use Avolutions\Orm\Entity;
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
     * An associative array with options.
     *
	 * @var array $options
	 */
    protected array $options = [];

    /**
     * The property of the Entity to validate.
     *
	 * @var string|null $property
	 */
    protected ?string $property = null;

    /**
     * The Entity to validate.
     *
	 * @var Entity|null $Entity
	 */
    protected ?Entity $Entity = null;

    /**
     * A custom error message.
     *
     * @var string|null $message
     */
    protected ?string $message = null;

    /**
     * __construct
     *
     * Creates an new Validator object and set the options.
     *
     * @param array $options An associative array with options.
     * @param string|null $property The property of the Entity to validate.
     * @param Entity|null $Entity $Entity The Entity to validate.
     */
    public function __construct(array $options = [], ?string $property = null, ?Entity $Entity = null) {
        $this->setOptions($options, $property, $Entity);
    }

    /**
     * setOptions
     *
     * Set the passed options, property and Entity to internal properties.
     *
     * @param array $options An associative array with options.
     * @param string|null $property The property of the Entity to validate.
     * @param Entity|null $Entity $Entity The Entity to validate.
     */
    public function setOptions(array $options = [], ?string $property = null, ?Entity $Entity = null) {
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
     * Returns the name of the validator in lowercase and without suffix 'Validator'.
     *
     * @return string The name of the validator.
     */
    protected function getValidatorName(): string
    {
        $validatorName = (new ReflectionClass($this))->getShortName();
        $validatorName = strtolower(str_replace(VALIDATOR, '', $validatorName));

        return $validatorName;
    }

    /**
     * getMessage
     *
     * Returns the error message of the validator.
     *
     * @return string The error message.
     */
    public function getMessage(): string
    {
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
            } catch (Exception) {
                if (is_null($this->property)) {
                    // AdHoc validation
                    return 'Not valid';
                } else {
                    return $this->property.' is not valid';
                }
            }
        }
    }
}