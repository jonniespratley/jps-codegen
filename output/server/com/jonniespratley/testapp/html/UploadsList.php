<?php 
require_once '../UploadsService.php';
require_once '../vo/UploadsVO.php';

$service = new UploadsService();
$result = '';
$recordList = '';

if ( isset($_POST['save']) )
{
	unset( $_POST['save'] );
	$recordValues = $_POST;
	$result = $service->saveUploads( $recordValues );	
}

$recordsArray = $service->getAllUploads();
$recordVO = new UploadsVO();

for ( $i = 0; $i < count( $recordsArray ); $i++ ) 
{
	$recordVO = $recordsArray[ $i ];
	$recordList .= '<tr id="'.$recordVO->id.'">';

	
			$recordList .= "<td>$recordVO->id</td>";
			$recordList .= "<td>$recordVO->name</td>";
			$recordList .= "<td>$recordVO->path</td>";
			$recordList .= "<td>$recordVO->size</td>";
			$recordList .= "<td>$recordVO->type</td>";

	$recordList .= '<td class="actions">';
	$recordList .= '<button onclick="window.location=\'UploadsForm.php?record_id='.$recordVO->id.'\'">Edit</button>';
	$recordList .= '<button onclick=" remove('.$recordVO->id.')">Delete</button></td>';
	$recordList .= '</tr>';
}
?>

<?php include '_header.php'; ?> 

<script type="text/javascript">
var service = '../UploadsService.php';
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


 
   <h1>Uploads</h1>
	<a href="UploadsForm.php">New Uploads</a>
	<a href="TestMain.php">Back</a>

	<table width="100%" border="0">
		<tr>
			
			<th scope="col">Id</th>
			<th scope="col">Name</th>
			<th scope="col">Path</th>
			<th scope="col">Size</th>
			<th scope="col">Type</th><th scope="col">Actions</th>   
		</tr>
		<?php echo $recordList; ?>
	</table>
	 
 
<?php include '_footer.php'; ?>