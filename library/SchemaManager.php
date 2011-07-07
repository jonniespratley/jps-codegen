<?php
/**
 * @name  	SchemaManager.php
 * @author  Jonnie Spratley
 * @version 1.9
 * @description This classes reads the xml file that holds the database schema, 
 * and then generates the files inside of the config.xml file.
 * 
 */

require_once 'ConfigManager.php';
require_once 'Utilities.php';
require_once 'CGManager.php';
require_once 'TemplateManager.php';
require_once 'CairngormGen.php';
require_once 'FlexGen.php';
require_once 'PHPGen.php';
require_once 'HTMLGen.php';
require_once 'SQLGen.php';

class SchemaManager
{
	
	/**
	 * I read the schema.xml file and generate all of the require_onced items for a CRUD application.
	 * @param  [string] $filepath - The path to the schema.xml file
	 * @param [database] $database - The name of the database 
	 * @return [results]
	 */
	public static function readSchema( $filepath, $database, $generate = true )
	{
		$namespace = ConfigManager::getConfigSetting ( $filepath, $database, 'namespace' );
		$application = ConfigManager::getConfigSetting ( $filepath, $database, 'application' );
		
		$schema = $filepath . ucfirst ( $database ) . 'Schema.xml';
		
		if ( file_exists ( $schema ) )
		{
			//write the namespace folders
			//$namespace = Utilities::namespaceFolders ( ConfigManager::getNamespace () );
			//Utilities::makeServerNamespaceFolders ( $namespace );
			$dom = new DOMDocument ( );
			$dom->load ( $schema );
			
			$tables = $dom->getElementsByTagName ( 'table' );
			$tableArray = array ();
			
			//Each table needs one of these files being generated below
			foreach ( $tables as $table )
			{
				if ( $table->hasAttribute ( 'name' ) )
				{
					$tableName = $table->getAttribute ( 'name' );
					$fieldArray = array ();
					
					//For each field inside of the table node
					foreach ( $table->childNodes as $node )
					{
						if ( is_a ( $node, 'DOMElement' ) )
						{
							$field = $node->getAttribute ( 'name' );
							$type = $node->getAttribute ( 'type' );
							$null = $node->getAttribute ( 'required' );
							$key = '';
							if ( $node->hasAttribute ( 'key' ) )
							{
								$key = $node->getAttribute ( 'name' );
							}
							
							$fieldArray [] = array ( 
								'name' => $field, 
								'type' => Utilities::replaceNumbers ( $type ), 
								'required' => $null, 
								'key' => $key 
							);
						}//ends if is_a node
						
						sort ( $fieldArray );
					}//ends foreach field
					
					//Push the into an array of a table and there fields
					$tableArray [ $tableName ] = array ( 
						'table' => ucfirst ( $tableName ), 'fields' => $fieldArray 
					);
					
					
					
					
					
					//SQLGen::writeCreateTable( $tableName, $fieldArray );
					$database = ConfigManager::getDatabase ();
					
					
							
						
						/* ============================================================================================
						 * PHP GENERATION
						 * ============================================================================================ */
							self::doPHPPerTableFiles( $filepath, $namespace, $database, $tableName, $fieldArray );
							
						/* ============================================================================================
						 * FLEX GENERATION
						 * ============================================================================================ */
							self::doFlexPerTableFiles( $filepath, $namespace, $database, $tableName, $fieldArray );
	
						/* ============================================================================================
						 * CAIRNGORM GENERATION
						 * ============================================================================================ */
							self::doHTMLPerTableFiles( $filepath, $namespace, $database, $tableName, $fieldArray );
							
						/* ============================================================================================
						 * CAIRNGORM GENERATION
						 * ============================================================================================ */
							//Check if they are using the framework 
							if ( ConfigManager::getFramework () === TemplateManager::$FRAMEWORK_CAIRNGORM )
							{
								self::doCairngormPerTableFiles( $filepath, $namespace, $database, $tableName, $fieldArray );
							} 
							else 
							{
								CGManager::$FLEX_LIST_GEN [] = FlexGen::generateValueObject ( $filepath, $namespace, $database, $tableName, $fieldArray );
							}//ends if cairngorm framework
						}
					}//ends foreach table loop
					
		
					/* ============================================================================================
					 * CAIRNGORM GENERATION
					 * ============================================================================================ */
					if ( ConfigManager::getFramework () === TemplateManager::$FRAMEWORK_CAIRNGORM )
					{
						self::doCairngormPerApplicationFiles( $filepath, $namespace, $database, $tableArray, $fieldArray );
					}
					
					/* ============================================================================================
					 * HTML GENERATION
					 * ============================================================================================ */				
					self::doHTMLPerApplicationFiles( $filepath, $namespace, $database, $tableArray, $fieldArray );
					
					/* ============================================================================================
					 * FLEX GENERATION
					 * ============================================================================================ */
					self::doFlexPerApplicationFiles( $filepath, $namespace, $database, $tableArray, $fieldArray );

					self::doPHPPerApplicationFiles( $filepath, $namespace, $database, $tableArray, $fieldArray );
			
		
			} //ends if file exists
	
		$appMessage = CGManager::GET_CG_LOG ();
		//return $appMessage;
		
		if( !$generate  )
		{
			//return array( 'database' => $database, 'tables' => $tableArray );	
		}
					
		return $appMessage;			
	}
	
