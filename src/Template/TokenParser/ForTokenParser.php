<?php

namespace Avolutions\Template\TokenParser;

use Avolutions\Template\Node;
use Avolutions\Template\Token;

class ForTokenParser implements ITokenParser, IEndTokenParser
{
    public function parse(Token $Token)
    {
        $VariableTokenParser = new VariableTokenParser();

        if (preg_match('@for\s(' . $VariableTokenParser->validVariableCharacters . '*)\sin\s(' . $VariableTokenParser->getVariableRegex(false) . ')@x', $Token->value, $matches)) {
            $variable = $VariableTokenParser->todoVariable($matches[2], false);

            $Node = new Node();

            $Node
                ->writeLine('if (isset(' . $variable . ')) { ')
                ->indent()
                ->writeLine('if (isset($loop)) {')
                ->indent()
                ->writeLine('$loop["parent"] = $loop;')
                ->outdent()
                ->writeLine('}')
                ->writeLine('$loop["count"] = count(' . $variable . ');')
                ->writeLine('$loop["index"] = 1;')
                ->writeLine('$loop["first"] = true;')
                ->writeLine('$loop["last"] = false;')
                ->nl()
                ->write('foreach (')
                ->append($variable . ' as $loop["key"] => ')
                ->append($VariableTokenParser->todoVariable($matches[1], false))
                ->append(') {')
                ->nl()
                ->indent()
                ->writeLine('$loop["last"] = $loop["index"] == $loop["count"];')
                ->writeLine('$loop["even"] = $loop["index"] % 2 == 0;')
                ->writeLine('$loop["odd"] = !$loop["even"];')
                ->nl()
                ;

            return $Node;
        } else {
            // throw Exception
        }
    }

    public function parseEnd(Token $Token)
    {
        $Node = new Node();

        $Node
            ->nl()
            ->indent(2)
            ->writeLine('$loop["index"]++;')
            ->writeLine('$loop["first"] = false;')
            ->outdent()
            ->writeLine('}')
            ->writeLine('if (isset($loop["parent"])) {')
            ->indent()
            ->writeLine('$loop = $loop["parent"];')
            ->outdent()
            ->writeLine('}')
            ->outdent()
            ->writeLine('}')
        ;

        return $Node;
    }
}