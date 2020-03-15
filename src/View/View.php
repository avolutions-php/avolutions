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
 */

namespace Avolutions\View;

/**
 * View class
 *
 * contains any representation of the application. This allows the separation 
 * from the application logic. It can also contain variable content that will 
 * be passed by a ViewModel.   
 *
 * @package		View
 * @author		Alexander Vogt <alexander.vogt@avolutions.de>
 */
class View
{
	/** 
	 * @var string $view The content of the view file
	 */
	private $view = "";

	
	/**
	 * __construct
	 * 
	 * Creates a new View object that contains the content of the view file and 
	 * the data of the passed ViewModel.
	 * 
	 * @param string $viewname The name of the View file.
	 * @param object $ViewModel The ViewModel object that will passed to the View.
	 */
	public function __construct($viewname = null, $ViewModel = null) {
		$filename = $this->getFilename($viewname);
				
		if(is_file($filename)) {
			$this->view = $this->loadViewFile($filename, $ViewModel);
		}
	}
	
	/**
	 * loadViewFile
	 *
	 * @param string $filename The path and filename of the View file.
	 * @param object $ViewModel The ViewModel object that will passed to the View.
	 *	 
	 * @return string The content of the loaded view file.
	 */ 
	private function loadViewFile($filename, $ViewModel = null) {
		ob_start();
		include $filename;
		$content = ob_get_contents();
		ob_end_clean();
		return $content;
	}

	/**
	 * getFilename
	 *
	 * Returns the full filename including the absoulte path. If filename parameter
	 * is not specified it will be resolved by the calling controller and action name.
	 *
	 * @param string $filename The name of the View file.
	 *	 
	 * @return string The filename of the loaded view file included the absolute path.
	 */
	private function getFilename($filename) {		
		if($filename == null) {
			$debugBacktrace = debug_backtrace()[2];
			
			$controller = explode("\\", $debugBacktrace["class"]);	
			$controller = str_ireplace("Controller", "", end($controller));
			
			$action = $debugBacktrace["function"];
			$action = str_ireplace("Action", "", $action);
			
			$filename = $controller.DIRECTORY_SEPARATOR.$action;
		}
		
		$filename = APP_VIEW_PATH.$filename.'.php';
		
		return $filename;
	}	
	
	/**
	 * __toString
	 *
	 * Outputs the content of the loaded view file together with the passed 
	 * ViewModel data.
	 *	 
	 * @return string The content of the loaded view file.
	 */ 
	public function __toString()
    {
        return $this->view;
    }
}
?>