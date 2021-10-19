<?php

namespace Avolutions\Template\TokenParser;

use Avolutions\Template\ITokenParser;
use Avolutions\Template\Token;

class PlainTokenParser implements ITokenParser
{
    public function parse(Token $Token)
    {
        return 'print "' . addcslashes($Token->value, '\"\$') . '";'.PHP_EOL;
    }
}