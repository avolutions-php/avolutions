<?php


namespace Avolutions\Command;


class Argument
{
    public string $name;
    public string $help;

    public function __construct($name, $help = '')
    {
        $this->name = $name;
        $this->help = $help;
    }
}