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
     * The header keys and values of the response.
     *
	 * @var array $headers
	 */
	private array $headers = [];

    /**
     * The content of the response.
     *
     * @var string $body
     */
    private string $body;

    /**
     * __construct
     *
     * TODO
     *
     * @param string $body
     * @param array $headers
     */
    public function __construct(string $body = '', array $headers = [])
    {
        $this->setBody($body);
        $this->setHeaders($headers);
    }


    /**
	 * send
	 *
	 * Displays the content of the Response.
	 */
    public function send()
    {
        $this->sendHeaders();
        $this->sendBody();
	}

	/**
     * TODO
     */
    public function sendBody()
    {
        print $this->body;
    }

    /**
     * TODO
     */
	public function sendHeaders()
    {
        foreach ($this->headers as $name => $value) {
            // TODO replace and status code?
            header($name.':'.$value);
        }
    }

    /**
     * setBody
     *
     * Fills the body of the Response with the passed value.
     *
     * @param string $value The value for the body
     */
    public function setBody(?string $value)
    {
        $this->body = $value ?? '';
    }

    /**
     * setHeaders
     *
     * TODO
     *
     * @param string $name TODO
     * @param mixed $value TODO
     */
    public function setHeader(string $name, mixed $value): void
    {
        $this->headers[$name] = $value;
    }

    /**
     * setHeaders
     *
     * TODO
     *
     * @param array $headers TODO
     */
    public function setHeaders(array $headers = []): void
    {
        foreach ($headers as $name => $value) {
            $this->setHeader($name, $value);
        }
    }
}