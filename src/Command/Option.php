<?php
/**
 * TODO
 */

namespace Avolutions\Command;

/**
 * TODO
 */
class Option
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
    public string $short;

    /**
     * TODO
     *
     * @var string|mixed
     */
    public string $help;

    /**
     * TODO
     *
     * @var mixed|null
     */
    public mixed $default;

    /**
     * TODO
     *
     * @param string $name TODO
     * @param string $short TODO
     * @param string $help TODO
     * @param bool $default TODO
     */
    public function __construct(string $name, string $short = '', string $help = '', bool $default = false)
    {
        $this->name = $name;
        $this->short = $short;
        $this->help = $help;
        $this->default = $default;
    }
}