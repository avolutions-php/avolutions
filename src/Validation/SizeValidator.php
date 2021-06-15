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

namespace Avolutions\Validation;

use Avolutions\Orm\Entity;
use InvalidArgumentException;

/**
 * SizeValidator
 *
 * The SizeValidator validates that a value has a specific size or is withing a min/max value.
 *
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.6.0
 */
class SizeValidator extends AbstractValidator
{
    /**
     * The exact size of the value.
     *
     * @var int|null $size
     */
    private ?int $size = null;

    /**
     * The minimum size (inclusive) for the value.
     *
     * @var int|null $min
     */
    private ?int $min = null;

    /**
     * The maximum size (inclusive) for the value.
     *
     * @var int|null $max
     */
    private ?int $max = null;

    /**
     * getSize
     *
     * Returns the size of the passed value. If value is of type integer the size is just the value of this integer.
     * If it is of type string the size will be the length of the string.
     * In case the value is of type array the size will be the count of elements.
     *
     * @param mixed $value The value to get the size of.
     *
     * @return int The size of the value.
     */
    private function getSize(mixed $value): int {
        if (is_numeric($value)) {
            return $value;
        } elseif (is_array($value)) {
            return count($value);
        } else {
            return strlen($value);
        }
    }

    /**
     * setOptions
     *
     * Set the passed options, property and Entity to internal properties.
     *
     * @param array $options An associative array with options.
     * @param string|null $property The property of the Entity to validate.
     * @param Entity|null $Entity The Entity to validate.
     */
    public function setOptions(array $options = [], ?string $property = null, ?Entity $Entity = null) {
        parent::setOptions($options, $property, $Entity);

        if (
            !isset($options['size'])
            && !isset($options['min'])
            && !isset($options['max'])
        ) {
            throw new InvalidArgumentException('Either option "size", "min" or "max" must be set.');
        }

        if (isset($options['size'])) {
            if (!is_int($options['size'])) {
                throw new InvalidArgumentException('Size must be of type integer.');
            } else {
                $this->size = $options['size'];
            }
        }

        if (isset($options['min'])) {
            if (!is_int($options['min'])) {
                throw new InvalidArgumentException('Min must be of type integer.');
            } else {
                $this->min = $options['min'];
            }
        }

        if (isset($options['max'])) {
            if (!is_int($options['max'])) {
                throw new InvalidArgumentException('Max must be of type integer.');
            } else {
                $this->max = $options['max'];
            }
        }
    }

    /**
     * isValid
     *
     * Checks if the passed value is valid considering the validator type and passed options.
     *
     * @param mixed $value The value to validate.
     *
     * @return bool Data is valid (true) or not (false).
     */
    public function isValid(mixed $value): bool {
        $size = $this->getSize($value);

        if (!is_null($this->size)) {
            return $size == $this->size;
        } elseif (!is_null($this->min) && !is_null($this->max)) {
            return $size >= $this->min && $size <= $this->max;
        } elseif (!is_null($this->min) && is_null($this->max)) {
            return $size >= $this->min;
        } elseif (is_null($this->min) && !is_null($this->max)) {
            return $size <= $this->max;
        } else {
            return false;
        }
    }
}