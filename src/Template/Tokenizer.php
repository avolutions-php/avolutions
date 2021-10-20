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
 * Tokenizer class
 *
 * TODO
 *
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.9.0
 */
class Tokenizer
{
    /**
     * tokenize
     *
     * TODO
     *
     * @param string $template TODO
     *
     * @return array TODO
     */
    public function tokenize(string $template): array
    {
        $position = 0;
        $contentLength = strlen($template);
        $tokens = [];

        preg_match_all('@{{(.*?)}}@', $template, $matches, PREG_OFFSET_CAPTURE);

        $matchesWithDelimiter = $matches[0];
        $matchesWithoutDelimiter = $matches[1];

        foreach ($matchesWithDelimiter as $index => $match) {
            $offset = $match[1];
            $length = strlen($match[0]);

            if ($offset > $position) {
                $diff = $offset - $position;

                $tokens[] = new Token(
                    TokenType::PLAIN,
                    substr($template, $position, $diff)
                );

                $position = $position + $diff;
            }

            $matchWithoutDelimiter = $matchesWithoutDelimiter[$index][0];
            $tokens[] = new Token(
                $this->getTokenType($matchWithoutDelimiter),
                trim($matchWithoutDelimiter)
            );
            $position = $offset + $length;
        }

        if ($position < $contentLength) {
            $tokens[] = new Token(
                TokenType::PLAIN,
                substr($template, $position, $contentLength)
            );
        }

        return $tokens;
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

        if (str_starts_with($match, 'include')) {
            return TokenType::INCLUDE;
        }

        if (str_starts_with($match, 'section')) {
            return TokenType::SECTION;
        }

        if (str_starts_with($match, 'if')) {
            return TokenType::IF;
        }

        if (str_starts_with($match, 'form')) {
            return TokenType::FORM;
        }

        if (str_starts_with($match, 'for')) {
            return TokenType::FOR;
        }

        if (str_starts_with($match, 'elseif')) {
            return TokenType::ELSEIF;
        }

        if ($match === 'else') {
            return TokenType::ELSE;
        }

        if (str_starts_with($match, 'default')) {
            return TokenType::DEFAULT;
        }

        if (str_starts_with($match, '/') || str_starts_with($match, 'end')) {
            return TokenType::END;
        }

        // TODO find variable and return UNKNOWN as default
        return TokenType::VARIABLE;
    }
}