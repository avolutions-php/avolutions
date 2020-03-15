<?php
/**
 * AVOLUTIONS
 * 
 * Just another open source PHP framework.
 * 
 * @author		Alexander Vogt <alexander.vogt@avolutions.de>
 * @copyright	2019 avolutions (http://avolutions.de)
 * @license		MIT License (https://opensource.org/licenses/MIT)
 * @link		https://github.com/avolutions/avolutions
 */
 
namespace Avolutions\Orm;

/**
 * EntityMapping class
 *
 * The EntityMapping class provides the values from the entity mapping file
 * as an object.
 *
 * @package		ORM
 * @author		Alexander Vogt <alexander.vogt@avolutions.de>
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
	public function __construct($entity) {
		$mapping = $this->loadMappingFile(APP_MAPPING_PATH.$entity."Mapping.php");

		foreach ($mapping as $key => $value) {
			if(!isset($value["column"])) {
				$value["column"] = $key;
			}
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
	private function loadMappingFile($mappingFile) {				
		if(file_exists($mappingFile)) {	
			return require $mappingFile;
		}
		
		return array();
	}
}
?>