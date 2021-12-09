<?php

namespace {{ namespace }};

use Avolutions\Orm\EntityCollection;

class {{ model }}Collection extends EntityCollection
{
    protected string $entity = '{{ model }}';
}