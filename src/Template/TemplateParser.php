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
     * TODO
     *
     * @var array
     */
    private array $tokens = [];

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
     * tokenize
     *
     * TODO
     */
    private function tokenize()
    {
        $position = 0;
        $template = $this->templateContent;
        $this->tokens = [];

        preg_match_all('@{{(.*?)}}@', $template, $matches, PREG_OFFSET_CAPTURE);

        // if no parsable template element ({{ ... }}) found
        if (empty($matches[0]) && empty($matches[1])) {
            $this->tokens[] = new Token(
            Token::PLAIN,
                $template
            );
        }

        $matchesWithDelimiter = $matches[0];
        $matchesWithoutDelimiter = $matches[1];

        foreach ($matchesWithDelimiter as $index => $match) {
            $offset = $match[1];
            $length = strlen($match[0]);

            if ($offset > $position) {
                $diff = $offset - $position;

                $this->tokens[] = new Token(
                    Token::PLAIN,
                    substr($template, $position, $diff)
                );

                $position = $position + $diff;
            }

            $matchWithoutDelimiter = $matchesWithoutDelimiter[$index][0];
            $this->tokens[] = new Token(
                $this->getTokenType($matchWithoutDelimiter),
                trim($matchWithoutDelimiter)
            );
            $position = $offset + $length;
        }

        // TODO remaining content, maybe working for "empty" case also (see line 56)
    }

    /**
     * getTokenType
     *
     * TODO
     *
     * @param string $match TODO
     *
     * @return int TODO
     */
    public function getTokenType(string $match): int
    {
        $match = trim($match);

        if (str_starts_with($match, 'master')) {
            return Token::MASTER;
        }

        if (str_starts_with($match, 'section')) {
            return Token::SECTION;
        }

        if (str_starts_with($match, 'if')) {
            return Token::IF;
        }

        if (str_starts_with($match, 'for')) {
            return Token::FOR;
        }

        if (str_starts_with($match, 'elseif')) {
            return Token::ELSEIF;
        }

        if ($match === 'else') {
            return Token::ELSE;
        }

        if (str_starts_with($match, 'default')) {
            return Token::DEFAULT;
        }

        if (str_starts_with($match, '/') || str_starts_with($match, 'end')) {
            return Token::END;
        }

        // TODO find variable and return UNKNOWN as default
        return Token::VARIABLE;
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
            $this->tokenize();
            $Tokens = $this->parseTokens();

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
     * @return array TODO
     */
    private function parseTokens(): array
    {
        foreach ($this->tokens as $Token) {
            $Token->value = match ($Token->type) {
                /*Token::MASTER => $this->parseMaster($Token),*/
                Token::SECTION => $this->parseSection($Token),
                Token::PLAIN => $this->parsePlain($Token),
                Token::IF => $this->parseIf($Token),
                Token::FOR => $this->parseFor($Token),
                Token::ELSEIF => $this->parseElseIf($Token),
                Token::ELSE => $this->parseElse($Token),
                Token::END => $this->parseEnd($Token),
                Token::VARIABLE => $this->parseVariable($Token)
            };
        }

        return $this->tokens;
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
        return 'print "' . $Token->value . '";'.PHP_EOL;
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
            $variable = $this->todoVariable($matches[2]);

            $forLoop = 'if (isset(' . $variable . ')) { ';
            $forLoop .= 'foreach (';
            $forLoop .= $variable;
            $forLoop .= ' as ';
            $forLoop .= $this->todoVariable($matches[1]);
            $forLoop .= ') {'.PHP_EOL;

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
        $end = '}'.PHP_EOL;

        if (preg_match('@(?:/|end)(if|for)@', $Token->value, $matches)) {
            if ($matches[1] == 'for') {
                $end .= '}'.PHP_EOL;
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

    private function todoVariable(string $variable): string
    {
        $variable = trim($variable);
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
        // TODO wenn variable, dann durch $data ersetzen, wenn string dann anführungszeichen, wenn bool oder zahl dann nichts
        if (preg_match('@' . $this->getVariableRegex() . '@x', $ifTerm, $matches)) {
            return $this->todoVariable($ifTerm);
        }

        if (!is_numeric($ifTerm) && !in_array($ifTerm, ['false', 'true'])) {
            return str_replace($ifTerm, '"' . $ifTerm . '"', $ifTerm);
        }

        return $ifTerm;
    }

    private function todoParseIfOperator(string $ifOperator): string
    {
        return $ifOperator;
    }

    private function getVariableRegex(bool $stringStartEnd = true): string
    {
        // Variables can either have a global or local scope, e.g.:
        //      Global: {{ $foo }} or {{ $foo.bar }}
        //      Local: {{ foo.bar }}
        // Global variable consists of two parts:
        //      1. Starts with exact one "$" followed by 1 to n allowed variable characters.
        //         This part is required exact once. E.g. "$foo"
        //      2. Starts with exact one "." followed by 1 to n allowed variable characters.
        //         This part can occur 0 to n times. E.g. ".bar"
        // Local variable consists of two parts:
        //      1. Starts with 1 to n allowed variable characters followed by exact on ".".
        //         This part can occur 1 to n times. E.g.: "foo."
        //      2. Starts with 1 to n allowed variable characters.
        //         This part is required exact once. E.g. "bar"
        $globalVariableRegex = '
            (?:\${1}' . $this->validVariableCharacters . '{1,}){1}
            (?:\.{1}' . $this->validVariableCharacters . '{1,})*
        ';

        $localVariableRegex = '
            (?:' . $this->validVariableCharacters . '{1,}\.{1}){1,}
            (?:' . $this->validVariableCharacters . '{1,}){1}
        ';

        if ($stringStartEnd) {
            $globalVariableRegex = '^' . $globalVariableRegex . '$';
            $localVariableRegex = '^' . $localVariableRegex . '$';
        }

        return $globalVariableRegex. '|' . $localVariableRegex;
    }
}