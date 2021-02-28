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
use DateTime;
use InvalidArgumentException;
use function implode;

/**
 * DateValidator
 *
 * TODO
 *
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.6.0
 */
class DateTimeValidator extends AbstractValidator
{
    /**
     * @var string $format TODO
     */
    private $format;

    /**
     * @var DateTimeZone $timezone TODO
     */
    private $timezone = null;

    /**
     * @var string $type TODO
     */
    private $type = 'datetime';

    /**
     * setOptions
     *
     * Set the passed options, property and Entity to internal properties.
     *
     * @param array $options An associative array with options.
     * @param string $property The property of the Entity to validate.
     * @param null $Entity The Entity to validate.
     */
    public function setOptions($options = [], $property = null, $Entity = null) {
        parent::setOptions($options, $property, $Entity);

        if (isset($options['type'])) {
            $validTypes = ['date', 'time', 'datetime'];
            if (!in_array($options['type'], $validTypes)) {
                throw new InvalidArgumentException('Invalid operator, must be either ' . implode($validTypes, ' '));
            } else {
                $this->type = $options['type'];
            }
        }

        // TODO check if format is a valid format?
        if (isset($options['format'])) {
            if(!is_string($options['format'])) {
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

        print_r($this->type);
        print_r($this->format);
    }

    /**
     * isValid
     *
     * Checks if the passed value is valid considering the validator type and passed options.
     *
     * @param $value The value to validate.
     *
     * @return bool Data is valid (true) or not (false).
     */
    public function isValid($value) {
        // TODO Timezone
        return DateTime::createFromFormat($this->format, $value, $this->timezone) !== false;
    }
}