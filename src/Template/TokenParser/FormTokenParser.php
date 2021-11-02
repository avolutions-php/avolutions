<?php

namespace Avolutions\Template\TokenParser;

use Avolutions\Template\Node;
use Avolutions\Template\Token;

class FormTokenParser implements ITokenParser, IEndTokenParser
{
    public function parse(Token $Token)
    {
        $VariableTokenParser = new VariableTokenParser();

        // TODO parse form(-element|widget|help|error|label) and call private methods like in IfTokenParser
        if (preg_match('@(?:form-{1}(element|input|label|error):{1}([a-zA-Z0-9_-]*)){1}@x', $Token->value, $matches)) {
            return match ($matches[1]) {
                'element' => $this->parseElement($Token, $matches[2]),
                'input' => $this->parseInput($Token, $matches[2]),
                'label' => $this->parseLabel($Token, $matches[2]),
                'error' => $this->parseError($Token, $matches[2])
            };
        } else if (preg_match('@form \s(' . $VariableTokenParser->getVariableRegex(false) . ')@x', $Token->value, $matches)) {
            $Node = new Node();

            $Node
                ->writeLine('use Avolutions\Template\Form;')
                ->writeLine('use Application\Model\User;')
                ->writeLine('$Form = new Form(new User());')
                ->print()
                ->writeLine('$Form->open();');

            return $Node;
        }
    }

    public function parseEnd(Token $Token)
    {
        $Node = new Node();

        $Node
            ->print()
            ->writeLine('$Form->close();');

        return $Node;
    }

    private function parseElement(Token $Token, string $field)
    {
        return new Node();
    }

    private function parseInput(Token $Token, string $field)
    {
        $Node = new Node();

        $Node
            ->print()
            ->writeLine('$Form->inputFor("' . $field . '");');

        return $Node;
    }

    private function parseLabel(Token $Token, string $field)
    {
        $Node = new Node();

        $Node
            ->print()
            ->writeLine('$Form->labelFor("' . $field . '");');

        return $Node;
    }

    private function parseError(Token $Token, string $field)
    {
        return new Node();
    }
}