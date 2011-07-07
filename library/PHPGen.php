<?php
/**
 * @name  	PHPGen.php
 * @author  Jonnie Spratley
 * @version 1.9
 * 
 */

require_once 'TemplateManager.php';
require_once 'FileSystemService.php';
require_once 'ConfigManager.php';
require_once 'SchemaManager.php';
require_once 'Utilities.php';

class PHPGen
{
	
	/**
	 * I create a value object for php
	 * 
	 * 
	 * @param [string] $filepath - The location where the config file is
	 * @param [string] $namespace - Applications namespace. example( com.domain.project )
	 * @param [string] $database - The applications database name.
	 * @param [string] $table - The applications databases table.
	 * @param [array] $fields - The applications table fields.
	 * @return [array] - An array containing the filename and the real file path.
	 */
	public static function generateValueObject( $filepath, $namespace, $database, $table, $fields = null )
	{
		$tableUFirst = ucfirst ( $table );
		$filename = $tableUFirst . 'VO.php';
		
		$folderNamespace = Utilities::namespaceFolders ( $namespace );
		$namespace = Utilities::namespaceApplication ( $namespace );
		
		$fieldVars = '';
		$fieldsCon = '';
		
		foreach ( $fields as $field )
		{
			$fieldVars .= '
			public $' . $field [ 'name' ] . ';';
			
			$fieldsCon .= '
			$this->' . $field [ 'name' ] . ' = $vo["' . $field [ 'name' ] . '"];';
			

		}
		
		$copywrite = '';
		if ( ConfigManager::getConfigSetting ( $filepath, $database, 'copywrite' ) )
		{
    		$copywrite = ConfigManager::getConfigSetting ( $filepath, $database, 'copywrite' );
		}

		
		$tableService = FileSystemService::readFile ( TemplateManager::$PHP_TEMPLATE_LOCATION . 'vo.txt' );
		
		$template = preg_replace ( TemplateManager::$TABLE_UFIRST_PATTERN, $tableUFirst, $tableService );
		$template = preg_replace ( TemplateManager::$FIELD_VARS_PATTERN, $fieldVars, $template );
		$template = preg_replace ( TemplateManager::$FIELDS_PATTERN, $fieldsCon, $template );
		$template = preg_replace ( TemplateManager::$NAMESPACE_PATTERN, $namespace, $template );
		$template = preg_replace ( TemplateManager::$COPYWRITE_PATTERN, $copywrite, $template );
		$template = preg_replace ( TemplateManager::$CG_VERSION_PATTERN, CGManager::$CG_VERSION, $template );
		$template = preg_replace ( TemplateManager::$CG_AUTHOR_PATTERN, CGManager::$CG_AUTHOR, $template );
		
		#Utilities::checkOrMakeFolders ( TemplateManager::$SERVER_OUTPUT, $folderNamespace, 'vo' );
		#$file = FileSystemService::writeFile ( TemplateManager::$SERVER_OUTPUT . $folderNamespace . '/vo/' . $filename, $template );
	
		#Utilities::log( $database.'-PHP-VO', 'wrote '.$tableUFirst . 'VO.php to '.TemplateManager::$SERVER_OUTPUT . $folderNamespace );
	
		//	return 'Generated PHP Value Object for ' . $tableUFirst;
		return array ( 
			'filename' => $filename, 'contents' => $template 
		);
	}
	public static function generateVO( $options, $table, $fields )
	{
		$tableUFirst = ucfirst ( $table );
		$filename = $tableUFirst . 'VO.php';

		$fieldVars = '';
		$fieldsCon = '';
		
		foreach ( $fields as $field )
		{
			$fieldVars .= '
			public $' . $field [ 'name' ] . ';';
			
			$fieldsCon .= '
			$this->' . $field [ 'name' ] . ' = $vo["' . $field [ 'name' ] . '"];';
 
		}
		
		$tableService = FileSystemService::readFile ( TemplateManager::$PHP_TEMPLATE_LOCATION . 'vo.txt' );
		
		$template = preg_replace ( TemplateManager::$TABLE_UFIRST_PATTERN, $tableUFirst, $tableService );
		$template = preg_replace ( TemplateManager::$FIELD_VARS_PATTERN, $fieldVars, $template );
		$template = preg_replace ( TemplateManager::$FIELDS_PATTERN, $fieldsCon, $template );
		$template = preg_replace ( TemplateManager::$NAMESPACE_PATTERN, $options['namespace'], $template );
		$template = preg_replace ( TemplateManager::$COPYWRITE_PATTERN, $options['copywrite'], $template );
		$template = preg_replace ( TemplateManager::$CG_VERSION_PATTERN, CGManager::$CG_VERSION, $template );
		$template = preg_replace ( TemplateManager::$CG_AUTHOR_PATTERN, CGManager::$CG_AUTHOR, $template );
		
	 
		//	return 'Generated PHP Value Object for ' . $tableUFirst;
		return array ( 
			'filename' => $filename, 
			'contents' => $template 
		);
	}
	
