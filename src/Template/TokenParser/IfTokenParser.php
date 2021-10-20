<?php

namespace Avolutions\Template\TokenParser;

use Avolutions\Template\Node;
use Avolutions\Template\Token;
use Avolutions\Template\TokenType;

class IfTokenParser implements ITokenParser, IEndTokenParser
{
    /**
     * @inheritDoc
     */
    public function parse(Token $Token)
    {
        return $this->parseIf($Token, $Token->type === TokenType::ELSEIF);
    }

    private function parseIf(Token $Token, bool $elseIf = false): Node
    {
        $ifTermRegex = $elseIf ? 'elseif' : 'if';

        // TODO regex for e.g. {{ if true }} or {{ if not true }}
        // TODO regex for and/or conditions
        $ifTermRegex .= ' (.*) (==|!=|>) (.*)';

        if (preg_match('@' . $ifTermRegex . '@', $Token->value, $matches)) {
            $Node = new Node();

            $Node
                ->write($elseIf ? '} elseif' : 'if')
                ->write(' (')
                ->write($this->todoParseIfTerm($matches[1]))
                ->write(' ' . $this->todoParseIfOperator($matches[2]) . ' ')
                ->writeLine(') { ');

            return $Node;
        } else {
            // throw Exception
        }
    }

    /**
     * @param string $ifTerm
     * @return mixed
     */
    private function todoParseIfTerm(string $ifTerm): mixed
    {
        $VariableTokenParser = new VariableTokenParser();

        if (
            is_numeric($ifTerm)
            || in_array($ifTerm, ['false', 'true', 'null'])
            || !preg_match('@' . $VariableTokenParser->getVariableRegex() . '@x', $ifTerm, $matches)
        ) {
            return $ifTerm;
        }

        return '(' . $VariableTokenParser->todoVariable($ifTerm) . ')';
    }

    private function todoParseIfOperator(string $ifOperator): string
    {
        return $ifOperator;
    }

    public function parseEnd(Token $Token)
    {
        $Node = new Node();

        $Node->writeLine('}');

        return $Node;
    }
}