<?php

namespace {{ namespace }};

use Avolutions\Orm\Entity;
use Avolutions\Validation\AbstractValidator;

class {{ name }}Validator extends AbstractValidator
{
    public function setOptions(array $options = [], ?string $property = null, ?Entity $Entity = null)
    {
        parent::setOptions($options, $property, $Entity);
    }

    public function isValid(mixed $value): bool
    {

    }
}