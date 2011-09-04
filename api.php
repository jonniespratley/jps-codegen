<?php
/**
 * @name  	api.php
 * @author  Jonnie Spratley
 * @version 1.9
 * @description - This is a api for the jps-codegen front-end, it uses URL params in the format below:

 http://localhost/jps-codegen/api.php?
	m = MODE 
	h = HOST
 	u = USER
	p = PASS
	d = DATABASE
	t = TABLE
	f = FILE PATH
	a = APP NAME
	n = NAMESPACE
	e = ENDPOINT GATEWAY
	
	

*
 */

require("cg_config.php");
 
 
 
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
				if( !(isset($_GET[d])) ){
					$tables[] = array('message' => "Please choose a database.  d = DATABASE");
				} else {
					$tables = $mysql->getTables ( $_GET ['d'] );
				}

				
				
				
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
             * inspectClass - @param - f - the path of the file - This method inspects the class and returns 
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
			 	$cg_result[] = array('message' => "Please choose a method to invoke");
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
		/* ===========================================================================================
		 * writeFile -
		 * =========================================================================================== */		
					
		$jsonOptions = str_replace('\\', '', $postData['options']);
		$options = json_decode($jsonOptions, true);
		require CG_LIB . 'CodeGenService.php';
		$cg = new CodeGenService($options);

		$namespaceArray = array();
		$serverVOFolder = array();
		$serverDAOFolder = array();
		$serverRoot = array();
		$serverFolder = array();

		$clientVOFolder = array();
		$clientRestFolder = array();
		$clientViewFolder = array();
		$clientServiceFolder = array();
		$clientRoot = array();
		$clientFolder = array();

		if($options['namespacee']) {
			$namespaceArray = split('\.', $options['namespacee'], 3);
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
			
			
		
	 
			//CG
			case 'cgGen_getServerPreview' :
				foreach($options['tables'] as $table) {
					$serverVOFolder[] = $cg -> phpGen_genValueObject($table['name'], $table['fields']);
					$serverDAOFolder[] = $cg -> phpGen_genBaseService($table['name'], $table['fields']);
				}
				$voFolder = array('label' => 'vo',
					'children' => $serverVOFolder);
				$daoFolder = array('label' => 'services',
					'children' => $serverDAOFolder);
				$serverFolder = array($voFolder,
					$daoFolder);
				$serverRoot[] = array('label' => $options['application'],
					'children' => array('label' => $namespaceArray[0],
						'children' => array('label' => $namespaceArray[1],
							'children' => array('label' => $namespaceArray[2],
								'children' => $serverFolder))));
				echo json_encode($serverRoot);

				break;

			//Case they call for the client side preview
			case 'cgGen_getClientPreview' :

			/*
			 * This is where all of the code generator magic happens.
			 */

			//Loop through the tables
				foreach($options['tables'] as $table) {
					$clientVOFolder[] = $cg -> flexGen_genValueObject($table['name'], $table['fields']);
					$clientViewFolder[] = $cg -> flexGen_genTableForm($table['name'], $table['fields']);
					//$clientServiceFolder[] = $cg->flexGen_genRestService($table['name'], $table['fields']);

				}

				//Create a folder for the vo's
				$voFolder = array('label' => 'vo',
					'children' => $clientVOFolder);
				//Create a folder for the rest service files
				$viewFolder = array('label' => 'view',
					'children' => $clientViewFolder);
				$serviceFolder = array(
				//    'label'=>'services', 'children'=>$clientServiceFolder
				);

				//Add them to the client folder
				$clientFolder = array($voFolder,
					$viewFolder,
					$serviceFolder);

				//Add the folder to the client root folder for display
				$clientRoot[] = array('label' => $options['application'],
					'children' => array('label' => $namespaceArray[0],
						'children' => array('label' => $namespaceArray[1],
							'children' => array('label' => $namespaceArray[2],
								'children' => $clientFolder))));

				//Return JSON containing all of the information from above
				echo json_encode($clientRoot);

				break;

			//PHP
			case 'phpGen_genValueObject' :
				foreach($options['tables'] as $table) {
					$result[] = $cg -> phpGen_genValueObject($table['name'], $table['fields']);
				}
				echo json_encode($result);
				break;

			//Flex
			case 'flexGen_genTableMain' :
				break;
			case 'flexGen_genTableForm' :
				break;
			case 'flexGen_genTableList' :
				break;
			case 'flexGen_genRestService' :
				break;
			case 'flexGen_genApplication' :
				break;

			//Eclipse

			//Cairngorm
			/* ===========================================================================================
			 * writeFile -
			 * =========================================================================================== */
			case 'writeFile' :
				$file = FileSystemService::writeFile($_POST['f'], $_POST['c']);
				echo json_encode($file);
				break;
			
			case 'test_post':
				$cg_result = array($_POST);
				echo json_encode($cg_result);
			break;
		}
			
			
			
			
			
	 
		break; //ends post switch
	

	/* ===========================================================================================
     * If no mode is called, then just render the regular webpage
     * =========================================================================================== */
	default :
			$cg_result[] = array('message' => "Please choose a method to invoke");
			echo json_encode($cg_result);
		break;
		
} //Ends request switch



?>
