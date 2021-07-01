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

namespace Avolutions\Util;

use Avolutions\Config\Config;
use Avolutions\Config\ConfigFileLoader;
use Avolutions\Http\Session;
use Exception;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

use const Avolutions\APP_TRANSLATION_PATH;

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
     * @param string|null $language The language in which the translation should be loaded.
     *
     * @return string The config value
     * @throws Exception
     */
    public static function getTranslation(string $key, array $params = [], ?string $language = null): string
    {
        if (is_null($language)) {
            if (!is_null(Session::get('language'))) {
                $language = Session::get('language');
            } else {
                $language = Config::get('application/defaultLanguage');
            }
        }

        $translation = parent::get($language.'/'.$key);
        // if $key not point on a translation but on a parent element
        if (!is_string($translation)) {
            throw new Exception('Value must be of type string to translate it.');
        }

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
        if (!is_dir(APP_TRANSLATION_PATH)) {
            return;
        }

        $DirectoryIterator = new RecursiveDirectoryIterator(APP_TRANSLATION_PATH, RecursiveDirectoryIterator::SKIP_DOTS);
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