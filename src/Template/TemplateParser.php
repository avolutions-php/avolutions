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

        if (str_starts_with($match, '$')) {
            return Token::VARIABLE;
        }

        return Token::UNKOWN;
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
        if (preg_match('@if \$?([a-zA-Z0-9_-]*) (==|!=) \$?([a-zA-Z0-9]*)@', $Token->value, $matches)) {
            // TODO parse matches[1]: wenn variable, dann durch $data ersetzen, wenn string dann anführungszeichen, wenn bool oder zahl dann nichts
            // TODO parse matches[2]: wenn equal/is/=== etc durch === etc ersetzen
            // TODO parse matches[3]: wenn variable, dann durch $data ersetzen, wenn string dann anführungszeichen, wenn bool oder zahl dann nichts

            return str_replace('if', 'if (', $Token->value) . ') {'.PHP_EOL;
        } else {
            // throw Expection
        }

        return "";
    }
    private function parseFor($Token): string
    {
        return "";
    }

    private function parseElse($Token): string
    {
        if (preg_match('@else@', $Token->value, $matches)) {
            return '} else {'.PHP_EOL;
        } else {
            // throw exception
        }
    }

    private function parseEnd($Token): string
    {
        if (preg_match('@(/|end)(if|for)@', $Token->value, $matches)) {
            return '}'.PHP_EOL;
        } else {
            // throw exception
        }
    }

    private function parseVariable($Token): string
    {
        if (preg_match('@\$([a-zA-Z0-9_-]*)@', $Token->value, $matches)) {
            return 'print ' . str_replace($matches[1], $this->todoVariable($matches[1]), $Token->value).PHP_EOL;
        } else {
            // throw Expection
        }
    }

    private function todoVariable($variable): string
    {
        return 'data["' . $variable . '"];';
    }

    private function todoPrint(): string
    {
        // TODO add print, semicolon and new line
        return "";
    }
}