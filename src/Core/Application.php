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

namespace Avolutions\Core;

use Avolutions\Http\Request;
use Avolutions\Http\Response;

/**
 * Application class
 *
 * TODO
 *
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.8.0
 */
class Application
{
    /**
     * __construct
     *
     * TODO
     */
    public function __construct()
    {

    }

    /**
     * TODO
     */
    public function start()
    {
        // create new Request
        $Request = new Request();

        // execute Request to get Response
        $Response = $Request->execute();

        // send Response
        $Response->send();
    }
}