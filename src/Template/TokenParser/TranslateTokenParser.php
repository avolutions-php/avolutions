<?php

namespace Avolutions\Template\TokenParser;

use Avolutions\Template\Node;
use Avolutions\Template\Template;
use Avolutions\Template\Token;

class TranslateTokenParser implements ITokenParser, IEndTokenParser
{
    public function parse(Token $Token)
    {
        if (preg_match('@translate \'([a-zA-Z0-9_\-\\\/\.]+)\'@', $Token->value, $matches)) {
            $Node = new Node();

            $Node
                ->print()
                ->writeLine("translate('" . $matches[1] . "');");

            return $Node;
        } else {
            // throw Exception
        }
    }

    public function parseEnd(Token $Token)
    {
        $Node = new Node();

        $Node
            ->writeLine();

        return $Node;
    }
}