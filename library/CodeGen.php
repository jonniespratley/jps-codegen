<?php
/**
 * @name  	CodeGen.php
 * @author  Jonnie Spratley
 * @version 1.9
 */

 

//require_once 'ConfigReader.php';
require_once 'SchemaManager.php';
require_once 'FileSystemService.php';
require_once 'ConfigManager.php';

class CodeGen {
	private $mysqli;
	private $log;
	private $config;

	private $cg_sqlite;
	private $cg_dsn = 'sqlite:';
	static private $cg_apps_sql = 'CREATE TABLE cg_apps (id integer NOT NULL PRIMARY KEY AUTOINCREMENT,app_name varchar,app_url varchar,app_config varchar,app_schema varchar,app_timestamp timestamp)';
	static private $cg_assets_sql = 'CREATE TABLE cg_assets (id integer NOT NULL PRIMARY KEY AUTOINCREMENT,name varchar,value varchar)';
	static private $cg_history_sql = 'CREATE TABLE cg_history (id integer NOT NULL PRIMARY KEY AUTOINCREMENT,history_name varchar,history_value varchar,history_timestamp timestamp)';
	static private $cg_options_sql = 'CREATE TABLE cg_options (id integer NOT NULL PRIMARY KEY AUTOINCREMENT,name varchar,value varchar)';
	static private $cg_settings_sql = 'CREATE TABLE cg_settings (id integer NOT NULL PRIMARY KEY AUTOINCREMENT,setting_name varchar, setting_value varchar)';
	static private $cg_users_sql = 'CREATE TABLE cg_users (id integer NOT NULL PRIMARY KEY AUTOINCREMENT,user_email varchar NOT NULL,user_pass varchar NOT NULL,user_role integer DEFAULT 0,user_lastlogin timestamp)';

	/**
	 * I am the CodeGen Core constructure that opens up the local sqlite database and gathers all of the recent apps.
	 */
	public function __construct($sqlitePath ='', $debug = false) {
		
		 
		
		$this -> cg_dsn .= $sqlitePath;

		try {
			$db = new PDO($this -> cg_dsn);
			$db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			$this -> cg_sqlite = $db;
		} catch(PDOException $e) {
			echo 'PDO Exception Caught. ';
			echo 'Error with the database: <br/>';
			echo '<pre>';
			echo 'Error: ' . $e -> getMessage() . '<br/>';
			echo 'Code: ' . $e -> getCode() . '<br/>';
			echo 'File: ' . $e -> getFile() . '<br/>';
			echo 'Line: ' . $e -> getLine() . '<br/>';
			echo 'Trace: ' . $e -> getTraceAsString();
			echo '</pre>';
			exit();
		}
	}

	/**
	 * I am the constructore for the CodeGen
	 *
	 *
	 * @param [string] $configFile The config.xml file
	 */
	public function start($filepath, $database) {
		ConfigManager::readConfig($filepath, $database);
		$this -> mysqli = new mysqli(ConfigManager::getHost(), ConfigManager::getUser(), ConfigManager::getPass());
		
	}

	/**
	 * I write the schema.xml file that is a copy of the structure from the database.
	 *
	 * @return [none]
	 */
	public function writeSchema($filepath) {
		return SchemaManager::writeSchema($this -> mysqli, $filepath, ConfigManager::getDatabase());
	}

	/**
	 * I generate the code from what the schema.xml file defines.
	 *
	 * @param [string] $schema The location of the DatabaseSchema.xml file
	 * @return [none] Generated Code in output folder
	 */
	public function generateCode($filepath) {
		return SchemaManager::readSchema($filepath, ConfigManager::getDatabase());
	}

	/**
	 * I browse the directory and return a array of folders, and files
	 *
	 * @param [string] $path the path, defaults to '.';
	 * @param [int] $level how deep
	 * @return [array]
	 */
	public function browseDirectory($path, $level) {
		return FileSystemService::browseDirectory($path, $level);
	}

	/**
	 * I read the contents of a file.
	 *
	 * @param [string] $file the file path
	 * @return [string] the contents
	 */
	static public function readFile($file) {
		return FileSystemService::readFile($file);
	}

	/**
	 * I write data to a file
	 *
	 * @param [string] $file the file path
	 * @param [string] $contents the file contents
	 * @return [string] true or false
	 */
	public function writeFile($file, $contents) {
		return FileSystemService::writeFile($file, $contents);
	}

