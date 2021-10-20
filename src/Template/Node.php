<?php

namespace Avolutions\Template;

class Node
{
    private string $value = '';

    private int $indentation = 0;

    public function print()
    {
        $this->write('print ');

        return $this;
    }

    public function write(string $value)
    {
        $this->value .= str_repeat("\t", $this->indentation) . $value;

        return $this;
    }

    public function append(string $value)
    {
        $this->value .= $value;

        return $this;
    }

    public function writeLine(string $value)
    {
        $this->write($value . PHP_EOL);

        return $this;
    }

    public function nl()
    {
        $this->append(PHP_EOL);

        return $this;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function escape(string $value)
    {
        return addcslashes($value, '\"\$');
    }

    public function quote(string $value)
    {
        return '"' . $value .'"';
    }

    public function indent(int $indent = 1)
    {
        $this->indentation += $indent;

        return $this;
    }

    public function outdent(int $indent = 1)
    {
        // TODO check if possible

        $this->indentation -= $indent;

        return $this;
    }
}