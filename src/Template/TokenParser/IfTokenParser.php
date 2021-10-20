<?php

namespace Avolutions\Template\TokenParser;

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

    private function parseIf(Token $Token, bool $elseIf = false): string
    {
        $ifTermRegex = $elseIf ? 'elseif' : 'if';

        // TODO regex for e.g. {{ if true }} or {{ if not true }}
        // TODO regex for and/or conditions
        $ifTermRegex .= ' (.*) (==|!=|>) (.*)';

        if (preg_match('@' . $ifTermRegex . '@', $Token->value, $matches)) {
            $ifCondition = $elseIf ? '} elseif' : 'if';
            $ifCondition .= ' (';
            $ifCondition .= $this->todoParseIfTerm($matches[1]);
            $ifCondition .= ' ' . $this->todoParseIfOperator($matches[2]) . ' ';
            $ifCondition .= $this->todoParseIfTerm($matches[3]);
            $ifCondition .= ') {'.PHP_EOL;

            return $ifCondition;
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
        return '}'.PHP_EOL;
    }
}