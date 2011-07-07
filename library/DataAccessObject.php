<?php

require_once ( 'Connection.php' );
require_once ( 'ValueObject.php' );

/**
 * I am the Database Access Layer, I can manipulate the database.
 *
 */
class DataAccessObject
{
	private $conn;
	private $database;
	private $table;
	
	/**
	 * I am the instance of a Database Access Object
	 *
	 * @return [link]
	 */
	public function __construct()
	{
		$conn = new Connection ( );
		
		$this->conn = $conn;
	}
	
	/**
	 * I get all records from the specified database and table
	 *
	 * @param [string] $database the database name
	 * @param [string] $table the table name
	 * @return [array]
	 */
	public function get( $database, $table )
	{
		
		$sql = "SELECT * FROM $database.$table";
		
		$this->_returnSQL ( $sql );
		
		return $this->_execute ( $sql, 'get' );
	}
	
	/**
	 * I get one record from the specified database and table.
	 *
	 * @param [string] $database - the database
	 * @param [string] $table - the table
	 * @param [array] $vo - an array from the url query string
	 * @return [array] the matching record
	 */
	public function getOne( $database, $table, $vo )
	{
		$primarykey = $this->_getKey ( $database, $table );
		$primarykeyValue = $vo [ $primarykey ];
		
		$sql = "SELECT * FROM $database.$table WHERE $primarykey = $primarykeyValue";
		
		$this->_returnSQL ( $sql );
		
		return $this->_execute ( $sql, 'getOne' );
	}
	
	/**
	 * I save a record to the specified database and table
	 *
	 * @param [string] $database - the database
	 * @param [string] $table - the table
	 * @param [array] $vo - the array from the url query
	 * @return [array] the inserted record
	 */
	public function save( $database, $table, $vo )
	{
		
		//Get the name of the primary key		
		$primarykey = $this->_getKey ( $database, $table );
		
		//Get the value of the primary key
		$primarykeyValue = $vo [ $primarykey ];
		
		$choice = '';
		if ( $primarykeyValue == 0 || $primarykeyValue == '' )
		{
			$choice = $this->create ( $database, $table, $vo );
		}
		else
		{
			$choice = $this->update ( $database, $table, $vo );
		}
		return $choice;
	}
	
	/**
	 * I update a record in the database/table
	 *
	 * @param [string] $database - the database
	 * @param [string] $table - the table
	 * @param [array] $vo - the array from the url query
	 * @return [array] the inserted object
	 */
	private function update( $database, $table, $vo )
	{
		
		//get the primary key
		$key = $this->_getKey ( $database, $table );
		
		$keyvalue = '';
		
		//check if the object has a key with the same value as the primary key
		if ( array_key_exists ( $key, $vo ) )
		{
			//set the keyvalue variable to the array key inside the object, the key should be the same name as the key in the table
			$keyvalue = $vo [ $key ];
		}
		
		$updateSet = '';
		
		//get the columns, the columns should be the name of the keys Get the name=values for the update set
		foreach ( $vo as $name => $value )
		{
			$updateSet .= $name . ' = ' . Connection::escape ( $value ) . ', ';
		}
		
		$updateSet = Connection::trimSQL ( $updateSet );
		
		//build the query
		$sql = "UPDATE $database.$table SET $updateSet WHERE $key = " . Connection::escape ( $keyvalue );
		
		$this->_returnSQL ( $sql );
		
		//return sql for debugging
		return $this->_execute ( $sql, 'update' );
	}
	
	/**
	 * I create a new record in the database/table
	 *
	 * @param [string] $database - the database
	 * @param [string] $table - the table
	 * @param [array] $vo - the array from the url query
	 * @return [array] the inserted object
	 */
	private function create( $database, $table, $vo )
	{
		
		//get the columns, the columns should be the name of the keys
		$voColumns = '';
		$voValues = '';
		
		foreach ( $vo as $column => $value )
		{
			$voColumns .= $column . ', ';
			$voValues .= Connection::escape ( $value ) . ', ';
		}
		$voColumns = Connection::trimSQL ( $voColumns );
		$voValues = Connection::trimSQL ( $voValues );
		
		//build the query
		$sql = "INSERT $database.$table ( $voColumns ) VALUES ( $voValues )";
		
		$this->_returnSQL ( $sql );
		
		return $this->_execute ( $sql, 'create' );
	}
	
