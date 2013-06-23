<?php
/**
 * @name  	CairngormGen.php
 * @author  Jonnie Spratley
 * @version 1.9
 * @method generateController - Creates Controller.as
 * @method generateDelegate - Creates Delegate.as
 * @method generateServiceLocator - Creates Services.mxml
 * @method generateModelLocator - Creates ModelLocator.as
 * @method generateValueObject - Creates TableVO.as
 * @method generateSaveEvent - Creates TableSaveEvent.as
 * @method generateSaveCommand - Creates TableSaveCommand.as
 * @method generateRemoveEvent - Creates TableRemoveEvent.as
 * @method generateRemoveCommand - Creates TableRemoveCommand.as
 * @method generateGetEvent - Creates TableGetEvent.as
 * @method generateGetCommand - Creates TableGetCommand.as
 *
 */

require_once 'TemplateManager.php';
require_once 'FileSystemService.php';
require_once 'ConfigManager.php';
require_once 'SchemaManager.php';
require_once 'Utilities.php';

class CairngormGen
{
	
	/**
	 * I generate a Cairngorm Controller for the application
	 *
	 * @param [string] $output - The location where the file is to be placed once generated
	 * @param [string] $namespace - Applications namespace. example( com.domain.project )
	 * @param [string] $database - The applications database name.
	 * @param [string] $table - The applications databases table.
	 * @param [array] $fields - The applications table fields.
	 * @return [array] - An array containing the filename and the real file path.
	 */
	public static function generateController( $output, $namespace, $database, $table, $fields = null )
	{
		$application = ConfigManager::getConfigSetting ( $output, $database, 'application' );
		$eventsToCommands = '';
		
		$folderNamespace = Utilities::namespaceFolders ( $namespace );
		$namespace = Utilities::namespaceApplication ( $namespace );
		
		foreach ( $table as $tbl )
		{
			$eventsToCommands .= '
			this.addCommand( Get' . $tbl [ "table" ] . 'Event.GET_' . strtoupper ( $tbl [ "table" ] ) . '_EVENT, Get' . $tbl [ "table" ] . 'Command );
			this.addCommand( Remove' . $tbl [ "table" ] . 'Event.REMOVE_' . strtoupper ( $tbl [ "table" ] ) . '_EVENT, Remove' . $tbl [ "table" ] . 'Command );
			this.addCommand( Save' . $tbl [ "table" ] . 'Event.SAVE_' . strtoupper ( $tbl [ "table" ] ) . '_EVENT, Save' . $tbl [ "table" ] . 'Command );
			';
		}
		
		$copywrite = ConfigManager::getConfigSetting ( $output, $database, 'copywrite' );
		
		$tableService = FileSystemService::readFile ( TemplateManager::$CAIRNGORM_TEMPLATE_LOCATION . 'CairngormController.txt' );
		$template = preg_replace ( TemplateManager::$NAMESPACE_PATTERN, $namespace, $tableService );
		$template = preg_replace ( TemplateManager::$APPLICATION_PATTERN, $application, $template );
		$template = preg_replace ( TemplateManager::$EVENT_COMMAND_PATTERN, $eventsToCommands, $template );
		$template = preg_replace ( TemplateManager::$COPYWRITE_PATTERN, $copywrite, $template );
		
		$filename = ucfirst ( $application ) . 'Controller.as';
		
		Utilities::checkOrMakeFolders ( TemplateManager::$CLIENT_OUTPUT, $folderNamespace, 'control' );
		$file = FileSystemService::writeFile ( TemplateManager::$CLIENT_OUTPUT . $folderNamespace . '/control/' . $filename, $template );
		
		//return 'Cairngorm Controller for ' . $application . ' Complete';
		return array ( 
			'label' => $filename, 'data' => $file 
		);
	}
	
