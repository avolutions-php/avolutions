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

namespace Avolutions\Di;

use Exception;
use Psr\Container\NotFoundExceptionInterface;

/**
 * NotFoundException class
 *
 * No entry was found in the container.
 *
 * @author  Alexander Vogt <alexander.vogt@avolutions.org>
 * @since   0.9.0
 */
class NotFoundException extends Exception implements NotFoundExceptionInterface
{
}