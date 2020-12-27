<?php

namespace Avolutions\Validation\Validator;

use Avolutions\Validation\Validator;

class RequiredValidator extends Validator
{
    public function isValid($value) {
        return !(
            is_null($value) || 
            (\is_string($value) && strlen($value) == 0) || 
            (\is_array($value) && count($value) == 0)
        );
    }
}