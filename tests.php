<?php
 

 
 
$cg_host = 'localhost';
$cg_user = 'root';
$cg_pass = 'fred';
$cg_database = 'jps_codegen';
$cg_app = '';
$cg_namespace = '';
$cg_endpoint = '';
$cg_copywrite = '';
$cg_framework = '';

$cg_sqlite = 'CodeGen.sqlite';
$cg_output = 'output/';

$codegen = new CodeGen ( $cg_sqlite, true );
$cg_result = array();

$firephp->group('jps-codegen - Tests');
$firephp->log($codegen);
$firephp->log($cg_sqlite);
$firephp->groupEnd();

$cg_options = array(
	'host' => 'localhost',
	'user' => 'root',
	'pass' => 'fred',
	'database' => 'test',
	'app' => 'TestApp',
	'namespace' => 'com.jonniespratley.testapp',
	'path' => '/Applications/MAMP/jps-codegen/output',
	'endpoint' => 'somegateway.php',
	'framework' => 'html',
	'ui-framework' => 'Backbone',
	'copywrite' => 'this is your default copywrite, much better than before.'
	
);
$cg_database = 'test';
$cg_table = 'users';
$cg_fields = array(
	array('name' => 'id', 'type' => 'int'),
	array('name' => 'title', 'type' => 'string'),
	array('name' => 'body', 'type' => 'string'),
	array('name' => 'created', 'type' => 'datetime')
);


$codegen->writeConfig($cg_options);



?>