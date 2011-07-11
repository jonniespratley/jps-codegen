<?php
/**
 * @name  	index.php
 * @author  Jonnie Spratley
 * @version 1.9
 * @description - This is a REST Service file for the CodeGen front-end, form html, flex, jquery mobile, http rest versions.
 *
 */


/**
 * @TODO: July 10th 2011
 * 
 * 1. Setup firebugPHP for debuging.
 * 2. Finish converting all html views to jquery mobilized
 * 3. Documentent any code not documentent
 * 4. Create UI for data manager, utilities, and inspector
 * 5. Move CodeGen over to Backbone.js framework for client side.
 * 6. Add new app templates to be generated, 
 * 
 * Including:
 * 		jQuery Mobile Web App
 * 		jQuery Mobile Web App with backbone.js client side
 * 		Wordpress Plugin Web App
 * 		Wordpress Theme Web App
 * 		
 * 
 * 
 */


/**
 * 
 * @TODO: Sept 29th 2009
 * 1. Fix all main generators to accept new parameters when generating code,
 * if an array is passed as the options read from the array keys
 * else read from the xml file.
 * 
 * 
 * @TODO: Sept 28th 2009
 * 
 * 
 * 
 * 1. When creating application make main folder name of the application. For flex import.
 * with services folder inside of folder.
 * 2. Add new options for generation, including 
 * getters/setters
 * REST url style
 * API key use
 * Admin Logging
 * User monitoring
 * Field alias, as well as uploading edited config and schema files.
 * Field toggle display.
 *
 * @TODO: July 11th 2009
 * 
 * 1. Edit php service template and add post switch statement on REST part.
 * 2. Add my jquery pages plugin to the main navigation of the site.
 * 3. Fix boxes to make all drag drop.
 * 4. Use 960.css style
 * 5. Create class to display recent updates to CodeGen repo
 * 6. Create automation script that downloads all the recent versions
 * 7. Create a update checker.
 * 8. Incorporate Flex service browser and api tester.
 * 9. Create sql schema export.
 * 10. Create class to find table relationships using rails method of
 * 		has_many:
 * 		has_one:
 * 		belongs_to:
 * 		has_and_belongs_to_many:
 * 		
 *  

 * @TODO: Auguest 7th 2009
 * 1. Upon successful generation of flex application, save the information in the sqlite database cg_historys table
 * 
 */

#error_reporting(0);

/**
 * FirePHP Debugging Class
 */
require_once 'library/FirePHPCore/FirePHP.class.php';
$firephp = FirePHP::getInstance(true);

/**
 * Testing FirePHP Debugging Class



$firephp->group('Group');
$firephp->log('Hello World');
$firephp->groupEnd();

$firephp->group('Collapsed and Colored Group', array('Collapsed' => true, 'Color' => '#FF00FF'));
$firephp->log('Plain Message');      
$firephp->info('Info Message');     
$firephp->warn('Warn Message');   
$firephp->error('Error Message');
 
$firephp->log('Message','Optional Label');
  */
/* Debug Table */ 
$table   = array();
$table[] = array('Col 1 Heading','Col 2 Heading');
$table[] = array('Row 1 Col 1','Row 1 Col 2');
$table[] = array('Row 2 Col 1','Row 2 Col 2');
$table[] = array('Row 3 Col 1','Row 3 Col 2');
$firephp->table('Table Label', $table);  

 




require_once 'library/CodeGen.php';
require_once 'library/ClassInspector.php';
require_once 'library/ConfigManager.php';
require_once 'library/CGManager.php';
require_once 'library/FileSystemService.php';
require_once 'library/HTMLHelper.php';
require_once 'library/MySQLService.php';
require_once 'library/TemplateManager.php';

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

$sqlitePath = dirname ( __FILE__ ) . DIRECTORY_SEPARATOR . 'CodeGen.sqlite';
$outputPath = dirname ( __FILE__ ) . DIRECTORY_SEPARATOR . TemplateManager::$CONFIG_OUTPUT;

