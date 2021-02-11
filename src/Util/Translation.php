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

use Avolutions\Config\Config;
use Avolutions\Config\ConfigFileLoader;
use Avolutions\Http\Session;
use Exception;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

/**
 * Translation class
 *
 * The Translation class loads all translation files at the bootstrapping and can be used to
 * get the translated values anywhere in the framework or application.
 *
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.6.0
 */
class Translation extends ConfigFileLoader
{
    /**
     * getTranslation
     *
     * Returns the translation of the given key and language and replace all placeholders
     * if params are passed.
     *
     * @param string $key The key of the translation string.
     * @param array $params An array with values to replace the placeholders in translation.
     * @param string $language The language in which the translation should be loaded.
     *
     * @throws Exception
     *
     * @return mixed The config value
     */
    public static function getTranslation($key, $params = [], $language = null)
    {
        if (is_null($language)) {
            if (!is_null(Session::get('language'))) {
                $language = Session::get('language');
            } else {
                $language = Config::get('application/defaultLanguage');
            }
        }

        $translation = parent::get($language.'/'.$key);

        $translation = StringHelper::interpolate($translation, $params);

        return $translation;
    }

    /**
     * initialize
     *
     * Loads all translation values from the translations files.
     */
    public function initialize()
    {
        if (!is_dir(TRANSLATION_PATH)) {
            return;
        }

        $DirectoryIterator = new RecursiveDirectoryIterator(TRANSLATION_PATH, RecursiveDirectoryIterator::SKIP_DOTS);
        $Iterator = new RecursiveIteratorIterator($DirectoryIterator);

        foreach ($Iterator as $translationFile) {
            if ($translationFile->isDir()) {
                continue;
            }

            $language = basename(dirname($translationFile));
            self::$values[$language][pathinfo($translationFile, PATHINFO_FILENAME)] = self::loadConfigFile($translationFile);
        }
    }
}