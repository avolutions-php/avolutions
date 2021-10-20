<?php

namespace Avolutions\Template\TokenParser;

use Avolutions\Template\Token;

class EndTokenParser implements ITokenParser
{
    public function parse(Token $Token)
    {
        // TODO own methods
        if (preg_match('@(?:/|end)(if|section|form|for)@', $Token->value, $matches)) {
            switch ($matches[1]) {
                case "form":
                    return 'print $Form->close();';
                    break;

                case "for":
                    $end = '$loop["index"]++;' . PHP_EOL;
                    $end .= '$loop["first"] = false;' . PHP_EOL;
                    $end .= '}'.PHP_EOL;
                    $end .= 'if (isset($loop["parent"])) {' . PHP_EOL;
                    $end .= "\t" . '$loop = $loop["parent"];' . PHP_EOL;
                    $end .= '}' . PHP_EOL;
                    $end .= '}' .PHP_EOL;
                    return $end;
                    break;

                case "if":
                    return '}'.PHP_EOL;
                    break;

                case "section":
                    return '{{ /section }}';
                    break;
            }
        } else {
            // throw Exception
        }
    }
}