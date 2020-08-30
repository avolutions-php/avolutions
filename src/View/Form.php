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

namespace Avolutions\View;

use Avolutions\Orm\Entity;
use Avolutions\Orm\EntityConfiguration;

/**
 * Form class
 *
 * Provides methods to create HTML forms with or without a Entity context. 
 *
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.2.0
 */
class Form
{
    /**
     * @var Entity $Entity The Entity context of the form.
     */
    private $Entity = null;

    /**
     * @var EntityConfiguration $EntityConfiguration The configuration of the Entity.
     */
    private $EntityConfiguration = null;

    /**
     * @var EntityMapping $EntityMapping The mapping of the Entity.
     */
    private $EntityMapping = null;

    /**
     * @var string $entityName The name of the Entity.
     */
    private $entityName = null;

    /**
	 * __construct
	 *
	 * Creates a new Form instance. If a Entity is given the method loads
     * the EntityConfiguration and EntityMapping automatically.
     * 
     * @param Entity $Entity The Entity context of the form.
	 */
    public function __construct($Entity = null) 
    {
        if($Entity instanceof Entity) {
            $this->Entity = $Entity;
            $this->entityName = $this->Entity->getEntityName();
            $this->EntityConfiguration = new EntityConfiguration($this->entityName);
            $this->EntityMapping = $this->EntityConfiguration->getMapping();
        }
    }

    /**
	 * inputFor
	 *
	 * Creates a HTML input element for the given Entity field depending on
     * the Mapping of this field.
     * 
     * @param string $fieldName The field of the Entity.
     * @param bool $showLabel Indicates if a label should be generated or not.
     * 
     * @return string A HTML input element for the field.
	 */
    public function inputFor($fieldName, $showLabel = true) 
    {   
        $input = '';

        $attributes = [
            'name' => lcfirst($this->entityName).'['.$fieldName.']',
            'value' => $this->Entity->exists() ? $this->Entity->$fieldName : null
        ];

        $inputType = $this->EntityMapping->$fieldName['form']['type'];

        // Do not show labels for input type hidden
        if($showLabel && $inputType != 'hidden') {            
            $input .= $this->labelFor($fieldName);
        }

        switch ($inputType) {
            case 'select':        
                $options = $this->EntityMapping->$fieldName['form']['options'] ?? [];
                $input .= $this->select($options, $attributes);
                break;

            case 'textarea':
                $input .= $this->textarea($attributes);
                break;
    

            default:            
                $input .= $this->input($inputType, $attributes);
                break;
        }

        return $input;
    }

     /**
	 * labelFor
	 *
	 * Creates a HTML label element for the given Entity field depending on
     * the Mapping for this field.
     * 
     * @param string $fieldName The field of the Entity.
     * 
     * @return string A HTML label element depending for the field.
     */ 
    public function labelFor($fieldName) 
    {   
        $label = $this->EntityMapping->$fieldName['form']['label'] ?? $fieldName;

        return $this->label($label);
    }

    /**
	 * generate
	 *
	 * Generates a Form for all fields of the Entity, depending on
     * the Mapping of the Entity.
     * 
     * @param array $formAttributes The attributes for the opening form tag.
     * @param bool $submitButton Indicates if a submit button should be generated automatically.
     * 
     * @return string A HTML form for the Entity.
	 */
    public function generate($formAttributes, $submitButton = true) 
    {                
        $formFields = $this->EntityMapping->getFormFields();

        $form = $this->open($formAttributes);
        foreach (array_keys($formFields) as $formField) {
            $form .= $this->inputFor($formField);
        }
        if ($submitButton) {
            $form .= $this->submit();
        }
        $form .= $this->close();

        return $form;
    }

    /**
	 * open
	 *
	 * Opens a form.
     * 
     * @param array $attributes The attributes for the form tag.
     * 
     * @return string An opening HTML form tag.
	 */
    public function open($attributes = [])
    {
        $attributesAsString = self::getAttributesAsString($attributes); 

        return '<form'.$attributesAsString.'>';
    }

    /**
	 * close
	 *
	 * Close a form.
     * 
     * @return string A closing HTML form tag.
	 */
    public function close()
    {
        return '</form>';
    }

    /**
	 * checkbox
	 *
	 * Creates a HTML input element of type checkbox.
     * 
     * @param array $attributes The attributes for the input tag.
     * 
     * @return string A HTML input element of type checkbox.
	 */
    public function checkbox($attributes = [])
    {
        return $this->input('checkbox', $attributes);
    }

