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

use Avolutions\Util\Translation;

function translate($key, $params = [], $language = null) {
    return Translation::getTranslation($key, $params, $language);
}