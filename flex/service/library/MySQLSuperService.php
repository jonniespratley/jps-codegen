<?php
require_once 'FileSystemService.php';
require_once 'JSONQuery.php';
require_once 'MySQLDump.php';
/**
 * I am a Super MySQL Database Manager Service the structure for the url is as follows:
 
 * </code>
 * 
 * TABLE OF CONTENTS
 * 
 * 1. MYSQL SHOW METHODS
 * 2. PRIVATE DATABASE/TABLE METHODS
 * 3. QUERY BUILDER/CREATE/UPDATE/DELETE METHODS
 * 4. ANALYZE/CHECK/OPTIMIZE/REPAIR METHODS
 * 5. BACKUP/IMPORT/EXPORT METHODS
 * 6. SERVER VARIABLES
 * 7. DATA METHODS
 * 8. UTILITY METHODS
 * 9. CLASS TESTING
 * 
 *
 * @name MySQLService
 * @author  Jonnie Spratley
 * @version 1.0
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
class MySQLSuperService {
	/**
	 * I am the database link
	 *
	 * @var private
	 */
	private $mysqli;
	private $query_pieces = array ();
	private $fileSvc;
	private $jquery;
	private $resultFormat;
	
	/**
	 * I hold alot of access to monitor and manager mysql tables
	 *
	 * @param [string] $host Host name
	 * @param [string] $username User name
	 * @param [string] $password User password
	 * 
	 * @return MySQLService
	 */
	public function MySQLSuperService($host, $username, $password) {
		//temporary for the bs warning signs on live
		// Report simple running errors
		error_reporting ( E_ERROR | E_USER_ERROR | E_PARSE );
		
		//$this->mysqli = new mysqli ( $host, $username, $password );
		

		/* create a connection object which is not connected */
		$this->mysqli = mysqli_init ();
		
		/* set connection options */
		$this->mysqli->options ( MYSQLI_CLIENT_COMPRESS );
		
		$this->mysqli->options ( MYSQLI_OPT_CONNECT_TIMEOUT, 5 );
		
		/* connect to server */
		$this->mysqli->real_connect ( $host, $username, $password );
		
		/* check connection */
		if (mysqli_connect_errno ()) {
			throw new Exception ( 'Database connection failure: Username/Password was incorrect.' );
			exit ();
		}
		
		$this->fileSvc = new FileSystemService ( );
		$this->jquery = new JSONQuery ( $this->mysqli );
	}
	/**
	 * @param $resultFormat the $resultFormat to set
	 */
	public function setResultFormat($resultFormat) {
		$this->resultFormat = $resultFormat;
	}
	
	/**
	 * @return the $resultFormat
	 */
	public function getResultFormat() {
		return $this->resultFormat;
	}
	
	/* ********************************************************************
 * ********************************************************************
 *  
 * 			 				1. MYSQL SHOW METHODS
 *
 * Below is all the methods for getting tables, columns, databases,
 * indexs, statusus from the database.
 * 
 * SHOW DATABASES;
 * SHOW TABLES FROM test;
 * SHOW TABLE STATUS LIKE 'users';
 * SHOW INDEX FROM 'contacts';
 * SHOW INDEX FROM contacts;
 * SHOW COLUMNS FROM contacts;
 * SHOW STATUS FROM test;
 * SHOW TABLE STATUS FROM test;
 * 
 * ********************************************************************
 * *********************************************************************/
	
	/**
	 * I show all of the columns for a specified table.
	 *
	 * @param [string] $whatDatabase the database
	 * @param [string] $whatTable the table
	 * @return [json] Json of all the columns
	 */
	public function getTableColumns($whatDatabase, $whatTable) {
		$sql = "SHOW COLUMNS FROM $whatDatabase.$whatTable";
		
		return $this->_queryToJSON ( $sql );
	}
	
	/**
	 * I get all tables in database
	 *
	 * @param [string] $database the database
	 * @return [json]
	 */
	public function showTableStatus($whatDatabase) {
		$sql = mysqli_query ( $this->mysqli, "SHOW TABLE STATUS FROM $whatDatabase" );
		$tables = array ();
		
		while ( $row = mysqli_fetch_assoc ( $sql ) ) {
			$tables [] = $row;
		}
		return json_encode ( $tables );
	}
	
	/**
	 * I get the primary key for the table.
	 *
	 * @param [string] $database the database
	 * @param [string] $table the table
	 * @return [json]
	 */
	public function getTableIndex($whatDatabase, $whatTable) {
		$sql = "SHOW INDEX FROM $whatDatabase.$whatTable";
		
		return $this->_queryToARRAY ( $sql );
	}
	
	/**
	 * I get all databases, tables, columns, and fields in the database.
	 * Formatted specially for Flex's Tree control.
	 *
	 * @return [json]
	 */
	public function getDatabasesAndTables() {
		//Database query     
		$databaseSQL = mysqli_query ( $this->mysqli, "SHOW DATABASES" );
		
		//New database array
		$databases = array ();
		
		//Loop the query
		while ( $database = mysqli_fetch_assoc ( $databaseSQL ) ) {
			//Create a new array of tables for each database
			$tables = array ();
			
			foreach ( $database as $key => $value ) {
				//Set the table array to get the tbles from the database 
				$tables = $this->_getTables ( $value );
			}
			
			//Add the tables to the database array
			$databases [] = array ("aDatabase" => $value, "aType" => "database", "aData" => $key, "aIcon" => "databaseIcon", "aTables" => $tables );
		}
		sort ( $databases );
		
		//Encode in json
		return json_encode ( $databases );
	}
	
	/**
	 * I get all the databases
	 *
	 * @return [json]
	 */
	public function getDatabases() {
		//Database query     
		$databaseSQL = mysqli_query ( $this->mysqli, "SHOW DATABASES" );
		
		//New database array
		$databases = array ();
		
		//Loop the query
		while ( $database = mysqli_fetch_assoc ( $databaseSQL ) ) {
			//Create a new array of tables for each database
			$tables = array ();
			$status = array ();
			$size = array ();
			foreach ( $database as $key => $value ) {
				//Set the table array to get the tbles from the database 
				$tables = $this->_getTables ( $value );
				$status = $this->_getTableStatus ( $value );
				$size = $this->_getDatabaseSize ( $value );
			}
			
			//Add the tables to the database array
			$databases [] = array ("aDatabase" => $value, "aType" => "database", "aData" => $key, "aIcon" => "databaseIcon", "aTables" => $tables, "aStatus" => $status, "aSize" => $size );
		}
		sort ( $databases );
		
		//Encode in json
		return json_encode ( $databases );
		//return $databases;
	}
	
	/**
	 * I get all tables in the database
	 *
	 * @param [string] $whatDatabase the name of the database
	 * @return [json]
	 */
	public function getTables($whatDatabase) {
		//table query
		$tableSQL = mysqli_query ( $this->mysqli, "SHOW TABLES FROM $whatDatabase" );
		
		//create a new array of tables
		$tables = array ();
		
		//loop all the results
		while ( $table = mysqli_fetch_assoc ( $tableSQL ) ) {
			$fields = array ();
			$indexes = array ();
			$statuss = array ();
			//for each table in the result make an array
			foreach ( $table as $key => $value ) {
				//now descibe each table
				$fields = $this->_describeTable ( $whatDatabase, $value );
				//now get the indexes
				$indexes = $this->_getTableIndexes ( $whatDatabase, $value );
				//now get the status for that table
				$statuss = $this->_getSingleTableStatus ( $whatDatabase, $value );
			}
			//build a tree
			$tables [] = array ("tableName" => $value, "aFields" => $fields, "aIndexes" => $indexes, 'aStatus' => $statuss );
		}
		
		return json_encode ( $tables );
	}
	
	/**
	 * I describe a table
	 *
	 * @param [string] $whatDatabase the database
	 * @param [string] $whatTable the table
	 * @return [json]
	 */
	public function describeTable($whatDatabase, $whatTable) {
		$sql = mysqli_query ( $this->mysqli, "DESCRIBE $whatDatabase.$whatTable" );
		$tables = array ();
		
		while ( $row = mysqli_fetch_assoc ( $sql ) ) {
			$tables [] = array ('Field' => $row ['Field'], 'Type' => $row ['Type'], 'Null' => $row ['Null'], 'Default' => $row ['Default'], 'Extra' => $row ['Extra'], 'Key' => $row ['Key'] );
		}
		sort ( $tables );
		
		return json_encode ( $tables );
	}
	
	/**
	 * I get user information
	 *
	 * @param [string] $username the users name
	 * @return [json]
	 */
	public function getUserInfo($username) {
		$sql = "SELECT * FROM mysql.user_info WHERE User = '$username'";
		$result = mysqli_query ( $this->mysqli, $sql );
		//return $this->_queryToJSON($sql);
		$array = array ();
		
		while ( $row = mysqli_fetch_assoc ( $result ) ) {
			$array [] = array ("User" => $row ['User'], 
					/*"Fullname" => $row[ 'Fullname' ],*/ 
					"Description" => $row ['Description'], "Icon" => base64_encode ( $row ['Icon'] ), "Email" => $row ['Email'], "Info" => $row ['Contact_information'] );
		}
		return json_encode ( $array );
	}
	
	/**
	 * I get all open tables for a database
	 *
	 * @param [string] $whatDatabase the database name
	 * @return [json]
	 */
	public function getOpenTables($whatDatabase) {
		$sql = "SHOW OPEN TABLES FROM $whatDatabase";
		return $this->_queryToJSON ( $sql );
	
	}
	
	/**
	 * I get a count of rows from the table
	 *
	 * @param [string] $whatDatabase the database
	 * @param [string] $whatTable the table
	 * @return [json]
	 */
	public function getTableRows($whatDatabase, $whatTable) {
		return $this->_queryToJSON ( "SELECT COUNT(*) FROM $whatDatabase.$whatTable" );
	}
	
	/* ********************************************************************
 * ********************************************************************
 * 
 * 						2. PRIVATE DATABASE/TABLE METHODS
 * 
 * Below is all the private methods that build up the database 
 * and table tree with information about each item. 
 * 
 * Example:
 * 
 * DatabaseName/
 * 		TableName/
 * 			FieldName/
 * 
 * ********************************************************************
 * ********************************************************************
	
	/**
	 * I get all tables for a database
	 *
	 * @param [string] $whatDatabase the database
	 * @return [array]
	 */
	public function _getTables($whatDatabase) {
		//table query
		$tableSQL = mysqli_query ( $this->mysqli, "SHOW TABLES FROM $whatDatabase" );
		
		//create a new array of tables
		$tables = array ();
		
		//loop all the results
		while ( $table = mysqli_fetch_assoc ( $tableSQL ) ) {
			$fields = array ();
			$statuss = array ();
			$indexes = array ();
			
			//for each table in the result make an array
			foreach ( $table as $t_key => $t_value ) {
				//get the tables fields for each table
				$fields = $this->_describeTable ( $whatDatabase, $t_value );
				
				//now get the primary key for each table
				$primaryKey = $this->_getTableKey ( $whatDatabase, $t_value );
				
				//now get the status for that table
				$statuss = $this->_getSingleTableStatus ( $whatDatabase, $t_value );
				
				//now get the indexes for each table
				$indexes = $this->_getTableIndexes ( $whatDatabase, $t_value );
			
			}
			
			$tables [] = array ("aTable" => $t_value, "aKey" => $primaryKey, "aType" => "table", "aIcon" => "tableIcon", "aData" => $t_key, "aFields" => $fields, "aStatus" => $statuss, "aIndexes" => $indexes );
		}
		//sort ( $tables );
		

		return $tables;
	}
	
	/**
	 * I describe a table for the getDatabasesAndTables() method
	 *
	 * @param [string]  $database the database
	 * @param [string]  $table the table
	 * @return [array]
	 */
	public function _describeTable($whatDatabase, $whatTable) {
		return $this->_queryToARRAY ( "SHOW FIELDS FROM $whatDatabase.$whatTable" );
	}
	
	public function _getTableIndexes($whatDatabase, $whatTable) {
		return $this->_queryToARRAY ( "SHOW INDEX FROM $whatDatabase.$whatTable" );
	}
	
	/**
	 * I get the table status for a table only when called from getDatabases()
	 *
	 * @param [string] $whatDatabase
	 * @return [array]
	 */
	public function _getTableStatus($whatDatabase) {
		return $this->_queryToARRAY ( "SHOW TABLE STATUS FROM $whatDatabase" );
	}
	
	public function _getSingleTableStatus($whatDatabase, $whatTable) {
		return $this->_queryToARRAY ( "SHOW TABLE STATUS FROM $whatDatabase LIKE '$whatTable'" );
	}
	
	/**
	 * I get tables and fields 
	 *
	 * @param [string] $whatDatabase the database
	 * @return [array]
	 */
	private function _getTableAndFields($whatDatabase) {
		$tableInfoSql = mysqli_query ( $this->mysqli, "SHOW TABLE STATUS FROM $whatDatabase" );
		
		$tables = array (); //array of all table info
		$fields = array (); //array of all field info
		

		//get the table name from the result
		while ( $tableInfo = mysqli_fetch_row ( $tableInfoSql ) ) {
			$tables [] = $tableInfo [0];
			
			//loop threw every table inside of the tables array
			foreach ( $tables as $table ) {
				//for each table, get the fields info for that table
				$fields = $this->_showFieldInfo ( $whatDatabase, $table );
			}
			$tableInfoAndFields [] = array ('aTable' => $table, 'aType' => 'table', 'aFields' => $fields );
		}
		$databaseInfoAndTables [] = array ('aDatabase' => $whatDatabase, 'aType' => 'database', 'aTables' => $tableInfoAndFields );
		
		//return $fields;
		//return $databaseInfoAndTables;
		return json_encode ( $databaseInfoAndTables );
	}
	
	private function _getDatabasesTablesAndFields() {
		$databaseInfoSql = mysqli_query ( $this->mysqli, "SHOW DATABASES" );
		
		$databases = array (); //array of all databases info
		$tables = array (); //array of all table info
		$fields = array (); //array of all field info
		

		//get the table name from the result
		while ( $databaseInfo = mysqli_fetch_row ( $databaseInfoSql ) ) {
			
			$databases [] = $databaseInfo [0];
			//loop threw every table inside of the tables array
			foreach ( $databases as $database ) {
				$tables = $this->_showTableInfo ( $database );
				//for each table, get the fields info for that table
				foreach ( $tables as $table ) {
					$fields = $this->_showFieldInfo ( $database, $table );
				}
			}
			
			$tableInfoAndFields [] = array ('aTable' => $table, 'aFields' => $fields );
		}
		
		//return $fields;
		//return $tables;
		return json_encode ( $tableInfoAndFields );
	}
	
	/**
	 * I get information about the table.
	 *
	 * @param [string] $whatDatabase the database
	 * @return [array]
	 */
	private function _showTableInfo($whatDatabase) {
		$tableInfoSql = "SHOW TABLE STATUS FROM $whatDatabase";
		$result = mysqli_query ( $this->mysqli, $tableInfoSql );
		$tableInfo = array ();
		
		while ( $tables = mysqli_fetch_assoc ( $result ) ) {
			$tableInfo [] = $tables;
		}
		return $tableInfo;
	}
	
	/**
	 * I get the fields for a table
	 *
	 * @param [string] $whatDatabase the database
	 * @param [string] $whatTable the table
	 * @return [array]
	 */
	private function _showFieldInfo($whatDatabase, $whatTable) {
		$fieldInfoSql = "SHOW FIELDS FROM $whatDatabase.$whatTable";
		$fieldInfo = array ();
		
		$result = $this->mysqli->query ( $fieldInfoSql );
		
		while ( $fields = mysqli_fetch_assoc ( $result ) ) {
			$fieldInfo [] = $fields;
		}
		return $fieldInfo;
	}
	
	/**
	 * I get the key for the table.
	 *
	 * @param [string] $whatDatabase the database
	 * @param [string] $whatTable the table
	 * @return [string]
	 */
	public function _getTableKey($whatDatabase, $whatTable) {
		$indexInfoSql = "SHOW INDEX FROM $whatDatabase.$whatTable";
		$index = array ();
		
		$result = $this->mysqli->query ( $indexInfoSql );
		
		while ( $indexes = mysqli_fetch_assoc ( $result ) ) {
			if ($indexes ['Key_name'] == 'PRIMARY') {
				$index = $indexes ['Column_name'];
			}
		}
		return $index;
	}
	
	/**
	 * I get the size of all databases in the database
	 *
	 * @return [json]
	 */
	public function getDatabaseSpace() {
		$sql = 'SELECT table_schema "Database",
				sum( data_length + index_length ) / 1024 / 1024  "TotalSize",
				sum( data_length ) / 1024 / 1024  "DataSize",
				sum( index_length ) / 1024 / 1024 "IndexSize",
				sum( data_free ) / 1024 / 1024  "FreeSize"
				FROM information_schema.TABLES
				GROUP BY table_schema';
		
		return $this->_queryToJSON ( $sql );
	}
	
	/**
	 * I get the database size for all tables
	 *
	 * @param [string] $whatDatabase the database name
	 */
	public function _getDatabaseSize($whatDatabase) {
		$statusSQL = mysqli_query ( $this->mysqli, "SHOW TABLE STATUS FROM $whatDatabase" );
		$sizeArray = array ();
		
		$totalSize = 0;
		$dataSize = 0;
		$indexSize = 0;
		
		//loop all the results
		while ( $size = mysqli_fetch_assoc ( $statusSQL ) ) {
			$dataSize += $size ['Data_length'];
			$indexSize += $size ['Index_length'];
		}
		$totalSize = $dataSize + $indexSize;
		$sizeArray [] = array ('totalSize' => $totalSize, 'dataSize' => $dataSize, 'indexSize' => $indexSize );
		
		return $sizeArray;
	}
	
	/* ********************************************************************
 * ********************************************************************
 *  
 *  			3. QUERY BUILDER/CREATE/UPDATE/DELETE METHODS
 * 
 * Below is all the methods for building insert queries, creating
 * databases, creating tables, creating users, removing data,
 * inserting data, and updating data.
 * Also there is methods for altering databases, and tables.
 * 
 * ********************************************************************
 * *********************************************************************/
	
	/**
	 * I create a database
	 *
	 * @param [string] $whatDatabase the name of the database
	 * @return [string] the result outcome
	 */
	public function createDatabase($whatDatabase) {
		//CREATE DATABASE `tutorial_library` 
		//DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
		$sql = "CREATE SCHEMA IF NOT EXISTS $whatDatabase
				CHARACTER SET utf8";
		$result = mysqli_query ( $this->mysqli, $sql );
		
		if (! $result) {
			return 'There was an error creating the database.';
		}
		return 'Database created!';
	}
	
	/**
	 * I create a table
	 *
	 * @param [string] $whatDatabase the database
	 * @param [string] $whatTable the name of the new table
	 * @return [string] the result
	 */
	public function createTable($whatDatabase, $whatTable) {
		/**
		 * CREATE TABLE `books` ( id int ) DEFAULT CHARACTER SET latin1;
		 * 
		 */
		$sql = "CREATE TABLE $whatDatabase.$whatTable ( id int ) DEFAULT CHARACTER SET latin1";
		$this->_LOG('create table', $sql);
		$result = mysqli_query ( $this->mysqli, $sql );
		
		if (! $result) {
			return false;
		}
		return true;
	}
	
	/**
	 * I alter a database table
	 *
	 * @param [string] $whatDatabase the database
	 * @param [string] $whatTable the name of the new table
	 * @param [string] $whatQuery a query array of what to change
	 * @return [string] the result
	 */
	public function alterTable($whatDatabase, $whatTable, $whatQuery) {
		/**
		 *  ALTER TABLE `cars` ADD `engine` varchar(225) DEFAULT NULL ;
		 */
		$sql = "ALTER TABLE $whatDatabase.$whatTable ADD $whatQuery";
		$this->_LOG('alter table', $sql);
		$result = mysqli_query ( $this->mysqli, $sql );
		
		if (! $result) {
			return false;
		}
		return true;
	}
	
	/**
	 * I remove a table
	 *
	 * @param [string] $whatDatabase the database
	 * @param [string] $whatTable the table
	 * @return [string] the result
	 */
	public function removeTable($whatDatabase, $whatTable) {
		/**
		 *   DROP TABLE `library`;
		 */
		$sql = "DROP TABLE $whatDatabase.$whatTable";
		$this->_LOG('remove table', $sql);
		$result = mysqli_query ( $this->mysqli, $sql );
		
		if (! $result) {
			return false;
		}
		return true;
	}
	
	/**
	 * I rename a table
	 *
	 * @param [string] $whatDatabase the database
	 * @param [string] $whatTable the table
	 * @param [string] $newName the new name
	 * @return [string] the result
	 */
	public function renameTable($whatDatabase, $whatTable, $newName) {
		/**
		 *   RENAME TABLE test.books TO test.the_books
			ALTER TABLE `test`.`posts` RENAME `userposts`
		 */
		$sql = "ALTER TABLE `$whatDatabase`.`$whatTable` RENAME `$newName`";
		
		$this->_LOG('rename table', $sql);
		$result = mysqli_query ( $this->mysqli, $sql );
		if ( $result) {
			return true;
		}
		return false;
	}
	
	/**
	 * I insert data into the database
	 * 
	 * 
	 * 
	 * @param [string] $whatDatabase the database
	 * @param [string] $whatTable the table
	 * @param [array] $whatQuery Array of Key/Value pairs for inserting in the database
	 * @return [string] the result
	 */
	public function insertRecord($jsonQuery) {
		return $this->jquery->buildQuery ( $jsonQuery, 'INSERT', true );
		//$queryArray[] = $this->jquery->buildQuery ( $jsonQuery, 'INSERT', false );
	}
	
	/**
	 * I update data from the database
	 * UPDATE db.tbl SET name='value'
	 * 
	 *
	 * @param [string] $jsonQuery Array of Key/Value pairs for updating the database
	 * @return [string] the result
	 */
	public function updateRecord($jsonQuery) {
		return $this->jquery->buildQuery ( $jsonQuery, 'UPDATE', true );
	}
	
	/**
	 * I remove data from the database
	 *
	 * @param [array] $jsonQuery the value to which remove by
	 * @return [string] the result
	 */
	public function removeRecord($jsonQuery) {
		return $this->jquery->buildQuery ( $jsonQuery, 'DELETE', true );
	}
	
	/** *******************************************************************
	 * ********************************************************************
	 *  
	 * 	 			4. ANALYZE/CHECK/OPTIMIZE/REPAIR METHODS
	 * 
	 * Below is all the methods analyzing, checking, optimizing and repairing
	 * database tables.
	 * 
	 * ********************************************************************
	 * *********************************************************************/
	
	/**
	 * I analyze a table
	 *
	 * @param [string] $whatDatabase the database
	 * @param [string] $whatTable the table
	 * @return [json]
	 */
	public function analyzeTable($whatDatabase, $whatTable) {
		$sql = "ANALYZE TABLE $whatDatabase.$whatTable";
		
		return $this->_queryToJSON ( $sql );
	}
	
	/**
	 * I check a table
	 *
	 * @param [string] $whatDatabase the database
	 * @param [string] $whatTable the table
	 * @return [json]
	 */
	public function checkTable($whatDatabase, $whatTable) {
		$sql = "CHECK TABLE $whatDatabase.$whatTable";
		
		return $this->_queryToJSON ( $sql );
	}
	
	/**
	 * I optimize a table
	 *
	 * @param [string] $whatDatabase the database
	 * @param [string] $whatTable the table
	 * @return [json]
	 */
	public function optimizeTable($whatDatabase, $whatTable) {
		$sql = "OPTIMIZE TABLE $whatDatabase.$whatTable";
		
		return $this->_queryToJSON ( $sql );
	}
	
	/**
	 * I repair a table
	 *
	 * @param [string] $whatDatabase the database
	 * @param [string] $whatTable the table
	 * @return [json]
	 */
	public function repairTable($whatDatabase, $whatTable) {
		$sql = "REPAIR TABLE $whatDatabase.$whatTable";
		
		return $this->_queryToJSON ( $sql );
	}
	
	/**
	 * I analyze a query are return the statistics
	 *
	 * @param [string] $sql query string
	 * @return [json] json results
	 */
	public function analyzeQuery($sql) {
		$setProfileSQL = $this->mysqli->query ( 'SET profiling = 1' );
		$analyzeSQL = $this->mysqli->query ( $sql );
		$showProfileSQL = $this->mysqli->query ( 'SHOW PROFILE' );
		$showProfilesSQL = $this->mysqli->query ( 'SHOW PROFILES' );
		
		$resultArray = array ();
		$profileArray = array ();
		$profilesArray = array ();
		
		/* fetch associative array */
		while ( $row1 = $analyzeSQL->fetch_assoc () ) {
			$resultArray [] = $row1;
		}
		
		/* fetch associative array */
		while ( $row2 = $showProfileSQL->fetch_assoc () ) {
			$profileArray [] = $row2;
		}
		
		/* fetch associative array */
		while ( $row3 = $showProfilesSQL->fetch_assoc () ) {
			$profilesArray [] = $row3;
		}
		
		$analyzedQuery [] = array ('aProfile' => $profileArray, 'aProfiles' => $profilesArray, 'aResults' => $resultArray );
		//$analyzedQuery[] = array( $profileArray, $profilesArray, $resultArray );
		

		/* Free all of the results */
		$analyzeSQL->close ();
		$showProfileSQL->close ();
		$showProfilesSQL->close ();
		
		/* close connection */
		//$this->mysqli->close ();
		

		return json_encode ( $analyzedQuery );
		//return $analyzedQuery;
	}
	
	/** *******************************************************************
	 * ********************************************************************
	 *  
	 * 	 					5. BACKUP/IMPORT/EXPORT METHODS
	 * 
	 * Below is all the methods for backing up the database, importing data,
	 * exporting data.
	 * 
	 * ********************************************************************
	 * *********************************************************************/
	/**
	 * I execute a query and return XML
	 *
	 * @param [string] $query the query 
	 * @return [xml]
	 */
	public function queryResultToXML($query) {
		$xmlResult = '<?xml version="1.0"?>';
		
		/* Set the content type for the browser */
		
		//table query
		$sql = mysqli_query ( $this->mysqli, "$query" );
		
		$xmlResult .= "<results>";
		
		//loop all the results
		while ( $rows = mysqli_fetch_assoc ( $sql ) ) {
			$xmlResult .= "<result>";
			//for each table in the result make an array
			foreach ( $rows as $key => $value ) {
				$xmlResult .= "<$key>" . htmlspecialchars ( $value ) . "</$key>";
			}
			$xmlResult .= "</result>";
		}
		$xmlResult .= "</results>";
		
		return $xmlResult;
	}
	
	/**
	 * I execute a query and return JSON
	 *
	 * @param [string] $query the query
	 * @return [json]
	 */
	private function queryResultToJSON($query) {
		return $this->_queryToJSON ( $query );
	}
	
	/**
	 * I execute a query and return json
	 *
	 * @param [string] $whatDatabase the database
	 * @param [string] $whatTable the table
	 * @return [json]
	 */
	public function exportToJSON($whatDatabase, $whatTable) {
		$sql = "SELECRT * FROM $whatDatabase.$whatTable";
		
		return $this->_queryToJSON ( $sql );
	}
	
	/**
	 * I export data from the database
	 *
	 * @param [string] $whatDatabase
	 * @param [string] $whatTable
	 * @param [string all, db_structure, db_data, tbl_structure, tbl_data ] $whatMode 
	 * @return [string] the filename of the file.
	 */
	public function createBackup($whatDatabase, $whatTable, $whatMode) {
		
		$result = '';
		$filename = $whatDatabase . '-' . $whatTable . '-' . $whatMode . '-' . $this->makeTimestamp () . '.sql';
		
		//$dbDir = mkdir( "backups/".$whatDatabase );
		

		//Set the database, filename, and we don't want to use compression.
		$dumper = new MySQLDump ( $whatDatabase, "../backups/" . $filename, false );
		$mode = $whatMode;
		
		//Switch based on what mode is specified
		switch ($mode) {
			case 'all' :
				$dumper->doDump ();
				$result = 'Dumping all data';
				return true;
				break;
			
			case 'db_structure' :
				$dumper->getDatabaseStructure ();
				$result = 'Database structure backed up successfully.';
				$resultArray [] = array ('mode' => $mode, 'result' => $result, 'filename' => $filename );
				return $resultArray;
				break;
			
			case 'db_data' :
				$dumper->getDatabaseData ( false );
				$result = 'Database data backed up successfully.';
				$resultArray [] = array ('mode' => $mode, 'result' => $result, 'filename' => $filename );
				return $resultArray;
				break;
			
			case 'tbl_structure' :
				$dumper->getTableStructure ( $whatTable );
				$result = 'Table structure backed up successfully.';
				$resultArray [] = array ('mode' => $mode, 'result' => $result, 'filename' => $filename );
				return $resultArray;
				break;
			
			case 'tbl_data' :
				$dumper->getTableData ( $whatTable, false );
				$result = 'Table data backed up successfully.';
				$resultArray [] = array ('mode' => $mode, 'result' => $result, 'filename' => $filename );
				return $resultArray;
				break;
			
			default :
				$result = 'Please specify a mode.';
				$resultArray [] = array ('mode' => $mode, 'result' => $result, 'filename' => $filename );
				return $resultArray;
				break;
		}
		return $result;
	}
	
	/**
	 * I get a list of all the backups in the backup folder
	 *
	 * @return [json]
	 */
	public function getDatabaseBackups() {
		return $this->fileSvc->browseDirectory ( './backups', 'json' );
	}
	
	public function removeBackup($whatDatabase, $whatFile) {
		return $this->fileSvc->removeFile ( './backups', $whatFile );
	}
	
	/** *******************************************************************
	 * ********************************************************************
	 * 
	 * 						6. SERVER VARIABLES
	 * 
	 * Below is all the methods that build up information about the server
	 * and system.
	 * 
	 * 
	 * ********************************************************************
	 * ********************************************************************/
	
	/**
	 * I kill a thread that is connected or running
	 *
	 * @param [int] $whatThread the id of the thread
	 * @return [boolean] true or false
	 */
	public function killProcess($whatThread) {
		$sql = "KILL $whatThread";
		$message = '';
		
		if (mysqli_query ( $this->mysqli, $sql )) {
			$message = array ('message' => true, 'thread' => $whatThread );
		} else {
			$message = array ('message' => false, 'thread' => $whatThread );
		}
		return json_encode ( $message );
	}
	
	/**
	 * I show all mysql system variables
	 *
	 * @return [json]
	 */
	public function showSystemVariables() {
		return $this->_queryStatusToJSON ( "SHOW GLOBAL VARIABLES" );
	}
	
	/**
	 * I show all system privileges
	 *
	 * @return [json]
	 */
	public function showSystemPrivileges() {
		return $this->_queryToJSON ( "SHOW PRIVILEGES" );
	}
	
	/**
	 * I show the system status
	 *
	 * @return [json]
	 */
	public function showSystemStatus() {
		return $this->_queryStatusToJSON ( "SHOW GLOBAL STATUS" );
	}
	
	/**
	 * I show system processes
	 *
	 * @return [json]
	 */
	public function showSystemProcess() {
		return $this->_queryStatusToJSON ( "SHOW FULL PROCESSLIST" );
	}
	
	/**
	 * I show all of the systems users
	 *
	 * @return [json]
	 */
	public function showSystemUsers() {
		return $this->_queryToJSON ( "SELECT * FROM mysql.user" );
	}
	
	/**
	 * I get server info
	 *
	 * @return [json]
	 */
	public function _getServerInfo() {
		$serverArray = array ();
		$aPath = $_SERVER ['DOCUMENT_ROOT'];
		
		$serverArray [] = array (

		'aDiskFreeSpace' => disk_free_space ( $aPath ), 'aDiskTotalSize' => disk_total_space ( $aPath ), 'aServerSoftware' => $_SERVER ['SERVER_SOFTWARE'], 'aServerName' => $_SERVER ['SERVER_NAME'], 'aPHPVersion' => PHP_VERSION, 'aPHPOs' => PHP_OS, 'aPHPExtensionDir' => PHP_EXTENSION_DIR, 'aMySQLClientV' => mysqli_get_client_info ( $this->mysqli ), 'aMySQLServerV' => mysqli_get_server_version ( $this->mysqli ), 'aMySQLHost' => mysqli_get_host_info ( $this->mysqli ), 'aMySQLProtocol' => mysqli_get_proto_info ( $this->mysqli ), 'aUptime' => $this->_getUptime () );
		
		return json_encode ( $serverArray );
	}
	
	/**
	 * I get all of the threads
	 *
	 * @return [json]
	 */
	public function _getThreads() {
		return $this->_queryStatusToJSON ( "SHOW STATUS LIKE '%Threads%'" );
	}
	
	/**
	 * I get the temp size
	 *
	 * @return [json]
	 */
	public function _getTemp() {
		return $this->_queryStatusToJSON ( "SHOW STATUS LIKE '%tmp%'" );
	}
	
	/**
	 * I get open tables
	 *
	 * @return [json]
	 */
	public function _getOpen() {
		return $this->_queryStatusToJSON ( "SHOW STATUS LIKE '%Open%'" );
	}
	
	/**
	 * I get the handlers variables
	 *
	 * @return [json]
	 */
	public function _getHandlers() {
		return $this->_queryStatusToJSON ( "SHOW STATUS LIKE '%Handler%'" );
	}
	
	/**
	 * I get the server uptime
	 *
	 * @return [array]
	 */
	public function _getUptime() {
		$result = mysqli_query ( $this->mysqli, "SHOW STATUS LIKE '%uptime%'" );
		$row = mysqli_fetch_row ( $result );
		$array = $this->_formatUptime ( $row [1] );
		
		return $array;
	}
	
	private function _getUnixTimestamp($unix) {
		return $this->_queryToARRAY ( "SELECT UNIX_TIMESTAMP() - $unix" );
	}
	
	/**
	 * I get the recent queries
	 *
	 * @return [json]
	 */
	public function _getQuestions() {
		return $this->_queryStatusToJSON ( "SHOW STATUS LIKE 'Questions%'" );
	}
	
	/**
	 * I get the query cache
	 *
	 * @return [json]
	 */
	public function _getQcache() {
		return $this->_queryStatusToJSON ( "SHOW STATUS LIKE '%Qcache%'" );
	}
	
	/**
	 * I get InnoDB
	 *
	 * @return [json]
	 */
	public function _getInnoDb() {
		return $this->_queryStatusToJSON ( "SHOW STATUS LIKE '%Innodb%'" );
	}
	
	/**
	 * I get the key cache
	 *
	 * @return [json]
	 */
	public function _getKeys() {
		return $this->_queryStatusToJSON ( "SHOW STATUS LIKE '%Key%'" );
	}
	
	/**
	 * I get the performance of mysql.
	 *
	 * @return [json]
	 */
	public function _getPerformance() {
		return $this->_queryStatusToJSON ( "SHOW STATUS LIKE '%Slow%'" );
	}
	
	/**
	 * I get all the sort
	 *
	 * @return [json]
	 */
	public function _getSort() {
		return $this->_queryStatusToJSON ( "SHOW STATUS LIKE '%Sort%'" );
	}
	
	/**
	 * I get the connections
	 *
	 * @return [json]
	 */
	public function _getConnections() {
		return $this->_queryStatusToJSON ( "SHOW STATUS LIKE '%Connections%'" );
	}
	
	/**
	 * I get the aborted clients and connections
	 *
	 * @return unknown
	 */
	public function _getClients() {
		return $this->_queryStatusToJSON ( "SHOW STATUS LIKE '%Aborted%'" );
	}
	
	/**
	 * I get mysql bytes
	 *
	 * @return [json]
	 */
	public function _getBytes() {
		return $this->_queryStatusToJSON ( "SHOW STATUS LIKE '%Bytes%'" );
	}
	
	/**
	 * I get all the slave hosts
	 *
	 * @return [json]
	 */
	public function _getReplication() {
		return $this->_queryStatusToJSON ( "SHOW STATUS LIKE '%Slave%'" );
	}
	
	/**
	 * I get the commands
	 *
	 * @return [json]
	 */
	public function _getCommands() {
		return $this->_queryStatusToJSON ( "SHOW STATUS LIKE '%Com%'" );
	}
	
	/**
	 * I show all of the SHOW commands
	 *
	 * @return [json]
	 */
	public function _getShowCommands() {
		return $this->_queryStatusToJSON ( "SHOW STATUS LIKE '%Com_show%'" );
	}
	
	/**
	 * I get the stats of the mysql connection
	 *
	 * @return [array]
	 */
	public function _getStat() {
		$stats = $this->mysqli->stat ();
		$newStats = explode ( ' ', $stats );
		
		return $newStats;
	}
	
	/* ********************************************************************
 * ********************************************************************
 * 
 * 						7. POLLING METHODS
 * 
 * Below is all the methods for executing a query on the database, 
 * and getting all records from the database.
 * 
 * ********************************************************************
 * ********************************************************************/
	
	/**
	 * I get the health of a mysql server
	 *
	 * @return [array] of results
	 */
	public function _getHealth() {
		$query = $this->mysqli->query ( "SHOW GLOBAL STATUS LIKE '%Key_%'" );
		$array = array ();
		
		while ( $row = mysqli_fetch_assoc ( $query ) ) {
			$array [$row ['Variable_name']] = array ($row ['Variable_name'] => $row ['Value'] );
		}
		
		return $array;
	}
	
	/**
	 * I am a polling method for checking the current select statements.
	 * @example Results
	 * <code>
	 * [
	 *	   {
	 *	      "Threads_cached":"0",
	 *	      "aTimestamp":"2009-02-20T21:52:34-08:00"
	 *	   },
	 *	   {
	 *	      "Threads_connected":"1",
	 *	      "aTimestamp":"2009-02-20T21:52:34-08:00"
	 *	   },
	 *	   {
	 *	      "Threads_created":"2070",
	 *	      "aTimestamp":"2009-02-20T21:52:34-08:00"
	 *	   },
	 *	   {
	 *	      "Threads_running":"1",
	 *	      "aTimestamp":"2009-02-20T21:52:34-08:00"
	 *	   }
	 *	]
	 *</code> 
	 * @return [json] encoded results
	 */
	public function pollQueries() {
		$result = mysqli_query ( $this->mysqli, "SHOW GLOBAL STATUS LIKE '%Com_select%'" );
		$timestamp = date ( DATE_W3C );
		
		while ( $row = mysqli_fetch_row ( $result ) ) {
			$array [] = array ($row [0] => $row [1], 'aTimestamp' => $timestamp );
		}
		return json_encode ( $array );
	}
	
	/**
	 * I am a polling method for checking the current bytes sent.
	 * @example Results
	 * <code>
	 * [
	 * 	  {
	 * 		"Bytes_sent":"48438",
	 * 		"aTimestamp":"2009-02-20T21:52:34-08:00"
	 *	  }
	 * ]
	 *</code> 
	 * @return [json] encoded results
	 */
	public function pollTraffic() {
		$result = mysqli_query ( $this->mysqli, "SHOW GLOBAL STATUS LIKE '%Bytes_sent%'" );
		$timestamp = date ( DATE_W3C );
		
		while ( $row = mysqli_fetch_row ( $result ) ) {
			$array [] = array ($row [0] => $row [1], 'aTimestamp' => $timestamp );
		}
		return json_encode ( $array );
	}
	
	/**
	 * I am a polling method for checking the current connections.
	 * @example Results
	 * <code>
	 * [
	 * 	  {
	 * 		"Com_select":"97",
	 * 		"aTimestamp":"2009-02-20T21:52:34-08:00"
	 *	  }
	 * ]
	 *</code> 
	 * 
	 * @return [json] encoded results
	 */
	public function pollConnections() {
		$result = mysqli_query ( $this->mysqli, "SHOW GLOBAL STATUS LIKE '%Threads_%'" );
		$timestamp = array ('aTimestamp' => date ( DATE_W3C ) );
		$array = array ();
		while ( $row = mysqli_fetch_row ( $result ) ) {
			$array = array ($row [0] => $row [1] );
			//array_push( $array, array( $row[0] => $row[1] ) );	
		}
		//$a[] = array_merge( $timestamp, $array );
		//return $a;
		return json_encode ( $array );
	}
	
	/* ********************************************************************
 * ********************************************************************
 * 
 * 						8. DATA METHODS
 * 
 * Below is all the methods for executing a query on the database, 
 * and getting all records from the database.
 * 
 * ********************************************************************
 * ********************************************************************/
	
	/**
	 * I get all the table data
	 *
	 * @param [string] $whatDatabase the database
	 * @param [string] $whatTable the table
	 * @return [json]
	 */
	public function getTableData($whatDatabase, $whatTable) {
		$sql = "SELECT * FROM $whatDatabase.$whatTable";
		
		return $this->_queryToJSON ( $sql );
	}
	
	/**
	 * I execute a query
	 *
	 * @param [string] $query the query to execute
	 * @return [json]
	 */
	public function executeQuery($sql) {
		$query = mysqli_escape_string ( $this->mysqli, $sql );
		return $this->_queryToJSON ( $query );
	}
	
	/* ********************************************************************
* ********************************************************************
* 
* 						9. RESULT HANDLERS
* 
* ********************************************************************
* ********************************************************************/
	
	/**
	 * I execute a query and return the results as json.
	 *
	 * @param [string] $sql the query to be executed
	 * @return [json] the result in json
	 */
	private function _queryToJSON($sql) {
		$result = mysqli_query ( $this->mysqli, $sql );
		
		while ( $row = mysqli_fetch_assoc ( $result ) ) {
			$array [] = $row;
		}
		//$this->dumpIt( $sql );
		
		$this->_LOG('sql', $sql);

		return json_encode ( $array );
	}
	
	/**
	 * I execute a query and return the result as an array.
	 *
	 * @param [string] $sql the query to be executed
	 * @return [array] the result array
	 */
	private function _queryToARRAY($sql) {
		$query = mysqli_query ( $this->mysqli, $sql );
		$array = array ();
		
		while ( $row = mysqli_fetch_assoc ( $query ) ) {
			$array [] = $row;
		}
		
		//$this->dumpIt( $sql );
		$this->_LOG('sql', $sql);

		return $array;
	}
	
	/**
	 * I execute a query and return the result as an array.
	 *
	 * @param [string] $sql the query to be executed
	 * @return [array] the result array
	 */
	private function _query($sql) {
		if ($this->getResultFormat () == 'json') {
			return $this->_queryToJSON ( $sql );
		} else {
			return $this->_queryToARRAY ( $sql );
		}
	}
	
	/**
	 * I get the query status
	 *
	 * @param [string] $sql
	 * @return [json] mysql status with the ('_') striped out
	 */
	private function _queryStatusToJSON($sql) {
		$result = mysqli_query ( $this->mysqli, $sql );
		
		while ( $row = mysqli_fetch_assoc ( $result ) ) {
			//replace some of the names
			$row = str_replace ( 'Com_', '', $row );
			//take out the _ of the rows
			$row = str_replace ( '_', ' ', $row );
			
			$array [] = $row;
		}
		sort ( $array );
		
		//$this->dumpIt( $sql );
		$this->_LOG('sql', $sql);

		return json_encode ( $array );
	}
	
	/** *******************************************************************
	 * ********************************************************************
	 * 
	 * 						10. UTILITY METHODS
	 * 
	 * Below is all the utility methods for handling the results from a query
	 * and dumping variables or creating timestamps
	 * 
	 * 
	 * ********************************************************************
	 * ********************************************************************/
	
	/**
	 * I ping mysql for a connection
	 *
	 * @return true or false
	 */
	public function ping() {
		$msg = '';
		/* check if server is alive */
		if ($this->mysqli->ping ()) {
			$msg = true;
		} else {
			$msg = false;
		}
		return $msg;
	}
	
	/**
	 * I get help from the mysql database
	 *
	 * @return [json]
	 */
	public function getHelp() {
		$sql = 'SELECT help_keyword.name, 
					   help_topic.name, 
					   help_topic.description, 
					   help_category.name AS AVG_help_category_name, 
					   help_category.url, 
					   help_topic.example, 
					   help_topic.url
					FROM mysql.help_keyword 
						INNER JOIN mysql.help_relation 
							ON help_keyword.help_keyword_id = help_relation.help_keyword_id
						INNER JOIN mysql.help_topic 
							ON help_topic.help_topic_id = help_relation.help_topic_id
						INNER JOIN mysql.help_category 
							ON help_topic.help_category_id = help_category.help_category_id';
		return $this->_queryToJSON ( $sql );
	}
	
	/**
	 * I format debug dumps
	 *
	 * @param [var] the variable you with to dump
	 */
	public function dumpIt($var) {
		print "<pre>\n";
		print_r ( $var );
		print "</pre>\n";
	}
	
	/**
	 * I make a formatted timestamp.
	 * <code> 
	 * 2008-12-30 22:40:00
	 * </code>
	 *
	 * @return [string] a timestamp
	 */
	private function makeTimestamp() {
		$time = time ();
		
		return date ( 'm-d-Y-H-i', $time );
	}
	
	/**
	 * I format uptime from MySQL
	 *
	 * @param [int] $time the old time
	 * @return [string] the new time
	 */
	private function _formatUptime($time = 0) {
		$days = ( int ) floor ( $time / 86400 );
		$hours = ( int ) floor ( $time / 3600 ) % 24;
		$minutes = ( int ) floor ( $time / 60 ) % 60;
		
		if ($days == 1) {
			$uptime = "$days day, ";
		} else if ($days > 1) {
			$uptime = "$days days, ";
		}
		if ($hours == 1) {
			$uptime .= "$hours hour";
		} else if ($hours > 1) {
			$uptime .= "$hours hours";
		}
		if ($uptime && $minutes > 0 && $seconds > 0) {
			$uptime .= ", ";
		} else if ($uptime && $minutes > 0 & $seconds == 0) {
			$uptime .= " and ";
		}
		($minutes > 0) ? $uptime .= "$minutes minute" . (($minutes > 1) ? "s" : NULL) : NULL;
		
		return $uptime;
	}
	
	/**
	 * I try and throw an error.
	 *
	 * @param [string] $msg the message of the mess
	 * @param [string] $type the type of error
	 * @return error
	 */
	private function _throwError($msg, $type) {
		switch ($type) {
			case 'user' :
				throw ErrorException ();
				break;
			
			case 'error' :
				return trigger_error ( $msg, E_ERROR );
				break;
			
			case 'other' :
				return trigger_error ( $msg, E_USER_ERROR );
				break;
		}
		return trigger_error ( $msg, E_USER_ERROR );
	}

  private function _LOG($type, $var) {
    
        //write to log file
        $file = 'mysqlsuperservice.log';
        
        //append to end of content in log fil
        $fp = fopen($file, "a+");
        
        //Date [Sat Jul 11 02:04:15 2009] [error] [client 127.0.0.1]
        $date = date('[D M j Y H:i:s] ', mktime());
        
        $contents = "\n".$date.'['.$type.'] '.$var;
        
        fwrite($fp, $contents);
        
        fclose($fp);
    }
    
}


$service = new MySQLSuperService('localhost', 'root', 'fred');
$db = 'test';
$tbl = 'tags';

//$service->alterTable($database, $table, 'ADD i INT FIRST');
print_r( $service->renameTable($db, $tbl, 'post_tags' ) );






?>