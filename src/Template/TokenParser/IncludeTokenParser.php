<?php

namespace Avolutions\Template\TokenParser;

use Avolutions\Template\ITokenParser;
use Avolutions\Template\Template;
use Avolutions\Template\Token;

class IncludeTokenParser implements ITokenParser
{
    public function parse(Token $Token)
    {
        if (preg_match('@include \'([a-zA-Z0-9_\-\\\/\.]+)\'@', $Token->value, $matches)) {
            $Template = new Template($matches[1] . '.php');
            return $Template->getParsedContent();
        } else {
            // throw Exception
        }
    }
}