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

use InvalidArgumentException;

/**
 * RegexValidator
 *
 * The CompareValidator performs validations against a regular expression.
 *
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.6.0
 */
class RegexValidator extends AbstractValidator
{
    /**
     * @var string $pattern The regular expression to validate.
     */
    private $pattern;

    /**
     * @var bool $not Inverts the result of the validation.
     */
    private $not = false;

    /**
     * setOptions
     *
     * Set the passed options, property and Entity to internal properties.
     *
     * @param array $options An associative array with options.
     * @param string $property The property of the Entity to validate.
     * @param null $Entity The Entity to validate.
     */
    public function setOptions($options = [], $property = null, $Entity = null) {
        parent::setOptions($options, $property, $Entity);

        if (!isset($options['pattern']) || !is_string($options['pattern'])) {
            throw new InvalidArgumentException('Option "pattern" must be set.');
        } else {
            $this->pattern = $options['pattern'];
        }

        if (isset($options['not'])) {
            if(!is_bool($options['not'])) {
                throw new InvalidArgumentException('Option "not" must be of type boolean.');
            } else {
                $this->not = $options['not'];
            }
        }
    }

    /**
     * isValid
     *
     * Checks if the passed value is valid considering the validator type and passed options.
     *
     * @param $value The value to validate.
     *
     * @return bool Data is valid (true) or not (false).
     */
    public function isValid($value) {
        if ($this->not) {
            return !preg_match($this->pattern, $value);
        } else {
            return preg_match($this->pattern, $value);
        }
    }
}