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
 * Router class
 *
 * The Router class find the matching Route for the url of the Request.
 *
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.1.0
 */
class Router
{
    /**
     * TODO
     */
    private RouteCollection $RouteCollection;

    /**
     * TODO
     */
    public function __construct(RouteCollection $RouteCollection)
    {
        $this->RouteCollection = $RouteCollection;
    }


    /**
     * findRoute
     *
     * Finds the matching Route from the RouteCollection by the passed uri/path and method.
     *
     * @param string $path The requested uri/path
     * @param string $method The method of the request
     *
     * @return Route|null The matched Route object with final controller-/action names and parameter values.
     */
    public function findRoute(string $path, string $method): ?Route
    {
		$MatchedRoute = null;

		foreach ($this->RouteCollection->getAllByMethod($method) as $Route) {
			if (preg_match($this->getRegularExpression($Route), $path, $matches)) {

				// remove full match
				array_splice($matches, 0, 1);

				preg_match_all('/\<[^\>]*\>/', $Route->url, $explodedUrl);
				$explodedUrl = $explodedUrl[0];

				$controllerName = $this->getKeywordValue($matches, $explodedUrl, 'controller');
				$actionName = $this->getKeywordValue($matches, $explodedUrl, 'action');

				$MatchedRoute = $Route;
				if ($controllerName) {
					$MatchedRoute->controllerName = $controllerName;
				}
				if ($actionName) {
					$MatchedRoute->actionName = $actionName;
				}
				$MatchedRoute->parameters = $this->getParameterValues($matches, $explodedUrl, $MatchedRoute->parameters);

				break;
			}
		}

		return $MatchedRoute;
	}


    /**
     * getRegularExpression
     *
     * Returns the regular expression to match the given Route.
     *
     * @param Route $Route The Route object to build the expression for.
     *
     * @return string The regular expression to match the url of the Route.
     */
    private function getRegularExpression(Route $Route): string
    {
		$startDelimiter = '/^';
		$endDelimiter = '$/';

		$controllerExpression = '([a-z]*)';
		$actionExpression = '([a-z]*)';

		$expression = $Route->url;
		$expression = str_replace('/', '\/', $expression);

		$expression = str_replace('<controller>', $controllerExpression, $expression);
		$expression = str_replace('<action>', $actionExpression, $expression);

		foreach ($Route->parameters as $parameterName => $parameterValues) {
			$parameterExpression = '(';
			$parameterExpression .= $parameterValues['format'] ?? '[a-zA-Z0-9\-_]*';
			if (isset($parameterValues['optional']) && $parameterValues['optional']) {
				// last slash for optional parameter is also optional, therefore we add a ? behind it
				$parameterExpression = '?' . $parameterExpression . '?';
			}
			$parameterExpression .= ')';

			$expression = str_replace('<' . $parameterName . '>', $parameterExpression, $expression);
		}

        return $startDelimiter . $expression . $endDelimiter;
	}


    /**
     * getKeywordValue
     *
     * Returns the value of a given keyword from the url of the matched Route.
     *
     * @param array $matches Array with the exploded url of the request.
     * @param array $explodedUrl Array with the exploded url of the route.
     * @param string $keyword Name of the keyword.
     *
     * @return mixed The value of the keyword from the url or false if nothing found.
     */
    private function getKeywordValue(array $matches, array $explodedUrl, string $keyword): mixed
    {
		$keywordIndex = array_search('<'.$keyword.'>', $explodedUrl);

		return is_numeric($keywordIndex) ? $matches[$keywordIndex] : false;
	}


    /**
     * getParameterValues
     *
     * Returns an array with all parameters values from the url of the matched Route.
     *
     * @param array $matches Array with the exploded url of the request.
     * @param array $explodedUrl Array with the exploded url of the route.
     * @param array $parameters Array with the parameters of the route.
     *
     * @return array An array with all parameter values.
     */
    private function getParameterValues(array $matches, array $explodedUrl, array $parameters): array
    {
		$parameterValues = [];

		foreach ($parameters as $parameterName => $parameterOptions) {
			$value = $this->getKeywordValue($matches, $explodedUrl, $parameterName);

			if ($value) {
				$parameterValues[] = $value;
			} else {
				if (isset($parameterOptions['optional']) && $parameterOptions['optional']) {
					if (isset($parameterOptions['default'])) {
						$parameterValues[] = $parameterOptions['default'];
					}
				}
			}
		}

		return $parameterValues;
	}
}