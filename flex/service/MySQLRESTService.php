<?php
/**
 * 
 * @name MySQLRESTService
 * @author  Jonnie Spratley
 * @version 1.0
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License 
 * 
 */
//echo header('Content-type: application/x-json');
require_once 'library/MySQLSuperService.php';
require_once 'library/FileSystemService.php';

$f = new FileSystemService ( );

error_reporting ( E_ERROR | E_USER_ERROR | E_PARSE );

if ( isset ( $_REQUEST[ 'h' ] ) )
{
	$host = $_REQUEST[ 'h' ]; //Host
}

if ( isset ( $_REQUEST[ 'u' ] ) )
{
	$user = $_REQUEST[ 'u' ]; //User
}

if ( isset ( $_REQUEST[ 'p' ] ) )
{
	$pass = $_REQUEST[ 'p' ]; //Password
}
if ( isset ( $_REQUEST[ 'm' ] ) )
{
	$mode = $_REQUEST[ 'm' ]; //Mode
}

if ( isset ( $_REQUEST[ 'd' ] ) )
{
	$database = $_REQUEST[ 'd' ]; //Database
}

if ( isset ( $_REQUEST[ 't' ] ) )
{
	$table = $_REQUEST[ 't' ]; //Table
}

if ( isset ( $_REQUEST[ 'q' ] ) )
{
	$query = $_REQUEST[ 'q' ]; //Query
}

//$user = $_REQUEST[ 'u' ]; //Username	
//$pass = $_REQUEST[ 'p' ]; //Password	
//$database = $_REQUEST[ 'd' ]; //Database	
//$table = $_REQUEST[ 't' ]; //Table	
//$mode = $_REQUEST[ 'm' ]; //Mode
//$query = $_REQUEST[ 'q' ]; //Query

$service = new MySQLSuperService ( $host, $user, $pass );

