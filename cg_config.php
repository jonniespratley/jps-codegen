<?php

/**
 * 
 * Configure these to your database on development environment
 */
define('CG_DATABASE', 'jps_codegen');
define('CG_HOST', 'localhost');
define('CG_USER', 'root');
define('CG_PASS', 'fred');


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

$sqlitePath = CG_SQLITE;
$outputPath = CG_OUTPUT_DIR;

$codegen = new CodeGen ( $sqlitePath, true );
$mysql = new MySQLService ( );
$filesSvc = new FileSystemService ( );
?>