	/**
	 * I generate a Cairngorm Service Delegate for the applications database table.
	 *
	 * @param [string] $output - The location where the file is to be placed once generated
	 * @param [string] $namespace - Applications namespace. example( com.domain.project )
	 * @param [string] $database - The applications database name.
	 * @param [string] $table - The applications databases table.
	 * @param [array] $fields - The applications table fields.
	 * @return [array] - An array containing the filename and the real file path.
	 */
	public static function generateDelegate( $output, $namespace, $database, $table, $fields = null )
	{
		//upper case the table name
		$tableUFirst = ucfirst ( $table );
		
		//Create the fileame
		$filename = $tableUFirst . 'ServiceDelegate.as';
		
		$copywrite = ConfigManager::getConfigSetting ( $output, $database, 'copywrite' );
		//	$framework = ConfigManager::getConfigSetting ( $output, $database, 'framework' );
		

		//make the folder namespace
		$folderNamespace = Utilities::namespaceFolders ( $namespace );
		$namespace = Utilities::namespaceApplication ( $namespace );
		
		$tableService = FileSystemService::readFile ( TemplateManager::$CAIRNGORM_TEMPLATE_LOCATION . 'CairngormDelegateREST.txt' );
		
		//replace the table name inside of the template
		$template = preg_replace ( TemplateManager::$TABLE_UFIRST_PATTERN, $tableUFirst, $tableService );
		$template = preg_replace ( TemplateManager::$NAMESPACE_PATTERN, $namespace, $template );
		$template = preg_replace ( TemplateManager::$COPYWRITE_PATTERN, $copywrite, $template );
		
		Utilities::checkOrMakeFolders ( TemplateManager::$CLIENT_OUTPUT, $folderNamespace, 'business' );
		$file = FileSystemService::writeFile ( TemplateManager::$CLIENT_OUTPUT . $folderNamespace . '/business/' . $filename, $template );
		
		//return 'Cairngorm Service Delegate for ' . $tableUFirst . ' Complete';
		return array ( 
			'label' => $filename, 'data' => $file 
		);
	}
	
	/**
	 * I generate a Cairngorm ServiceLocator for the application.
	 *
	 * @param [string] $output - The location where the file is to be placed once generated
	 * @param [string] $namespace - Applications namespace. example( com.domain.project )
	 * @param [string] $database - The applications database name.
	 * @param [string] $table - The applications databases table.
	 * @param [array] $fields - The applications table fields.
	 * @return [array] - An array containing the filename and the real file path.
	 */
	public static function generateServiceLocator( $output, $namespace, $database, $table, $fields = null )
	{
		$endpoint = ConfigManager::getConfigSetting ( $output, $database, 'endpoint' );
		$copywrite = ConfigManager::getConfigSetting ( $output, $database, 'copywrite' );
		
		$filename = 'Services.mxml';
		
		$folderNamespace = Utilities::namespaceFolders ( $namespace );
		$namespace = Utilities::namespaceApplication ( $namespace );
		
		$serviceLocator = '';
		
		/**
		 *  <mx:HTTPService
    			id="CodeGenService"
    			url="library/FlexService.php"
    			useProxy="false"
    			showBusyCursor="true"/>
		 */
		
		foreach ( $table as $tbl )
		{
			$tableUFirst = ucfirst ( $tbl [ 'table' ] );
			/*
			$serviceLocator .= '
			<mx:RemoteObject
		    	id="' . $tbl [ 'table' ] . 'Service"
		    	destination="amfphp"
		    	endpoint="' . $endpoint . '"
		    	source="' . $namespace . '.' . $tbl [ 'table' ] . 'Service"
		    	showBusyCursor="true"
		    	makeObjectsBindable="true">
		    </mx:RemoteObject>';
			*/
			$serviceLocator .= '
			<mx:HTTPService
    			id="' . $tableUFirst . 'Service"
    			url="' . $endpoint . '/' . $tableUFirst . 'Service.php"
    			useProxy="false"
    			showBusyCursor="true"/>
			';
		
		}
		
		$tableService = FileSystemService::readFile ( TemplateManager::$CAIRNGORM_TEMPLATE_LOCATION . 'CairngormServiceLocatorREST.txt' );
		
		$template = preg_replace ( TemplateManager::$NAMESPACE_PATTERN, $namespace, $tableService );
		$template = preg_replace ( TemplateManager::$ENDPOINT_PATTERN, $endpoint, $template );
		$template = preg_replace ( TemplateManager::$TABLE_UFIRST_PATTERN, $serviceLocator, $template );
		$template = preg_replace ( TemplateManager::$COPYWRITE_PATTERN, $copywrite, $template );
		
		Utilities::checkOrMakeFolders ( TemplateManager::$CLIENT_OUTPUT, $folderNamespace, 'business' );
		$file = FileSystemService::writeFile ( TemplateManager::$CLIENT_OUTPUT . $folderNamespace . '/business/' . $filename, $template );
		
		//return 'Cairngorm Service Locator for ' . $database . ' Complete';
		return array ( 
			'label' => $filename, 'data' => $file 
		);
	}
	