//Switch depending on mode
switch ( $mode )
{
	case 'ping' :
		$db = $service->ping ();
		echo $db;
		break;
	
	/*********************************************
	 * ANALYZE/OPTIMIZE/CHECK/REPAIR TABLES
	 *********************************************/
	case 'analyzeTable' :
		$db = $service->analyzeTable ( $database, $table );
		echo $db;
		break;
	case 'optimizeTable' :
		$db = $service->optimizeTable ( $database, $table );
		echo $db;
		break;
	case 'checkTable' :
		$db = $service->checkTable ( $database, $table );
		echo $db;
		break;
	case 'repairTable' :
		$db = $service->repairTable ( $database, $table );
		echo $db;
		break;
	
	/*********************************************
	 * CREATE DATEBASE/TABLE/USER
	 *********************************************/
	case 'createDatabase' :
		$db = $service->createDatabase ( $database );
		echo $db;
		break;
	case 'createTable' :
		$db = $service->createTable ( $database, $table );
		echo $db;
		break;
	
	case 'alterTable' :
		$db = $service->alterTable ( $database, $table, $query );
		echo $db;
		break;
	
	case 'removeTable' :
		$db = $service->removeTable ( $database, $query );
		echo $db;
		break;
	
	case 'renameTable' :
		$db = $service->renameTable ( $database, $table, $query );
		echo $db;
		break;
	
	//	case 'createUser' :
	//		$db = $service->createUser ( $user );
	//		echo $db;
	//		break;
	

	/*********************************************
	 * INSERT/UPDATE/REMOVE DATA
	 *********************************************/
	case 'insertRecord' :
		$insert = $service->insertRecord ( $query );
		echo $insert;
		break;
	case 'updateRecord' :
		$update = $service->updateRecord ( $query );
		echo $update;
		break;
	case 'removeRecord' :
		$remove = $service->removeRecord ( $query );
		echo $remove;
		break;
	
	/*********************************************
	 * DATABASE/TABLE/FIELD INFO
	 *********************************************/
	case 'describeTable' :
		$db = $service->describeTable ( $database, $table );
		echo $db;
		break;
	case 'getTableColumns' :
		$db = $service->getTableColumns ( $database, $table );
		echo $db;
		break;
	case 'getDatabases' :
		$db = $service->getDatabases ();
		echo $db;
		break;
	case 'getDatabasesAndTables' :
		$db = $service->getDatabasesAndTables ();
		echo $db;
		break;
	case 'getTableIndex' :
		$db = $service->getTableIndex ( $database, $table );
		echo $db;
		break;
	case 'getTables' :
		$db = $service->_getTableAndFields ( $database );
		echo $db;
		break;
	case 'getServerInfo' :
		$db = $service->_getServerInfo ();
		echo $db;
		break;
	case 'getTableData' :
		$db = $service->getTableData ( $database, $table );
		echo $db;
		break;
	case 'getUserInfo' :
		$db = $service->getUserInfo ( $query );
		echo $db;
		break;
	
	/*********************************************
	 * EXECUTE QUERY/ RESULT XML/JSON
	 *********************************************/
	case 'executeQuery' :
		$db = $service->executeQuery ( $query );
		echo $db;
		break;
	case 'explainQuery' :
		$db = $service->executeQuery ( "EXPLAIN $query" );
		echo $db;
		break;
	
	case 'executeQueryToXML' :
		header ( "Content-type: text/xml" );
		$db = $service->exportToXML ( $database, $table );
		echo $db;
		break;
	case 'exportToJSON' :
		$db = $service->exportToJSON ( $database, $table );
		echo $db;
		break;
	
	/*********************************************
	 * MYSQL STATS
	 *********************************************/
	case 'getBytes' : //check
		$db = $service->_getBytes ();
		echo $db;
		break;
	case 'getCommands' : //check
		$db = $service->_getCommands ();
		echo $db;
		break;
	case 'getConnections' : //check
		$db = $service->_getConnections ();
		echo $db;
		break;
	case 'getInnoDb' : //check
		$db = $service->_getInnoDb ();
		echo $db;
		break;
	case 'getKeys' : //check
		$db = $service->_getKeys ();
		echo $db;
		break;
	case 'getOpen' : //check
		$db = $service->_getOpen ();
		echo $db;
		break;
	case 'getPerformance' : //check
		$db = $service->_getPerformance ();
		echo $db;
		break;
	case 'getQcache' : //check
		$db = $service->_getQcache ();
		echo $db;
		break;
	case 'getShowCommands' : //check
		$db = $service->_getShowCommands ();
		echo $db;
		break;
	case 'getSort' : //check
		$db = $service->_getSort ();
		echo $db;
		break;
	case 'getTemp' : //check
		$db = $service->_getTemp ();
		echo $db;
		break;
	case 'getThreads' : //check
		$db = $service->_getThreads ();
		echo $db;
		break;
	case 'getReplication' : //check
		$db = $service->_getReplication ();
		echo $db;
		break;
	case 'getQuestions' : //check
		$db = $service->_getQuestions ();
		echo $db;
		break;
	case 'getUptime' : //check
		$db = $service->_getUptime();
		echo $db;
		break;
	case 'getHandlers' : //check
		$db = $service->_getHandlers();
		echo $db;
		break;
	case 'pollTraffic' : //check
		$db = $service->pollTraffic ();
		echo $db;
		break;
	case 'pollQueries' : //check
		$db = $service->pollQueries ();
		echo $db;
		break;
	case 'pollConnections' : //check
		$db = $service->pollConnections ();
		echo $db;
		break;
	
	/*********************************************
	 * SYSTEM INFORMATION
	 *********************************************/
	case 'showSystemVariables' :
		$db = $service->showSystemVariables ();
		echo $db;
		break;
	case 'showSystemPrivileges' :
		$db = $service->showPrivileges ();
		echo $db;
		break;
	case 'showSystemStatus' :
		$db = $service->showSystemStatus ();
		echo $db;
		break;
	case 'showSystemProcess' :
		$db = $service->showSystemProcess ();
		echo $db;
		break;
	case 'showTableStatus' :
		$db = $service->showTableStatus ( $database );
		echo $db;
		break;
	case 'showSystemUsers' :
		$db = $service->showSystemUsers ();
		echo $db;
		break;
	
	case 'killProcess' :
		$db = $service->killProcess ( $query );
		echo $db;
		break;
	
	/*********************************************
	 * BACKUPS/EXPORTS/IMPORTS
	 *********************************************/
	case 'createBackup' :
		$db = $service->createBackup ( $database, $table, $query );
		echo $db;
		break;
	case 'getDatabaseBackups' :
		$db = $service->getDatabaseBackups ();
		echo $db;
		break;
	case 'removeBackup' :
		$db = $service->removeBackup ( $database, $query );
		echo $db;
		break;
	
	case 'getDiskInfo' :
		$files = $f->getDiskInfo ( '../backups' );
		echo json_encode ( $files );
		break;
	
	case 'getDatabaseSpace' :
		$db = $service->getDatabaseSpace ();
		echo $db;
		break;
	case 'analyzeQuery' :
		$db = $service->analyzeQuery( $query );
		echo $db;
		break;
		

	default :
		trigger_error ( 'Please choose a mode.' );
		exit ();
}

?>