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

namespace Avolutions\Routing;

/**
 * Route class
 *
 * A Route object which will be added to the RouteCollection.
 * The Router class will find the corresponding Route object for
 * the current request.
 *
 * @author  Alexander Vogt <alexander.vogt@avolutions.org>
 * @since   0.1.0
 */
class Route
{
    /**
     * The url of the Route
     *
     * @var string $url
     */
    public string $url;

    /**
     * The method of the Route
     *
     * @var string $method
     */
    public string $method = 'GET';

    /**
     * The name of the Controller
     *
     * @var string $controllerName
     */
    public string $controllerName;

    /**
     * The name of the Controller action
     *
     * @var string $actionName
     */
    public string $actionName;

    /**
     * An array with all parameters and their options
     *
     * @var array $parameters
     */
    public array $parameters = [];

    /**
     * __construct
     *
     * Creates a new Route object with the given parameters.
     *
     * @param string $url The URL that will be mapped
     * @param array $defaults Default values for the Route
     *        $defaults = [
     *            'controller'    => string Name of the controller
     *            'action'        => string Name of the action
     *            'method'        => string Name of the method (GET|POST)
     *        ]
     * @param array $parameters An array which contains all parameters and their options
     *        '{param}' = [    => string Name of the parameter
     *            'format'    => string RegEx for valid format
     *            'optional'  => bool If true the parameter is optional
     *            'default'    => string Default value for the parameter if it is optional
     *        ]
     */
    public function __construct(string $url, array $defaults = [], array $parameters = [])
    {
        $this->url = $url;
        if (isset($defaults['controller'])) {
            $this->controllerName = $defaults['controller'];
        }
        if (isset($defaults['action'])) {
            $this->actionName = $defaults['action'];
        }
        if (isset($defaults['method'])) {
            $this->method = $defaults['method'];
        }

        $this->setParameters($url, $parameters);
    }

    /**
     * setParameters
     *
     * Set the parameter and options.
     *
     * @param string $url The URL that will be mapped
     * @param array $parameters An array which contains all parameters and their options
     */
    private function setParameters(string $url, array $parameters): void
    {
        // find all parameters in url string
        preg_match_all('/<([^>]*)>/', $url, $urlParameters);

        // to get parameters without angle brackets (index 1 = groups of preg_match_all)
        $urlParameters = $urlParameters[1];

        // remove reserved keywords
        $urlParameters = array_filter($urlParameters, function ($item) {
            return !in_array($item, ['controller', 'action']);
        });

        // iterate all parameters from url
        foreach ($urlParameters as $urlParameter) {
            if (isset($parameters[$urlParameter])) {
                // if options passed for parameter use this
                $this->parameters[$urlParameter] = $parameters[$urlParameter];
            } else {
                // if no options passed add parameter with empty options
                $this->parameters[$urlParameter] = [];
            }
        }
    }
}