<?php


namespace Avolutions\Command;


class Option
{
    public string $name;
    public string $short;
    public string $help;
    public mixed $default;

    public function __construct($name, $short = '', $help = '', $default = null)
    {
        $this->name = $name;
        $this->short = $short;
        $this->help = $help;
        $this->default = $default;
    }
}