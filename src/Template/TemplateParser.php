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

use Avolutions\Template\TokenParser;
use Avolutions\Template\TokenParser\ITokenParser;

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
            $Tokenizer = new Tokenizer();
            $Tokens = $Tokenizer->tokenize($this->templateContent);
            $Nodes = $this->parseTokens($Tokens);

            return $this->compile($Nodes);
        }
    }

    // TODO maybe own class?
    private function compile(array $Nodes): string
    {
        // TODO add tabs for if/for blocks
        $output = '';
        foreach ($Nodes as $Node) {
            $output .= $Node->getValue();
        }

        return $output;
    }

    /**
     * parseTokens
     *
     * TODO
     *
     * @param array $Tokens TODO
     *
     * @return array TODO
     */
    private function parseTokens(array $Tokens): array
    {
        $Nodes = [];

        foreach ($Tokens as $Token) {
            $TokenParser = $this->getTokenParser($Token->type);
            $Nodes[] = $TokenParser->parse($Token);
        }

        return $Nodes;
    }

    private function getTokenParser(int $TokenType): ITokenParser
    {
        return match ($TokenType) {
            TokenType::INCLUDE => new TokenParser\IncludeTokenParser(),
            TokenType::SECTION => new TokenParser\SectionTokenParser(),
            TokenType::PLAIN => new TokenParser\PlainTokenParser(),
            TokenType::IF,
            TokenType::ELSEIF => new TokenParser\IfTokenParser(),
            TokenType::FORM => new TokenParser\FormTokenParser(),
            TokenType::FOR => new TokenParser\ForTokenParser(),
            TokenType::ELSE => new TokenParser\ElseTokenParser(),
            TokenType::END => new TokenParser\EndTokenParser(),
            TokenType::VARIABLE => new TokenParser\VariableTokenParser()
        };
    }

    /**
     * parseSections
     *
     * TODO
     */
    private function parseSections()
    {
        // TODO move to SectinTokenParser?
        $masterTemplateContent = $this->Template->getMasterTemplate()->getParsedContent();
        foreach ($this->Template->getSections() as $key => $content) {
            $masterTemplateContent = str_replace('{{ section ' . $key . ' }}', $content, $masterTemplateContent);
            $this->templateContent = $masterTemplateContent;
        }
    }

    private function todoPrint(): string
    {
        // TODO add print, semicolon and new line
        return "";
    }
}