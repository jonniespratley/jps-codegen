<?php
/**
 * @name  	ConfigManager.php
 * @author  Jonnie Spratley
 * @version 1.9
 */
require_once 'TemplateManager.php';
require_once 'Utilities.php';

class ConfigManager
{
	public static $host;
	public static $user;
	public static $pass;
	public static $endpoint;
	public static $namespace;
	public static $database;
	public static $application;
	public static $framework;
	public static $copywrite;
	public static $htmlDemoURL;
	
	/**
	 * I read the config.xml file and set all of the values to the setters.
	 *
	 * @param [string] $filepath - Path to the file, leave trailing '/'
	 * @param unknown_type $database - Name of the database.
	 */
	public static function readConfig( $filepath, $database )
	{
		$configFile = $filepath . ucfirst ( $database ) . 'Config.xml';
		
		if ( file_exists ( $configFile ) )
		{
			$dom = new DOMDocument ( );
			$dom->load ( $configFile );
			
			$configs = $dom->getElementsByTagName ( "config" );
			
			foreach ( $configs as $config )
			{
				$hosts = $config->getElementsByTagName ( "host" );
				self::setHost ( $hosts->item ( 0 )->nodeValue );
				
				$users = $config->getElementsByTagName ( "user" );
				self::setUser ( $users->item ( 0 )->nodeValue );
				
				$passes = $config->getElementsByTagName ( "pass" );
				self::setPass ( $passes->item ( 0 )->nodeValue );
				
				$endpoints = $config->getElementsByTagName ( "endpoint" );
				self::setEndpoint ( $endpoints->item ( 0 )->nodeValue );
				
				$namespaces = $config->getElementsByTagName ( "namespace" );
				self::setNamespace ( $namespaces->item ( 0 )->nodeValue );
				
				$databases = $config->getElementsByTagName ( "database" );
				self::setDatabase ( $databases->item ( 0 )->nodeValue );
				
				$applications = $config->getElementsByTagName ( "application" );
				self::setApplication ( $applications->item ( 0 )->nodeValue );
				
				/**
				 * @TODO: added 05/2/09
				 * Framework and Copywrite
				 */
				$frameworks = $config->getElementsByTagName ( "framework" );
				self::setFramework ( $frameworks->item ( 0 )->nodeValue );
				
				$copywrites = $config->getElementsByTagName ( "copywrite" );
				self::setCopywrite ( $copywrites->item ( 0 )->nodeValue );
			
			}
		}
		else
		{
			trigger_error ( $configFile . " does not exist at " . $filepath );
			exit ();
		}
	}
	
	/**
	 * I write the config.xml file from the users information
	 *
	 * @param [string] $host - database host
	 * @param [string] $user - database user
	 * @param [string] $pass - database password
	 * @param [string] $app - application name
	 * @param [string] $schema - name of database
	 * @param [string] $endpoint - url of service file
	 * @param [string] $namespace - namespace of developer
	 * @return [string] location of config.xml
	 */
	public static function writeConfig( $filepath, $host, $user, $pass, $database, $app, $endpoint, $namespace, $framework, $copywrite )
	{
		$dom = new DOMDocument ( '1.0' );
		
		//create a element
		$config = $dom->createElement ( 'config' );
		
		//set the element on itself
		$config = $dom->appendChild ( $config );
		
		//Host
		$hostNode = $dom->createElement ( 'host' );
		$hostValue = $dom->createTextNode ( $host );
		$hostNode->appendChild ( $hostValue );
		
		//User
		$userNode = $dom->createElement ( 'user' );
		$userValue = $dom->createTextNode ( $user );
		$userNode->appendChild ( $userValue );
		
		//Pass
		$passNode = $dom->createElement ( 'pass' );
		$passValue = $dom->createTextNode ( $pass );
		$passNode->appendChild ( $passValue );
		
		//Database
		$databaseNode = $dom->createElement ( 'database' );
		$databaseValue = $dom->createTextNode ( $database );
		$databaseNode->appendChild ( $databaseValue );
		
		//Application
		$appNode = $dom->createElement ( 'application' );
		$appValue = $dom->createTextNode ( $app );
		$appNode->appendChild ( $appValue );
		
		//Namespace
		$namespaceNode = $dom->createElement ( 'namespace' );
		$namespaceValue = $dom->createTextNode ( $namespace );
		$namespaceNode->appendChild ( $namespaceValue );
		
		//Endoint
		$endpointNode = $dom->createElement ( 'endpoint' );
		$endpointValue = $dom->createTextNode ( $endpoint );
		$endpointNode->appendChild ( $endpointValue );
		
		/*
		 * 
		 * ADDED 5/2/09
		 * framework - cairngorm or as3
		 * copywrite - for the developer to add to each file.
		 */
		
		//Framework
		$frameworkNode = $dom->createElement ( 'framework' );
		$frameworkValue = $dom->createTextNode ( $framework );
		$frameworkNode->appendChild ( $frameworkValue );
		
		//Copywrite
		$copywriteNode = $dom->createElement ( 'copywrite' );
		$copywriteValue = $dom->createTextNode ( $copywrite );
		$copywriteNode->appendChild ( $copywriteValue );
		
		//Add all of the values to the root node
		$config->appendChild ( $hostNode );
		$config->appendChild ( $userNode );
		$config->appendChild ( $passNode );
		$config->appendChild ( $databaseNode );
		$config->appendChild ( $appNode );
		$config->appendChild ( $namespaceNode );
		$config->appendChild ( $endpointNode );
		
		//added 5/2/09
		$config->appendChild ( $frameworkNode );
		$config->appendChild ( $copywriteNode );
		
		//updated this 4/20/09 - Jonnie - Now multiple config files can be created, for each database.
		

		$filename = '';
		
		$filename = $filepath . ucfirst ( $database ) . 'Config.xml';
		$dom->formatOutput = true;
		$dom->save ( $filename );
		
		//change the permissions
		//chmod ( $filename, 0775 );
		

		return $filename;
	}
	
