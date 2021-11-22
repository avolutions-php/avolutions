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

namespace Avolutions\Test\Http;

use PHPUnit\Framework\TestCase;

use Avolutions\Http\Session;

use const PHP_SESSION_ACTIVE;

class SessionTest extends TestCase
{
    public function testSessionCanBeStarted()
    {
        $Session = new Session();
        $Session->start();

        $this->assertEquals(PHP_SESSION_ACTIVE, session_status());
        $this->assertEquals([], $_SESSION);
    }

    public function testSessionIsStarted()
    {
        $Session = new Session();
        $isStarted = $Session->isStarted();

        $this->assertEquals(true, $isStarted);
    }

    public function testSetSessionValues()
    {
        $Session = new Session();

        $Session->set('value1', 'foo');
        $Session->set('value2', 4711);
        $Session->set('value3', true);

        $this->assertEquals('foo', $_SESSION['value1']);
        $this->assertEquals(4711, $_SESSION['value2']);
        $this->assertEquals(true, $_SESSION['value3']);
    }

    public function testGetSessionValues()
    {
        $Session = new Session();

        $value1 = $Session->get('value1');
        $value2 = $Session->get('value2');
        $value3 = $Session->get('value3');

        $this->assertEquals('foo', $value1);
        $this->assertEquals(4711, $value2);
        $this->assertEquals(true, $value3);
    }

    public function testDeleteSessionValue()
    {
        $Session = new Session();

        $Session->delete('value2');

        $this->assertEquals('foo', $Session->get('value1'));
        $this->assertEquals(null, $Session->get('value2'));
        $this->assertEquals(true, $Session->get('value3'));
    }

    public function testSessionCanBeDestroyed()
    {
        $Session = new Session();
        $Session->destroy();

        $this->assertEquals(null, $Session->get('value1'));
        $this->assertEquals(null, $Session->get('value2'));
        $this->assertEquals(null, $Session->get('value3'));
        $this->assertEquals([], $_SESSION);
    }
}