	/**
	 * I generate a Cairngorm Model Locator for the application
	 *
	 * @param [string] $output - The location where the file is to be placed once generated
	 * @param [string] $namespace - Applications namespace. example( com.domain.project )
	 * @param [string] $database - The applications database name.
	 * @param [string] $table - The applications databases table.
	 * @param [array] $fields - The applications table fields.
	 * @return [array] - An array containing the filename and the real file path.
	 */
	public static function generateModelLocator( $output, $namespace, $database, $table, $fields = null )
	{
		$copywrite = ConfigManager::getConfigSetting ( $output, $database, 'copywrite' );
		$namespace = ConfigManager::getConfigSetting ( $output, $database, 'namespace' );
		
		//Create the fileame
		$filename = 'ModelLocator.as';
		
		//make the folder namespace
		$folderNamespace = Utilities::namespaceFolders ( $namespace );
		$namespace = Utilities::namespaceApplication ( $namespace );
		
		$collections = '';
		
		foreach ( $table as $tbl )
		{
			
			$collections .= '
			public var ' . ucfirst ( $tbl [ 'table' ] ) . 'Collection:ArrayCollection;
			public var selected' . ucfirst ( $tbl [ 'table' ] ) . ':' . ucfirst ( $tbl [ 'table' ] ) . 'VO;
			';
		}
		
		$tableService = FileSystemService::readFile ( TemplateManager::$CAIRNGORM_TEMPLATE_LOCATION . 'CairngormModel.txt' );
		
		$template = preg_replace ( TemplateManager::$TABLE_UFIRST_PATTERN, $collections, $tableService );
		$template = preg_replace ( TemplateManager::$NAMESPACE_PATTERN, $namespace, $template );
		$template = preg_replace ( TemplateManager::$COPYWRITE_PATTERN, $copywrite, $template );
		
		Utilities::checkOrMakeFolders ( TemplateManager::$CLIENT_OUTPUT, $folderNamespace, 'model' );
		$file = FileSystemService::writeFile ( TemplateManager::$CLIENT_OUTPUT . $folderNamespace . '/model/' . $filename, $template );
		
		//return 'Cairngorm Model Locator for ' . $database . ' Complete';
		return array ( 
			'label' => $filename, 'data' => $file 
		);
	}
	
	/**
	 * I generate a Cairngorm Value Object for the application, I create one VO for each database table.
	 *
	 * @param [string] $output - The location where the file is to be placed once generated
	 * @param [string] $namespace - Applications namespace. example( com.domain.project )
	 * @param [string] $database - The applications database name.
	 * @param [string] $table - The applications databases table.
	 * @param [array] $fields - The applications table fields.
	 * @return [array] - An array containing the filename and the real file path.
	 */
	public static function generateValueObject( $output, $namespace, $database, $table, $fields = null )
	{
		$copywrite = ConfigManager::getConfigSetting ( $output, $database, 'copywrite' );
		$tableUFirst = ucfirst ( $table );
		
		$folderNamespace = Utilities::namespaceFolders ( $namespace );
		$namespace = Utilities::namespaceApplication ( $namespace );
		
		$fieldVars = '';
		$fieldsCon = '';
		$fieldsQuery = '';
		
		foreach ( $fields as $field )
		{
			$fieldVars .= '
			public var ' . $field [ 'name' ] . ':String;';
			
			$fieldsCon .= '
			this.' . $field [ 'name' ] . ' = obj["' . $field [ 'name' ] . '"];';
			
			$fieldsQuery .= '"&' . $field [ 'name' ] . '=" + ' . $field [ 'name' ] . ' + ';
		
		}
		$fieldsQuery = Utilities::trim ( $fieldsQuery, 2 );
		
		$tableService = FileSystemService::readFile ( TemplateManager::$CAIRNGORM_TEMPLATE_LOCATION . 'CairngormValueObject.txt' );
		$template = preg_replace ( TemplateManager::$TABLE_UFIRST_PATTERN, $tableUFirst, $tableService );
		$template = preg_replace ( TemplateManager::$NAMESPACE_PATTERN, $namespace, $template );
		$template = preg_replace ( TemplateManager::$FIELD_VARS_PATTERN, $fieldVars, $template );
		$template = preg_replace ( TemplateManager::$FIELDS_PATTERN, $fieldsCon, $template );
		$template = preg_replace ( TemplateManager::$FIELDS_QUERY_PATTERN, $fieldsQuery, $template );
		$template = preg_replace ( TemplateManager::$COPYWRITE_PATTERN, $copywrite, $template );
		
		$filename = $tableUFirst . 'VO.as';
		
		Utilities::checkOrMakeFolders ( TemplateManager::$CLIENT_OUTPUT, $folderNamespace, 'vo' );
		$file = FileSystemService::writeFile ( TemplateManager::$CLIENT_OUTPUT . $folderNamespace . '/vo/' . $filename, $template );
		
		//return 'Value Object for' . $tableUFirst . ' Complete';
		return array ( 
			'label' => $filename, 'data' => $file 
		);
	}
	
