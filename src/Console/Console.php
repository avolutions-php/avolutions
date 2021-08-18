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

namespace Avolutions\Console;

/**
 * Console class
 *
 * Handles the console output.
 *
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.8.0
 */
class Console
{
    /**
     * Output stream.
     *
     * @var resource|false $output
     */
    private $output;

    /**
     * Formats for output.
     *
     * @var array $formats
     */
    private array $formats = [
        'bold' => 1,
        'italic' => 3,
        'underline' => 5,
        'reverse' => 7
    ];

    /**
     * Colors for output.
     *
     * @var array $colors
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
     * Background colors for output.
     *
     * @var array $backgroundColors
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
     * Predefined styles for output.
     *
     * @var array $styles
     */
    private array $styles = [
        'error' => ['color' => 'lightRed'],
        'success' => ['color' => 'green']
    ];

    /**
     * __construct
     *
     * Creates a new Console instance and initializes the output stream.
     */
    public function __construct()
    {
        $this->output = STDOUT;
    }

    /**
     * writeLine
     *
     * Adds text with line break at the end to the Console output.
     *
     * @param string $message The message to output.
     * @param mixed|null $style Either the name of a predefined style or an array with style information.
     */
    public function writeLine(string $message, mixed $style = null): void
    {
        $this->write($message, $style, true);
    }

    /**
     * write
     *
     * Adds text to the Console output.
     *
     * @param string $message The message to output.
     * @param mixed|null $style Either the name of a predefined style or an array with style information.
     * @param bool $newLine Either a line break is added to the end (true) or not (false).
     */
    public function write(string $message, mixed $style = null, bool $newLine = false): void
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