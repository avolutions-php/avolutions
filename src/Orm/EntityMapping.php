<?php
/**
 * AVOLUTIONS
 * 
 * Just another open source PHP framework.
 * 
 * @copyright   Copyright (c) 2019 - 2021 AVOLUTIONS
 * @license     MIT License (http://avolutions.org/license)
 * @link        http://avolutions.org
 */
 
namespace Avolutions\Orm;

/**
 * EntityMapping class
 *
 * The EntityMapping class provides the values from the entity mapping file
 * as an object.
 *
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.1.0
 */
class EntityMapping
{	
	/**
	 * __construct
	 * 
	 * Creates a new EntityMapping object for the given entity type and loads
	 * the values from the entity mapping file.
	 * 
	 * @param string $entity The name of the entity type.
	 */
    public function __construct($entity)
    {
		$mapping = $this->loadMappingFile(APP_MAPPING_PATH.$entity.'Mapping.php');

		foreach ($mapping as $key => $value) {
            // Set default values
            // If type is an Entity
            if (isset($value['type']) && is_a(APP_MODEL_NAMESPACE.$value['type'], 'Avolutions\Orm\Entity', true)) {
                $value['isEntity'] = true;
            } else {
                $value['isEntity'] = false;
            }

            // If no column is specified use the name of the property as database column     
            $value['column'] = $value['column'] ?? $key;

            if ($key == 'id') {
                // Set id property to input type hidden by default
                $value['form']['type'] = $value['form']['type'] ?? 'hidden';
            } 

            // If no form type is specified set to 'text'
            $value['form']['type'] = $value['form']['type'] ?? 'text';
            
            // Set property
			$this->$key = $value;
        }
	}	
	
	/**
	 * loadMappingFile
	 *
	 * Loads the given mapping file and return the content (array) or an empty array 
	 * if the file can not be found.
	 *
	 * @param string $mappingFile Complete name including the path of the mapping file.
	 * 
	 * @return array An array with the loaded mapping values or an empty array if 
     *				 file can not be found.
	 */
    private function loadMappingFile($mappingFile)
    {				
		if (file_exists($mappingFile)) {	
			return require $mappingFile;
		}
		
		return [];
    }
    
    /**
	 * getFormFields
	 * 
	 * Returns all fields where the form hidden attribute is not set or where it is false.
     * 
     * @return array An array with all Entity fields not hidden in forms.
	 */
    public function getFormFields()
    {
        return array_filter(get_object_vars($this), function($field) {
            return isset($field['form']['hidden']) ? !$field['form']['hidden'] : true;
        });
    }
}