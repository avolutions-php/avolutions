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

use Avolutions\Core\Application;
use Avolutions\Routing\Router;

use const Avolutions\CONTROLLER;

/**
 * Request class
 *
 * The Request class calls the Router to find the matching Route for the url
 * invokes the corresponding controller action.
 *
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.1.0
 */
class Request
{
    /**
     * The uri of the request.
     *
     * @var string $uri
     */
    public string $uri;

    /**
     * The method of the request.
     *
     * @var string $method
     */
    public string $method;

    /**
     * The variables from $_REQUEST.
     *
     * @var array $parameters
     */
    public array $parameters = [];

    /**
     * __construct
     *
     * Creates a new Request object.
     *
     */
    public function __construct()
    {
        $this->uri = $_SERVER['REQUEST_URI'];
        $this->method = $_SERVER['REQUEST_METHOD'];

        // Get all parameters from the request depending on request method
        $parameters = match ($this->method) {
            'GET' => $_GET,
            'POST' => $_POST,
        };
        // Remove 'path' from Request parameters because we use it in rewrite rule in htaccess for pretty url and it is
        // handled by the Route later.
        unset($parameters['path']);
        $this->parameters = $parameters;
    }

    /**
     * execute
     *
     * Executes the Request by calling the Router to find the matching Route.
     * Invokes the controller action with passed parameters.
     *
     */
    public function execute(): Response
    {
        $MatchedRoute = Router::findRoute($this->uri, $this->method);

		$fullControllerName = Application::getControllerNamespace().ucfirst($MatchedRoute->controllerName).CONTROLLER;
		$Controller = new $fullControllerName();

        $fullActionName = $MatchedRoute->actionName.'Action';
        // Merge the parameters of the route with the values of $_REQUEST
        $parameters = array_merge($MatchedRoute->parameters, $this->parameters);

        $Response = new Response();
        $Response->setBody(call_user_func_array([$Controller, $fullActionName], $parameters));

        return $Response;
    }
}