    /**
	 * color
	 *
	 * Creates a HTML input element of type color.
     * 
     * @param array $attributes The attributes for the input tag.
     * 
     * @return string A HTML input element of type color.
	 */
    public function color($attributes = [])
    {
        return $this->input('color', $attributes);
    }

    /**
	 * date
	 *
	 * Creates a HTML input element of type date.
     * 
     * @param array $attributes The attributes for the input tag.
     * 
     * @return string A HTML input element of type date.
	 */
    public function date($attributes = [])
    {
        return $this->input('date', $attributes);
    }

    /**
	 * datetime
	 *
	 * Creates a HTML input element of type datetime-local.
     * 
     * @param array $attributes The attributes for the input tag.
     * 
     * @return string A HTML input element of type datetime-local.
	 */
    public function datetime($attributes = [])
    {
        return $this->input('datetime-local', $attributes);
    }

    /**
	 * email
	 *
	 * Creates a HTML input element of type email.
     * 
     * @param array $attributes The attributes for the input tag.
     * 
     * @return string A HTML input element of type email.
	 */
    public function email($attributes = [])
    {
        return $this->input('email', $attributes);
    }

    /**
	 * file
	 *
	 * Creates a HTML input element of type file.
     * 
     * @param array $attributes The attributes for the input tag.
     * 
     * @return string A HTML input element of type file.
	 */
    public function file($attributes = [])
    {
        return $this->input('file', $attributes);
    }

    /**
	 * hidden
	 *
	 * Creates a HTML input element of type hidden.
     * 
     * @param array $attributes The attributes for the input tag.
     * 
     * @return string A HTML input element of type hidden.
	 */
    public function hidden($attributes = [])
    {
        return $this->input('hidden', $attributes);
    }

    /**
	 * image
	 *
	 * Creates a HTML input element of type image.
     * 
     * @param array $attributes The attributes for the input tag.
     * 
     * @return string A HTML input element of type image.
	 */
    public function image($attributes = [])
    {
        return $this->input('image', $attributes);
    }

    /**
	 * label
	 *
	 * Creates a HTML label element.
     * 
     * @param string $text The text of the label element.
     * @param array $attributes The attributes for the label tag.
     * 
     * @return string A HTML input element of type image.
	 */
    public function label($text, $attributes = [])
    {
        $attributesAsString = self::getAttributesAsString($attributes); 

        return '<label'.$attributesAsString.'>'.$text.'</label>';
    }

    /**
	 * month
	 *
	 * Creates a HTML input element of type month.
     * 
     * @param array $attributes The attributes for the input tag.
     * 
     * @return string A HTML input element of type month.
	 */
    public function month($attributes = [])
    {
        return $this->input('month', $attributes);
    }

    /**
	 * number
	 *
	 * Creates a HTML input element of type number.
     * 
     * @param array $attributes The attributes for the input tag.
     * 
     * @return string A HTML input element of type number.
	 */
    public function number($attributes = [])
    {
        return $this->input('number', $attributes);
    }

    /**
	 * password
	 *
	 * Creates a HTML input element of type password.
     * 
     * @param array $attributes The attributes for the input tag.
     * 
     * @return string A HTML input element of type password.
	 */
    public function password($attributes = [])
    {
        return $this->input('password', $attributes);
    }

    /**
	 * radio
	 *
	 * Creates a HTML input element of type radio.
     * 
     * @param array $attributes The attributes for the input tag.
     * 
     * @return string A HTML input element of type radio.
	 */
    public function radio($attributes = [])
    {
        return $this->input('radio', $attributes);
    }

    /**
	 * range
	 *
	 * Creates a HTML input element of type range.
     * 
     * @param array $attributes The attributes for the input tag.
     * 
     * @return string A HTML input element of type range.
	 */
    public function range($attributes = [])
    {
        return $this->input('range', $attributes);
    }

    /**
	 * reset
	 *
	 * Creates a HTML input element of type reset.
     * 
     * @param array $attributes The attributes for the input tag.
     * 
     * @return string A HTML input element of type reset.
	 */
    public function reset($attributes = [])
    {
        return $this->input('reset', $attributes);
    }

    /**
	 * search
	 *
	 * Creates a HTML input element of type search.
     * 
     * @param array $attributes The attributes for the input tag.
     * 
     * @return string A HTML input element of type search.
	 */
    public function search($attributes = [])
    {
        return $this->input('search', $attributes);
    }

    /**
	 * submit
	 *
	 * Creates a HTML input element of type submit.
     * 
     * @param array $attributes The attributes for the input tag.
     * 
     * @return string A HTML input element of type submit.
	 */
    public function submit($attributes = [])
    {
        return $this->input('submit', $attributes);
    }