	/**
	 * I get a setting for a user
	 *
	 * @param [string] $filepath
	 * @param [string] $database
	 * @param [string] $option
	 * @return [string]
	 */
	static public function getConfigSetting( $filepath, $database, $option )
	{
		$result = '';
		self::readConfig ( $filepath, $database );
		
		switch ( $option )
		{
			case 'host':
				$result = self::getHost ();
				break;
			
			case 'user':
				$result = self::getUser ();
				break;
			
			case 'pass':
				$result = self::getPass ();
				break;
			
			case 'database':
				$result = self::getDatabase ();
				break;
			
			case 'application':
				$result = self::getApplication ();
				break;
			
			case 'framework':
				$result = self::getFramework ();
				break;
			
			case 'copywrite':
				$result = self::getCopywrite ();
				break;
			
			case 'endpoint':
				$result = self::getEndpoint ();
				break;
			
			case 'namespace':
				$result = self::getNamespace ();
				break;
		}
		return $result;
	}
	
	/**
	 * @return [string]
	 */
	public static function getApplication()
	{
		return self::$application;
	}
	
	/**
	 * @return [string]
	 */
	public static function getCopywrite()
	{
		return self::$copywrite;
	}
	
	/**
	 * @return [string]
	 */
	public static function getDatabase()
	{
		return self::$database;
	}
	
	/**
	 * @return [string]
	 */
	public static function getEndpoint()
	{
		return self::$endpoint;
	}
	
	/**
	 * @return [string]
	 */
	public static function getFramework()
	{
		return self::$framework;
	}
	
	/**
	 * @return [string]
	 */
	public static function getHost()
	{
		return self::$host;
	}
	
	/**
	 * @return [string]
	 */
	public static function getNamespace()
	{
		return self::$namespace;
	}
	
	/**
	 * @return [string]
	 */
	public static function getPass()
	{
		return self::$pass;
	}
	
	/**
	 * @return [string]
	 */
	public static function getUser()
	{
		return self::$user;
	}
	
	/**
	 * @param [string] $application
	 */
	public static function setApplication( $application )
	{
		self::$application = $application;
	}
	
	/**
	 * @param [string] $copywrite
	 */
	public static function setCopywrite( $copywrite )
	{
		self::$copywrite = $copywrite;
	}
	
	/**
	 * @param [string] $database
	 */
	public static function setDatabase( $database )
	{
		self::$database = $database;
	}
	
	/**
	 * @param [string] $endpoint
	 */
	public static function setEndpoint( $endpoint )
	{
		self::$endpoint = $endpoint;
	}
	
	/**
	 * @param [string] $framework
	 */
	public static function setFramework( $framework )
	{
		self::$framework = $framework;
	}
	
	/**
	 * @param [string] $host
	 */
	public static function setHost( $host )
	{
		self::$host = $host;
	}
	
	/**
	 * @param [string] $namespace
	 */
	public static function setNamespace( $namespace )
	{
		self::$namespace = $namespace;
	}
	
	/**
	 * @param [string] $pass
	 */
	public static function setPass( $pass )
	{
		self::$pass = $pass;
	}
	
	/**
	 * @param [string] $user
	 */
	public static function setUser( $user )
	{
		self::$user = $user;
	}
	
	/**
	 * @return unknown
	 */
	public static function getHtmlDemoURL()
	{
		$folderURL = Utilities::namespaceFolders ( self::getNamespace () );
		$applicationName = self::getApplication ();
		$applicationName = ucfirst ( $applicationName );
		$url = $folderURL . $applicationName . 'Main.php';
		return $url;
	}

}

//ConfigManager::readConfig( '/Applications/MAMP/htdocs/CodeGen/output/', 'Test' );
//echo ConfigManager::getCopywrite();


//echo ConfigManager::getConfigSetting( '/Applications/MAMP/htdocs/CodeGen/output/', 'Test', 'database' );


?>