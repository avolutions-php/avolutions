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

namespace Avolutions\Core;

/**
 * Convertable trait
 *
 * TODO
 *
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.9.0
 */
trait ConvertableTrait
{
    /**
     * toArray
     *
     * TODO
     *
     * @return array TODO
     */
    public function toArray(): array
    {
        return json_decode($this->toJson(), true);
    }

    /**
     * toJson
     *
     * TODO
     *
     * @return string TODO
     */
    public function toJson(): string
    {
        return json_encode($this);
    }
}