	/**
	 * I generate a Cairngorm Save Event for the database table.
	 *
	 * @param [string] $output - The location where the file is to be placed once generated
	 * @param [string] $namespace - Applications namespace. example( com.domain.project )
	 * @param [string] $database - The applications database name.
	 * @param [string] $table - The applications databases table.
	 * @param [array] $fields - The applications table fields.
	 * @return [array] - An array containing the filename and the real file path.
	 */
	public static function generateSaveEvent( $output, $namespace, $database, $table, $fields = null )
	{
		$copywrite = ConfigManager::getConfigSetting ( $output, $database, 'copywrite' );
		$tableUFirst = ucfirst ( $table );
		
		//Create the fileame
		$filename = 'Save' . $tableUFirst . 'Event.as';
		
		//make the folder namespace
		$folderNamespace = Utilities::namespaceFolders ( $namespace );
		$namespace = Utilities::namespaceApplication ( $namespace );
		
		$tableService = FileSystemService::readFile ( TemplateManager::$CAIRNGORM_TEMPLATE_LOCATION . 'CairngormSaveEvent.txt' );
		$template = preg_replace ( TemplateManager::$TABLE_UFIRST_PATTERN, $tableUFirst, $tableService );
		$template = preg_replace ( TemplateManager::$NAMESPACE_PATTERN, $namespace, $template );
		$template = preg_replace ( TemplateManager::$EVENT_CONST, strtoupper ( $table ), $template );
		$template = preg_replace ( TemplateManager::$COPYWRITE_PATTERN, $copywrite, $template );
		
		Utilities::checkOrMakeFolders ( TemplateManager::$CLIENT_OUTPUT, $folderNamespace, 'events' );
		$file = FileSystemService::writeFile ( TemplateManager::$CLIENT_OUTPUT . $folderNamespace . '/events/' . $filename, $template );
		
		//return 'Cairngorm Event for ' . $tableUFirst . ' Complete';
		return array ( 
			'label' => $filename, 'data' => $file 
		);
	}
	
	/**
	 * I generate a Cairngorm Save Command for the database table.
	 *
	 * @param [string] $output - The location where the file is to be placed once generated
	 * @param [string] $namespace - Applications namespace. example( com.domain.project )
	 * @param [string] $database - The applications database name.
	 * @param [string] $table - The applications databases table.
	 * @param [array] $fields - The applications table fields.
	 * @return [array] - An array containing the filename and the real file path.
	 */
	public static function generateSaveCommand( $output, $namespace, $database, $table, $fields = null )
	{
		$copywrite = ConfigManager::getConfigSetting ( $output, $database, 'copywrite' );
		$tableUFirst = ucfirst ( $table );
		
		//Create the fileame
		$filename = 'Save' . $tableUFirst . 'Command.as';
		
		//make the folder namespace
		$folderNamespace = Utilities::namespaceFolders ( $namespace );
		$namespace = Utilities::namespaceApplication ( $namespace );
		
		$tableService = FileSystemService::readFile ( TemplateManager::$CAIRNGORM_TEMPLATE_LOCATION . 'CairngormSaveCommand.txt' );
		$template = preg_replace ( TemplateManager::$TABLE_UFIRST_PATTERN, $tableUFirst, $tableService );
		$template = preg_replace ( TemplateManager::$NAMESPACE_PATTERN, $namespace, $template );
		$template = preg_replace ( TemplateManager::$COPYWRITE_PATTERN, $copywrite, $template );
		
		Utilities::checkOrMakeFolders ( TemplateManager::$CLIENT_OUTPUT, $folderNamespace, 'commands' );
		$file = FileSystemService::writeFile ( TemplateManager::$CLIENT_OUTPUT . $folderNamespace . '/commands/' . $filename, $template );
		
		//return 'Cairngorm Save Command for ' . $tableUFirst . ' Complete';
		return array ( 
			'label' => $filename, 'data' => $file 
		);
	}
	
