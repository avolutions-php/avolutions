<?php
/**
 * TODO
 */

namespace Avolutions\Console;

/**
 * Class Console
 *
 * TODO
 */
class Console
{
    /**
     * TODO
     *
     * @var false|resource
     */
    private $output;

    /**
     * TODO
     *
     * @var array
     */
    private array $formats = [
        'bold' => 1,
        'italic' => 3,
        'underline' => 5,
        'reverse' => 7
    ];

    /**
     * TODO
     *
     * @var array
     */
    private array $colors = [
        'black' => 30,
        'red' => 31,
        'green' => 32,
        'yellow' => 33,
        'blue' => 34,
        'magenta' => 35,
        'cyan' => 36,
        'white' => 37,
        'gray' => 90,
        'lightRed' => 91,
        'lightGreen' => 92,
        'lightYellow' => 93,
        'lightBlue' => 94,
        'lightMagenta' => 95,
        'lightCyan' => 96,
        'lightWhite' => 97
    ];

    /**
     * TODO
     *
     * @var array
     */
    private array $backgroundColors = [
        'black' => 40,
        'red' => 41,
        'green' => 42,
        'yellow' => 43,
        'blue' => 44,
        'magenta' => 45,
        'cyan' => 46,
        'white' => 47,
        'gray' => 100,
        'lightRed' => 101,
        'lightGreen' => 102,
        'lightYellow' => 103,
        'lightBlue' => 104,
        'lightMagenta' => 105,
        'lightCyan' => 106,
        'lightWhite' => 107
    ];

    /**
     * TODO
     *
     * @var array
     */
    private array $styles = [
        'error' => ['color' => 'lightRed'],
        'success' => ['color' => 'green']
    ];

    /**
     * TODO
     */
    public function __construct()
    {
        $this->output = STDOUT;
    }


    public function header()
    {
        // TODO make it overridable from application
        $this->writeLine(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'header.txt'));
    }

    /**
     * TODO
     *
     * @param string $message TODO
     * @param array $style TODO
     */
    public function writeLine(string $message, mixed $style = null)
    {
        $this->write($message, $style, true);
    }

    /**
     * TODO
     *
     * @param string $message TODO
     * @param array $style TODO
     * @param bool $newLine TODO
     */
    public function write(string $message, mixed $style = null, bool $newLine = false)
    {
        if (is_string($style) && !empty($style)) {
            $style = $this->styles[$style];
        }

        if (is_array($style)) {
            $styleCodes = [];

            if (isset($style['format'])) {
                $styleCodes[] = $this->formats[$style['format']];
            }

            if (isset($style['color'])) {
                $styleCodes[] = $this->colors[$style['color']];
            }

            if (isset($style['background'])) {
                $styleCodes[] = $this->backgroundColors[$style['background']];
            }

            $message = "\033[" . implode(';', $styleCodes) . "m" . $message . "\033[0m";
        }

        if ($newLine) {
            $message = $message.PHP_EOL;
        }

        fwrite($this->output, $message);
    }
}