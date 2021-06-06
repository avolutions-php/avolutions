<?php
/**
 * AVOLUTIONS
 *
 * Just another open source PHP framework.
 *
 * @copyright   Copyright (c) 2019 - 2021 AVOLUTIONS
 * @license     MIT License (http://avolutions.org/license)
 * @link        http://avolutions.org
 */

namespace Avolutions\Util;

use Composer\Script\Event;

/**
 * Composer class
 *
 * Provides helper methods to composer events.
 *
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.7.0
 */
class ComposerHelper
{
    public static function postAutoloadDump(Event $event)
    {
        $vendorDir = $event->getComposer()->getConfig()->get('vendor-dir');
        require $vendorDir.'/autoload.php';
    }
}