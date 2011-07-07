<?php 

require_once 'service/PostsService.php';
require_once 'service/vo/PostsVO.php';

$id = '';
$title = '';
$body = '';
$date = '';

if ( $_GET['id'] )
{
	$id = $_GET['id'];
	$service = new PostsService();
	$postVO = new PostsVO();
	$post = $service->getOnePosts( $id ); 
	$postVO = $post[0];//First object in array
	
	//Set the values
	$id = $postVO->id;
	$title = $postVO->title;
	$body = $postVO->body;
	$date = $postVO->date;
}


?>
<?php include '_header.php'; ?>

    <form id="form1" name="form1" method="post" action="List.php">
     <div>
      <label for="id">ID</label>
      <input type="text" name="id" value="<?php echo $id; ?>" disabled="disabled"/>
    </div>
    <div>
      <label for="title">Title</label>
      <input type="text" name="title" value="<?php echo $title; ?>"/>
    </div>
     <div>
      <label for="body">Body</label>
      <input type="text" name="body" value="<?php echo $body; ?>"/>
    </div>
     <div>
      <label for="date">Date</label>
      <input type="text" name="date" value="<?php echo $date; ?>"/>
    </div>
    <div>
    	<input type="hidden" name="id" value="<?php echo $id; ?>"/>
	    <input name="save" type="submit" value="Save" />
		<button onclick="window.location='List.php'">Back</button>
    </div>
    </form>
 <?php include '_footer.php'; ?>