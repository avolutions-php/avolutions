<?php

namespace Avolutions\Template\TokenParser;

use Avolutions\Template\ITokenParser;
use Avolutions\Template\Token;

class VariableTokenParser implements ITokenParser
{
    /**
     * TODO
     *
     * @var string
     */
    public string $validVariableCharacters = '[a-zA-Z0-9_-]';

    /**
     * @inheritDoc
     */
    public function parse(Token $Token)
    {
        if (preg_match('@' . $this->getVariableRegex() . '@x', $Token->value, $matches)) {
            return 'print ' . str_replace($matches[0], $this->todoVariable($matches[0]), $Token->value) . ';' . PHP_EOL;
        } else {
            // throw Exception
        }
    }

    public function getVariableRegex(bool $stringStartEnd = true): string
    {
        // Variables can either have a global or local scope, e.g.:
        //      Global: {{ $foo }} or {{ $foo.bar }}...
        //      Local: {{ local }} or {{ foo.bar }}...
        // Variables consists of three parts:
        //      1. Can start with zero or one "_" to translate the variable
        //         This part must occur exact once. E.g. "_$foo"
        //      2. Can start with zero or one "$" followed by 1 to n allowed variable characters.
        //         This part must occur exact once. E.g. "$foo"
        //      3. Starts with exact one "." followed by 1 to n allowed variable characters.
        //         This part can occur 0 to n times. E.g. ".bar"
        $variableRegex = '
            (?:_?\$?' . $this->validVariableCharacters . '{1,}){1}
            (?:\.{1}' . $this->validVariableCharacters . '{1,})*
        ';

        if ($stringStartEnd) {
            $variableRegex = '^' . $variableRegex . '$';
        }

        return $variableRegex;
    }

    public function todoVariable(string $variable, bool $nullCoalescing = true): string
    {
        $variable = trim($variable);
        $translate = false;

        if (str_starts_with($variable, '_')) {
            $translate = true;
            $variable = ltrim($variable, '_');
        }

        $explodedVariable = explode('.', $variable);

        if (str_starts_with($variable, '$')) {
            // global
            $parsedVariable = '$data';
        } else {
            // local
            $parsedVariable = '$' . trim($explodedVariable[0]);
            unset($explodedVariable[0]);
        }

        foreach ($explodedVariable as $name) {
            $parsedVariable .= '["' . trim(ltrim($name, '$')) . '"]';
        }

        if ($nullCoalescing) {
            $parsedVariable .= ' ?? null';
        }

        if ($translate) {
            $parsedVariable = 'translate(' . $parsedVariable .')';
        }

        return $parsedVariable;
    }
}