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
use Avolutions\Core\Application;
use Avolutions\Http\Session;
use Exception;
use FilesystemIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

/**
 * Translation class
 *
 * The Translation class loads all translation files at the bootstrapping and can be used to
 * get the translated values anywhere in the framework or application.
 *
 * @author  Alexander Vogt <alexander.vogt@avolutions.org>
 * @since   0.6.0
 */
class Translation extends ConfigFileLoader
{
    /**
     * Config instance.
     *
     * @var Config $Config
     */
    private Config $Config;

    /**
     * Session instance.
     *
     * @var Session $Session
     */
    private Session $Session;


    /**
     * __construct
     *
     * Creates a new Translation instance and loads all translation values from the translations files.
     *
     * @param Application $Application Application instance.
     * @param Config $Config Config instance.
     * @param Session $Session Session instance.
     */
    public function __construct(Application $Application, Config $Config, Session $Session)
    {
        $this->Config = $Config;
        $this->Session = $Session;

        if (!is_dir($Application->getTranslationPath())) {
            return;
        }

        $DirectoryIterator = new RecursiveDirectoryIterator(
            $Application->getTranslationPath(),
            FilesystemIterator::SKIP_DOTS
        );
        $Iterator = new RecursiveIteratorIterator($DirectoryIterator);

        foreach ($Iterator as $translationFile) {
            if ($translationFile->isDir()) {
                continue;
            }

            $language = basename(dirname($translationFile));
            $this->values[$language][pathinfo($translationFile, PATHINFO_FILENAME)] = $this->loadConfigFile(
                $translationFile
            );
        }
    }

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
    public function getTranslation(string $key, array $params = [], ?string $language = null): string
    {
        if (is_null($language)) {
            if (!is_null($this->Session->get('language'))) {
                $language = $this->Session->get('language');
            } else {
                $language = $this->Config->get('application/defaultLanguage');
            }
        }

        $translation = parent::get($language . '/' . $key);
        // if $key not point on a translation but on a parent element
        if (!is_string($translation)) {
            throw new Exception('Value must be of type string to translate it.');
        }

        return StringHelper::interpolate($translation, $params);
    }
}