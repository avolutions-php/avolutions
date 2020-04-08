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
 * TODO 
 *
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.2.0
 */
class Formular
{
    private $Entity = null;

    private $EntityConfiguration = null;

    private $EntityMapping = null;

    private $entityName = null;

    /**
	 * __construct
	 *
	 * TODO
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
	 */
    public function inputFor($fieldName) 
    {   
        $inputType = $this->EntityMapping->$fieldName['form']['type'];
        $attributes = [
            'name' => lcfirst($this->entityName).'['.$fieldName.']'
        ];

        // TODO switch case
        return $this->$inputType($attributes);
    }


    /**
	 * generate
	 *
	 * TODO
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
	 */
    public function close()
    {
        return '</form>';
    }

    /**
	 * text
	 *
	 * TODO
	 */
    public function text($attributes = [])
    {
        return $this->input('text', $attributes);
    }

    /**
	 * text
	 *
	 * TODO
	 */
    public function date($attributes = [])
    {
        return $this->input('date', $attributes);
    }

    /**
	 * password
	 *
	 * TODO
	 */
    public function password($attributes = [])
    {
        return $this->input('password', $attributes);
    }

    /**
	 * input
	 *
	 * TODO
	 */
    public function input($type, $attributes = [])
    {
        $attributes['type'] = $type;
        $attributesAsString = self::getAttributes($attributes); 

        return '<input'.$attributesAsString.' />';
    }

    /**
	 * submit
	 *
	 * TODO
	 */
    public function submit($attributes = [])
    {
        return $this->input('submit', $attributes);
    }

    /**
	 * button
	 *
	 * TODO
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
	 */
    private function option($key, $value)
    {       
        return '<option value="'.$key.'">'.$value.'</option>';
    }

    /**
	 * getAttributesAsString
	 *
	 * TODO
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