<?php
/**
 * @name  	index.php
 * @author  Jonnie Spratley
 * @version 1.9
 * @description - This is a REST Service file for the CodeGen front-end, form html, flex, jquery mobile, http rest versions.
 *
 */


/**
 * Define some globals
 */

define('CG_DEBUG', true);
define('CG_VERSION', '1.9.3');

define('CG_DIR', dirname ( __FILE__ ).DIRECTORY_SEPARATOR);
define('CG_LIB', CG_DIR.'library'.DIRECTORY_SEPARATOR);
define('CG_SQLITE', CG_DIR.'library'.DIRECTORY_SEPARATOR.'CodeGen.sqlite');
define('CG_INCLUDES', CG_DIR.'includes'.DIRECTORY_SEPARATOR);
define('CG_ASSETS', CG_DIR.'assets'.DIRECTORY_SEPARATOR);
define('CG_MOBILE', CG_DIR.'mobile'.DIRECTORY_SEPARATOR);
define('CG_FLEX', CG_DIR.'flex'.DIRECTORY_SEPARATOR);
define('CG_SERVICES', CG_DIR.'services'.DIRECTORY_SEPARATOR);


define('CG_TEMPLATES_DIR',  CG_DIR.'Templates'.DIRECTORY_SEPARATOR);
define('CG_OUTPUT_DIR', CG_DIR.'output'.DIRECTORY_SEPARATOR);

define('CG_DATABASE', 'jps_codegen');
define('CG_HOST', 'VALUE');
define('CG_USER', 'VALUE');
define('CG_PASS', 'VALUE');

 
/**
 * Include all required files
 */
require_once CG_LIB. 'FirePHPCore/FirePHP.class.php';
require_once CG_LIB.'CodeGen.php';
require_once CG_LIB.'ClassInspector.php';
require_once CG_LIB.'ConfigManager.php';
require_once CG_LIB.'CGManager.php';
require_once CG_LIB.'FileSystemService.php';
require_once CG_LIB.'HTMLHelper.php';
require_once CG_LIB.'MySQLService.php';
require_once CG_LIB.'TemplateManager.php';

 
 
 
#error_reporting(0);
$firephp = FirePHP::getInstance(true);

$firephp->group('jps-codegen bootstrap');

$firephp->info(CG_DEBUG, 'CG_DEBUG');
$firephp->info(CG_VERSION, 'CG_VERSION');
$firephp->info(CG_DIR, 'CG_DIR');
$firephp->info(CG_LIB, 'CG_LIB');
$firephp->info(CG_INCLUDES, 'CG_INCLUDES');
$firephp->info(CG_ASSETS, 'CG_ASSETS');
$firephp->info(CG_TEMPLATES_DIR, 'CG_TEMPLATES_DIR');
$firephp->info(CG_OUTPUT_DIR, 'CG_OUTPUT_DIR');
 
$firephp->groupEnd();

/** **********************************
 * FirePHP Debugging Class
 */

/** **********************************
 * Testing FirePHP Debugging Class
$firephp->group('Group');
$firephp->log('Hello World');
$firephp->groupEnd();

$firephp->group('Collapsed and Colored Group', 
array('Collapsed' => true, 'Color' => '#FF00FF'));
$firephp->log('Plain Message');      
$firephp->info('Info Message');     
$firephp->warn('Warn Message');   
$firephp->error('Error Message');
 
$firephp->log('Message','Optional Label');
  */
/* Debug Table
$table   = array();
$table[] = array('Col 1 Heading','Col 2 Heading');
$table[] = array('Row 1 Col 1','Row 1 Col 2');
$table[] = array('Row 2 Col 1','Row 2 Col 2');
$table[] = array('Row 3 Col 1','Row 3 Col 2');
$firephp->table('Table Label', $table);  
***********************************/ 
 



$configMessage = '';
$schemaMessage = '';
$appMessage = '';
$configLocation = '';
$schemaLocation = '';
$appOutputLog = '';
$mode = '';

$host = '';
$user = '';
$pass = '';
$database = '';
$app = '';
$namespace = '';
$endpoint = '';
$copywrite = '';
$framework = '';

$sqlitePath = CG_SQLITE;
$outputPath = CG_OUTPUT_DIR;

$codegen = new CodeGen ( $sqlitePath, true );
$mysql = new MySQLService ( );
$filesSvc = new FileSystemService ( );

$cg_result = array();


