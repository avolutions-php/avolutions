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

namespace Avolutions\Http;

use Avolutions\View\View;

/**
 * Response class
 *
 * An object that contains the response of the request.
 *
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.1.0
 */
class Response
{
    /**
     * The content of the response.
     *
     * @var string $body
     */
    public string $body;

    /**
     * setBody
     *
     * Fills the body of the Response with the passed value.
     *
     * @param string $value The value for the body
     */
    public function setBody(string $value)
    {
        $this->body = $value;
    }

    /**
     * send
     *
     * Displays the content of the Response.
     */
    public function send()
    {
        print $this->body;
    }
}