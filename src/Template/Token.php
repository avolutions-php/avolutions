<?php


namespace Avolutions\Template;


class Token
{
    public const INCLUDE = 0;
    public const SECTION = 1;
    public const PLAIN = 2;
    public const IF = 3;
    public const FOR = 4;
    public const ELSEIF = 5;
    public const ELSE = 6;
    public const END = 7;
    public const VARIABLE = 8;
    public const UNKOWN = 99;

    public int $type;
    public string $value;

    public function __construct(int $type, string $value)
    {
        $this->type = $type;
        $this->value = $value;
    }
}