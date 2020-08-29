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

use Avolutions\View\Form;

class FormTest extends TestCase
{
    private $attributes = [
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
        
        $this->assertEquals($formWithoutAttributes, '<form>');
        $this->assertEquals($formWithAttributes, '<form name="myForm" method="POST">');
    }

    public function testCloseForm()
    {
        $Form = new Form();
        $form = $Form->close();
        
        $this->assertEquals($form, '</form>');
    }

    public function testCheckbox()
    {
        $Form = new Form();
        $inputWithoutAttributes = $Form->checkbox();
        $inputWithAttributes = $Form->checkbox($this->attributes);
        
        $this->assertEquals($inputWithoutAttributes, '<input type="checkbox" />');
        $this->assertEquals($inputWithAttributes, '<input name="myInput" class="a-css-class" type="checkbox" />');
    }

    public function testColor()
    {
        $Form = new Form();
        $inputWithoutAttributes = $Form->color();
        $inputWithAttributes = $Form->color($this->attributes);
        
        $this->assertEquals($inputWithoutAttributes, '<input type="color" />');
        $this->assertEquals($inputWithAttributes, '<input name="myInput" class="a-css-class" type="color" />');
    }

    public function testDate()
    {
        $Form = new Form();
        $inputWithoutAttributes = $Form->date();
        $inputWithAttributes = $Form->date($this->attributes);
        
        $this->assertEquals($inputWithoutAttributes, '<input type="date" />');
        $this->assertEquals($inputWithAttributes, '<input name="myInput" class="a-css-class" type="date" />');
    }

    public function testDatetime()
    {
        $Form = new Form();
        $inputWithoutAttributes = $Form->datetime();
        $inputWithAttributes = $Form->datetime($this->attributes);
        
        $this->assertEquals($inputWithoutAttributes, '<input type="datetime-local" />');
        $this->assertEquals($inputWithAttributes, '<input name="myInput" class="a-css-class" type="datetime-local" />');
    }

    public function testEmail()
    {
        $Form = new Form();
        $inputWithoutAttributes = $Form->email();
        $inputWithAttributes = $Form->email($this->attributes);
        
        $this->assertEquals($inputWithoutAttributes, '<input type="email" />');
        $this->assertEquals($inputWithAttributes, '<input name="myInput" class="a-css-class" type="email" />');
    }
    
    public function testFile()
    {
        $Form = new Form();
        $inputWithoutAttributes = $Form->file();
        $inputWithAttributes = $Form->file($this->attributes);
        
        $this->assertEquals($inputWithoutAttributes, '<input type="file" />');
        $this->assertEquals($inputWithAttributes, '<input name="myInput" class="a-css-class" type="file" />');
    }
    
    public function testHidden()
    {
        $Form = new Form();
        $inputWithoutAttributes = $Form->hidden();
        $inputWithAttributes = $Form->hidden($this->attributes);
        
        $this->assertEquals($inputWithoutAttributes, '<input type="hidden" />');
        $this->assertEquals($inputWithAttributes, '<input name="myInput" class="a-css-class" type="hidden" />');
    }
    
    public function testImage()
    {
        $Form = new Form();
        $inputWithoutAttributes = $Form->image();
        $inputWithAttributes = $Form->image($this->attributes);
        
        $this->assertEquals($inputWithoutAttributes, '<input type="image" />');
        $this->assertEquals($inputWithAttributes, '<input name="myInput" class="a-css-class" type="image" />');
    }
    
    public function testLabel()
    {
        $Form = new Form();
        $labelWithoutAttributes = $Form->label('This is a label');
        $labelWithAttributes = $Form->label('This is a label', $this->attributes);
        
        $this->assertEquals($labelWithoutAttributes, '<label>This is a label</label>');
        $this->assertEquals($labelWithAttributes, '<label name="myInput" class="a-css-class">This is a label</label>');
    }
    
    public function testMonth()
    {
        $Form = new Form();
        $inputWithoutAttributes = $Form->month();
        $inputWithAttributes = $Form->month($this->attributes);
        
        $this->assertEquals($inputWithoutAttributes, '<input type="month" />');
        $this->assertEquals($inputWithAttributes, '<input name="myInput" class="a-css-class" type="month" />');
    }
    
    public function testNumber()
    {
        $Form = new Form();
        $inputWithoutAttributes = $Form->number();
        $inputWithAttributes = $Form->number($this->attributes);
        
        $this->assertEquals($inputWithoutAttributes, '<input type="number" />');
        $this->assertEquals($inputWithAttributes, '<input name="myInput" class="a-css-class" type="number" />');
    }
    
    public function testPassword()
    {
        $Form = new Form();
        $inputWithoutAttributes = $Form->password();
        $inputWithAttributes = $Form->password($this->attributes);
        
        $this->assertEquals($inputWithoutAttributes, '<input type="password" />');
        $this->assertEquals($inputWithAttributes, '<input name="myInput" class="a-css-class" type="password" />');
    }
    
