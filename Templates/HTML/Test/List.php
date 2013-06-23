<?php 
require_once 'service/PostsService.php';
require_once 'service/vo/PostsVO.php';

$service = new PostsService();
$result = '';
$recordList = '';

if ( isset($_POST['save']) )
{
	unset( $_POST['save'] );
	$postValues = $_POST;
	$result = $service->savePosts( $postValues );	
}

$postsArray = $service->getAllPosts();
$postVO = new PostsVO();

for ( $i = 0; $i < count( $postsArray ); $i++ ) 
{
	$postVO = $postsArray[ $i ];
	
	$recordList .= '<tr id="'.$postVO->id.'">';
	$recordList .= "<td>$postVO->id</td>";
	$recordList .= '<td>'.$postVO->title.'</td>';
	$recordList .= '<td>'.$postVO->body.'</td>';
	$recordList .= '<td>'.$postVO->date.'</td>';
	$recordList .= '<td class="actions">';
	$recordList .= '<button class="edit" onclick="window.location=\'Form.php?id='.$postVO->id.'\'">Edit</button>';
	$recordList .= '<button class="delete" onclick="remove('.$postVO->id.')">Delete</button></td>';
	$recordList .= '</tr>';
}

?>
<?php include '_header.php'; ?> 
<script type="text/javascript" src="flexigrid.pack.js"></script>
<script type="text/javascript">
	var service = /*@TABLE_UC*/'service/PostsService.php';
	
	function remove( id ){
		$.get( service, { m: 'remove', id: id }, function(data){
			if ( data ) {
				$("#"+id).fadeOut("slow");
			} else {
				alert( 'There was a problem!' );
			}
		});
	}

	
	
</script>
<script type="text/javascript">

			$("#flex1").flexigrid
			(
			{
			url: 'service/PostsService.php?m=get',
			dataType: 'json',
			colModel : [
				{display: 'ID', name : 'id', width : 40, sortable : true, align: 'center'},
				{display: 'Title', name : 'title', width : 180, sortable : true, align: 'left'},
				{display: 'Body', name : 'body', width : 120, sortable : true, align: 'left'},
				{display: 'Date', name : 'date', width : 130, sortable : true, align: 'left', hide: true},
				{display: 'User ID', name : 'user_id', width : 80, sortable : true, align: 'right'}
				],
			searchitems : [
				{display: 'Title', name : 'title'},
				{display: 'UserID', name : 'user_id', isdefault: true}
				],
			sortname: "ID",
			sortorder: "asc",
			usepager: true,
			title: 'Posts',
			useRp: true,
			rp: 15,
			showTableToggleBtn: true,
			width: 700,
			onSubmit: addFormData,
			height: 200
			}
			);




//This function adds paramaters to the post of flexigrid. 
//You can add a verification as well by return to false if you don't want flexigrid to submit			
function addFormData()
{
//passing a form object to serializeArray will get the valid data from all the objects, 
//but, if the you pass a non-form object, 
//you have to specify the input elements that the data will come from
var dt = $('#sform').serializeArray();
	$("#flex1").flexOptions( { params: dt } );

return true;
}
	
$('#sform').submit(function () {
	$('#flex1').flexOptions( { newp: 1 } ).flexReload();

return false;
});						
</script>

<table id="flex1" style="display:none"></table>



    <table width="100%" border="0">
	<tr>
        <th scope="col">ID</th>
        <th scope="col">Title</th>
        <th scope="col">Body</th>
        <th scope="col">Date</th>
        <th scope="col">Actions</th>
      </tr>
      
      <!-- @TABLELIST -->
       <?php echo $recordList; ?>
     <!-- ENDS REPEAT -->
    </table>
    <a href="Form.php">New Post</a>
  
 <?php include '_footer.php'; ?>