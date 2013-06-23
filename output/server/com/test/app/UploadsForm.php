<?php 
require_once "UploadsService.php";
require_once "vo/UploadsVO.php";


			$id = "";
			$name = "";
			$path = "";
			$size = "";
			$type = "";
$record_id = '';
if ( isset($_GET[ 'id' ]) )
{
	$record_id = isset($_GET[ 'id' ]);
	$service = new UploadsService();
	$recordVO = new UploadsVO();
	$record = $service->getOneUploads( $record_id ); 
	$recordVO = $record[ 0 ];//First object in array
	
	
			$id = $recordVO->id;
			$name = $recordVO->name;
			$path = $recordVO->path;
			$size = $recordVO->size;
			$type = $recordVO->type;	
}
?>

<?php include '_header.php'; ?>
 
   <form id="formUploads" name="formUploads" method="post" action="UploadsList.php">

		
			<div>
		 		<label for="id">Id</label>
		 		<input type="text" name="id" value="<?php echo $id; ?>"/>
		 	</div>
			<div>
		 		<label for="name">Name</label>
		 		<input type="text" name="name" value="<?php echo $name; ?>"/>
		 	</div>
			<div>
		 		<label for="path">Path</label>
		 		<input type="text" name="path" value="<?php echo $path; ?>"/>
		 	</div>
			<div>
		 		<label for="size">Size</label>
		 		<input type="text" name="size" value="<?php echo $size; ?>"/>
		 	</div>
			<div>
		 		<label for="type">Type</label>
		 		<input type="text" name="type" value="<?php echo $type; ?>"/>
		 	</div>

	    <div>
	    	<input type="hidden" name="id" value="<?php echo $record_id; ?>"/>
		   <input name="save" type="submit" value="Save" />
			<input type="button" onclick="window.location='UploadsList.php'" value="Cancel"/>
	    </div>
	</form>
	
  
<?php include '_footer.php'; ?>