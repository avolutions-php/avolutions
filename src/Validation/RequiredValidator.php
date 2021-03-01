<?php
/**
 * AVOLUTIONS
 *
 * Just another open source PHP framework.
 *
 * @copyright   Copyright (c) 2019 - 2021 AVOLUTIONS
 * @license     MIT License (http://avolutions.org/license)
 * @link        http://avolutions.org
 */

namespace Avolutions\Validation;

/**
 * RequiredValidator
 *
 * The RequiredValidator indicates that a value is mandatory.
 *
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.6.0
 */
class RequiredValidator extends AbstractValidator
{
    /**
     * isValid
     *
     * Checks if the passed value is valid considering the validator type and passed options.
     *
     * @param mixed $value The value to validate.
     *
     * @return bool Data is valid (true) or not (false).
     */
    public function isValid($value) {
        return !(
            is_null($value)
            || (is_string($value) && strlen($value) == 0)
            || (is_array($value) && count($value) == 0)
        );
    }
}