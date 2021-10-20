<?php

namespace Avolutions\Template\TokenParser;

use Avolutions\Template\Token;

interface ITokenParser
{
    /**
     * parse
     *
     * TODO
     *
     * @param Token $Token TODO
     */
    // TODO add string as return type
    public function parse(Token $Token);
}