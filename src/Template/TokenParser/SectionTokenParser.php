<?php

namespace Avolutions\Template\TokenParser;

use Avolutions\Template\Token;

class SectionTokenParser implements ITokenParser, IEndTokenParser
{
    public function parse(Token $Token)
    {
        $Node = new Node();

        $Node->writeLine('{{ ' . $Token->value . ' }}');

        return $Node;
    }

    public function parseEnd(Token $Token)
    {
        $Node = new Node();

        $Node->writeLine('{{ /section }}');

        return $Node;
    }
}