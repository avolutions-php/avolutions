<?php

namespace Avolutions\Template\TokenParser;

use Avolutions\Template\Node;
use Avolutions\Template\Token;

class PlainTokenParser implements ITokenParser
{
    public function parse(Token $Token)
    {
        $Node = new Node();

        $Node
            ->print()
            ->write($Node->quote($Node->escape($Token->value)))
            ->writeLine(";");

        return $Node;
    }
}