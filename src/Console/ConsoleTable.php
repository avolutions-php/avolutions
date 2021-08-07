<?php
/**
 * TODO
 */

namespace Avolutions\Console;

/**
 * Class ConsoleTable
 *
 * TODO
 */
class ConsoleTable
{
    /**
     * TODO
     *
     * @var Console
     */
    private Console $Console;

    /**
     * TODO
     *
     * @var array
     */
    private array $header = [];

    /**
     * TODO
     *
     * @var array
     */
    private array $rows = [];

    /**
     * TODO
     *
     * @param Console $Console TODO
     * @param array $header TODO
     * @param array $rows TODO
     */
    public function __construct(Console $Console, array $header = [], array $rows = [])
    {
        $this->setHeader($header);
        $this->Console = $Console;
    }

    /**
     * TODO
     *
     * @param array $header TODO
     */
    public function setHeader(array $header): void
    {
        $this->header = $header;
    }

    /**
     * TODO
     *
     * @param array $row TODO
     */
    public function addRow(array $row): void
    {
        // TODO check if header count and row count same
        $this->rows[] = $row;
    }

    /**
     * TODO
     *
     * @param array $rows TODO
     */
    public function addRows(array $rows)
    {
        foreach ($rows as $row) {
            if (is_array($row)) {
                $this->addRow($row);
            } else {
                // TODO show error
            }
        }
    }

    /**
     * TODO
     *
     * @param array $header TODO
     * @param array $rows TODO
     */
    public function render(array $header = [], array $rows = [])
    {
        if (!empty($header)) {
            $this->setHeader($header);
        }
        if (!empty($rows)) {
            $this->setRows($rows);
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
     * TODO
     *
     * @return array TODO
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