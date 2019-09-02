<?php
/**
 * AVOLUTIONS
 * 
 * Just another open source PHP framework.
 * 
 * @author		Alexander Vogt <alexander.vogt@avolutions.de>
 * @copyright	2019 avolutions (http://avolutions.de)
 * @license		MIT License (https://opensource.org/licenses/MIT)
 * @link		https://github.com/avolutions/avolutions
 * @since		Version 1.0.0
 */
 
namespace core;

use core\routing\Router; 

/**
 * Request class
 *
 * The Request class calls the Router to find the matching Route for the url
 * invokes the corresponding controller action.
 *
 * @package		core
 * @author		Alexander Vogt <alexander.vogt@avolutions.de>
 * @since		Version 1.0.0
 */
class Request
{
	/** 
	 * @var string $uri The uri of the request.
	 */
	public $uri;
	
	/** 
	 * @var string $method The method of the request.
	 */
	public $method;
		
	/**
	 * __construct
	 * 
	 * Creates a new Request object.	 						  
	 *
	 */
	public function __construct() {
		$this->uri = $_SERVER["REQUEST_URI"];
		$this->method = $_SERVER["REQUEST_METHOD"];
	}
	
	/**
	 * send
	 * 
	 * Executes the Request by calling the Router to find the matching Route.
     * Invokes the controller action with passed parameters.
	 *
	 */
	public function send() {		
		$MatchedRoute = Router::findRoute($this->uri, $this->method);	
						
		$fullControllerName = '\\application\\controller\\'.ucfirst($MatchedRoute->controllerName)."Controller";
		$Controller = new $fullControllerName();		
		
		$fullActionName = $MatchedRoute->actionName."Action";
				
		$Response = new Response();
		$Response->setBody(call_user_func_array(array($Controller, $fullActionName), $MatchedRoute->parameters));
		$Response->send();
	}
}
?>