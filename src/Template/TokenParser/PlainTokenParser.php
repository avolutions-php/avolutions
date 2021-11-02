<?php

namespace Avolutions\Template\TokenParser;

use Avolutions\Template\Node;
use Avolutions\Template\Token;

class PlainTokenParser implements ITokenParser
{
    public function parse(Token $Token)
    {
        $Node = new Node();

        $value = trim($Token->value, PHP_EOL);

        if (strlen($value) > 0) {
            $Node
                ->print()
                ->write($Node->quote($Node->escape(trim($Token->value, PHP_EOL))))
                ->writeLine(";");
        }

        return $Node;
    }
}