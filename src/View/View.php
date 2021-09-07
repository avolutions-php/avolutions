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

namespace Avolutions\View;

use Avolutions\Core\Application;
use Avolutions\Template\Template;

/**
 * View class
 *
 * contains any representation of the application. This allows the separation
 * from the application logic. It can also contain variable content that will
 * be passed by a ViewModel.
 *
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.1.0
 */
class View
{
	/**
     * The content of the view file
     *
	 * @var string $view
	 */
	private string $view = '';

    /**
     * __construct
     *
     * Creates a new View object that contains the content of the view file and
     * the data of the passed ViewModel.
     *
     * @param string|null $viewname The name of the View file.
     * @param ViewModel|null $ViewModel $ViewModel The ViewModel object that will passed to the View.
     */
	public function __construct(?string $viewname = null, ?ViewModel $ViewModel = null)
	{
		$filename = $this->getFilename($viewname);

		if (is_file($filename)) {
            //$this->view = $this->loadViewFile($filename, $ViewModel);

            $toArray = function($x) use(&$toArray)
            {
                return is_scalar($x)
                    ? $x
                    : array_map($toArray, (array) $x);
            };

            $ViewModel = $toArray($ViewModel);

		    $Template = new Template($filename, $ViewModel);
		    //$Template->assign('name', $ViewModel->name);
            //$Template->name = $ViewModel->name;
			//$this->view = $Template->render();
            $this->view = $Template->parse();
		}
	}

    /**
     * loadViewFile
     *
     * @param string $filename The path and filename of the View file.
     * @param ViewModel|null $ViewModel The ViewModel object that will passed to the View.
     *
     * @return string The content of the loaded view file.
     */
	private function loadViewFile(string $filename, array $data = []): string
    {
		ob_start();
        include $filename;
		$content = ob_get_contents();
		ob_end_clean();
		return $content;
	}

    /**
     * getFilename
     *
     * Returns the full filename including the absolute path. If filename parameter
     * is not specified it will be resolved by the calling controller and action name.
     *
     * @param string|null $filename The name of the View file.
     *
     * @return string The filename of the loaded view file included the absolute path.
     */
	private function getFilename(?string $filename = null): string
    {
		if ($filename == null) {
			$debugBacktrace = debug_backtrace()[2];

			$controller = explode('\\', $debugBacktrace['class']);
			$controller = str_ireplace('Controller', '', end($controller));

			$action = $debugBacktrace['function'];
			$action = str_ireplace('Action', '', $action);

			$filename = $controller.DIRECTORY_SEPARATOR.$action;
		}

		$filename = Application::getViewPath().$filename.'.php';

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
	public function __toString(): string
    {
        return $this->view;
    }
}