	private function execute($sql) {
		return $this -> mysqli -> query($sql);
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
	static public function writeConfig($options) {
		return ConfigManager::writeConfig($options);
	}

	/*
	 ALL SQLITE METHODS
	 */

	public function saveSetting($name, $value) {
		$sql = 'UPDATE cg_settings SET setting_value = :value WHERE setting_name = :name';
		$stmt = $this -> cg_sqlite -> prepare($sql);
		$stmt -> bindParam(':name', $name);
		$stmt -> bindParam(':value', $value);
		$count = $stmt -> execute();
		return $count;
	}

	public function saveSettings($settings) {
		$result = '';
		foreach($settings as $name => $value) {
			$result = $this -> saveSetting($name, $value);
		}
		return $result;
	}

	public function saveHistory($name, $value) {
		$sql = 'INSERT INTO cg_history VALUES (NULL, :name, :value)';
		$stmt = $this -> cg_sqlite -> prepare($sql);
		$stmt -> bindParam(':name', $name);
		$stmt -> bindParam(':value', $value);
		$count = $stmt -> execute();
		return $count;
	}

	public function saveApp($name, $url, $config, $schema) {
		$timestamp = date("Y-m-d H:i:s");
		$sql = 'INSERT INTO cg_apps VALUES (NULL, :name, :url, :config, :schema, :time)';
		$stmt = $this -> cg_sqlite -> prepare($sql);
		$stmt -> bindParam(':name', $name);
		$stmt -> bindParam(':url', $url);
		$stmt -> bindParam(':config', $config);
		$stmt -> bindParam(':schema', $schema);
		$stmt -> bindParam(':time', $timestamp);
		$count = $stmt -> execute();
		return $count;
	}

	public function saveUser($email, $pass, $role) {
		$timestamp = date("Y-m-d H:i:s");
		$sql = 'INSERT INTO cg_users VALUES (NULL, :email, :pass, :role, :time)';
		$stmt = $this -> cg_sqlite -> prepare($sql);
		$stmt -> bindParam(':email', $email);
		$stmt -> bindParam(':pass', sha1($pass));
		$stmt -> bindParam(':role', $role);
		$stmt -> bindParam(':time', $timestamp);
		$count = $stmt -> execute();
		return $count;
	}

	/*

	 UPDATE cg_users SET user_lastlogin = '' WHERE id = '3';
	 */

	public function loginUser($email, $pass) {
		$sql = 'SELECT * FROM cg_users WHERE user_email = :email, AND user_pass = :pass';
		$stmt = $this -> cg_sqlite -> prepare($sql);
		$stmt -> bindParam(':email', $email, PDO::PARAM_STR);
		$stmt -> bindParam(':pass', sha1($pass), PDO::PARAM_STR);
		$stmt -> execute();
		$result = array();

		while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
			$result[] = $row;
		}
		return $result;
	}

	public function removeApp($id) {

		$sql = 'DELETE FROM cg_apps WHERE id = :id';
		$stmt = $this -> cg_sqlite -> prepare($sql);
		$stmt -> bindParam(':id', $id);
		$count = $stmt -> execute();
		return $count;
	}

	public function getSetting($name) {

		$sql = "SELECT setting_value FROM cg_settings WHERE setting_name =  '$name' LIMIT 1";

		$stmt = $this -> cg_sqlite -> prepare($sql);
		$stmt -> execute();
		$results = array();

		while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
			$results = $row;
		}
		return $results['setting_value'];
	}

	public function getSettings() {
		$sql = "SELECT * FROM cg_settings";

		$stmt = $this -> cg_sqlite -> prepare($sql);
		$stmt -> execute();
		$results = array();

		while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
			$results[] = $row;
		}
		return $results;
	}

	public function getHistory() {
		$sql = "SELECT * FROM cg_history";
		$dbh = $this -> cg_sqlite;
		$stmt = $dbh -> prepare($sql);
		$stmt -> execute();
		$results = array();

		while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
			$results[] = $row;
		}
		return $results;
	}

	public function getApps() {
		$sql = "SELECT * FROM cg_apps ORDER BY app_timestamp DESC";
		$dbh = $this -> cg_sqlite;
		$stmt = $dbh -> prepare($sql);
		$stmt -> execute();
		$results = array();
		while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
			$results[] = $row;
		}
		return $results;
	}

	static public function googlecode_Get($url ='', $count =null) {

		$json = file_get_contents($url);
		$jsonArray = json_decode($json);
		$title = $jsonArray -> value -> title;
		$desc = $jsonArray -> value -> description;
		$entries = $jsonArray -> value -> items;

		$entryArray = $entries[0];

		$entryCount = ($count != null ? $count : count($entryArray));
		$returnArray = array();
		for($i = 0; $i < $entryCount; $i++) {
			$entry = $entryArray -> entry[$i];

			$entryLink = $entry -> link -> type;
			$entryContent = $entry -> content -> content;
			$entryCategory = $entry -> category -> term;
			$entryAuthor = $entry -> author -> name;
			$entryDate = $entry -> updated;

			$returnArray[] = array('type' => $entryCategory, 'author' => $entryAuthor, 'link' => $entryLink, 'content' => $entryContent, 'date' => date('m.d.y', strtotime($entryDate)));
		}
		return $returnArray;
	}

}
?>
