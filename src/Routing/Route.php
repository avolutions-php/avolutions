<?php
/**
 * AVOLUTIONS
 *
 * Just another open source PHP framework.
 *
 * @copyright   Copyright (c) 2019 - 2021 AVOLUTIONS
 * @license     MIT License (http://avolutions.org/license)
 * @link        http://avolutions.org
 */

namespace Avolutions\Routing;

/**
 * Route class
 *
 * A Route object which will be added to the RouteCollection.
 * The Router class will find the corresponding Route object for
 * the current request.
 *
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.1.0
 */
class Route
{
	/**
	 * @var string $url The url of the Route
	 */
	public string $url;

	/**
	 * @var string $method The method of the Route
	 */
	public string $method = 'GET';

	/**
	 * @var string $controllerName The name of the Controller
	 */
	public string $controllerName;

	/**
	 * @var string $actionName The name of the Controller action
	 */
	public string $actionName;

	/**
	 * @var array $parameters An array with all parameters and their options
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

		if ($parameters != null) {
			foreach ($parameters as $parameterName => $parameterValues) {
				$this->parameters[$parameterName] = $parameterValues;
			}
		}
	}
}