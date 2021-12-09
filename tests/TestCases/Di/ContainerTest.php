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

namespace Avolutions\Test\TestCases\Di;

use Avolutions\Di\Container;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class ContainerTest extends TestCase
{
    public function testGetEntryFromContainer()
    {
        $Container = new Container();

        $ContainerTestClass = $Container->get(SimpleContainerStub::class);
        $this->assertInstanceOf(SimpleContainerStub::class, $ContainerTestClass);
    }

    public function testGetSingletonFromContainer()
    {
        $Container = new Container();

        $SimpleContainer = $Container->get(SimpleContainerStub::class);
        $SimpleContainer->isTest = true;

        $ContainerWithConstructor = $Container->get(SimpleContainerWithConstructorStub::class);
        $this->assertEquals($ContainerWithConstructor->SimpleContainerStub, $SimpleContainer);
    }

    public function testContainerHasEntry()
    {
        $Container = new Container();

        $this->assertEquals(false, $Container->has(SimpleContainerStub::class));
        $Container->get(SimpleContainerStub::class);
        $this->assertEquals(true, $Container->has(SimpleContainerStub::class));
    }

    public function testMakeEntryWithContainer()
    {
        $Container = new Container();

        $TestClass = $Container->make(
            ContainerWithConstructorStub::class,
            ['string' => 'foo', 'int' => 4711]
        );
        $this->assertInstanceOf(ContainerWithConstructorStub::class, $TestClass);
        $this->assertEquals('foo', $TestClass->string);
        $this->assertEquals(4711, $TestClass->int);
        $this->assertEquals(false, $TestClass->bool);

        $TestClass2 = $Container->make(
            ContainerWithConstructorStub::class,
            ['string' => 'bar', 'int' => 1337]
        );
        $this->assertNotSame($TestClass, $TestClass2);
    }

    public function testContainerThrowsExceptionIfNoEntryFound()
    {
        $Container = new Container();

        $this->expectException(NotFoundExceptionInterface::class);
        $Container->get('My\Test\Class');
    }

    public function testContainerThrowsExceptionIfCircularDependencyDetected()
    {
        $Container = new Container();

        $this->expectException(ContainerExceptionInterface::class);
        $Container->get(ContainerCircularDependency1Stub::class);
    }

    public function testContainerThrowsExceptionIfCannotResolveParameter()
    {
        $Container = new Container();

        $this->expectException(ContainerExceptionInterface::class);
        $Container->get(ContainerNotResolvableStub::class);
    }

    public function testSetParametersInContainer()
    {
        $Container = new Container();
        $Container->set(
            ContainerWithConstructorStub::class,
            ['string' => 'foo', 'int' => 4711]
        );
        $TestClass = $Container->get(ContainerWithConstructorStub::class);
        $this->assertInstanceOf(ContainerWithConstructorStub::class, $TestClass);
        $this->assertEquals('foo', $TestClass->string);
        $this->assertEquals(4711, $TestClass->int);
        $this->assertEquals(false, $TestClass->bool);
    }

    public function testSetInterfaceInContainer()
    {
        $Container = new Container();
        $Container->set(ContainerInterface::class, ContainerWithInterfaceStub::class);

        $TestClass = $Container->get(ContainerWithInterfaceParameterStub::class);
        $this->assertInstanceOf(ContainerWithInterfaceParameterStub::class, $TestClass);
        $this->assertInstanceOf(ContainerWithInterfaceStub::class, $TestClass->ContainerInterface);
    }

    public function testSetAliasInContainer()
    {
        $Container = new Container();
        $Container->set('stub', SimpleContainerStub::class);

        $TestClass = $Container->get('stub');
        $this->assertInstanceOf(SimpleContainerStub::class, $TestClass);
    }
}

interface ContainerInterface
{

}

class ContainerWithInterfaceStub implements ContainerInterface
{

}

class ContainerWithInterfaceParameterStub
{
    public ContainerInterface $ContainerInterface;

    public function __construct(ContainerInterface $ContainerInterface)
    {
        $this->ContainerInterface = $ContainerInterface;
    }
}

class SimpleContainerStub
{
    public bool $isTest = false;
}

class SimpleContainerWithConstructorStub
{
    public SimpleContainerStub $SimpleContainerStub;

    public function __construct(SimpleContainerStub $SimpleContainerStub)
    {
        $this->SimpleContainerStub = $SimpleContainerStub;
    }
}

class ContainerWithConstructorStub
{
    public string $string;
    public int $int;
    public bool $bool;

    public function __construct(string $string, int $int, bool $bool = false)
    {
        $this->string = $string;
        $this->int = $int;
        $this->bool = $bool;
    }
}

class ContainerCircularDependency1Stub
{
    public function __construct(ContainerCircularDependency2Stub $dependency)
    {
    }
}

class ContainerCircularDependency2Stub
{
    public function __construct(ContainerCircularDependency1Stub $dependency)
    {
    }
}

class ContainerNotResolvableStub
{
    public function __construct($test)
    {
    }
}