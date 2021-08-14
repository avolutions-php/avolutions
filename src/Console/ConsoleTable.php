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
     * @param array $rows Multidimensional array with row values.
     * @param bool $useFirstRowAsHeader First row is used as header (true) or not (false).
     */
    public function __construct(Console $Console, array $rows = [], bool $useFirstRowAsHeader = true)
    {
        if ($useFirstRowAsHeader) {
            $this->setHeader($rows[0]);
            array_shift($rows);
        }
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
        if (!empty($this->header) && count($this->header) != count($row)) {
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
     * @param array $rows Multidimensional array with row values.
     * @param bool $useFirstRowAsHeader First row is used as header (true) or not (false).
     */
    public function render(array $rows = [], bool $useFirstRowAsHeader = true)
    {
        if (!empty($rows)) {
            if ($useFirstRowAsHeader) {
                $this->setHeader($rows[0]);
                array_shift($rows);
            }
            $this->addRows($rows);
        }

        $width = $this->calculateColumnWidth();

        if (!empty($this->header)) {
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
        }
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

        if (!empty($this->header)) {
            $rows = array_merge([$this->header], $this->rows);
        } else {
            $rows = $this->rows;
        }

        for ($i = 0; $i < count($rows[0]); $i++) {
            $width[$i] = max(array_map('strlen', array_map(function($row) use ($i) { return $row[$i]; }, $rows)));
        }

        return $width;
    }
}