<?php
/**
 * @name  	ConnectionWriter.php
 * @author  Jonnie Spratley
 * @version 1.9
 * 
 */
require_once 'TemplateManager.php';
require_once 'FileSystemService.php';
require_once 'ConfigManager.php';
require_once 'SchemaReader.php';
require_once 'Utilities.php';

class ConnectionWriter
{
	
	public static function writeConnection( $output, $database )
	{
		ConfigManager::readConfig ( $output, $database );
		
		$folderNamespace = Utilities::namespaceFolders ( ConfigManager::getNamespace () );
		
		//read the template
		$conn = FileSystemService::readFile ( TemplateManager::$PHP_TEMPLATE_LOCATION . 'conn.txt' );
		
		//replace the table name inside of the template
		$template = preg_replace ( TemplateManager::$HOST_PATTERN, $config->getHost (), $conn );
		$template = preg_replace ( TemplateManager::$USER_PATTERN, $config->getUser (), $template );
		$template = preg_replace ( TemplateManager::$PASS_PATTERN, $config->getPass (), $template );
		
		$template = preg_replace ( TemplateManager::$CG_VERSION_PATTERN, CGManager::$CG_VERSION, $template );
		$template = preg_replace ( TemplateManager::$CG_AUTHOR_PATTERN, CGManager::$CG_AUTHOR, $template );
		
		//write the file 
		FileSystemService::writeFile ( TemplateManager::$SERVER_OUTPUT . $folderNamespace . '/' . ucfirst ( $database ) . 'Connection.php', $template );
		
		return 'Connection File Written';
	}

}

?>