<?php

namespace Avolutions\Template\TokenParser;

use Avolutions\Template\Token;

class ElseTokenParser implements ITokenParser
{
    public function parse(Token $Token)
    {
        if (preg_match('@else@', $Token->value, $matches)) {
            return '} else {'.PHP_EOL;
        } else {
            // throw Exception
        }
    }
}