<?php
/**
 * AVOLUTIONS
 * 
 * Just another open source PHP framework.
 * 
 * @copyright	Copyright (c) 2019 - 2020 AVOLUTIONS
 * @license		MIT License (http://avolutions.org/license)
 * @link		http://avolutions.org
 */
 
namespace Avolutions\Http;

/**
 * Cookie class
 *
 * TODO
 *
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.4.0
 */
class Cookie
{	
    /** 
     * @var string $domain TODO
     */
    public $domain = '';

    /** 
     * @var int $expires TODO
     */
    public $expires = 0;

    /** 
     * @var bool $httpOnly TODO
     */
    public $httpOnly = false;

    /** 
     * @var string $name TODO
     */
    public $name;

    /** 
     * @var string $path TODO
     */
    public $path = '';

    /** 
     * @var bool $secure TODO
     */
    public $secure = false;

    /** 
     * @var string $value TODO
     */
    public $value = '';

    /**
	 * __construct
	 * 
	 * TODO
     * 
     * @param string $name TODO
     * @param string $value TODO
     * ...
	 */
    public function __construct($name, $value)
    {
        $this->name = $name;
        $this->value = $value;
	}	
}