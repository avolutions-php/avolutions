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

/**
 * RequiredValidator
 *
 * TODO
 *
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.6.0
 */
class RequiredValidator extends AbstractValidator
{
    /**
     * isValid
     *
     * TODO
     *
     * @return bool TODO
     */
    public function isValid($value) {
        return !(
            is_null($value)
            || (is_string($value) && strlen($value) == 0)
            || (is_array($value) && count($value) == 0)
        );
    }
}