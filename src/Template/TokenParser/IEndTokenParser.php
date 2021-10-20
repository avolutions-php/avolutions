<?php

namespace Avolutions\Template\TokenParser;

use Avolutions\Template\Token;

interface IEndTokenParser
{
    /**
     * parseEnd
     *
     * TODO
     *
     * @param Token $Token TODO
     */
    public function parseEnd(Token $Token);
}