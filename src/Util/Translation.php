<?php
/**
 * AVOLUTIONS
 *
 * Just another open source PHP framework.
 *
 * @copyright	Copyright (c) 2019 - 2021 AVOLUTIONS
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
	 * get
	 *
	 * Returns the value for the given key. The key is seperated by slashes (/).
	 *
	 * @param string $key The key (slash separated) of the config value.
	 * @param array $params TODO
     *
     * @throws \Exception
	 *
	 * @return mixed The config value
	 */
    public static function getTranslation($key, $params)
    {
        $translation = parent::get($key);

        if (\is_array($params) && count($params) > 0) {
            foreach ($params as $key => $value) {
                $translation = str_replace('{'.$key.'}', $value, $translation);
            }
        }

        return $translation;
    }

	/**
	 * initialize
	 *
	 * TODO
	 */
    public function initialize()
    {
        if(!is_dir(TRANSLATION_PATH)) {
            return;
        }

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