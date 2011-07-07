<?php
/**
 * I am a JSON Query builder
 * 
 * Here is a inline example of how to create your json when sending it.
 * 
 * <code>
 * 		$flexJSON = '[{"table":"TABLENAME","objectName":"FIELDNAME","objectValue":"FIELDVALUE","database":"DATABASE","tableKey":"PRI KEY","objectKey":"RECORD KEY"}]';
 * 		$j = new JSONQuery( 'host', 'user', 'pass' );
 * 		$j->dump( $j->buildQuery( $flexJSON, 'INSERT' ), 'INSERT JSON ' );
 * 		$j->dump( $j->buildQuery( $flexJSON, 'UPDATE' ), 'UPDATE JSON' );
 * 		$j->dump( $j->buildQuery( $flexJSON, 'DELETE' ), 'DELETE JSON' );
 * 		$j->setJSONString( $flexJSON );
 * 		$j->dump( $j->getJSONString(), 'JSON STRING' );
 * </code>
 * 
 * @author Jonnie Spratley
 * @copyright 2009 http://jonniespratley.com
 * @version 0.7
 *
 */
class JSONQuery
{
	private $mysqli;
	private $jsonArray;
	private $jsonString;
	private $jsonQuery;
	
	/**
	 * Database Link
	 *
	 * @param [database] $link
	 */
	public function __construct( $link )
	{
		$this->mysqli = $link;
	}
	
	/**
	 * I build a INSERT/UPDATE/DELETE from a json string.
	 * I can either auto update the database, or return the sql.
	 *	<code>
	 * [{"table":"TABLENAME","objectName":"FIELDNAME","objectValue":"FIELDVALUE","database":"DATABASE","tableKey":"PRI KEY","objectKey":"RECORD KEY"}]
	 * </code>
	 * 
	 * @param [json] $json JSON string like [{"table":"TABLENAME","objectName":"FIELDNAME","objectValue":"FIELDVALUE","database":"DATABASE","tableKey":"PRI KEY","objectKey":"RECORD KEY"}]
	 * @param [string] $type INSERT/UPDATE/DELETE
	 * @param [boolean] $autoInsert = false Auto update database 
	 * @return unknown
	 */
	public function buildQuery( $json, $type, $autoInsert = false )
	{
		$jsonString = str_replace ( "\\", "", $json );
		$jsonArray = json_decode ( $jsonString, true );
		$query = '';
		$queryArray = array ();
		
		switch ( $type )
		{
			case 'INSERT' :
				//do insert statement
				foreach ( $jsonArray as $record )
				{
					$query = sprintf ( 'INSERT INTO %s.%s SET %s = "%s"', $record [ 'database' ], $record [ 'table' ], $record [ 'objectName' ], $record [ 'objectValue' ] );
					//echo $query;
					$queryArray [] = $query;
				}
				
				break;
			
			case 'UPDATE' :
				
				foreach ( $jsonArray as $record )
				{
					$query = sprintf ( 'UPDATE %s.%s SET %s = "%s" WHERE %s = "%s"', $record [ 'database' ], $record [ 'table' ], $record [ 'objectName' ], $record [ 'objectValue' ], $record [ 'tableKey' ], $record [ 'objectKey' ] );
					//echo $query;
					$queryArray [] = $query;
				}
				
				break;
			
			case 'DELETE' :
				
				foreach ( $jsonArray as $record )
				{
					$query = sprintf ( 'DELETE FROM %s.%s WHERE %s = "%s"', $record [ 'database' ], $record [ 'table' ], $record [ 'tableKey' ], $record [ 'objectKey' ] );
					//echo $query;
					$queryArray [] = $query;
				}
				
				break;
			
			default :
				echo 'Specify a type of statement';
				exit ();
				break;
		}
		if ( $autoInsert )
		{
			return $this->_batchQuery ( $queryArray );
		}
		return $queryArray;
	}
	
	/**
	 * I take an array of sql statements and execute them in order to the database.
	 *
	 * @param [array] $sql array of sql statements
	 */
	private function _batchQuery( $sql )
	{
		foreach ( $sql as $q )
		{
			$result = $this->mysqli->query ( $q );
			if ( $result )
			{
				printf ( "%d row affected.", $this->mysqli->affected_rows );
			}
		}
	}
	
	private function _filterTable( $s )
	{
		$tablename = stripos ( $s, 'table' );
		
		return $tablename;
	}
	
	/**
	 * Escape SQL 
	 *
	 * @param [string] $str
	 * @return escaped string
	 */
	private function _sqlQuote( $str )
	{
		if ( ! isset ( $str ) )
			return ( "NULL" );
		
		$func = function_exists ( "mysqli_escape_string" ) ? "mysqli_escape_string" : "addslashes";
		return ( "'" . $func ( $str ) . "'" );
	}
	
	/**
	 * @return associative array
	 */
	public function getJSONArray()
	{
		return $this->jsonArray;
	}
	
	/**
	 * @return json string
	 */
	public function getJSONString()
	{
		return $this->jsonString;
	}
	
	/**
	 * @return sql query
	 */
	public function getQuery()
	{
		return $this->query;
	}
	
	/**
	 * @param associative $jsonArray
	 */
	public function setJSONArray( $json )
	{
		$jsonArray = json_decode ( $json, true );
		
		$this->jsonArray = $jsonArray;
	}
	
	/**
	 * @param json $jsonString
	 */
	public function setJSONString( $jsonString )
	{
		$this->jsonString = $jsonString;
	}
	
	/**
	 * @param string $query
	 */
	public function setJSONQuery( $query )
	{
		$this->jsonQuery = $query;
	}
	
	/**
	 * I dump vars
	 *
	 * @param [var] $var
	 * @param [string] $name
	 */
	public function dump( $var, $name = 'Variable Dump' )
	{
		echo "<b>$name</b><br/>";
		echo '<pre>';
		print_r ( $var );
		echo '</pre>';
	}

}
?>