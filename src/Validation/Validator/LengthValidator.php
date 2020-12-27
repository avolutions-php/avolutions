<?php

namespace Avolutions\Validation\Validator;

use Avolutions\Validation\Validator;

class LengthValidator extends Validator
{
    public function isValid($value) {
        return strlen($value) == $this->options;
    }
}