    /**
	 * tel
	 *
	 * Creates a HTML input element of type tel.
     * 
     * @param array $attributes The attributes for the input tag.
     * 
     * @return string A HTML input element of type tel.
	 */
    public function tel($attributes = [])
    {
        return $this->input('tel', $attributes);
    }

    /**
	 * text
	 *
	 * Creates a HTML input element of type text.
     * 
     * @param array $attributes The attributes for the input tag.
     * 
     * @return string A HTML input element of type text.
	 */
    public function text($attributes = [])
    {
        return $this->input('text', $attributes);
    }

    /**
	 * time
	 *
	 * Creates a HTML input element of type time.
     * 
     * @param array $attributes The attributes for the input tag.
     * 
     * @return string A HTML input element of type time.
	 */
    public function time($attributes = [])
    {
        return $this->input('time', $attributes);
    }

    /**
	 * url
	 *
	 * Creates a HTML input element of type url.
     * 
     * @param array $attributes The attributes for the input tag.
     * 
     * @return string A HTML input element of type url.
	 */
    public function url($attributes = [])
    {
        return $this->input('url', $attributes);
    }

    /**
	 * week
	 *
	 * Creates a HTML input element of type week.
     * 
     * @param array $attributes The attributes for the input tag.
     * 
     * @return string A HTML input element of type week.
	 */
    public function week($attributes = [])
    {
        return $this->input('week', $attributes);
    }

    /**
	 * input
	 *
	 * Creates a HTML input element.
     * 
     * @param string $type The type for the input tag.
     * @param array $attributes The attributes for the input tag.
     * 
     * @return string A HTML input element of given type.
	 */
    public function input($type, $attributes = [])
    {
        $attributes['type'] = $type;
        $attributesAsString = self::getAttributesAsString($attributes); 

        return '<input'.$attributesAsString.' />';
    }

    /**
	 * button
	 *
	 * Creates a HTML button element.
     * 
     * @param array $attributes The attributes for the button tag.
     * 
     * @return string A HTML element of type button.
	 */
    public function button($attributes = [])
    {
        $value = $attributes['value'] ?? null;
        unset($attributes['value']); // To not render it to the select tag
        
        $attributesAsString = self::getAttributesAsString($attributes); 

        return '<button'.$attributesAsString.'>'.$value.'</button>';
    }

    /**
	 * textarea
	 *
	 * Creates a HTML textarea element.
     * 
     * @param array $attributes The attributes for the textarea tag.
     * 
     * @return string A HTML element of type textarea.
	 */
    public function textarea($attributes = [])
    {
        $value = $attributes['value'] ?? null;
        unset($attributes['value']); // To not render it to the select tag

        $attributesAsString = self::getAttributesAsString($attributes); 

        return '<textarea'.$attributesAsString.'>'.$value.'</textarea>';
    }

    /**
	 * select
	 *
	 * Creates a HTML select element with the given options.
     * 
     * @param array $options The options for the select list.
     * @param array $attributes The attributes for the select tag.
     * 
     * @return string A HTML element of type select.
	 */
    public function select($options = [], $attributes = [])
    {
        $selectedValue = $attributes['value'] ?? null;
        unset($attributes['value']); // To not render it to the select tag

        $attributesAsString = self::getAttributesAsString($attributes); 
        $optionsAsString = '';

        foreach ($options as $key => $value) {
            $optionsAsString .= $this->option($key, $value, $selectedValue);
        }

        return '<select'.$attributesAsString.'>'.$optionsAsString.'</select>';
    }

    /**
	 * option
	 *
	 * Creates a HTML option element.
     * 
     * @param string $value The value of the option tag.
     * @param string $text The text of the option element.
     * @param string $selectedValue The selected value of the option element.
     * 
     * @return string A HTML element of type option.
	 */
    private function option($value, $text, $selectedValue = null)
    {       
        $selected = $value == $selectedValue ? ' selected' : '';

        return '<option value="'.$value.'"'.$selected.'>'.$text.'</option>';
    }

    /**
	 * getAttributesAsString
	 *
	 * Returns the attributes as a string in the format attribute="value"
     * 
     * @param array $attributes The attributes for the select tag.
     * 
     * @return string The attributes as a string.
	 */
    private static function getAttributesAsString($attributes)
    {
        $attributesAsString = '';

        foreach($attributes as $attributeName => $attributeValue) {
            $attributesAsString .= ' '.$attributeName.'="'.$attributeValue.'"';
        }

        return $attributesAsString;
    }
}