$codegen = new CodeGen ( $sqlitePath, true );
$mysql = new MySQLService ( );
$filesSvc = new FileSystemService ( );
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
				
				
				$firephp->log($databases, $mode, 'CodeGen');
				$firephp->table($mode, $databases);
				echo json_encode ( $databases );
				break;
			
			/* ===========================================================================================
             * getTables - @param $host, $user, $pass - Your MySQL credentials, $database - The database
             * =========================================================================================== */
			case 'getTables' :
				
				$mysql->connect ( $_GET ['h'], $_GET ['u'], $_GET ['p'] );
				$tables = $mysql->getTables ( $_GET ['d'] );
				
				echo json_encode ( $tables );
				break;
			
			case 'getDatabasesAndTables' :

				$mysql->connect ( $_GET ['h'], $_GET ['u'], $_GET ['p'] );
				$tables = $mysql->getDatabasesAndTables( $_GET ['d'] );

				echo json_encode ( $tables );
				break;
			/* ===========================================================================================
             * getTables - @param $host, $user, $pass - Your MySQL credentials, $database - The database
             * =========================================================================================== */
			case 'checkDatabase' :
				
				break;
			
			/* ===========================================================================================
             * getConfig - @param $database - The database the config file is for.
             * =========================================================================================== */
			case 'getConfig' :
				$config = file_get_contents ( $outputPath . ucfirst ( $_GET ['d'] ) );
				echo htmlentities ( $config );
				break;
			
			/* ===========================================================================================
             * getSchema - @param database - The database the config file is for.
             * =========================================================================================== */
			case 'getSchema' :
				$schema = file_get_contents ( $outputPath . ucfirst ( $_GET ['d'] ) );
				
				echo htmlentities ( $schema );
				break;
			
			/* ===========================================================================================
             * getTemplates - The location of the templates
             * =========================================================================================== */
			case 'getTemplates' :
				 
				$templates = $filesSvc->browseDirectory ( dirname ( __FILE__ ) . DIRECTORY_SEPARATOR . 'Templates', true );
				
				echo json_encode ( $templates );
				break;
			
			/* ===========================================================================================
             * getOutput - The generated files 
             * =========================================================================================== */
			case 'getOutput' :
				
				$output = $filesSvc->browseDirectory ( dirname ( __FILE__ ) . DIRECTORY_SEPARATOR . 'output', true );
				
				echo json_encode ( $output );
				break;
			
			/* ===========================================================================================
             * getDirectory -
             * =========================================================================================== */
			case 'getDirectory' :
			 
				$output = $filesSvc->browseDirectory ( $_GET ['p'], true );
				
				echo json_encode ( $output );
				break;
			
			/* ===========================================================================================
             * getServices -
             * =========================================================================================== */
			case 'getServices' :
			 
				$output = $filesSvc->browseDirectory ( $_GET ['p'], true );
				
				echo json_encode ( $output );
				break;
			
			/* ===========================================================================================
             * saveSettings -
             * =========================================================================================== */
			case 'saveSettings' :
				$settings = CodeGen::saveSettings ( $_GET ['s'] );
				echo json_encode ( array ($settings ) );
				break;
			
			/* ===========================================================================================
             * readFile -
             * =========================================================================================== */
			case 'readFile' :
				$file = FileSystemService::readFile ( $_GET ['f'] );
				
				echo htmlentities ( $file );
				break;
			
			/* ===========================================================================================
             * inspectClass -
             * =========================================================================================== */
			case 'inspectClass' :
				$file = ClassInspector::inspectClass ( $_GET ['f'] );
				echo json_encode ( array ($file ) );
				break;
			
			/* ===========================================================================================
             * callClassFunction -
             * =========================================================================================== */
			case 'callClassFunction' :
				$request = ClassInspector::call ( $_GET ['_class'], $_GET ['_func'], $_GET ['_args'] );
				$file [] = array ('methodCalled' => $_GET ['_func'], 'methodResults' => $request );
				
				echo json_encode ( $request );
				break;
			
			/* ===========================================================================================
             * If no mode is called, then just render the regular webpage
             * =========================================================================================== */
			default :
				include 'includes/cg_index.php';
				break;
		
		}
		
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
		include 'includes/cg_index.php';
		break;

} //Ends request switch


?>
