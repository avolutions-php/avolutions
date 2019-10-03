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
 
namespace core\orm;

/**
 * Entity class
 *
 * TODO
 *
 * @package		core
 * @author		Alexander Vogt <alexander.vogt@avolutions.de>
 */
class Entity
{
	/**
	 * @var mixed $id The unique identifier of the entity.
	 */
	public $id;
		
	
	/**
	 * __construct
	 * 
	 * TODO
	 */
	public function __construct() {
		print '__construct()';		
				
		print_r($this);
	}	
		
	/**
	 * save
	 * 
	 * TODO
	 */
	public function save() {
		print 'save()';
		
		if($this->exists()) {
			$this->update();
		} else {
			$this->insert();
		}
	}	

	/**
	 * delete
	 * 
	 * TODO
	 */
	public function delete() {
		print 'delete()';
	}	

	/**
	 * insert
	 * 
	 * TODO
	 */
	private function insert() {
		print 'insert()';
	}	

	/**
	 * update
	 * 
	 * TODO
	 */
	private function update() {
		print 'update()';
	}
	
	/**
	 * exists
	 * 
	 * TODO
	 */
	private function exists() {
		print 'exists()';		
	}
}
?>