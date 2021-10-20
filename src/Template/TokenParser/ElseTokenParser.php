<?php

namespace Avolutions\Template\TokenParser;

use Avolutions\Template\Node;
use Avolutions\Template\Token;

class ElseTokenParser implements ITokenParser
{
    public function parse(Token $Token)
    {
        if (preg_match('@else@', $Token->value, $matches)) {
            $Node = new Node();

            $Node->writeLine('} else {');

            return $Node;
        } else {
            // throw Exception
        }
    }
}