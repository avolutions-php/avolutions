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

use core\view\view;

/**
 * Response class
 *
 * An object that contains the response of the request.
 *
 * @package		core
 * @author		Alexander Vogt <alexander.vogt@avolutions.de>
 * @since		Version 1.0.0
 */
class Response
{
	/** 
	 * @var string $body The content of the response.
	 */
	public $body;
	
	
	/**
	 * Fills the body of the Response with the passed value.
	 */
	public function setBody($body) {
		$this->body = $body;
	}
	
	/**
	 * Displays the content of the Response.
	 */
	public function send() {		
		if($this->body instanceof View) {
			print $this->body;
		}
	}
}
?>