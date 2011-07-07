<pre>
	
<?php
/**
 *  <host>localhost</host>
  <user></user>
  <pass></pass>
  <database></database>
  <application></application>
  <namespace></namespace>
  
  
  <!-- @TODO: New tags for changed parameters-->
  <path></path>
  
  
  <endpoint>services/</endpoint>
  <framework></framework>
  <copywrite>
  	<![CDATA[
	
	]]>
	</copywrite>
 * 
 */
require_once 'library/PHPGen.php';
$options = array(
	'host' => 'localhost',
	'user' => 'root',
	'pass' => 'fred',
	'database' => 'demo',
	'application' => 'Demo',
	'namespace' => 'com.demo.app',
	'path' => '/Applications/MAMP/CodeGen/output/Demo',
	'endpoint' => 'services/',
	'framework' => 'Cairngorm',
	'copywrite' => 'this is your default copywrite, much better than before.'
	
);
$table = 'posts';
$database = 'demo';
$fields = array(
	array('name' => 'id', 'type' => 'int'),
	array('name' => 'title', 'type' => 'string'),
	array('name' => 'body', 'type' => 'string'),
	array('name' => 'created', 'type' => 'datetime')
);

$vo = PHPGen::generateVO($options, $database, $table, $fields);

file_put_contents($vo['filename'], $vo['contents']);
print_r($vo);
 
/*
require_once 'library/MySQLService.php';

$u = 'root';
$p = 'fred';
$h = 'localhost';
$d = 'demo';

$mysql = new MySQLService ( );
$mysql->connect ( $h, $u, $p );
$tables = $mysql->getTables ( $d );

$tablePrimarys = array();
$tablePrimary = array();
$fields = array();
$keys = array();

$tableFields = array();
foreach($tables as $table){
	$fieldNames = array();
	foreach($table['aFields'] as $field){
		$fieldNames[] = $field['Field'];		
	}
		$tableFields[] = array('table' => $table['label'], 'fields' => $fieldNames );
	
	echo '<h2> Table Fields </h2>';
	print_r($fieldNames);
}




foreach($tables as $table){
	$keys[] = $table['aIndexes'];
}

echo '<h2> Tables </h2>';
print_r($tableNames);

echo '<h2> Tables and Fields </h2>';
print_r($tableFields);

echo '<h2> Table Keys </h2>';
print_r($keys);
*/


				
/*
$sh = 'runsdk.sh';
print_r( pathinfo($sh) );


$doSdk = exec('./'.$sh);
echo $doSdk;




require_once 'library/CodeGen.php';
require_once 'library/ClassInspector.php';
require_once 'library/ConfigManager.php';
require_once 'library/CGManager.php';
require_once 'library/FileSystemService.php';
require_once 'library/HTMLHelper.php';
require_once 'library/MySQLService.php';
require_once 'library/TemplateManager.php';

$filesSvc = new FileSystemService ( );
$url = 'http://pipes.yahoo.com/pipes/pipe.run?_id=050f25c6bdacec1c5b48ced60edb73e0&_render=json';

$json = file_get_contents($url);
$jsonArray = json_decode($json);
$title = $jsonArray->value->title;
$desc = $jsonArray->value->description;
$entries = $jsonArray->value->items;

echo $title;
echo "\n";
$entryArray = $entries[0];
$entryCount = count($entryArray->entry);

for ($i=0; $i < $entryCount; $i++) { 
	$entry = $entryArray->entry[$i];

	$entryLink = $entry->link->type;
	$entryContent = $entry->content->content;
	$entryCategory = $entry->category->term;
	$entryAuthor = $entry->author->name;
	
	echo 'Content: '. $entryContent ."\n";
}

 

print_r($entries);


?>


<div class="cg_debug">
<pre>

<?php
$servicepath = dirname ( __FILE__ ) . DIRECTORY_SEPARATOR . 'services';
$files = $filesSvc->browseDirectory ( $servicepath, true );

print_r( $files );
$servicesArray = array();
foreach ($files as $file ) {
	//
	if ( is_file($file['path']) )
	{
	 	echo $file['path'];
		echo '<br/>';
			$servicesArray[] = ClassInspector::inspectClass ( $file['path'] );
	}
	
	

}

print_r($servicesArray);
*/			
?>
</pre>