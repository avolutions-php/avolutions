<?php

namespace Avolutions\Validation\Validator;

use Avolutions\Validation\Validator;

class SizeValidator extends Validator
{
    public function isValid($value) {
        $size = $this->getSize($value);

        // min & max value
        if(\is_array($this->options) && count($this->options) == 2) {
            return $size > $this->options[0] && $size < $this->options[1];
        } else {
            return $size == $this->options;
        }
    }
}