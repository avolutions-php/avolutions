<?php

namespace Avolutions\Template\TokenParser;

use Avolutions\Template\Token;

class SectionTokenParser implements ITokenParser, IEndTokenParser
{
    public function parse(Token $Token)
    {
        return '{{ ' . $Token->value . ' }}' . PHP_EOL;
    }

    public function parseEnd(Token $Token)
    {
        return '{{ /section }}';
    }
}