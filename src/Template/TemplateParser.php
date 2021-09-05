<?php


namespace Avolutions\Template;

class TemplateParser
{
    private string $startTag = '{{';
    private string $endTag = '}}';

    private int $position = 0;
    private array $tokens = [];

    public function tokenize($template): array
    {
        preg_match_all('@{{(.*?)}}@', $template, $matches, PREG_OFFSET_CAPTURE);
        $matchesWithDelimiter = $matches[0];
        $matchesWithoutDelimiter = $matches[1];

        foreach ($matchesWithDelimiter as $index => $match) {
            $offset = $match[1];
            $length = strlen($match[0]);

            if ($offset > $this->position) {
                $diff = $offset - $this->position;

                $this->tokens[] = new Token(
                    Token::PLAIN,
                    substr($template, $this->position, $diff)
                );

                $this->position = $this->position + $diff;
            }

            $matchWithDelimiter = $matchesWithoutDelimiter[$index][0];
            $this->tokens[] = new Token(
                $this->getTokenType($matchWithDelimiter),
                $matchWithDelimiter
            );
            $this->position = $offset + $length;
        }

        //print_r($this->tokens);

        return $this->tokens;
    }

    public function getTokenType(string $match)
    {
        $match = trim($match);

        if (str_starts_with($match, 'if')) {
            return Token::IF;
        }

        if (str_starts_with($match, 'for')) {
            return Token::FOR;
        }

        if ($match === 'else') {
            return Token::ELSE;
        }

        if (str_starts_with($match, '/') || str_starts_with($match, 'end')) {
            return Token::END;
        }

        return Token::VARIABLE;
    }

    public function parse(array $tokens)
    {
        foreach ($tokens as $Token) {
            $Token->value = match ($Token->type) {
                Token::PLAIN => $this->parsePlain($Token),
                Token::IF => $this->parseIf($Token),
                Token::FOR => $this->parseFor($Token),
                Token::ELSE => $this->parseElse($Token),
                Token::END => $this->parseEnd($Token),
                Token::VARIABLE => $this->parseVariable($Token)
            };
        }

        return $this->tokens;
    }

    private function parsePlain($Token): string
    {
        return 'print "' . $Token->value . '";'.PHP_EOL;
    }

    private function parseIf($Token): string
    {
        // TODO multiple regex for e.g. {{ if true }} or {{ if not true }}
        if (preg_match('@if (\$?[a-zA-Z0-9_-]*) (==|!=) (\$?[a-zA-Z0-9]*)@', $Token->value, $matches)) {
            $ifCondition = 'if (';
            $ifCondition .= $this->todoParseIfTerm($matches[1]);
            $ifCondition .= ' ' . $this->todoParseIfOperator($matches[2]) . ' ';
            $ifCondition .= $this->todoParseIfTerm($matches[3]);
            $ifCondition .= ') {'.PHP_EOL;

            return $ifCondition;
        } else {
            // throw Exception
        }
    }
    private function parseFor($Token): string
    {
        if (preg_match('@for ([a-zA-Z0-9_-]*) (in) (\$[a-zA-Z0-9_-]*)@', $Token->value, $matches)) {
            $forLoop = 'foreach (';
            $forLoop .= $this->todoVariable($matches[3]);
            $forLoop .= ' as ';
            $forLoop .= $this->todoVariable($matches[1], 'local');
            $forLoop .= ') {'.PHP_EOL;

            return $forLoop;
        } else {
            // throw Exception
        }
    }

    private function parseElse($Token): string
    {
        if (preg_match('@else@', $Token->value, $matches)) {
            return '} else {'.PHP_EOL;
        } else {
            // throw Exception
        }
    }

    private function parseEnd($Token): string
    {
        if (preg_match('@(/|end)(if|for)@', $Token->value, $matches)) {
            return '}'.PHP_EOL;
        } else {
            // throw Exception
        }
    }

    private function parseVariable($Token): string
    {
        // TODO one regex to match global and local ($ = optional)
        if (preg_match('@(\$[a-zA-Z0-9_-]*)(.[a-zA-Z0-9_-]*)*@', $Token->value, $matches)) {
            // global
            return 'print ' . str_replace($matches[0], $this->todoVariable($matches[0]), $Token->value) . ';' . PHP_EOL;
        } else if (preg_match('@([a-zA-Z0-9_-]*.[a-zA-Z0-9_-])*@', $Token->value, $matches)) {
            // local
            return 'print ' . str_replace($matches[0], $this->todoVariable($matches[0], 'local'), $Token->value) . ';' . PHP_EOL;
        } else {
            // throw Exception
        }
    }

    private function todoVariable($variable, $scope = 'global'): string
    {
        $parsedVariable = '';
        $explodedVariable = explode('.', $variable);

        if ($scope == 'global') {
            $parsedVariable = '$data';
        }

        if ($scope == 'local') {
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
     * @param $haystack
     * @param mixed $ifCondition
     * @return array|mixed|string|string[]
     */
    private function todoParseIfTerm($ifTerm): mixed
    {
        // TODO wenn variable, dann durch $data ersetzen, wenn string dann anführungszeichen, wenn bool oder zahl dann nichts
        if (str_starts_with($ifTerm, '$')) {
            return $this->todoVariable($ifTerm);
        }

        // TODO check bool
        if (!is_numeric($ifTerm)) {
            return str_replace($ifTerm, '"' . $ifTerm . '"', $ifTerm);
        }

        return $ifTerm;
    }

    private function todoParseIfOperator($ifOperator)
    {
        return $ifOperator;
    }
}