	/**
	 * Enter description here...
	 *
	 * @param [string] $filepath - The location where the config file is
	 * @param [string] $namespace - Applications namespace. example( com.domain.project )
	 * @param [string] $database - The applications database name.
	 * @param [string] $table - The applications databases table.
	 * @param [array] $fields - The applications table fields.
	 * @return [array] - An array containing the filename and the real file path.
	 */
	public static function generateBaseService( $filepath, $namespace, $database, $table, $fields = null )
	{
		$orgTable = $table;
		$tableUFirst = ucfirst ( $table );
		$tableLC = strtolower ( $table );
		$filename = ucfirst ( $table ) . 'Service.php';
		$folderNamespace = Utilities::namespaceFolders ( $namespace );
		$namespace = Utilities::namespaceApplication ( $namespace );
		$tableService = FileSystemService::readFile ( TemplateManager::$PHP_TEMPLATE_LOCATION . 'dao.txt' );
		$setFields = '';
		
		foreach ( $fields as $field )
		{
			$setFields .= '' . $field [ 'name' ] . ' = ".$this->_prepare( $' . $tableUFirst . 'VO->' . $field [ 'name' ] . ').", ';
		}
		
		$setFields = Utilities::trimSQL ( $setFields );
		$copywrite = ConfigManager::getConfigSetting ( $filepath, $database, 'copywrite' );
		
		$template = preg_replace ( TemplateManager::$TABLE_LOWERCASE_PATTERN, $tableLC, $tableService );
		$template = preg_replace ( TemplateManager::$TABLE_UFIRST_PATTERN, $tableUFirst, $template );
		$template = preg_replace ( TemplateManager::$TABLE_UFIRST_PATTERN, $tableUFirst, $template );
		$template = preg_replace ( TemplateManager::$TABLE_PATTERN, $orgTable, $template );
		$template = preg_replace ( TemplateManager::$DATABASE_PATTERN, $database, $template );
		$template = preg_replace ( TemplateManager::$SET_FIELDS_PATTERN, $setFields, $template );
		$template = preg_replace ( TemplateManager::$NAMESPACE_PATTERN, $namespace, $template );
		$template = preg_replace ( TemplateManager::$CG_VERSION_PATTERN, CGManager::$CG_VERSION, $template );
		$template = preg_replace ( TemplateManager::$CG_AUTHOR_PATTERN, CGManager::$CG_AUTHOR, $template );
		$template = preg_replace ( TemplateManager::$COPYWRITE_PATTERN, $copywrite, $template );
		
		Utilities::checkOrMakeFolders ( TemplateManager::$SERVER_OUTPUT, $folderNamespace, '' );
		$file = FileSystemService::writeFile ( TemplateManager::$SERVER_OUTPUT . $folderNamespace . '/' . $filename, $template );
		
		Utilities::log( $database.'-PHP-SERVICE', 'wrote '.$tableUFirst . 'Service.php to '.TemplateManager::$SERVER_OUTPUT . $folderNamespace );
		
		//return 'Generated PHP Service for ' . $tableUFirst;
		return array ( 
			'label' => $tableUFirst . 'Service.php', 'data' => $file 
		);
	}
	
