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

namespace Avolutions\Template;

/**
 * TemplateParser class
 *
 * TODO
 *
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.9.0
 */
class TemplateParser
{
    /**
     * TODO
     *
     * @var string
     */
    private string $validVariableCharacters = '[a-zA-Z0-9_-]';

    /**
     * TODO
     *
     * @var Template|null
     */
    private ?Template $Template = null;

    /**
     * TODO
     *
     * @var string
     */
    // TODO rename to content?
    private string $templateContent;

    /**
     * __construct
     *
     * TODO
     *
     * @param Template|null $Template TODO
     */
    public function __construct(?Template $Template = null)
    {
        if ($Template !== null) {
            $this->Template = $Template;
        }
    }

    /**
     * parse
     *
     * TODO
     *
     * @param string $content TODO
     *
     * @return string TODO
     */
    public function parse(string $content): string
    {
        $this->templateContent = $content;

        if ($this->Template !== null && $this->Template->hasMasterTemplate()) {
            $this->parseSections();

            return $this->templateContent;
        } else {
            // TODO move to Tokenizer class
            $Tokenizer = new Tokenizer();
            $Tokens = $Tokenizer->tokenize($this->templateContent);
            $Tokens = $this->parseTokens($Tokens);

            $test = '';
            foreach ($Tokens as $Token) {
                $test .= $Token->value;
            }

            return $test;
        }
    }

    /**
     * parseTokens
     *
     * TODO
     *
     * @param array $Tokens
     *
     *
     * @return array TODO
     * @throws \Exception
     */
    private function parseTokens(array $Tokens): array
    {
        foreach ($Tokens as $Token) {
            $Token->value = match ($Token->type) {
                TokenType::INCLUDE => $this->parseInclude($Token),
                TokenType::SECTION => $this->parseSection($Token),
                TokenType::PLAIN => $this->parsePlain($Token),
                TokenType::IF => $this->parseIf($Token),
                TokenType::FORM => $this->parseForm($Token),
                TokenType::FOR => $this->parseFor($Token),
                TokenType::ELSEIF => $this->parseElseIf($Token),
                TokenType::ELSE => $this->parseElse($Token),
                TokenType::END => $this->parseEnd($Token),
                TokenType::VARIABLE => $this->parseVariable($Token)
            };
        }

        return $Tokens;
    }

    /**
     * @throws \Exception
     */
    private function parseInclude(Token $Token): string
    {
        if (preg_match('@include \'([a-zA-Z0-9_\-\\\/\.]+)\'@', $Token->value, $matches)) {
            $Template = new Template($matches[1] . '.php');
            return $Template->getParsedContent();
        } else {
            // throw Exception
        }
    }

    /**
     * parseSection
     *
     * TODO
     *
     * @param Token $Token TODO
     *
     * @return string TODO
     */
    private function parseSection(Token $Token): string
    {
        return '{{ ' . $Token->value . ' }}' . PHP_EOL;
    }

    /**
     * parseSections
     *
     * TODO
     */
    private function parseSections()
    {
        $masterTemplateContent = $this->Template->getMasterTemplate()->getParsedContent();
        foreach ($this->Template->getSections() as $key => $content) {
            $masterTemplateContent = str_replace('{{ section ' . $key . ' }}', $content, $masterTemplateContent);
            $this->templateContent = $masterTemplateContent;
        }
    }

    private function parsePlain(Token $Token): string
    {
        return 'print "' . addcslashes($Token->value, '\"\$') . '";'.PHP_EOL;
    }

    private function parseIf(Token $Token, bool $elseIf = false): string
    {
        $ifTermRegex = $elseIf ? 'elseif' : 'if';

        // TODO regex for e.g. {{ if true }} or {{ if not true }}
        // TODO regex for and/or conditions
        $ifTermRegex .= ' (.*) (==|!=) (.*)';

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
    private function parseFor(Token $Token): string
    {
        if (preg_match('@for\s(' . $this->validVariableCharacters . '*)\sin\s(' . $this->getVariableRegex(false) . ')@x', $Token->value, $matches)) {
            $variable = $this->todoVariable($matches[2], false);

            $forLoop = 'if (isset(' . $variable . ')) { ' . PHP_EOL;
            $forLoop .= 'if (isset($loop)) {' . PHP_EOL;
            $forLoop .= '$loop["parent"] = $loop;' . PHP_EOL;
            $forLoop .= '}' . PHP_EOL;
            $forLoop .= '$loop["count"] = count(' . $variable . ');' . PHP_EOL;
            $forLoop .= '$loop["index"] = 1;' . PHP_EOL;
            $forLoop .= '$loop["first"] = true;' . PHP_EOL;
            $forLoop .= '$loop["last"] = false;' . PHP_EOL;
            $forLoop .= 'foreach (';
            $forLoop .= $variable;
            $forLoop .= ' as ';
            $forLoop .= '$loop["key"] => ';
            $forLoop .= $this->todoVariable($matches[1], false);
            $forLoop .= ') {'.PHP_EOL;
            $forLoop .= '$loop["last"] = $loop["index"] == $loop["count"];' . PHP_EOL;

            return $forLoop;
        } else {
            // throw Exception
        }
    }

    private function parseElseIf(Token $Token): string
    {
        return $this->parseIf($Token, true);
    }

    private function parseElse(Token $Token): string
    {
        if (preg_match('@else@', $Token->value, $matches)) {
            return '} else {'.PHP_EOL;
        } else {
            // throw Exception
        }
    }

    private function parseEnd(Token $Token): string
    {
        // TODO own methods
        if (preg_match('@(?:/|end)(if|for)@', $Token->value, $matches)) {
            if ($matches[1] == 'for') {
                $end = '$loop["index"]++;' . PHP_EOL;
                $end .= '$loop["first"] = false;' . PHP_EOL;
                $end .= '}'.PHP_EOL;
                $end .= 'if (isset($loop["parent"])) {' . PHP_EOL;
                $end .= "\t" . '$loop = $loop["parent"];' . PHP_EOL;
                $end .= '}' . PHP_EOL;
                $end .= '}' . PHP_EOL;
            } else {
                $end = '}'.PHP_EOL;
            }

            return $end;
        } elseif (preg_match('@(?:/|end)(section)@', $Token->value, $matches)) {
            return '{{ /section }}';
        } else {
            // throw Exception
        }
    }

    private function parseVariable(Token $Token): string
    {
        if (preg_match('@' . $this->getVariableRegex() . '@x', $Token->value, $matches)) {
            return 'print ' . str_replace($matches[0], $this->todoVariable($matches[0]), $Token->value) . ';' . PHP_EOL;
        } else {
            // throw Exception
        }
    }

    private function todoVariable(string $variable, bool $nullCoalescing = true): string
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

    private function todoPrint(): string
    {
        // TODO add print, semicolon and new line
        return "";
    }

    /**
     * @param string $ifTerm
     * @return mixed
     */
    private function todoParseIfTerm(string $ifTerm): mixed
    {
        if (
            is_numeric($ifTerm)
            || in_array($ifTerm, ['false', 'true', 'null'])
            || !preg_match('@' . $this->getVariableRegex() . '@x', $ifTerm, $matches)
        ) {
            return $ifTerm;
        }

        return $this->todoVariable($ifTerm);
    }

    private function todoParseIfOperator(string $ifOperator): string
    {
        return $ifOperator;
    }

    private function getVariableRegex(bool $stringStartEnd = true): string
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
}