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
use Exception;

/**
 * View class
 *
 * contains any representation of the application. This allows the separation
 * from the application logic. It can also contain variable content that will
 * be passed by a ViewModel.
 *
 * @author  Alexander Vogt <alexander.vogt@avolutions.org>
 * @since   0.1.0
 */
class View
{
    /**
     * Application instance.
     *
     * @var Application $Application
     */
    private Application $Application;

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
     * @param Application $Application Application instance.
     * @param string|null $viewname The name of the View file.
     * @param ViewModel|null $ViewModel $ViewModel The ViewModel object that will be passed to the View.
     *
     * @throws Exception
     */
    public function __construct(Application $Application, ?string $viewname = null, ?ViewModel $ViewModel = null)
    {
        $this->Application = $Application;
        $filename = $this->getFilename($viewname);

        if (is_file($filename)) {
            $this->view = $this->loadViewFile($filename, $ViewModel);
        } else {
            throw new Exception(interpolate('View file \'{0}\' not found', [$filename]));
        }
    }

    /**
     * loadViewFile
     *
     * @param string $filename The path and filename of the View file.
     * @param ViewModel|null $ViewModel The ViewModel object that will be passed to the View.
     *
     * @return string The content of the loaded view file.
     */
    private function loadViewFile(string $filename, ViewModel $ViewModel = null): string
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
            $debugBacktrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);

            // find Controller and Action in debug backtrace
            $caller = array_filter($debugBacktrace, function ($item) {
                return
                    str_ends_with($item['function'], 'Action')
                    && str_ends_with($item['class'], 'Controller');
            });
            $caller = array_shift($caller);

            if (!empty($caller)) {
                $controller = explode('\\', $caller['class']);
                $controller = strtolower(str_ireplace('Controller', '', end($controller)));

                $action = $caller['function'];
                $action = strtolower(str_ireplace('Action', '', $action));

                $filename = $controller . DIRECTORY_SEPARATOR . $action;
            }
        }

        return $this->Application->getViewPath() . $filename . '.php';
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
	
	/**
	 * Redirect helper
	 *
	 * @param string $url
	 * @param integer $statusCode
	 * @return void
	 */
	public function redirect($url, $statusCode = 303)
	{
		header('Location: ' . $url, true, $statusCode);
		exit();
	}
}
