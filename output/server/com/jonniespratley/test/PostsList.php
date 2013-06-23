<?php 
require_once 'PostsService.php';
require_once 'vo/PostsVO.php';

$service = new PostsService();
$result = '';
$recordList = '';

if ( isset($_POST['save']) )
{
	unset( $_POST['save'] );
	$recordValues = $_POST;
	$result = $service->savePosts( $recordValues );	
}

$recordsArray = $service->getAllPosts();
$recordVO = new PostsVO();

for ( $i = 0; $i < count( $recordsArray ); $i++ ) 
{
	$recordVO = $recordsArray[ $i ];
	$recordList .= '<tr id="'.$recordVO->id.'">';

	
			$recordList .= "<td>$recordVO->created</td>";
			$recordList .= "<td>$recordVO->id</td>";
			$recordList .= "<td>$recordVO->post_content</td>";
			$recordList .= "<td>$recordVO->post_title</td>";
			$recordList .= "<td>$recordVO->updated</td>";

	$recordList .= '<td class="actions">';
	$recordList .= '<button onclick="window.location=\'PostsForm.php?record_id='.$recordVO->id.'\'">Edit</button>';
	$recordList .= '<button onclick=" remove('.$recordVO->id.')">Delete</button></td>';
	$recordList .= '</tr>';
}
?>

<?php include '_header.php'; ?> 

<script type="text/javascript">
var service = 'PostsService.php';
function remove( id ){
	$.post( service, { m: 'remove', id: id }, function(data){
		if ( data ) {
			$('#'+id).fadeOut('slow');
		} else {
			alert( 'There was a problem!' );
		}
	});
}
</script>


 
   <h1>Posts</h1>
	<a href="PostsForm.php">New Posts</a>
	<a href="TestMain.php">Back</a>

	<table width="100%" border="0">
		<tr>
			
			<th scope="col">Created</th>
			<th scope="col">Id</th>
			<th scope="col">Post_content</th>
			<th scope="col">Post_title</th>
			<th scope="col">Updated</th><th scope="col">Actions</th>   
		</tr>
		<?php echo $recordList; ?>
	</table>
	 
 
<?php include '_footer.php'; ?>