	/**
	 * I write a xml schema file of the database.
	 *
	 * @param [string] $filepath - The path of the schema output folder
	 * @param [link] $dblink - The MySQLI link
	 * @param [string] $database - The database name
	 * @return [string] - The location of the new schema.xml file
	 */
	public static function writeSchema( $dblink, $filepath, $database )
	{
		$dom = new DOMDocument ( '1.0' );
		
		/************************************
		 * Builds the root 
		 ************************************/
		//create a element
		$schema = $dom->createElement ( 'schema' );
		
		//set the element on itself
		$schema = $dom->appendChild ( $schema );
		
		//set a attribute for the schema node 
		$schema->setAttribute ( 'name', $database );
		
		/***********************************
		 * Builds the table inside the root
		 **********************************/
		$tableQuery = mysqli_query ( $dblink, "SHOW TABLES FROM $database" );
		
		while ( $tableRow = mysqli_fetch_row ( $tableQuery ) )
		{
			//create a table element
			$table = $dom->createElement ( 'table' );
			
			//set the table element on itself
			$table = $dom->appendChild ( $table );
			
			//set the name attribute on the table
			$table->setAttribute ( 'name', $tableRow [ 0 ] );
			
			$fieldQuery = mysqli_query ( $dblink, "DESCRIBE $database.$tableRow[0]" );
			
			while ( $fieldRow = mysqli_fetch_assoc ( $fieldQuery ) )
			{
				//create a element
				$field = $dom->createElement ( 'field' );
				
				//set the element on itself
				$field = $dom->appendChild ( $field );
				
				//set the name attribute
				$field->setAttribute ( 'name', $fieldRow [ 'Field' ] );
				
				//set the type attribute
				$field->setAttribute ( 'type', Utilities::replaceNumbers ( $fieldRow [ 'Type' ] ) );
				
				//set the null attribute
				$field->setAttribute ( 'required', $fieldRow [ 'Null' ] == 'NO' ? 'true' : 'false' );
				
				if ( $fieldRow [ 'Default' ] != '' )
				{
					//set the default
					$field->setAttribute ( 'default', strtolower ( $fieldRow [ 'Default' ] ) );
				}
				if ( $fieldRow [ 'Key' ] != '' )
				{
					//set the key
					$field->setAttribute ( 'key', strtolower ( $fieldRow [ 'Key' ] ) );
				}
				if ( $fieldRow [ 'Extra' ] != '' )
				{
					//set the value/length attribute
					$field->setAttribute ( 'extra', strtolower ( $fieldRow [ 'Extra' ] ) );
				}
				//put the field inside of the table
				$table->appendChild ( $field );
			}
			//put the table inside of the schema
			$schema->appendChild ( $table );
		}
		$dom->formatOutput = true;
		
		//updated this 4/20/09 - Jonnie - Now multiple schema files can be created, for each database.
		$filename = $filepath . ucfirst ( $database ) . 'Schema.xml';
		
		$dom->save ( $filename );
		
		return $filename;
	}
	
	
	
	
	
	
	static public function doCairngormPerTableFiles( $filepath, $namespace, $database, $tableName, $fieldArray )
	{
		//Get/Save/Remove Events
		CGManager::$CAIRNGORM_GET_EVENT_GEN [] = CairngormGen::generateGetEvent ( $filepath, $namespace, $database, $tableName, $fieldArray );
		CGManager::$CAIRNGORM_SAVE_EVENT_GEN [] = CairngormGen::generateSaveEvent ( $filepath, $namespace, $database, $tableName, $fieldArray );
		CGManager::$CAIRNGORM_REMOVE_EVENT_GEN [] = CairngormGen::generateRemoveEvent ( $filepath, $namespace, $database, $tableName, $fieldArray );	

		//Get/Save/Remove Commands
		CGManager::$CAIRNGORM_GET_COMMAND_GEN [] = CairngormGen::generateGetCommand ( $filepath, $namespace, $database, $tableName, $fieldArray );
		CGManager::$CAIRNGORM_SAVE_COMMAND_GEN [] = CairngormGen::generateSaveCommand ( $filepath, $namespace, $database, $tableName, $fieldArray );
		CGManager::$CAIRNGORM_REMOVE_COMMAND_GEN [] = CairngormGen::generateRemoveCommand ( $filepath, $namespace, $database, $tableName, $fieldArray );

		//Service Delegate				
		CGManager::$CAIRNGORM_SERVICE_DELEGATE_GEN [] = CairngormGen::generateDelegate ( $filepath, $namespace, $database, $tableName, $fieldArray );

		//Value Object
		CGManager::$CAIRNGORM_VO_GEN [] = CairngormGen::generateValueObject ( $filepath, $namespace, $database, $tableName, $fieldArray );
	}
	
