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

use Avolutions\Database\Column;
use Avolutions\Database\ColumnType;

class ColumnTest extends TestCase
{
    public function testColumnWithNameAndType()
    {
        $name = 'name';
        $type = 'type';

        $Column = new Column($name, $type);

        $this->assertInstanceOf('Avolutions\Database\Column', $Column); 
        $this->assertEquals($Column->getPattern(), '`'.$name.'` '.$type.' NOT NULL');
    }

    public function testColumnWithLength()
    {
        $name = 'name';
        $type = 'type';
        $length = 255;

        $Column = new Column($name, $type, $length);

        $this->assertInstanceOf('Avolutions\Database\Column', $Column); 
        $this->assertEquals($Column->getPattern(), '`'.$name.'` '.$type.'('.$length.') NOT NULL');
    }

    public function testColumnWithDefaultValue()
    {
        $name = 'name';
        $type = 'type';
        $length = 255;
        $default = 'default';

        $Column = new Column($name, $type, $length, $default);

        $this->assertInstanceOf('Avolutions\Database\Column', $Column); 
        $this->assertEquals($Column->getPattern(), '`'.$name.'` '.$type.'('.$length.') NOT NULL DEFAULT '.$default);
    }

    public function testColumnWithBooleanDefaultValue()
    {
        $name = 'name';
        $type = ColumnType::BOOLEAN;
        $length = 255;
        $default = false;

        $Column = new Column($name, $type, $length, $default);

        $this->assertInstanceOf('Avolutions\Database\Column', $Column); 
        $this->assertEquals($Column->getPattern(), '`'.$name.'` '.$type.'('.$length.') NOT NULL DEFAULT FALSE');
    }

    public function testColumnWithNull()
    {
        $name = 'name';
        $type = 'type';
        $length = 255;
        $default = 'default';
        $null = Column::NULL;

        $Column = new Column($name, $type, $length, $default, $null);

        $this->assertInstanceOf('Avolutions\Database\Column', $Column); 
        $this->assertEquals($Column->getPattern(), '`'.$name.'` '.$type.'('.$length.') NULL DEFAULT '.$default);
    }

    public function testColumnWithPrimarKey()
    {
        $name = 'name';
        $type = 'type';
        $length = 255;
        $default = 'default';
        $null = Column::NULL;
        $primaryKey = true;

        $Column = new Column($name, $type, $length, $default, $null, $primaryKey);

        $this->assertInstanceOf('Avolutions\Database\Column', $Column); 
        $this->assertEquals($Column->getPattern(), '`'.$name.'` '.$type.'('.$length.') NULL DEFAULT '.$default.' PRIMARY KEY');
    }

    public function testColumnWithAutoIncrement()
    {
        $name = 'name';
        $type = 'type';
        $length = 255;
        $default = 'default';
        $null = Column::NULL;
        $primaryKey = true;
        $autoIncrement = true;

        $Column = new Column($name, $type, $length, $default, $null, $primaryKey, $autoIncrement);

        $this->assertInstanceOf('Avolutions\Database\Column', $Column); 
        $this->assertEquals($Column->getPattern(), '`'.$name.'` '.$type.'('.$length.') NULL DEFAULT '.$default.' PRIMARY KEY AUTO_INCREMENT');
    }
}