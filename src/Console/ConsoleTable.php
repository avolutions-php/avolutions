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

use InvalidArgumentException;

/**
 * ConsoleTable class
 *
 * Helper to create tables for Console output.
 *
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.8.0
 */
class ConsoleTable
{
    /**
     * Console instance for output.
     *
     * @var Console
     */
    private Console $Console;

    /**
     * Array with header columns.
     *
     * @var array
     */
    private array $header = [];

    /**
     * Multidimensional array with row values.
     *
     * @var array
     */
    private array $rows = [];

    /**
     * __construct
     *
     * Creates and initializes a new ConsoleTable instance.
     *
     * @param Console $Console Console instance for output.
     * @param array $header Array with header columns.
     * @param array $rows Multidimensional array with row values.
     */
    public function __construct(Console $Console, array $header = [], array $rows = [])
    {
        $this->setHeader($header);
        $this->addRows($rows);
        $this->Console = $Console;
    }

    /**
     * setHeader
     *
     * Set the header columns for the table.
     *
     * @param array $header Array with header columns.
     */
    public function setHeader(array $header): void
    {
        $this->header = $header;
    }

    /**
     * addRow
     *
     * Adds an array with row values.
     *
     * @param array $row Array with row values.
     */
    public function addRow(array $row): void
    {
        if (count($this->header) != count($row)) {
            throw new InvalidArgumentException('Row must contain same amount of columns as header.');
        }
        $this->rows[] = $row;
    }

    /**
     * addRows
     *
     * Adds multiple rows to the table.
     *
     * @param array $rows Multidimensional array with row values.
     */
    public function addRows(array $rows)
    {
        foreach ($rows as $row) {
            if (is_array($row)) {
                $this->addRow($row);
            } else {
                throw new InvalidArgumentException('Rows must contain arrays with column values.');
            }
        }
    }

    /**
     * render
     *
     * Displays the table to the Console output.
     *
     * @param array $header Array with header columns.
     * @param array $rows Multidimensional array with row values.
     */
    public function render(array $header = [], array $rows = [])
    {
        if (!empty($header)) {
            $this->setHeader($header);
        }
        if (!empty($rows)) {
            $this->addRows($rows);
        }

        $width = $this->calculateColumnWidth();

        foreach ($this->header as $index => $header) {
            if ($index == 0) {
                $this->Console->write('|');
            }
            $this->Console->write(' ' . str_pad($header, $width[$index], ' ', STR_PAD_BOTH) . ' |');
        }
        $this->Console->writeLine('');
        foreach ($this->header as $index => $header) {
            if ($index == 0) {
                $this->Console->write('|');
            }
            $this->Console->write('' . str_pad('', $width[$index] + 2, '-', STR_PAD_BOTH) . '|');
        }
        $this->Console->writeLine('');
        foreach ($this->rows as $row) {
            foreach ($row as $index => $field) {
                if ($index == 0) {
                    $this->Console->write('|');
                }
                $this->Console->write(' ' . str_pad($field, $width[$index]) . ' |');
            }
            $this->Console->writeLine('');
        }
    }

    /**
     * calculateColumnWidth
     *
     * Finds the longest value/header of each column to adjust the layout.
     *
     * @return array Longest value per column.
     */
    private function calculateColumnWidth(): array
    {
        $width = [];

        $rows = array_merge([$this->header], $this->rows);
        for ($i = 0; $i < count($this->header); $i++) {
            $width[$i] = max(array_map('strlen', array_map(function($row) use ($i) { return $row[$i]; }, $rows)));
        }

        return $width;
    }
}