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

use Avolutions\Util\Translation;

function translate($key, $language = null) {
    if(is_null($language)) {
        $language = config('application/defaultLanguage');
    }
    return Translation::get($language.'/'.$key);
}
