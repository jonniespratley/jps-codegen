<?php
/**
 * @name  	EclipseGen.php
 * @author  Jonnie Spratley
 * @version 1.9
 * 
 */
require_once 'TemplateManager.php';
require_once 'FileSystemService.php';
require_once 'ConfigManager.php';
require_once 'SchemaManager.php';
require_once 'Utilities.php';

class EclipseGen
{
	public static function writeProject( $database )
	{
		$config = new ConfigReader ( );
		$config->readConfig ( TemplateManager::$CONFIG_OUTPUT . '/' . ucfirst ( $database ) . 'Config.xml' );
		
		$appPattern = TemplateManager::$APPLICATION_PATTERN;
		
		$folderNamespace = Utilities::namespaceFolders ( $config->getNamespace () );
		
		//read the template
		$as3Props = FileSystemService::readFile ( TemplateManager::$ECLIPSE_TEMPLATE_LOCATION . 'actionScriptProperties.txt' );
		
		//replace the table name inside of the template
		$template = preg_replace ( $appPattern, $config->getApplication (), $as3Props );
		
		//write the file 
		FileSystemService::writeFile ( TemplateManager::$CLIENT_OUTPUT . $folderNamespace . '/.actionScriptProperties', $template );
	
	}
	
	public static function makeDirectory( $application, $namespace )
	{
		$newNamespace = str_replace ( '.', '/', $namespace );
		
		$projectFolder = $application . '/';
		$dirPath = 'output/' . $projectFolder;
		
		$htmltemplateFolder = $dirPath . 'html-template/';
		$srcFolder = $dirPath . 'src/' . $newNamespace;
		$libsFolder = $dirPath . 'libs/';
		
		if ( ! is_dir ( $dirPath ) )
		{
			mkdir ( $dirPath, 0777 );
		}
		if ( ! is_dir ( $htmltemplateFolder ) )
		{
			mkdir ( $htmltemplateFolder, 0777 );
		}
		if ( ! is_dir ( $srcFolder ) )
		{
			mkdir ( $srcFolder, 0777, true );
		}
		
		if ( ! is_dir ( $libsFolder ) )
		{
			mkdir ( $libsFolder, 0777 );
		}
		chmod ( $srcFolder, 0777 );
		
		return $srcFolder . '/';
	}

}

?>