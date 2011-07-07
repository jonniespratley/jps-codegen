<?php

class SQLiteService
{
	private $sqlite;
	private $error;
	private $sqlite_results;
	
	/**
	 * I open a connection to a SQLite database
	 *
	 * @param [string] $dbfile - The path to the database
	 */
	public function __construct( $dbfile )
	{
		if ( ! $this->sqlite = new SQLiteDatabase ( $dbfile, 0666, $e ) )
		{
			die ( $e );
		}
	
	}
	
	/**
	 * I execute a query
	 *
	 * @param [string] $sql
	 * @return [handle]
	 */
	public function execute( $sql )
	{
		$results = $this->sqlite->query ( $sql );
		
		return $results;
	}
 
	
	/**
	 * I execute a query and return the results as json.
	 *
	 * @param [string] $sql the query to be executed
	 * @return [json] the result in json
	 */
	public function queryToJSON( $sql )
	{
		$result = $this->sqlite->query ( $sql );
		
		while ( $row = $result->fetch ( SQLITE_ASSOC ) )
		{
			$array [] = $row;
		}
		
		return json_encode ( $array );
	}
	
	/**
	 * I execute a query and return the result as an array.
	 *
	 * @param [string] $sql the query to be executed
	 * @return [array] the result array
	 */
	public function queryToArray( $sql )
	{
		$resultArray = array ();
		$e = '';
		
		if ( $result = $this->sqlite->query ( $sql, SQLITE_ASSOC, $e ) )
		{
			while ( $row = $result->fetch ( SQLITE_ASSOC ) )
			{
				
				$resultArray [] = $row;
			
			}
		}
		else
		{
			die ( $e );
		}
		return $resultArray;
	}
	

}
?>