<?php


namespace Avolutions\Template;


class Token
{
    public const PLAIN = 0;
    public const IF = 1;
    public const FOR = 2;
    public const ELSE = 3;
    public const END = 4;
    public const VARIABLE = 5;
    public const UNKOWN = 99;

    public int $type;
    public string $value;

    public function __construct(int $type, string $value)
    {
        $this->type = $type;
        $this->value = $value;
    }
}