switch ($_SERVER ['REQUEST_METHOD']) {
	
	case 'GET' :
		$getData = $_GET;
		
		if (isset ( $_GET ['m'] )) {
			$mode = $_GET ['m'];
			unset ( $getData ['m'] );
		}
		if (isset ( $_GET ['mode'] )) {
			$mode = $_GET ['mode'];
			unset ( $getData ['mode'] );
		}
		
		switch ($mode) {
			
			case 'getHTMLDemo' :
				return ConfigManager::getHtmlDemoURL ();
				break;
			
			/* ===========================================================================================
             * getDatabases - @param $host, $user, $pass - Your MySQL credentials
             * =========================================================================================== */
			case 'getDatabases' :
				
				$mysql->connect ( $_GET ['h'], $_GET ['u'], $_GET ['p'] );
				$databases = $mysql->getDatabases ();
				
				 
				$cg_result = $databases;
				break;
			
			/* ===========================================================================================
             * getTables - @param $host, $user, $pass - Your MySQL credentials, $database - The database
             * =========================================================================================== */
			case 'getTables' :
				
				$mysql->connect ( $_GET ['h'], $_GET ['u'], $_GET ['p'] );
				$tables = $mysql->getTables ( $_GET ['d'] );
				
				
				
				$cg_result = $tables;
				break;
				
				
			/* ===========================================================================================
             * getDatabasesAndTables - @param $host, $user, $pass - Your MySQL credentials, $database - Returns the databases and tables 
             * =========================================================================================== */
			case 'getDatabasesAndTables' :

				$mysql->connect ( $_GET ['h'], $_GET ['u'], $_GET ['p'] );
				$tables = $mysql->getDatabasesAndTables( $_GET ['d'] );

				$cg_result = $tables;
				break;
			
			case 'checkDatabase' :
				
				break;
			
			/* ===========================================================================================
             * getConfig - @param $database - The database the config file is for.
             * =========================================================================================== */
			case 'getConfig' :
				$config = file_get_contents ( $outputPath . ucfirst ( $_GET ['d'] ) );
				$cg_result = htmlentities ( $config );
				
				break;
			
			/* ===========================================================================================
             * getSchema - @param database - The database the config file is for.
             * =========================================================================================== */
			case 'getSchema' :
				$schema = file_get_contents ( $outputPath . ucfirst ( $_GET ['d'] ) );
				
				$cg_result = htmlentities ( $schema );
				break;
			
			/* ===========================================================================================
             * getTemplates - The location of the templates
             * =========================================================================================== */
			case 'getTemplates' :
				 
				$templates = $filesSvc->browseDirectory ( CG_TEMPLATES_DIR, true );
				
				$cg_result = $templates;
				break;
			
			/* ===========================================================================================
             * getOutput - The generated files 
             * =========================================================================================== */
			case 'getOutput' :
				
				$output = $filesSvc->browseDirectory ( CG_OUTPUT_DIR, true );
				
				$cg_result = ( $output );
				break;
			
			/* ===========================================================================================
             * getDirectory - @param p - The directory path - Gets all of the contents in the directory
             * =========================================================================================== */
			case 'getDirectory' :
			 
				$output = $filesSvc->browseDirectory ( $_GET ['p'], true );
				
				$cg_result = ( $output );
				break;
			
			/* ===========================================================================================
             * getServices - @param p - The directory path - Gets all of the services in the /jps-codegen/servies directory
             * =========================================================================================== */
			case 'getServices' :
			 
				$output = $filesSvc->browseDirectory ( CG_SERVICES, true );
				
				$cg_result = ( $output );
				break;
			
			/* ===========================================================================================
             * saveSettings - @param s - The settings object - Saves the codegen settings to the sqlite database.
             * =========================================================================================== */
			case 'saveSettings' :
				$settings = CodeGen::saveSettings ( $_GET ['s'] );
				$cg_result = ( array ($settings ) );
				break;
			
			/* ===========================================================================================
             * readFile - @param f - The path to the file - Reads the contents of the file and returns
             * =========================================================================================== */
			case 'readFile' :
				$file = FileSystemService::readFile ( $_GET ['f'] );
				
				$cg_result = htmlentities ( $file );
				break;
			
			
			/* ===========================================================================================
             * callClassFunction - 
			 * @param 
			 * 	_class - string - The name of the class to invoke
			 * 	_func - string - The name of the class function to call
			 * 	_args - array - The array (if any) of arguments to pass with the calling function
			 * 	
             * =========================================================================================== */
			case 'callClassFunction' :		
				$request = ClassInspector::call ( $_GET ['_class'], $_GET ['_func'], $_GET ['_args'] );
				$cg_result [] = array ('methodCalled' => $_GET ['_func'], 'methodResults' => $request );
				
				 
				break;
				
			/* ===========================================================================================
             * inspectClass -
             * =========================================================================================== */
			case 'inspectClass' :
				$file = ClassInspector::inspectClass ( $_GET ['f'] );
				$cg_result = ( $file );
				
				
				
				break;
			
			/* ===========================================================================================
             * inspectClassFunc - 
			 * @param 
			 * 	_class - string - The name of the class to invoke
			 * 	_func - string - The name of the class function to call
			 * 	_args - array - The array (if any) of arguments to pass with the calling function
			 * 	
             * =========================================================================================== */
			case 'inspectClassFunc' :		
				$request = ClassInspector::call ( $_GET ['_class'], $_GET ['_func'], $_GET ['_args'] );
				$cg_result [] = array ('methodCalled' => $_GET ['_func'], 'methodResults' => $request );
				
				 
				break;
			
			/* ===========================================================================================
             * If no mode is called, then just render the regular webpage
             * =========================================================================================== */
			default :
				include 'includes/cg_index.php';
				break;
		
		}//ends switch
		
	
		$firephp->table($mode, $cg_result);
		
		
		
		echo json_encode($cg_result);
		
		
		break; //ends get switch
	

	case 'POST' :
		$postData = $_POST;
		
		if (isset ( $_POST ['m'] )) {
			$mode = $_POST ['m'];
			unset ( $postData ['m'] );
		}
		
		switch ($mode) {
			/* ===========================================================================================
             * generateConfig
             * =========================================================================================== */
			case 'generateConfig' :
				$configLocation = CodeGen::writeConfig ( $outputPath, $_POST ['h'],/*Host*/ 
																	$_POST ['u'], /*User*/ 
																	$_POST ['p'], /*Pass */ 
																	$_POST ['d'], /*Database*/ 
																	$_POST ['a'], /*Application*/ 
																	$_POST ['e'], /*Endpoint*/ 
																	$_POST ['n'], /*Namespace*/ 
																	$_POST ['f'], /*Framework*/ 
																	$_POST ['c'] ); /*Copywrite*/
				
				echo json_encode ( $configLocation );
				break;
			
			/* ===========================================================================================
             * generateSchema - @param $outputPath - The location where you want to output the schema
             * =========================================================================================== */
			case 'generateSchema' :
				
				$codegen->start ( $outputPath, $_POST ['d'] );
				$schema = $codegen->writeSchema ( $outputPath );
				
				echo json_encode ( $schema );
				break;
			
			/* ===========================================================================================
             * generateApplication - @param $outputPath, $database - The database and output path
             * =========================================================================================== */
			case 'generateApplication' :
				
				$codegen->start ( $outputPath, $_POST ['d'] );
				$appOutputLog = $codegen->generateCode ( $outputPath, $_POST ['d'] );
				
				//echo htmlentities( json_encode ( $appOutputLog ) );
				//echo $appOutputLog;
				break;
			/* ===========================================================================================
             * saveSettings - @param Array - The name value pair array of settings to be saved.
             * =========================================================================================== */
			case 'saveSettings' :
				$service = $codegen->saveSettings ( $postData );
				echo $service;
				break;
			
			/* ===========================================================================================
	          * saveApp - @param 
             * =========================================================================================== */
			case 'saveApp' :
				$service = $codegen->saveApp ( $_POST ['name'], $_POST ['url'], $_POST ['config'], $_POST ['schema'] );
				echo $service;
				break;
			
			/* ===========================================================================================
	          * removeApp - @param 
             * =========================================================================================== */
			case 'removeApp' :
				$service = $codegen->removeApp ( $_POST ['id'] );
				echo $service;
				break;
			
			/* ===========================================================================================
	             * writeFile -
	             * =========================================================================================== */
			case 'writeFile' :
				$file = FileSystemService::writeFile ( $_POST ['f'], $_POST ['c'] );
				echo json_encode ( $file );
				break;
		
		}
		
		break; //ends post switch
	

	/* ===========================================================================================
     * If no mode is called, then just render the regular webpage
     * =========================================================================================== */
	default :
		include CG_INCLUDES. 'cg_index.php';
		break;

} //Ends request switch



?>