	static public function doCairngormPerApplicationFiles( $filepath, $namespace, $database, $tableArray, $fieldArray )
	{
		//Write the Services.mxml file
		CGManager::$CAIRNGORM_SERVICE_LOCATOR_GEN [] = CairngormGen::generateServiceLocator ( $filepath, $namespace, $database, $tableArray, $fieldArray );
					
		//Write the ModelLocator.as file
		CGManager::$CAIRNGORM_MODEL_GEN [] = CairngormGen::generateModelLocator ( $filepath, $namespace, $database, $tableArray, $fieldArray );
		
		//Write the FrontController.as file
		CGManager::$CAIRNGORM_CONTROLLER_GEN [] = CairngormGen::generateController ( $filepath, $namespace, $database, $tableArray, $fieldArray );
	}
	
	static public function doFlexPerTableFiles( $filepath, $namespace, $database, $tableName, $fieldArray )
	{
		//Flex List Component
		CGManager::$FLEX_LIST_GEN [] = FlexGen::generateList ( $filepath, $namespace, $database, $tableName, $fieldArray );
		
		//Flex Form Component
		CGManager::$FLEX_FORM_GEN [] = FlexGen::generateForm ( $filepath, $namespace, $database, $tableName, $fieldArray );
		
		//Flex Main Component 
		CGManager::$FLEX_MAIN_GEN [] = FlexGen::generateTableMain ( $filepath, $namespace, $database, $tableName, $fieldArray );
	}
	
	static public function doFlexPerApplicationFiles( $filepath, $namespace, $database, $tableArray, $fieldArray )
	{
		//Write the main application
		CGManager::$FLEX_APP_GEN [] = FlexGen::generateApplication ( $filepath, $namespace, $database, $tableArray, $fieldArray );
		
		//Write the FlexREST Service Class ( if selected )
		CGManager::$FLEX_REST_SERVICE_GEN [] = FlexGen::generateRESTService ( $filepath, $namespace, $database, $tableArray, $fieldArray );
	}
	
	static public function doPHPPerTableFiles( $filepath, $namespace, $database, $tableName, $fieldArray )
	{
		CGManager::$PHP_DAO_GEN [] = PHPGen::generateBaseService ( $filepath, $namespace, $database, $tableName, $fieldArray );
		CGManager::$PHP_VO_GEN [] = PHPGen::generateValueObject ( $filepath, $namespace, $database, $tableName, $fieldArray );
	}
	
	static public function doPHPPerApplicationFiles( $filepath, $namespace, $database, $tableArray, $fieldArray )
	{
		//Write the RESTService.php file
		CGManager::$PHP_REST_GEN [] = PHPGen::generateRESTService ( $filepath, $namespace, $database, $tableArray, $fieldArray );
		
		//Write the Connection.php file
		CGManager::$PHP_CONN_GEN [] = PHPGen::writeConnection ( $filepath, $database );
	}
	
	static public function doHTMLPerTableFiles( $filepath, $namespace, $database, $tableName, $fieldArray )
	{
		/* =========================================================================
		 * HTML SERVER SIDE CODE GENERATION
		 * TODO:5/22/09 added
		 * ========================================================================= */ 
		CGManager::$HTML_LIST_GEN [] = HTMLGen::generateHTMLList ( $filepath, $namespace, $database, $tableName, $fieldArray );
		CGManager::$HTML_FORM_GEN [] = HTMLGen::generateHTMLForm ( $filepath, $namespace, $database, $tableName, $fieldArray );
	
	}
	
	static public function doHTMLPerApplicationFiles( $filepath, $namespace, $database, $tableArray, $fieldArray )
	{
		//Write the Main File
		CGManager::$HTML_MAIN_GEN [] = HTMLGen::generateHTMLMain ( $filepath, $namespace, $database, $tableArray, $fieldArray );
	}
	

}


/*
$path = '../output/';
$db = 'test';

echo '<pre>';
print_r( SchemaManager::readSchema( $path, $db, false ) );
echo '</pre>';
*/

?>