    public function testRadio()
    {
        $Form = new Form();
        $inputWithoutAttributes = $Form->radio();
        $inputWithAttributes = $Form->radio($this->attributes);
        
        $this->assertEquals($inputWithoutAttributes, '<input type="radio" />');
        $this->assertEquals($inputWithAttributes, '<input name="myInput" class="a-css-class" type="radio" />');
    }
    
    public function testRange()
    {
        $Form = new Form();
        $inputWithoutAttributes = $Form->range();
        $inputWithAttributes = $Form->range($this->attributes);
        
        $this->assertEquals($inputWithoutAttributes, '<input type="range" />');
        $this->assertEquals($inputWithAttributes, '<input name="myInput" class="a-css-class" type="range" />');
    }
    
    public function testReset()
    {
        $Form = new Form();
        $inputWithoutAttributes = $Form->reset();
        $inputWithAttributes = $Form->reset($this->attributes);
        
        $this->assertEquals($inputWithoutAttributes, '<input type="reset" />');
        $this->assertEquals($inputWithAttributes, '<input name="myInput" class="a-css-class" type="reset" />');
    }
    
    public function testSearch()
    {
        $Form = new Form();
        $inputWithoutAttributes = $Form->search();
        $inputWithAttributes = $Form->search($this->attributes);
        
        $this->assertEquals($inputWithoutAttributes, '<input type="search" />');
        $this->assertEquals($inputWithAttributes, '<input name="myInput" class="a-css-class" type="search" />');
    }
    
    public function testSubmit()
    {
        $Form = new Form();
        $inputWithoutAttributes = $Form->submit();
        $inputWithAttributes = $Form->submit($this->attributes);
        
        $this->assertEquals($inputWithoutAttributes, '<input type="submit" />');
        $this->assertEquals($inputWithAttributes, '<input name="myInput" class="a-css-class" type="submit" />');
    }
    
    public function testTel()
    {
        $Form = new Form();
        $inputWithoutAttributes = $Form->tel();
        $inputWithAttributes = $Form->tel($this->attributes);
        
        $this->assertEquals($inputWithoutAttributes, '<input type="tel" />');
        $this->assertEquals($inputWithAttributes, '<input name="myInput" class="a-css-class" type="tel" />');
    }
    
    public function testText()
    {
        $Form = new Form();
        $inputWithoutAttributes = $Form->text();
        $inputWithAttributes = $Form->text($this->attributes);
        
        $this->assertEquals($inputWithoutAttributes, '<input type="text" />');
        $this->assertEquals($inputWithAttributes, '<input name="myInput" class="a-css-class" type="text" />');
    }
    
    public function testTime()
    {
        $Form = new Form();
        $inputWithoutAttributes = $Form->time();
        $inputWithAttributes = $Form->time($this->attributes);
        
        $this->assertEquals($inputWithoutAttributes, '<input type="time" />');
        $this->assertEquals($inputWithAttributes, '<input name="myInput" class="a-css-class" type="time" />');
    }
    
    public function testUrl()
    {
        $Form = new Form();
        $inputWithoutAttributes = $Form->url();
        $inputWithAttributes = $Form->url($this->attributes);
        
        $this->assertEquals($inputWithoutAttributes, '<input type="url" />');
        $this->assertEquals($inputWithAttributes, '<input name="myInput" class="a-css-class" type="url" />');
    }
    
    public function testWeek()
    {
        $Form = new Form();
        $inputWithoutAttributes = $Form->week();
        $inputWithAttributes = $Form->week($this->attributes);
        
        $this->assertEquals($inputWithoutAttributes, '<input type="week" />');
        $this->assertEquals($inputWithAttributes, '<input name="myInput" class="a-css-class" type="week" />');
    }
    
    public function testInput()
    {
        $Form = new Form();
        $inputWithoutAttributes = $Form->input('text');
        $inputWithAttributes = $Form->input('text', $this->attributes);
        
        $this->assertEquals($inputWithoutAttributes, '<input type="text" />');
        $this->assertEquals($inputWithAttributes, '<input name="myInput" class="a-css-class" type="text" />');
    }
    
    public function testButton()
    {
        $attributes = $this->attributes;
        $attributes['value'] = 'This is the value';

        $Form = new Form();
        $inputWithoutAttributes = $Form->button();
        $inputWithAttributes = $Form->button($attributes);
        
        $this->assertEquals($inputWithoutAttributes, '<button></button>');
        $this->assertEquals($inputWithAttributes, '<button name="myInput" class="a-css-class">This is the value</button>');
    }
    
    public function testTextarea()
    {
        $attributes = $this->attributes;
        $attributes['value'] = 'This is the value';

        $Form = new Form();
        $inputWithoutAttributes = $Form->textarea();
        $inputWithAttributes = $Form->textarea($attributes);
        
        $this->assertEquals($inputWithoutAttributes, '<textarea></textarea>');
        $this->assertEquals($inputWithAttributes, '<textarea name="myInput" class="a-css-class">This is the value</textarea>');
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
        
        $this->assertEquals($inputWithoutAttributes, '<select><option value="0" selected>Zero</option><option value="1">One</option></select>');
        $this->assertEquals($inputWithAttributes, '<select name="myInput" class="a-css-class"><option value="0">Zero</option><option value="1" selected>One</option></select>');
    }
}