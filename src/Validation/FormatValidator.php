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
use function implode;

/**
 * FormatValidator
 *
 * The FormatValidator checks if a value has a valid format.
 *
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.6.0
 */
class FormatValidator extends AbstractValidator
{
    /**
     * The format to check against.
     *
     * @var string $format
     */
    private string $format;

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

        $validFormats = ['ip', 'ip4', 'ip6', 'mail', 'url', 'json'];
        if (!isset($options['format']) || !in_array($options['format'], $validFormats)) {
            throw new InvalidArgumentException('Invalid format, must be either '.implode(' ', $validFormats));
        } else {
            $this->format = $options['format'];
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
        switch ($this->format) {
            case 'ip':
                return filter_var($value, FILTER_VALIDATE_IP) !== false;
            case 'ip4':
                return filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) !== false;
            case 'ip6':
                return filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) !== false;
            case 'mail':
                return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
            case 'url':
                return filter_var($value, FILTER_VALIDATE_URL) !== false;
            case 'json':
                json_decode($value);
                return (json_last_error() == JSON_ERROR_NONE);
            default:
                return false;
        }
    }
}