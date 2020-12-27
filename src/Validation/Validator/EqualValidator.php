<?php

namespace Avolutions\Validation\Validator;

use Avolutions\Validation\Validator;

class EqualValidator extends Validator
{
    public function isValid($value) {
        return $value === $this->options;
    }
}