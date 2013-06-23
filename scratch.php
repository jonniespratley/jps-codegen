
<?php

#[Embed(source='FamFamSilkIcons.swf', symbol="add")] public var add:Class;

$url = 'http://localhost/CodeGen/index.php?m=getDirectory&p=/Volumes/WebWorkspace/FamFam';
$data = file_get_contents($url);
$json = $data;
$decoded = json_decode($json, true);
//Target is z to a
$result = $decoded;

//I am doing a to z;

for ($i=1; $i < count($result); $i++) { 
 	
	$filename = $result[$i]['filename'];
	$symbol = str_replace ( '.png', '', $filename );
	#$symbol = str_replace ( '_', '', $symbol );
	$n = ($i - 1);
	$ucsymbol = ucfirst($symbol);
	#echo "[Embed(source='FamFamSilkIcons.swf', symbol='New Symbol $n')] public var $symbol:Class;\n";
	#echo ".icon$symbol { icon: Embed(source='FamFamSilkIcons.swf', symbol='New Symbol $n'); }\n";
	echo "{ label: '$symbol', icon: $symbol },\n";
}

?>
