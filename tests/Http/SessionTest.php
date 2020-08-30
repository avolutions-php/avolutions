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

use PHPUnit\Framework\TestCase;

use Avolutions\Http\Session;

class SessionTest extends TestCase
{
    public function testSessionCanBeStarted()
    {
        Session::start();

        $this->assertEquals(session_status(), \PHP_SESSION_ACTIVE);
        $this->assertEquals($_SESSION, []);
    }

    public function testSessionIsStarted()
    {
        $isStarted = Session::isStarted();

        $this->assertEquals($isStarted, true);
    }

    public function testSetSessionValues() 
    {
        Session::set('value1', 'foo');
        Session::set('value2', 4711);
        Session::set('value3', true);

        $this->assertEquals($_SESSION['value1'], 'foo');
        $this->assertEquals($_SESSION['value2'], 4711);
        $this->assertEquals($_SESSION['value3'], true);
    }

    public function testGetsessionValues() 
    {
        $value1 = Session::get('value1');
        $value2 = Session::get('value2');
        $value3 = Session::get('value3');

        $this->assertEquals($value1, 'foo');
        $this->assertEquals($value2, 4711);
        $this->assertEquals($value3, true);
    }

    public function testDeleteSessionValue() 
    {
        Session::delete('value2');
        
        $this->assertEquals(Session::get('value1'), 'foo');
        $this->assertEquals(Session::get('value2'), null);
        $this->assertEquals(Session::get('value3'), true);
    }

    public function testSessionCanBeDestroyed()
    {
        Session::destroy();
        
        $this->assertEquals(Session::get('value1'), null);
        $this->assertEquals(Session::get('value2'), null);
        $this->assertEquals(Session::get('value3'), null);
        $this->assertEquals($_SESSION, []);
    }
}