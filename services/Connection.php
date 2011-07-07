<?php
/**
 * @name  	Connection.php
 * @author  Jonnie Spratley
 * @version 1.7
 * @description 
 * 
 * This class holds all of the static methods 
 * for creating all the neccessary files for the PHP on the server side.
 * 
 * @method generateValueObject -
 * @method generateBaseService -
 * @method generateRESTService -
 * 
 */

class Connection
{
	private $link;
	
	/**
	 * I create a new connection to a database
	 *
	 * @param [string] $host hostname
	 * @param [string] $user username
	 * @param [string] $pass password
	 * @return [link] a link to the connection
	 */
	public function __construct()
	{
		$link = new mysqli ( 'localhost', 'root', 'fred' );
		
		return $this->setLink ( $link );
	}
	
	public function getLink()
	{
		return $this->link;
	}
	
	public function setLink( $link )
	{
		$this->link = $link;
	}
	
	/**
	 * I execute a query on the database
	 *
	 * @param [string] $query
	 * @return [result] the result
	 */
	public function execute( $query )
	{
		return $this->link->query ( $query );
	}
	
	/**
	 * I execute a query and return an array of the results.
	 *
	 * @param [string] $sql - the sql
	 * @return [array] the results
	 */
	public function executeAndReturn( $sql )
	{
		$query = $this->link->query ( $sql );
		$array = array ();
		while ( $row = mysqli_fetch_assoc ( $query ) )
		{
			$array [] = $row;
		}
		return $array;
	}
	
	static public function escape( $value )
	{
		$escaped = $value;
		
		if ( ! is_numeric ( $value ) )
		{
			$escaped = '"' . ( $value ) . '"';
		}
		
		return $escaped;
	}
	
	static public function trimSQL( $sql )
	{
		return substr ( $sql, 0, strlen ( $sql ) - 2 );
	}

}
?>