	/**
	 * I generate a Cairngorm Remove Event for the database table.
	 *
	 * @param [string] $output - The location where the file is to be placed once generated
	 * @param [string] $namespace - Applications namespace. example( com.domain.project )
	 * @param [string] $database - The applications database name.
	 * @param [string] $table - The applications databases table.
	 * @param [array] $fields - The applications table fields.
	 * @return [array] - An array containing the filename and the real file path.
	 */
	public static function generateRemoveEvent( $output, $namespace, $database, $table, $fields = null )
	{
		$copywrite = ConfigManager::getConfigSetting ( $output, $database, 'copywrite' );
		$tableUFirst = ucfirst ( $table );
		
		$filename = 'Remove' . $tableUFirst . 'Event.as';
		
		$folderNamespace = Utilities::namespaceFolders ( $namespace );
		$namespace = Utilities::namespaceApplication ( $namespace );
		$tableService = FileSystemService::readFile ( TemplateManager::$CAIRNGORM_TEMPLATE_LOCATION . 'CairngormRemoveEvent.txt' );
		
		$template = preg_replace ( TemplateManager::$TABLE_UFIRST_PATTERN, $tableUFirst, $tableService );
		$template = preg_replace ( TemplateManager::$NAMESPACE_PATTERN, $namespace, $template );
		$template = preg_replace ( TemplateManager::$EVENT_CONST, strtoupper ( $table ), $template );
		$template = preg_replace ( TemplateManager::$COPYWRITE_PATTERN, $copywrite, $template );
		
		Utilities::checkOrMakeFolders ( TemplateManager::$CLIENT_OUTPUT, $folderNamespace, 'events' );
		$file = FileSystemService::writeFile ( TemplateManager::$CLIENT_OUTPUT . $folderNamespace . '/events/' . $filename, $template );
		
		//return 'Cairngorm Remove Event for ' . $tableUFirst . ' Complete';
		return array ( 
			'label' => $filename, 'data' => $file 
		);
	}
	
	/**
	 * I generate a Cairngorm Remove Command for the database table.
	 *
	 * @param [string] $output - The location where the file is to be placed once generated
	 * @param [string] $namespace - Applications namespace. example( com.domain.project )
	 * @param [string] $database - The applications database name.
	 * @param [string] $table - The applications databases table.
	 * @param [array] $fields - The applications table fields.
	 * @return [array] - An array containing the filename and the real file path.
	 */
	public static function generateRemoveCommand( $output, $namespace, $database, $table, $fields = null )
	{
		$copywrite = ConfigManager::getConfigSetting ( $output, $database, 'copywrite' );
		$tableUFirst = ucfirst ( $table );
		
		$filename = 'Remove' . $tableUFirst . 'Command.as';
		
		$folderNamespace = Utilities::namespaceFolders ( $namespace );
		$namespace = Utilities::namespaceApplication ( $namespace );
		
		$tableService = FileSystemService::readFile ( TemplateManager::$CAIRNGORM_TEMPLATE_LOCATION . 'CairngormRemoveCommand.txt' );
		
		$template = preg_replace ( TemplateManager::$TABLE_UFIRST_PATTERN, $tableUFirst, $tableService );
		$template = preg_replace ( TemplateManager::$NAMESPACE_PATTERN, $namespace, $template );
		$template = preg_replace ( TemplateManager::$COPYWRITE_PATTERN, $copywrite, $template );
		
		Utilities::checkOrMakeFolders ( TemplateManager::$CLIENT_OUTPUT, $folderNamespace, 'commands' );
		$file = FileSystemService::writeFile ( TemplateManager::$CLIENT_OUTPUT . $folderNamespace . '/commands/' . $filename, $template );
		
		//return 'Cairngorm Remove Command for ' . $tableUFirst . ' Complete';
		return array ( 
			'label' => $filename, 'data' => $file 
		);
	}
	
