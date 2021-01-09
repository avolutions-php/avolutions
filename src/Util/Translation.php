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

namespace Avolutions\Util;

use Avolutions\Config\ConfigFileLoader;

/**
 * Translation class
 *
 * TODO
 *
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.6.0
 */
class Translation extends ConfigFileLoader
{
	/**
	 * initialize
	 *
	 * TODO
	 */
    public function initialize()
    {
        $DirectoryIterator = new \RecursiveDirectoryIterator(TRANSLATION_PATH, \RecursiveDirectoryIterator::SKIP_DOTS);
        $Iterator = new \RecursiveIteratorIterator($DirectoryIterator);

        foreach ($Iterator as $translationFile) {
            if ($translationFile->isDir()) {
                continue;
            }

            $language = basename(dirname($translationFile));
            self::$values[$language][pathinfo($translationFile, PATHINFO_FILENAME)] = self::loadConfigFile($translationFile);
        }
	}
}