<?php

namespace Avolutions\Template\TokenParser;

use Avolutions\Template\Token;

class EndTokenParser implements ITokenParser
{
    public function parse(Token $Token)
    {
        if (preg_match('@(?:/|end)(if|section|form|for)@', $Token->value, $matches)) {
            $TokenParser = match ($matches[1]) {
                'form' => new FormTokenParser(),
                'for' => new ForTokenParser(),
                'if' => new IfTokenParser(),
                'section' => new SectionTokenParser(),
            };

            return $TokenParser->parseEnd($Token);
        } else {
            // throw Exception
        }
    }
}