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
    // TODO add Node as return type
    public function parseEnd(Token $Token);
}