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
 * Formular class
 *
 * TODO 
 *
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.2.0
 */
class Formular
{
    /**
     * @var Entity $Entity TODO
     */
    private $Entity = null;

    /**
     * @var EntityConfiguration $EntityConfiguration TODO
     */
    private $EntityConfiguration = null;

    /**
     * @var EntityMapping $EntityMapping TODO
     */
    private $EntityMapping = null;

    /**
     * @var string $entityName TODO
     */
    private $entityName = null;

    /**
	 * __construct
	 *
	 * TODO
     * 
     * @param Entity $Entity TODO
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
	 * TODO find better name?
     * 
     * @param string $fieldName TODO
     * @param bool $label TODO
     * 
     * @return TODO
	 */
    public function inputFor($fieldName, $label = true) 
    {   
        // TODO set values from Entity?!

        $input = '';

        $inputType = $this->EntityMapping->$fieldName['form']['type'];
        $attributes = [
            'name' => lcfirst($this->entityName).'['.$fieldName.']'
        ];

        if($label) {            
            $input .= $this->labelFor($fieldName);
        }

        switch ($inputType) {
            case 'button':
                // TODO use label as text?
                $input .= $this->button('', $attributes);
                break;

            case 'select':           
                $options = $this->EntityMapping->$fieldName['form']['options'] ?? [];
                $input .= $this->select($options, $attributes);
                break;

            case 'textarea':             
                // TODO set value
                $input .= $this->textarea('', $attributes);
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
	 * TODO find better name?
     * 
     * @param string $fieldName TODO
     * 
     * @return TODO
	 */
    public function labelFor($fieldName) 
    {   
        $label = $this->EntityMapping->$fieldName['form']['label'] ?? $fieldName;

        return $this->label($label);
    }


    /**
	 * generate
	 *
	 * TODO
     * 
     * @param array $formAttributes TODO
     * @param bool $submitButton TODO
     * 
     * @return TODO
	 */
    public function generate($formAttributes, $submitButton = true) 
    {                
        $formularFields = $this->EntityMapping->getFormularFields();

        $formular = $this->open($formAttributes);
        foreach (array_keys($formularFields) as $formularField) {
            $formular .= $this->inputFor($formularField);
        }
        if ($submitButton) {
            $formular .= $this->submit();
        }
        $formular .= $this->close();

        return $formular;
    }

    /**
	 * open
	 *
	 * TODO
     * 
     * @param array $attributes TODO
     * 
     * @return TODO
	 */
    public function open($attributes = [])
    {
        $attributesAsString = self::getAttributes($attributes); 

        return '<form'.$attributesAsString.'>';
    }

    /**
	 * close
	 *
	 * TODO
     * 
     * @return TODO
	 */
    public function close()
    {
        return '</form>';
    }

    /**
	 * checkbox
	 *
	 * TODO
     * 
     * @param array $attributes TODO
     * 
     * @return TODO
	 */
    public function checkbox($attributes = [])
    {
        return $this->input('checkbox', $attributes);
    }

    /**
	 * color
	 *
	 * TODO
     * 
     * @param array $attributes TODO
     * 
     * @return TODO
	 */
    public function color($attributes = [])
    {
        return $this->input('color', $attributes);
    }

    /**
	 * text
	 *
	 * TODO
     * 
     * @param array $attributes TODO
     * 
     * @return TODO
	 */
    public function date($attributes = [])
    {
        return $this->input('date', $attributes);
    }

    /**
	 * datetime
	 *
	 * TODO
     * 
     * @param array $attributes TODO
     * 
     * @return TODO
	 */
    public function datetime($attributes = [])
    {
        return $this->input('datetime-local', $attributes);
    }

    /**
	 * email
	 *
	 * TODO
     * 
     * @param array $attributes TODO
     * 
     * @return TODO
	 */
    public function email($attributes = [])
    {
        return $this->input('email', $attributes);
    }

    /**
	 * file
	 *
	 * TODO
     * 
     * @param array $attributes TODO
     * 
     * @return TODO
	 */
    public function file($attributes = [])
    {
        return $this->input('file', $attributes);
    }

    /**
	 * hidden
	 *
	 * TODO
     * 
     * @param array $attributes TODO
     * 
     * @return TODO
	 */
    public function hidden($attributes = [])
    {
        return $this->input('hidden', $attributes);
    }

    /**
	 * image
	 *
	 * TODO
     * 
     * @param array $attributes TODO
     * 
     * @return TODO
	 */
    public function image($attributes = [])
    {
        return $this->input('image', $attributes);
    }

    /**
	 * label
	 *
	 * TODO
     * 
     * @param array $attributes TODO
     * 
     * @return TODO
	 */
    public function label($value, $attributes = [])
    {
        $attributesAsString = self::getAttributes($attributes); 

        return '<label'.$attributesAsString.'>'.$value.'</label>';
    }

    /**
	 * month
	 *
	 * TODO
     * 
     * @param array $attributes TODO
     * 
     * @return TODO
	 */
    public function month($attributes = [])
    {
        return $this->input('month', $attributes);
    }

    /**
	 * number
	 *
	 * TODO
     * 
     * @param array $attributes TODO
     * 
     * @return TODO
	 */
    public function number($attributes = [])
    {
        return $this->input('number', $attributes);
    }

    /**
	 * password
	 *
	 * TODO
     * 
     * @param array $attributes TODO
     * 
     * @return TODO
	 */
    public function password($attributes = [])
    {
        return $this->input('password', $attributes);
    }

    /**
	 * radio
	 *
	 * TODO
     * 
     * @param array $attributes TODO
     * 
     * @return TODO
	 */
    public function radio($attributes = [])
    {
        return $this->input('radio', $attributes);
    }

    /**
	 * range
	 *
	 * TODO
     * 
     * @param array $attributes TODO
     * 
     * @return TODO
	 */
    public function range($attributes = [])
    {
        return $this->input('range', $attributes);
    }

    /**
	 * reset
	 *
	 * TODO
     * 
     * @param array $attributes TODO
     * 
     * @return TODO
	 */
    public function reset($attributes = [])
    {
        return $this->input('reset', $attributes);
    }

    /**
	 * search
	 *
	 * TODO
     * 
     * @param array $attributes TODO
     * 
     * @return TODO
	 */
    public function search($attributes = [])
    {
        return $this->input('search', $attributes);
    }

    /**
	 * submit
	 *
	 * TODO
     * 
     * @param array $attributes TODO
     * 
     * @return TODO
	 */
    public function submit($attributes = [])
    {
        return $this->input('submit', $attributes);
    }

    /**
	 * tel
	 *
	 * TODO
     * 
     * @param array $attributes TODO
     * 
     * @return TODO
	 */
    public function tel($attributes = [])
    {
        return $this->input('tel', $attributes);
    }

    /**
	 * text
	 *
	 * TODO
     * 
     * @param array $attributes TODO
     * 
     * @return TODO
	 */
    public function text($attributes = [])
    {
        return $this->input('text', $attributes);
    }

    /**
	 * time
	 *
	 * TODO
     * 
     * @param array $attributes TODO
     * 
     * @return TODO
	 */
    public function time($attributes = [])
    {
        return $this->input('time', $attributes);
    }

    /**
	 * url
	 *
	 * TODO
     * 
     * @param array $attributes TODO
     * 
     * @return TODO
	 */
    public function url($attributes = [])
    {
        return $this->input('url', $attributes);
    }

    /**
	 * week
	 *
	 * TODO
     * 
     * @param array $attributes TODO
     * 
     * @return TODO
	 */
    public function week($attributes = [])
    {
        return $this->input('week', $attributes);
    }

    /**
	 * input
	 *
	 * TODO
     * 
     * @param string $type TODO
     * @param array $attributes TODO
     * 
     * @return TODO
	 */
    public function input($type, $attributes = [])
    {
        $attributes['type'] = $type;
        $attributesAsString = self::getAttributes($attributes); 

        return '<input'.$attributesAsString.' />';
    }

    /**
	 * button
	 *
	 * TODO
     * 
     * @param string $content TODO
     * @param array $attributes TODO
     * 
     * @return TODO
	 */
    public function button($content = '', $attributes = [])
    {
        $attributesAsString = self::getAttributes($attributes); 

        return '<button'.$attributesAsString.'>'.$content.'</button>';
    }

    /**
	 * textarea
	 *
	 * TODO
     * 
     * @param string $content TODO
     * @param array $attributes TODO
     * 
     * @return TODO
	 */
    public function textarea($content = '', $attributes = [])
    {
        $attributesAsString = self::getAttributes($attributes); 

        return '<textarea'.$attributesAsString.'>'.$content.'</textarea>';
    }

    /**
	 * select
	 *
	 * TODO
     * 
     * @param array $options TODO
     * @param array $attributes TODO
     * 
     * @return TODO
	 */
    public function select($options = [], $attributes = [])
    {
        $attributesAsString = self::getAttributes($attributes); 
        $optionsAsString = '';

        foreach ($options as $key => $value) {
            $optionsAsString .= $this->option($key, $value);
        }

        return '<select'.$attributesAsString.'>'.$optionsAsString.'</select>';
    }

    /**
	 * option
	 *
	 * TODO
     * 
     * @param string $key TODO
     * @param string $value TODO
     * 
     * @return TODO
	 */
    private function option($key, $value)
    {       
        return '<option value="'.$key.'">'.$value.'</option>';
    }

    /**
	 * getAttributesAsString
	 *
	 * TODO
     * 
     * @param array $attributes TODO
     * 
     * @return TODO
	 */
    private static function getAttributes($attributes)
    {
        $attributesAsString = '';

        foreach($attributes as $attributeName => $attributeValue) {
            $attributesAsString .= ' '.$attributeName.'="'.$attributeValue.'"';
        }

        return $attributesAsString;
    }
}