	/**
	 * I generate a REST service class for the application, one per application.
	 * I have methods that call upon the proper class based on the URL query string.
	 *
	 * @param [string] $output - The location where the file is to be placed once generated
	 * @param [string] $namespace - Applications namespace. example( com.domain.project )
	 * @param [string] $database - The applications database name.
	 * @param [string] $table - The applications databases table.
	 * @param [array] $fields - The applications table fields.
	 * @return [array] - An array containing the filename and the real file path.
	 */
	public static function generateRESTService( $filepath, $namespace, $database, $table, $fields = null )
	{
		$database = ucfirst ( $database );
		$filename = ucfirst ( $database ) . 'Service.php';
		
		$folderNamespace = Utilities::namespaceFolders ( $namespace );
		$namespace = Utilities::namespaceApplication ( $namespace );
		
		$restServiceIncludes = '';
		$restGetSwitch = '';
		$restSaveSwitch = '';
		$restRemoveSwitch = '';
		
		foreach ( $table as $tbl )
		{
			$restServiceIncludes .= '
			require_once ( "' . ucfirst ( $tbl [ 'table' ] ) . 'Service.php" );
			require_once ( "vo/' . ucfirst ( $tbl [ 'table' ] ) . 'VO.php" );
			';
			
			/* -------- GET ---------- */
			$restGetSwitch .= '
				case "' . $tbl [ 'table' ] . '":
					$service = new ' . ucfirst ( $tbl [ 'table' ] ) . 'Service();
					$results = $service->getAll' . ucfirst ( $tbl [ 'table' ] ) . '();
					print_r( json_encode( $results ) );
				break;
				';
			
			/* -------- SAVE ---------- */
			$restSaveSwitch .= '
				case "' . $tbl [ 'table' ] . '":
					$service = new ' . ucfirst ( $tbl [ 'table' ] ) . 'Service();
					$results = $service->save' . ucfirst ( $tbl [ 'table' ] ) . '( $query );
					print_r( json_encode( $results ) );
				break;
				';
			
			/* -------- REMOVE ---------- */
			$restRemoveSwitch .= '
				case "' . $tbl [ 'table' ] . '":
					$service = new ' . ucfirst ( $tbl [ 'table' ] ) . 'Service();
					$results = $service->remove' . ucfirst ( $tbl [ 'table' ] ) . '( $query );
					print_r( json_encode( $results ) );
				break;
				';
		}
		$copywrite = ConfigManager::getConfigSetting ( $filepath, $database, 'copywrite' );
		$databaseService = FileSystemService::readFile ( TemplateManager::$PHP_TEMPLATE_LOCATION . 'rest.txt' );
		
		$template = preg_replace ( TemplateManager::$FILE_INCLUDES_PATTERN, $restServiceIncludes, $databaseService );
		$template = preg_replace ( TemplateManager::$REST_TABLE_GET_PATTERN, $restGetSwitch, $template );
		$template = preg_replace ( TemplateManager::$REST_TABLE_SAVE_PATTERN, $restSaveSwitch, $template );
		$template = preg_replace ( TemplateManager::$REST_TABLE_REMOVE_PATTERN, $restRemoveSwitch, $template );
		$template = preg_replace ( TemplateManager::$COPYWRITE_PATTERN, $copywrite, $template );
		$template = preg_replace ( TemplateManager::$CG_VERSION_PATTERN, CGManager::$CG_VERSION, $template );
		$template = preg_replace ( TemplateManager::$CG_AUTHOR_PATTERN, CGManager::$CG_AUTHOR, $template );
		
		Utilities::checkOrMakeFolders ( TemplateManager::$SERVER_OUTPUT, $folderNamespace, '' );
		$file = FileSystemService::writeFile ( TemplateManager::$SERVER_OUTPUT . $folderNamespace . '/' . $filename, $template );
		
		Utilities::log( $database.'-PHP-REST', 'wrote '.$database . 'REST.php to '.TemplateManager::$SERVER_OUTPUT . $folderNamespace );
		
		return array ( 
			'label' => $database . 'Service.php', 'data' => $file 
		);
	}
	
	/**
	 * I create the connection file for database access.
	 *
	 * @param [string] $output - The location where the file is to be placed once generated
	 * @param [string] $database - The applications database name.
	 * @return [array] - An array containing the filename and the real file path.
	 */
	public static function writeConnection( $filepath, $database )
	{
		$databaseName = ConfigManager::getConfigSetting ( $filepath, $database, 'database' );
		$namespace = ConfigManager::getConfigSetting ( $filepath, $database, 'namespace' );
		$copywrite = ConfigManager::getConfigSetting ( $filepath, $database, 'copywrite' );
		$host = ConfigManager::getConfigSetting ( $filepath, $database, 'host' );
		$user = ConfigManager::getConfigSetting ( $filepath, $database, 'user' );
		$pass = ConfigManager::getConfigSetting ( $filepath, $database, 'pass' );
		
		$folderNamespace = Utilities::namespaceFolders ( $namespace );
		$conn = FileSystemService::readFile ( TemplateManager::$PHP_TEMPLATE_LOCATION . 'conn.txt' );
	
		$template = preg_replace ( TemplateManager::$HOST_PATTERN, $host, $conn );
		$template = preg_replace ( TemplateManager::$USER_PATTERN, $user, $template );
		$template = preg_replace ( TemplateManager::$PASS_PATTERN, $pass, $template );
		$template = preg_replace ( TemplateManager::$DATABASE_PATTERN, $databaseName, $template );
		$template = preg_replace ( TemplateManager::$CG_VERSION_PATTERN, CGManager::$CG_VERSION, $template );
		$template = preg_replace ( TemplateManager::$CG_AUTHOR_PATTERN, CGManager::$CG_AUTHOR, $template );
		$template = preg_replace ( TemplateManager::$COPYWRITE_PATTERN, $copywrite, $template );
 
		$file = FileSystemService::writeFile ( TemplateManager::$SERVER_OUTPUT . $folderNamespace . '/' . $database . 'Connection.php', $template );
		
		Utilities::log( $database.'-PHP-CONN', 'wrote '.$database . 'Connection.php to '.TemplateManager::$SERVER_OUTPUT . $folderNamespace );
		
		return array ( 
			'label' => 'Connection File', 'data' => $file 
		);
	}
}
 
 
?>