	/**
	 * I generate a Cairngorm Get Event for the database table.
	 *
	 * @param [string] $output - The location where the file is to be placed once generated
	 * @param [string] $namespace - Applications namespace. example( com.domain.project )
	 * @param [string] $database - The applications database name.
	 * @param [string] $table - The applications databases table.
	 * @param [array] $fields - The applications table fields.
	 * @return [array] - An array containing the filename and the real file path.
	 */
	public static function generateGetEvent( $output, $namespace, $database, $table, $fields = null )
	{
		$copywrite = ConfigManager::getConfigSetting ( $output, $database, 'copywrite' );
		$tableUFirst = ucfirst ( $table );
		
		$filename = 'Get' . $tableUFirst . 'Event.as';
		
		$folderNamespace = Utilities::namespaceFolders ( $namespace );
		$namespace = Utilities::namespaceApplication ( $namespace );
		
		$tableService = FileSystemService::readFile ( TemplateManager::$CAIRNGORM_TEMPLATE_LOCATION . 'CairngormGetEvent.txt' );
		
		$template = preg_replace ( TemplateManager::$TABLE_UFIRST_PATTERN, $tableUFirst, $tableService );
		$template = preg_replace ( TemplateManager::$NAMESPACE_PATTERN, $namespace, $template );
		$template = preg_replace ( TemplateManager::$EVENT_CONST, strtoupper ( $table ), $template );
		$template = preg_replace ( TemplateManager::$COPYWRITE_PATTERN, $copywrite, $template );
		
		Utilities::checkOrMakeFolders ( TemplateManager::$CLIENT_OUTPUT, $folderNamespace, 'events' );
		$file = FileSystemService::writeFile ( TemplateManager::$CLIENT_OUTPUT . $folderNamespace . '/events/' . $filename, $template );
		
		//return 'Cairngorm Get Event for ' . $table . ' Complete';
		return array ( 
			'label' => $filename, 'data' => $file 
		);
	}
	
	/**
	 * I generate a Cairngorm Get Command for the database table.
	 *
	 * @param [string] $output - The location where the file is to be placed once generated
	 * @param [string] $namespace - Applications namespace. example( com.domain.project )
	 * @param [string] $database - The applications database name.
	 * @param [string] $table - The applications databases table.
	 * @param [array] $fields - The applications table fields.
	 * @return [array] - An array containing the filename and the real file path.
	 */
	public static function generateGetCommand( $output, $namespace, $database, $table, $fields = null )
	{
		$copywrite = ConfigManager::getConfigSetting ( $output, $database, 'copywrite' );
		$tableUFirst = ucfirst ( $table );
		
		$filename = 'Get' . $tableUFirst . 'Command.as';
		
		$folderNamespace = Utilities::namespaceFolders ( $namespace );
		$namespace = Utilities::namespaceApplication ( $namespace );
		
		$tableService = FileSystemService::readFile ( TemplateManager::$CAIRNGORM_TEMPLATE_LOCATION . 'CairngormGetCommand.txt' );
		
		$template = preg_replace ( TemplateManager::$TABLE_UFIRST_PATTERN, $tableUFirst, $tableService );
		$template = preg_replace ( TemplateManager::$NAMESPACE_PATTERN, $namespace, $template );
		$template = preg_replace ( TemplateManager::$COPYWRITE_PATTERN, $copywrite, $template );
		
		Utilities::checkOrMakeFolders ( TemplateManager::$CLIENT_OUTPUT, $folderNamespace, 'commands' );
		$file = FileSystemService::writeFile ( TemplateManager::$CLIENT_OUTPUT . $folderNamespace . '/commands/' . $filename, $template );
		
		//return 'Cairngorm Get Command for ' . $table . ' Complete';
		return array ( 
			'label' => $filename, 'data' => $file 
		);
	}

}

?>