	/**
	 * I remove a record from the specified database/table
	 *
	 * @param [string] $database - the database
	 * @param [string] $table - the table
	 * @param [array] $vo - the array from the url query
	 * @return [string] the id removed
	 */
	public function remove( $database, $table, $vo )
	{
		
		$primarykey = $this->_getKey ( $database, $table );
		$primarykeyValue = $vo [ $primarykey ];
		
		$sql = "DELETE FROM $database.$table WHERE $primarykey = $primarykeyValue";
		
		return $this->_execute ( $sql, 'remove' );
	}
	
	/**
	 * I get the tables key field
	 *
	 * @param [string] $database - the database
	 * @param [string] $table - the table
	 * @return [string] the name of the key
	 */
	private function _getKey( $database, $table )
	{
		$keys = $this->conn->executeAndReturn ( "SHOW INDEX FROM $database.$table" );
		$primaryKey = '';
		
		foreach ( $keys as $key )
		{
			if ( $key [ 'Key_name' ] == 'PRIMARY' )
			{
				$primaryKey = $key [ 'Column_name' ];
			}
		}
		$this->_returnSQL ( $primaryKey );
		
		return $primaryKey;
	}
	
	/**
	 * I take the mysqli connection object and return a value object of the data
	 *
	 * @param [array] $obj - The mysqli object 
	 * @return [array]
	 */
	private function _mapObject( $obj )
	{
		$array = array ();
		
		while ( $row = mysqli_fetch_assoc ( $obj ) )
		{
			$vo = new ValueObject ( );
			foreach ( $row as $key => $value )
			{
				$vo->__set ( $key, $value );
			}
			$array [] = $vo;
		}
		
		return $array;
	}
	
	/**
	 * I execute a method and return the results based on the mode
	 *
	 * @param [string] $sql - the sql to execute
	 * @return results
	 */
	private function _execute( $sql, $mode )
	{
		$query = $this->conn->execute ( $sql );
		$result = array ();
		if ( $mode == 'get' || $mode == 'getOne' )
		{
			$result = $this->_mapObject ( $query );
		
		}
		else if ( $mode == 'remove' || $mode == 'update' || $mode == 'create' )
		{
			$result = mysqli_affected_rows ( $this->conn->getLink () );
		}
		
		return $result;
	}
	
	/**
	 * I dump out the SQL created from the functions.
	 *
	 * @param [string] - $sql
	 * @return string
	 */
	private function _returnSQL( $sql )
	{
		//Uncomment this to print out the sql from the function
	//echo '<b>SQL:</b> ' . $sql . '<br/>';
	}

}

/** ==============================================================================================
 * REST SERVICE FOR CLASS
 * ============================================================================================== */

if ( isset ( $_GET ) )
{
	
	//header ( 'Content-type: application/json' );
	

	//Set up the variables for the calls
	$mode = '';
	$table = '';
	$database = '';
	$object = '';
	$format = '';
	$query = $_GET;
	
	if ( isset ( $_GET [ 'm' ] ) )
	{
		$mode = $_GET [ 'm' ]; //Mode
		unset ( $query [ 'm' ] );
	}
	
	if ( isset ( $_GET [ 'd' ] ) )
	{
		$database = $_GET [ 'd' ]; //Database
		unset ( $query [ 'd' ] );
	}
	
	if ( isset ( $_GET [ 't' ] ) )
	{
		$table = $_GET [ 't' ]; //Table
		unset ( $query [ 't' ] );
	}
	
	/* ********************************************
 * Call Error/Result Codes/Messages
 * ********************************************/
	$jsonFault [] = array ( 
		'status' => 401, 'message' => 'Unknown method or incorrect parameters' 
	);
	
	$jsonData = array ();
	
	/* ********************************************
 * Switch based on the mode
 * ********************************************/
	
	$service = new DataAccessObject ( );
	switch ( $mode )
	{
		case 'get':
			
			$result = $service->get ( $database, $table );
			
			if ( $result )
			{
				echo json_encode ( array( array ( 
					'status' => 200, 'mode' => 'get', 'result' => $result 
				) ) );
			}
			else
			{
				echo json_encode ( $jsonFault );
			}
			
			break;
		
		case 'getOne':
			$result = $service->getOne ( $database, $table, $query );
			
			if ( $result )
			{
				echo json_encode ( array( array ( 
					'status' => 200, 'mode' => 'getOne', 'result' => $result 
				) ) );
			}
			else
			{
				echo json_encode ( $jsonFault );
			}
			break;
		
		case 'save':
			$result = $service->save ( $database, $table, $query );
			
			if ( $result )
			{
				echo json_encode ( array( array ( 
					'status' => 200, 'mode' => 'save', 'result' => $result 
				) ) );
			}
			else
			{
				echo json_encode ( $jsonFault );
			}
			break;
		
		case 'remove':
			$result = $service->remove ( $database, $table, $query );
			
			if ( $result )
			{
				echo json_encode ( array( array ( 
					'status' => 200, 'mode' => 'remove', 'result' => $result 
				) ) );
			}
			else
			{
				echo json_encode ( $jsonFault );
			}
			break;
		
		default :
			echo json_encode ( $jsonFault );
			break;
	
	}

} //ends $_GET


