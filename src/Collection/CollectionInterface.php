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

namespace Avolutions\Collection;

/**
 * Collection interface
 *
 * An interface which declares the base collection functionality.
 *
 * @author  Alexander Vogt <alexander.vogt@avolutions.org>
 * @since   0.1.0
 */
interface CollectionInterface
{
    /**
     * getAll
     *
     * Returns all items of the Collection.
     *
     * @return array An array of all items of the Collection
     */
    public function getAll(): array;

    /**
     * count
     *
     * Returns the number of items in the Collection.
     *
     * @return int The number of items in the Collection.
     */
    public function count(): int;
}