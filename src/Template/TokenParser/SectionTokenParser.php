<?php

namespace Avolutions\Template\TokenParser;

use Avolutions\Template\ITokenParser;
use Avolutions\Template\Token;

class SectionTokenParser implements ITokenParser
{
    public function parse(Token $Token)
    {
        return '{{ ' . $Token->value . ' }}' . PHP_EOL;
    }
}