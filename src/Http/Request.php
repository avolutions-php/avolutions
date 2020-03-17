<?php
/**
 * AVOLUTIONS
 * 
 * Just another open source PHP framework.
 * 
 * @copyright	Copyright (c) 2019 - 2020 AVOLUTIONS
 * @license		MIT License (http://avolutions.org/license)
 * @link		http://avolutions.org
 */
 
namespace Avolutions\Http;

use Avolutions\Routing\Router; 

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
    public function __construct()
    {
		$this->uri = $_SERVER['REQUEST_URI'];
		$this->method = $_SERVER['REQUEST_METHOD'];
	}
	
	/**
	 * send
	 * 
	 * Executes the Request by calling the Router to find the matching Route.
     * Invokes the controller action with passed parameters.
	 *
	 */
    public function send()
    {		
		$MatchedRoute = Router::findRoute($this->uri, $this->method);	
						
		$fullControllerName = ucfirst($MatchedRoute->controllerName).'Controller';
		$Controller = new $fullControllerName();		
		
		$fullActionName = $MatchedRoute->actionName.'Action';
				
		$Response = new Response();
		$Response->setBody(call_user_func_array([$Controller, $fullActionName], $MatchedRoute->parameters));
		$Response->send();
	}
}
?>