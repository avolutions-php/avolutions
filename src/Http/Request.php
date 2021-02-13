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
	 * @var array $parameters The variables from $_REQUEST.
	 */
	public $parameters = [];
		
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

        // Get all values of the request, remove $_REQUEST['path] and set as $this->parameters 
        $parameters = $_REQUEST;
        unset($parameters['path']);
        $this->parameters = $parameters;
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
						
		$fullControllerName = APP_CONTROLLER_NAMESPACE.ucfirst($MatchedRoute->controllerName).'Controller';
		$Controller = new $fullControllerName();		
		
        $fullActionName = $MatchedRoute->actionName.'Action';        
        // Merge the parameters of the route with the values of $_REQUEST
        $parameters = array_merge($MatchedRoute->parameters, $this->parameters);

		$Response = new Response();
		$Response->setBody(call_user_func_array([$Controller, $fullActionName], $parameters));
		$Response->send();
	}
}