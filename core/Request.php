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
 
namespace core;

use core\routing\Router; 

/**
 * Request class
 *
 * TODO 
 *
 * @package		avolutions\core
 * @subpackage	Core
 * @author		Alexander Vogt <alexander.vogt@avolutions.de>
 * @link		http://framework.avolutions.de/documentation/request
 * @since		Version 1.0.0
 */
class Request
{
	/** 
	 * @var string $uri TODO
	 */
	public $uri;
	
	/** 
	 * @var string $method TODO
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
	 * TODO 						  
	 *
	 */
	public function send() {
		$MatchedRoute = Router::findRoute($this->uri, $this->method);
		
		// TODO find better way in autoloader for plugins later		
		$fullControllerName = '\\application\\controller\\'.ucfirst($MatchedRoute->controllerName)."Controller";
		$fullActionName = $MatchedRoute->actionName."Action";
		
		call_user_func_array(array($fullControllerName, $fullActionName), $MatchedRoute->parameters);
	}
}
?>