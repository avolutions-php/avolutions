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

namespace Avolutions\Test\TestCases\View;

use PHPUnit\Framework\TestCase;

use Avolutions\View\Form;

class FormTest extends TestCase
{
    private array $attributes = [
        'name' => 'myInput',
        'class' => 'a-css-class'
    ];

    public function testOpenForm()
    {
        $attributes = [
            'name' => 'myForm',
            'method' => 'POST'
        ];

        $Form = new Form();
        $formWithoutAttributes = $Form->open();
        $formWithAttributes = $Form->open($attributes);

        $this->assertEquals('<form>', $formWithoutAttributes);
        $this->assertEquals('<form name="myForm" method="POST">', $formWithAttributes);
    }

    public function testCloseForm()
    {
        $Form = new Form();
        $form = $Form->close();

        $this->assertEquals('</form>', $form);
    }

    public function testCheckbox()
    {
        $Form = new Form();
        $inputWithoutAttributes = $Form->checkbox();
        $inputWithAttributes = $Form->checkbox($this->attributes);

        $this->assertEquals('<input type="checkbox" />', $inputWithoutAttributes);
        $this->assertEquals('<input name="myInput" class="a-css-class" type="checkbox" />', $inputWithAttributes);
    }

    public function testColor()
    {
        $Form = new Form();
        $inputWithoutAttributes = $Form->color();
        $inputWithAttributes = $Form->color($this->attributes);

        $this->assertEquals('<input type="color" />', $inputWithoutAttributes);
        $this->assertEquals('<input name="myInput" class="a-css-class" type="color" />', $inputWithAttributes);
    }

    public function testDate()
    {
        $Form = new Form();
        $inputWithoutAttributes = $Form->date();
        $inputWithAttributes = $Form->date($this->attributes);

        $this->assertEquals('<input type="date" />', $inputWithoutAttributes);
        $this->assertEquals('<input name="myInput" class="a-css-class" type="date" />', $inputWithAttributes);
    }

    public function testDatetime()
    {
        $Form = new Form();
        $inputWithoutAttributes = $Form->datetime();
        $inputWithAttributes = $Form->datetime($this->attributes);

        $this->assertEquals('<input type="datetime-local" />', $inputWithoutAttributes);
        $this->assertEquals('<input name="myInput" class="a-css-class" type="datetime-local" />', $inputWithAttributes);
    }

    public function testEmail()
    {
        $Form = new Form();
        $inputWithoutAttributes = $Form->email();
        $inputWithAttributes = $Form->email($this->attributes);

        $this->assertEquals('<input type="email" />', $inputWithoutAttributes);
        $this->assertEquals('<input name="myInput" class="a-css-class" type="email" />', $inputWithAttributes);
    }

    public function testFile()
    {
        $Form = new Form();
        $inputWithoutAttributes = $Form->file();
        $inputWithAttributes = $Form->file($this->attributes);

        $this->assertEquals('<input type="file" />', $inputWithoutAttributes);
        $this->assertEquals('<input name="myInput" class="a-css-class" type="file" />', $inputWithAttributes);
    }

    public function testHidden()
    {
        $Form = new Form();
        $inputWithoutAttributes = $Form->hidden();
        $inputWithAttributes = $Form->hidden($this->attributes);

        $this->assertEquals('<input type="hidden" />', $inputWithoutAttributes);
        $this->assertEquals('<input name="myInput" class="a-css-class" type="hidden" />', $inputWithAttributes);
    }

    public function testImage()
    {
        $Form = new Form();
        $inputWithoutAttributes = $Form->image();
        $inputWithAttributes = $Form->image($this->attributes);

        $this->assertEquals('<input type="image" />', $inputWithoutAttributes);
        $this->assertEquals('<input name="myInput" class="a-css-class" type="image" />', $inputWithAttributes);
    }

    public function testLabel()
    {
        $Form = new Form();
        $labelWithoutAttributes = $Form->label('This is a label');
        $labelWithAttributes = $Form->label('This is a label', $this->attributes);

        $this->assertEquals('<label>This is a label</label>', $labelWithoutAttributes);
        $this->assertEquals('<label name="myInput" class="a-css-class">This is a label</label>', $labelWithAttributes);
    }

    public function testMonth()
    {
        $Form = new Form();
        $inputWithoutAttributes = $Form->month();
        $inputWithAttributes = $Form->month($this->attributes);

        $this->assertEquals('<input type="month" />', $inputWithoutAttributes);
        $this->assertEquals('<input name="myInput" class="a-css-class" type="month" />', $inputWithAttributes);
    }

    public function testNumber()
    {
        $Form = new Form();
        $inputWithoutAttributes = $Form->number();
        $inputWithAttributes = $Form->number($this->attributes);

        $this->assertEquals('<input type="number" />', $inputWithoutAttributes);
        $this->assertEquals('<input name="myInput" class="a-css-class" type="number" />', $inputWithAttributes);
    }

    public function testPassword()
    {
        $Form = new Form();
        $inputWithoutAttributes = $Form->password();
        $inputWithAttributes = $Form->password($this->attributes);

        $this->assertEquals('<input type="password" />', $inputWithoutAttributes);
        $this->assertEquals('<input name="myInput" class="a-css-class" type="password" />', $inputWithAttributes);
    }

