<?php
/**
 * TODO
 */

namespace Avolutions\Command;

/**
 * TODO
 */
class Argument
{
    /**
     * TODO
     *
     * @var string
     */
    public string $name;

    /**
     * TODO
     *
     * @var string|mixed
     */
    public string $help;

    /**
     * TODO
     *
     * @var bool|mixed
     */
    public bool $optional;

    /**
     * TODO
     *
     * @param string $name TODO
     * @param string $help TODO
     * @param bool $optional TODO
     */
    public function __construct(string $name, string $help = '', bool $optional = false)
    {
        $this->name = $name;
        $this->help = $help;
        $this->optional = $optional;
    }
}