<?php
/**
 * AVOLUTIONS
 *
 * Just another open source PHP framework.
 *
 * @copyright   Copyright (c) 2019 - 2021 AVOLUTIONS
 * @license     MIT License (https://avolutions.org/license)
 * @link        https://avolutions.org
 */

namespace Avolutions\Template;

/**
 * TokenType class
 *
 * TODO
 *
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.9.0
 */
class TokenType
{
    /**
     * TODO
     *
     * @var int INCLUDE
     */
    public const INCLUDE = 0;
    public const SECTION = 1;
    public const PLAIN = 2;
    public const IF = 3;
    public const FORM = 4;
    public const FOR = 5;
    public const ELSEIF = 6;
    public const ELSE = 7;
    public const END = 8;
    public const VARIABLE = 9;
    public const UNKOWN = 99;
}