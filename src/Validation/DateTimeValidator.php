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

use Avolutions\Config\Config;
use Avolutions\Orm\Entity;
use DateTime;
use InvalidArgumentException;
use function implode;

/**
 * DateValidator
 *
 * The DateValidator checks if a value is a valid date, time or datetime.
 *
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.6.0
 */
class DateTimeValidator extends AbstractValidator
{
    /**
     * The date/time format to check against.
     *
     * @var string $format
     */
    private string $format;

    /**
     * Predefined type to check against.
     *
     * @var string $type
     */
    private string $type = 'datetime';

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

        if (isset($options['type'])) {
            $validTypes = ['date', 'time', 'datetime'];
            if (!in_array($options['type'], $validTypes)) {
                throw new InvalidArgumentException('Invalid operator, must be either ' . implode(' ', $validTypes));
            } else {
                $this->type = $options['type'];
            }
        }

        if (isset($options['format'])) {
            if (!is_string($options['format'])) {
                throw new InvalidArgumentException('Option "format" must be of type string.');
            } else {
                $this->format = $options['format'];
            }
        } else {
            switch ($this->type) {
                case 'date':
                    $this->format = Config::get('application/defaultDateFormat');
                    break;

                case 'time':
                    $this->format = Config::get('application/defaultTimeFormat');
                    break;

                case 'datetime':
                    $this->format = Config::get('application/defaultDateTimeFormat');
                    break;
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
        $DateTime = DateTime::createFromFormat($this->format, $value);

        return $DateTime && $DateTime->format($this->format) === $value;
    }
}