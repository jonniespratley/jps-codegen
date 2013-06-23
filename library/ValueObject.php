<?php
/**
 * I represent a table record.
 */
class ValueObject
{
	//public $explicitType;

	public function __construct(){}
	
	/**
	 * Sets the namesapce explicit type
	 *
	 * @param [string] $namespace - Your namespace ie. com.domain.project
	 */
	public function setNamespace( $namespace )
	{
		//$this->explicitType = $namespace;
	}
	
	/**
	 * Gets the name/value of the set object
	 *
	 * @param [string] $name
	 * @return [array]
	 */
	public function __get( $name )
	{
		return $this->$name;
	}
	
	/**
	 * Sets a name/value to the class
	 *
	 * @param [string] $name - the name
	 * @param [string] $value - the value
	 */
	public function __set( $name, $value )
	{
		$this->$name = $value;
	}

}
?>