/** ==============================================================================================
 * CLASS TESTING
 *

//To update a table record, simply just specify the the values for the fields in which you are wanting to update.
//Make sure it is an assoc array containing array keys ( which are table columns ) and values ( which are the //updated values )


$updateVO = array ( 
	'id' => 100, 'title' => 'This record just got updated', 'body' => 'Dont you just love PHP programming?' 
);

//To create a table record, do the same as above just make the id field for your table 0, this is because the //class does a check, to see
//if there is a key with the value of ( table primary key ), if there is a key, then it continues and checks the //value of that key, in the array
//if the value is set to 0 or '', then it creates a new record, otherwise it updates that record in which is //specified in the value of the key array.


$createVO = array ( 
	'id' => 0, 'title' => 'This is a new post', 'body' => 'I really dont know what to say here.' 
);

$database = 'codegen';
$table = 'posts';
$key = 'id';

echo '<pre>';

//=========================================================================================
echo '<h2>Universal Value Object</h2>';
$vo = new ValueObject ( );
$vo->__set ( 'id', 0 );
$vo->__set ( 'title', 'Flex Value Object' );
$vo->__set ( 'body', 'This is just a sample get and set value objerct' );

print_r ( $vo );

//=========================================================================================
echo '<h2>Universal DataAccess Object</h2>';
$service = new DataAccessObject ( );


//==========================Get===============================================================
<b>get(database, table)</b>;

<strong>URL Example:</strong>
<pre class="brush: php">
http://localhost/DataAccessObject.php?m=get&d=test&t=tags
</pre>

<strong>JSON Response:</strong>
<pre class="brush: php">
[
	{
	  status: 200, 
	  mode: "get", 
	  result: [
	    {
	      id: "115", 
	      tag_title: "FlexMe", 
	      user_id: "0"
	    }
	  ]
	}
]
</pre>


//===========================getOne==============================================================
<b>getOne(database, table, value)</b>

<strong>URL Example:</strong>
<pre class="brush: php">
http://localhost/DataAccessObject.php?m=getOne&d=codegen&t=posts&id=5
</pre>

<strong>JSON Response:</strong>
<pre class="brush: php">
[
	{
	  status: 200, 
	  mode: "getOne", 
	  result: [
	    {
	      id: "113", 
	      tag_title: "FlexMe", 
	      user_id: "0"
	    }
	  ]
	}
]
</pre>

//=========================Update================================================================
<b>save(database, table, value)</b>

<strong>URL Example:</strong>
<pre class="brush: php">
http://localhost/DataAccessObject.php?m=save&d=test&t=tags&id=4&tag_title=Fuck&user_id=3
</pre>

<strong>JSON Response:</strong>
<pre class="brush: php">
[	
	{
	  status: 200, 
	  mode: "update", 
	  result: 1
	}
]
</pre>


//=========================Create=============================================================
<b>save(database, table, value)</b>

<strong>URL Example:</strong>
<pre class="brush: php">
http://localhost/DataAccessObject.php?m=save&d=test&t=tags&id=0&tag_title=FuckIt&user_id=0
</pre>

<strong>JSON Response:</strong>
<pre class="brush: php">
[
	{
	  status: 200, 
	  mode: "save", 
	  result: 1
	}
]
</pre>


//===========================Remove==============================================================
<b>remove(database, table, value)</b>

<strong>URL Example:</strong>
<pre class="brush: php">
http://localhost/DataAccessObject.php?m=remove&d=test&t=tags&id=106
</pre>

<strong>JSON Response:</strong>
<pre class="brush: php">
[
	{
	  status: 200, 
	  mode: "remove", 
	  result: 1
	}
]
</pre>

<b>Failed Query</b>

<strong>JSON Response:</strong>
<pre class="brush: php">
[
  {
    status: 401, 
    message: "Unknown method or incorrect parameters"
  }
]
</pre>

============================================================================================== */
?>