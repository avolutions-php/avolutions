<?php
/**
 * AVOLUTIONS
 * 
 * An open source PHP framework.
 * 
 * @author		Alexander Vogt <alexander.vogt@avolutions.de>
 * @copyright	2019 avolutions (http://avolutions.de)
 * @license		MIT License (https://opensource.org/licenses/MIT)
 * @link		http://framework.avolutions.de
 * @since		Version 1.0.0
 */

namespace core\routing;

/**
 * Router class
 * 
 * The Router class find the matching Route for the url of the Request and
 * invokes the corresponding controller and action.
 *
 * @package		avolutions\core\routing
 * @subpackage	Core
 * @author		Alexander Vogt <alexander.vogt@avolutions.de>
 * @link		http://framework.avolutions.de/documentation/router
 * @since		Version 1.0.0
 */
class Router
{
	/**
	 * findRoute
	 * 
	 * Finds the matching Route from the RouteCollection by the passed url/path.
	 * 
	 * @param string $path TODO
	 * @param string $method TODO
	 *
	 * @return object $MatchedRoute TODO
	 */
	public static function findRoute($path, $method) {
		$RouteCollection = RouteCollection::getInstance();
		$MatchedRoute = null;
		
		print $path.'<br />';
		
		// TODO get all by method
		foreach ($RouteCollection->getAll() as $Route) {
			if (preg_match(self::getRegularExpression($Route), $path, $matches)) {
				print 'Wow it´s a match <br />';
				
				print_r($matches);
				
				$explodedUrl = explode('/', $Route->url);	
				print_r($explodedUrl);
				$controllerName = self::getKeywordValue($matches, $explodedUrl, 'controller');
				$actionName = self::getKeywordValue($matches, $explodedUrl, 'action');
				
				$MatchedRoute = $Route;
				if($controllerName) {				
					$MatchedRoute->controllerName = $controllerName;	
				}
				if($actionName) {				
					$MatchedRoute->actionName = $actionName;	
				}
				$MatchedRoute->parameters = self::getParameterValues($matches, $explodedUrl, $MatchedRoute->parameters);
				
				print_r($MatchedRoute);
				
				break;
			}
		}	
		
		return $MatchedRoute;
	}	
	
	
	/**
	 * getRegularExpression
	 * 
	 * TODO
	 * 
	 * @param object $Route TODO
	 *
	 * @return string $expression TODO 
	 */
	private static function getRegularExpression($Route) {
		$startDelimiter = '/^';
		$endDelimiter = '$/';
		
		// TODO from config?
		$controllerRegEx = '([a-z]*)';
		$actionRegEx = '([a-z]*)';
		
		$expression = $Route->url;
		$expression = str_replace('/', '\/', $expression);
		
		$expression = str_replace('<controller>', $controllerRegEx, $expression);
		$expression = str_replace('<action>', $actionRegEx, $expression);
		
		foreach($Route->parameters as $parameterName => $parameterValues) {
			// TODO optional (?) only if default or optional flag in parameter options are set
			$expression = str_replace('<'.$parameterName.'>', '('.$parameterValues["format"].'?)', $expression);
		}
		
		$expression = $startDelimiter.$expression.$endDelimiter;
		
		print $expression.'<br />';
		
		return $expression;
	}
	
	
	/**
	 * getKeywordValue
	 * 
	 * TODO
	 * 
	 * @param array $matches TODO
	 * @param array $explodedUrl TODO
	 * @param string $keyword TODO
	 *
	 * @return mixed $value TODO 
	 */
	private static function getKeywordValue($matches, $explodedUrl, $keyword) {
		$keywordIndex = array_search('<'.$keyword.'>', $explodedUrl); 
		
		// TODO shorten + new variable $keywordValue
		if($keywordIndex) {
			return $matches[$keywordIndex];
		} else {
			return false;
		}		
	}
	
	
	/**
	 * getParameterValues
	 * 
	 * TODO
	 * 
	 * @param array $matches TODO
	 * @param array $explodedUrl TODO
	 * @param array $parameters TODO
	 *
	 * @return array $test TODO 
	 */
	private static function getParameterValues($matches, $explodedUrl, $parameters) {		
		// TODO rename variable
		$test = array();
	
		foreach($parameters as $parameterName => $parameterValues) {
			$value = self::getKeywordValue($matches, $explodedUrl, $parameterName);
			
			// TODO shorten
			if($value) {
				$test[] = $value;
			} else {
				$test[] = $parameterValues["default"];
			}
		}
		
		print_r($test);
		
		return $test;
	}
}
?>