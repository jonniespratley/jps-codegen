<?php

require_once ( 'ValueObject.php' );

/**
 * I am the Database Access Layer, I can manipulate the database.
 *
 */
class DataAccessObject
{
	private $mysqli;
	private $database;
	private $table;
	
	/**
	 * I am the instance of a Database Access Object
	 *
	 * @return [link]
	 */
	public function __construct()
	{
		$this->mysqli = new mysqli ( 'localhost', 'root', 'fred' );
		if ( mysqli_connect_errno () )
		{
			trigger_error ( 'Database connection failure: Username/Password was incorrect.', E_USER_ERROR );
			exit ();
		}
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
			$updateSet .= $name . ' = ' . $this->escape ( $value ) . ', ';
		}
		
		$updateSet = $this->trimSQL ( $updateSet );
		
		//build the query
		$sql = "UPDATE $database.$table SET $updateSet WHERE $key = " . $this->escape ( $keyvalue );
		
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
			$voValues .= $this->escape ( $value ) . ', ';
		}
		$voColumns = $this->trimSQL ( $voColumns );
		$voValues = $this->trimSQL ( $voValues );
		
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
	 * I get the databases in the mysql server
	 *
	 * @return unknown
	 */
	public function getDatabases()
	{
		$sql = "SHOW DATABASES";
		$results = $this->executeAndReturn ( $sql );
		$return = array ();
		
		foreach ( $results as $result )
		{
			$return [] = $result;
		}
		return $return;
	}
	
	/**
	 * I get the tables, fields, and information about the tables from the database.
	 *
	 * @param [string] $database
	 * @return array
	 */
	public function _getTables( $database )
	{
		$sql = "SHOW TABLES FROM $database";
		$return = array ();
		$results = $this->executeAndReturn ( $sql );
		
		foreach ( $results as $result )
		{
			$return [] = $result;
		}
		return $return;
	}
	
	/**
	 * I get all tables for a database
	 *
	 * @param [string] $whatDatabase the database
	 * @return [array]
	 */
	public function getTables( $whatDatabase )
	{
		//table query
		$tableSQL = mysqli_query ( $this->mysqli, "SHOW TABLES FROM $whatDatabase" );
		
		//create a new array of tables
		$tables = array ();
		
		//loop all the results
		while ( $table = mysqli_fetch_assoc ( $tableSQL ) )
		{
			$fields = array ();
			
			//for each table in the result make an array
			foreach ( $table as $t_key => $t_value )
			{
				//get the tables fields for each table
				$fields = $this->describeTable ( $whatDatabase, $t_value );
			}
			
			$tables [] = array ( 
				"label" => $t_value, "fields" => $fields 
			)
			;
		}
		$databaseTables [] = array ( 
			'label' => $whatDatabase, 'children' => $tables
		);
		//sort ( $tables );
		return $databaseTables;
	}
	
	/**
	 * I describe a table for the getDatabasesAndTables() method
	 *
	 * @param [string]  $database the database
	 * @param [string]  $table the table
	 * @return [array]
	 */
	public function describeTable( $whatDatabase, $whatTable )
	{
		$sql = mysqli_query ( $this->mysqli, "DESCRIBE $whatDatabase.$whatTable" );
		$tables = array ();
		
		while ( $row = mysqli_fetch_assoc ( $sql ) )
		{
			$tables [] = array ( 
				'label' => $row [ 'Field' ] . ' [' . $row [ 'Type' ] . ']' 
			)
			;
		}
		//sort ( $tables );
		

		return $tables;
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
		$keys = $this->executeAndReturn ( "SHOW INDEX FROM $database.$table" );
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
		$query = $this->execute ( $sql );
		$result = array ();
		
		if ( $mode == 'get' || $mode == 'getOne' || $model == 'query' )
		{
			$result = $this->_mapObject ( $query );
		}
		else if ( $mode == 'remove' || $mode == 'update' || $mode == 'create' )
		{
			$result = $query;
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
	
	/**
	 * I execute a query on the database
	 *
	 * @param [string] $query
	 * @return [result] the result
	 */
	private function execute( $query )
	{
		return $this->mysqli->query ( $query );
	}
	
	/**
	 * I execute a query and return an array of the results.
	 *
	 * @param [string] $sql - the sql
	 * @return [array] the results
	 */
	private function executeAndReturn( $sql )
	{
		$query = $this->mysqli->query ( $sql );
		$array = array ();
		while ( $row = mysqli_fetch_assoc ( $query ) )
		{
			$array [] = $row;
		}
		return $array;
	}
	
	/**
	 * I don't really escape, just wrap little ' around something.
	 *
	 * @param [string] $value
	 * @return [string]
	 */
	private function escape( $value )
	{
		$escaped = $value;
		
		if ( ! is_numeric ( $value ) )
		{
			$escaped = '"' . ( $value ) . '"';
		}
		
		return $escaped;
	}
	
	/**
	 * I remove the extra , at the end of the sql.
	 *
	 * @param [string] $sql
	 * @return [string]
	 */
	private function trimSQL( $sql )
	{
		return substr ( $sql, 0, strlen ( $sql ) - 2 );
	}

}

/** ==============================================================================================
 * REST SERVICE FOR CLASS
 * ============================================================================================== */
//header ( 'Content-type: application/json' );
//Set up the variables for the calls
$mode = '';
$table = '';
$database = '';
$object = '';
$format = '';
$query = '';
$service = new DataAccessObject ( );
$log = fopen ( 'log/log.txt', 'a' );

$jsonFault [] = array ( 
	'status' => 401, 'message' => 'Unknown method or incorrect parameters' 
);

$jsonData = array ();
/* ============================================================================
 * 
 * ============================================================================ */
switch ( $_SERVER [ 'REQUEST_METHOD' ] )
{
	case 'GET':
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
		
		/* ============================================================================
		 * Switch based on mode
		 * ============================================================================ */
		switch ( $mode )
		{
			
			case 'getData':
				
				$result = $service->get ( $database, $table );
				
				if ( $result )
				{
					echo json_encode ( array ( 
						array ( 
						'status' => 200, 'mode' => 'getData', 'result' => $result 
					) 
					) );
				}
				else
				{
					echo json_encode ( $jsonFault );
				}
				
				break; //ends case 'getData'
			

			/* ============================================================================
		 * 
		 * ============================================================================ */
			case 'getOneData':
				$result = $service->getOne ( $database, $table, $query );
				
				if ( $result )
				{
					echo json_encode ( array ( 
						array ( 
						'status' => 200, 'mode' => 'getOneData', 'result' => $result 
					) 
					) );
				}
				else
				{
					echo json_encode ( $jsonFault );
				}
				break; //ends case 'getOneData'
			

			/* ============================================================================
		 * 
		 * ============================================================================ */
			case 'removeData':
				$result = $service->remove ( $database, $table, $query );
				
				if ( $result )
				{
					echo json_encode ( array ( 
						array ( 
						'status' => 200, 'mode' => 'removeData', 'result' => $result 
					) 
					) );
				}
				else
				{
					echo json_encode ( $jsonFault );
				}
				break; //ends case 'removeData
			

			/* ============================================================================
		 * 
		 * ============================================================================ */
			case 'getDatabases':
				
				$result = $service->getDatabases ();
				
				if ( $result )
				{
					echo json_encode ( array ( 
						array ( 
						'status' => 200, 'mode' => 'getDatabases', 'result' => $result 
					) 
					) );
				}
				else
				{
					echo json_encode ( $jsonFault );
				}
				
				break; //ends case 'getDatabases'
			

			/* ============================================================================
		 * 
		 * ============================================================================ */
			case 'getTables':
				
				$result = $service->getTables ( $database );
				
				if ( $result )
				{
					echo json_encode ( array ( 
						array ( 
						'status' => 200, 'mode' => 'getTables', 'result' => $result 
					) 
					) );
				}
				else
				{
					echo json_encode ( $jsonFault );
				}
				
				break; //ends case 'getTables'
		

		}
		break; //ends case 'GET'
	

	/* ============================================================================
 *	Now that its a post, lets go ahead and deal with it 
 * ============================================================================ */
	case 'POST':
		
	/* ============================================================================
	 * Since its a post, lets remove the mode, database and table, 
	 * so we can insert/update our data
	 * ============================================================================ */
		$query = $_POST;
		
		//Mode - Either upload file, or save to database
		if ( isset ( $_POST [ 'm' ] ) )
		{
			$mode = $_POST [ 'm' ];
			unset ( $query [ 'm' ] );
		}
		
		//Database
		if ( isset ( $_POST [ 'd' ] ) )
		{
			$database = $_POST [ 'd' ];
			unset ( $query [ 'd' ] );
		}
		
		//Table
		if ( isset ( $_POST [ 't' ] ) )
		{
			$table = $_POST [ 't' ];
			unset ( $query [ 't' ] );
		}
		
		//TODO: remove this on the client side
		if ( isset ( $_POST [ 'mx_internal_uid' ] ) )
		{
			unset ( $query [ 'mx_internal_uid' ] );
		}
		
		//Debugging Purposes 	
		$postLog = date ( 'Y-m-d H:i:s' ) . ' - ';
		
		foreach ( $query as $p_key => $p_value )
		{
			$postLog .= $p_key . " = " . $p_value . "\n";
		}
		
		fwrite ( $log, $postLog );
		
		switch ( $mode )
		{
			case 'saveData':
				$result = $service->save ( $database, $table, $query );
				
				if ( $result )
				{
					echo json_encode ( array ( 
						array ( 
						'status' => 200, 'mode' => 'saveData', 'result' => $result 
					) 
					) );
				}
				else
				{
					echo json_encode ( $jsonFault );
				}
				break; //ends case 'saveData'
			

			case 'uploadData':
				
				file_put_contents ( 'upload.txt', json_encode ( $_FILES ) );
				$uploaddir = 'uploads/';
				$uploadfile = $uploaddir . basename ( $_FILES [ 'uploadData' ] [ 'name' ] );
				
				$filetempName = $_FILES [ 'uploadData' ] [ 'tmp_name' ];
				
				move_uploaded_file ( $filetempName, $uploaddir );
				
				break; //ends case 'uploadData'
		}
		
		break; //Ends case 'POST'


} //ends $_SERVER['REQUEST_METHOD']


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

 */
?>