    public function testRadio()
    {
        $Form = new Form();
        $inputWithoutAttributes = $Form->radio();
        $inputWithAttributes = $Form->radio($this->attributes);

        $this->assertEquals('<input type="radio" />', $inputWithoutAttributes);
        $this->assertEquals('<input name="myInput" class="a-css-class" type="radio" />', $inputWithAttributes);
    }

    public function testRange()
    {
        $Form = new Form();
        $inputWithoutAttributes = $Form->range();
        $inputWithAttributes = $Form->range($this->attributes);

        $this->assertEquals('<input type="range" />', $inputWithoutAttributes);
        $this->assertEquals('<input name="myInput" class="a-css-class" type="range" />', $inputWithAttributes);
    }

    public function testReset()
    {
        $Form = new Form();
        $inputWithoutAttributes = $Form->reset();
        $inputWithAttributes = $Form->reset($this->attributes);

        $this->assertEquals('<input type="reset" />', $inputWithoutAttributes);
        $this->assertEquals('<input name="myInput" class="a-css-class" type="reset" />', $inputWithAttributes);
    }

    public function testSearch()
    {
        $Form = new Form();
        $inputWithoutAttributes = $Form->search();
        $inputWithAttributes = $Form->search($this->attributes);

        $this->assertEquals('<input type="search" />', $inputWithoutAttributes);
        $this->assertEquals('<input name="myInput" class="a-css-class" type="search" />', $inputWithAttributes);
    }

    public function testSubmit()
    {
        $Form = new Form();
        $inputWithoutAttributes = $Form->submit();
        $inputWithAttributes = $Form->submit($this->attributes);

        $this->assertEquals('<input type="submit" />', $inputWithoutAttributes);
        $this->assertEquals('<input name="myInput" class="a-css-class" type="submit" />', $inputWithAttributes);
    }

    public function testTel()
    {
        $Form = new Form();
        $inputWithoutAttributes = $Form->tel();
        $inputWithAttributes = $Form->tel($this->attributes);

        $this->assertEquals('<input type="tel" />', $inputWithoutAttributes);
        $this->assertEquals('<input name="myInput" class="a-css-class" type="tel" />', $inputWithAttributes);
    }

    public function testText()
    {
        $Form = new Form();
        $inputWithoutAttributes = $Form->text();
        $inputWithAttributes = $Form->text($this->attributes);

        $this->assertEquals('<input type="text" />', $inputWithoutAttributes);
        $this->assertEquals('<input name="myInput" class="a-css-class" type="text" />', $inputWithAttributes);
    }

    public function testTime()
    {
        $Form = new Form();
        $inputWithoutAttributes = $Form->time();
        $inputWithAttributes = $Form->time($this->attributes);

        $this->assertEquals('<input type="time" />', $inputWithoutAttributes);
        $this->assertEquals('<input name="myInput" class="a-css-class" type="time" />', $inputWithAttributes);
    }

    public function testUrl()
    {
        $Form = new Form();
        $inputWithoutAttributes = $Form->url();
        $inputWithAttributes = $Form->url($this->attributes);

        $this->assertEquals('<input type="url" />', $inputWithoutAttributes);
        $this->assertEquals('<input name="myInput" class="a-css-class" type="url" />', $inputWithAttributes);
    }

    public function testWeek()
    {
        $Form = new Form();
        $inputWithoutAttributes = $Form->week();
        $inputWithAttributes = $Form->week($this->attributes);

        $this->assertEquals('<input type="week" />', $inputWithoutAttributes);
        $this->assertEquals('<input name="myInput" class="a-css-class" type="week" />', $inputWithAttributes);
    }

    public function testInput()
    {
        $Form = new Form();
        $inputWithoutAttributes = $Form->input('text');
        $inputWithAttributes = $Form->input('text', $this->attributes);

        $this->assertEquals('<input type="text" />', $inputWithoutAttributes);
        $this->assertEquals('<input name="myInput" class="a-css-class" type="text" />', $inputWithAttributes);
    }

    public function testButton()
    {
        $attributes = $this->attributes;
        $attributes['value'] = 'This is the value';

        $Form = new Form();
        $inputWithoutAttributes = $Form->button();
        $inputWithAttributes = $Form->button($attributes);

        $this->assertEquals('<button></button>', $inputWithoutAttributes);
        $this->assertEquals(
            '<button name="myInput" class="a-css-class">This is the value</button>',
            $inputWithAttributes
        );
    }

    public function testTextarea()
    {
        $attributes = $this->attributes;
        $attributes['value'] = 'This is the value';

        $Form = new Form();
        $inputWithoutAttributes = $Form->textarea();
        $inputWithAttributes = $Form->textarea($attributes);

        $this->assertEquals('<textarea></textarea>', $inputWithoutAttributes);
        $this->assertEquals(
            '<textarea name="myInput" class="a-css-class">This is the value</textarea>',
            $inputWithAttributes
        );
    }

    public function testSelect()
    {
        $attributes = $this->attributes;
        $attributes['value'] = '1';

        $options = [
            '0' => 'Zero',
            '1' => 'One'
        ];

        $Form = new Form();
        $inputWithoutAttributes = $Form->select($options);
        $inputWithAttributes = $Form->select($options, $attributes);

        $this->assertEquals(
            '<select><option value="0">Zero</option><option value="1">One</option></select>',
            $inputWithoutAttributes
        );
        $this->assertEquals(
            '<select name="myInput" class="a-css-class"><option value="0">Zero</option><option value="1" selected>One</option></select>',
            $inputWithAttributes
        );
    }
}