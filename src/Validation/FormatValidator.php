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

namespace Avolutions\Validation;

use Avolutions\Validation\Validator;

/**
 * FormatValidator
 *
 * TODO
 *
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.6.0
 */
class FormatValidator extends Validator
{
    /**
     * TODO
     */
    private $format;

    /**
     * setOptions
     *
     * TODO
     * @param array $options
     * @param null $property
     * @param null $Entity
     */
    public function setOptions($options = [], $property = null, $Entity = null) {
        $validFormats = ['ip', 'ip4', 'ip6', 'mail', 'url', 'json'];
        if (!isset($options['format']) || !in_array($options['format'], $validFormats)) {
            throw new \InvalidArgumentException('Invalid format, must be either '.\implode($validFormats, ' '));
        } else {
            $this->format = $options['format'];
        }
    }

    /**
     * isValid
     *
     * TODO
     *
     * @param $value
     * @return bool TODO
     */
    public function isValid($value) {
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