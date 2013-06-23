<?php 
require_once "../PostsService.php";
require_once "../vo/PostsVO.php";


			$created = "";
			$id = "";
			$post_content = "";
			$post_title = "";
			$updated = "";
$record_id = '';
if ( $_GET[ 'id' ] )
{
	$record_id = $_GET[ 'id' ];
	$service = new PostsService();
	$recordVO = new PostsVO();
	$record = $service->getOnePosts( $record_id ); 
	$recordVO = $record[ 0 ];//First object in array
	
	
			$created = $recordVO->created;
			$id = $recordVO->id;
			$post_content = $recordVO->post_content;
			$post_title = $recordVO->post_title;
			$updated = $recordVO->updated;	
}
?>

<?php include '_header.php'; ?>
 
   <form id="formPosts" name="formPosts" method="post" action="PostsList.php">

		
			<div>
		 		<label for="created">Created</label>
		 		<input type="text" name="created" value="<?php echo $created; ?>"/>
		 	</div>
			<div>
		 		<label for="id">Id</label>
		 		<input type="text" name="id" value="<?php echo $id; ?>"/>
		 	</div>
			<div>
		 		<label for="post_content">Post_content</label>
		 		<input type="text" name="post_content" value="<?php echo $post_content; ?>"/>
		 	</div>
			<div>
		 		<label for="post_title">Post_title</label>
		 		<input type="text" name="post_title" value="<?php echo $post_title; ?>"/>
		 	</div>
			<div>
		 		<label for="updated">Updated</label>
		 		<input type="text" name="updated" value="<?php echo $updated; ?>"/>
		 	</div>

	    <div>
	    	<input type="hidden" name="id" value="<?php echo $record_id; ?>"/>
		   <input name="save" type="submit" value="Save" />
			<input type="button" onclick="window.location='PostsList.php'" value="Cancel"/>
	    </div>
	</form>
	
  
<?php include '_footer.php'; ?>