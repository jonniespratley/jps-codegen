<?php 
require_once 'ContactsService.php';
require_once 'vo/ContactsVO.php';

$service = new ContactsService();
$result = '';
$recordList = '';

if ( isset($_POST['save']) )
{
	unset( $_POST['save'] );
	$recordValues = $_POST;
	$result = $service->saveContacts( $recordValues );	
}

$recordsArray = $service->getAllContacts();
$recordVO = new ContactsVO();

for ( $i = 0; $i < count( $recordsArray ); $i++ ) 
{
	$recordVO = $recordsArray[ $i ];
	$recordList .= '<tr id="'.$recordVO->id.'">';

	
			$recordList .= "<td>$recordVO->address</td>";
			$recordList .= "<td>$recordVO->city</td>";
			$recordList .= "<td>$recordVO->email</td>";
			$recordList .= "<td>$recordVO->id</td>";
			$recordList .= "<td>$recordVO->name</td>";
			$recordList .= "<td>$recordVO->phone</td>";
			$recordList .= "<td>$recordVO->state</td>";

	$recordList .= '<td class="actions">';
	$recordList .= '<button onclick="window.location=\'ContactsForm.php?record_id='.$recordVO->id.'\'">Edit</button>';
	$recordList .= '<button onclick=" remove('.$recordVO->id.')">Delete</button></td>';
	$recordList .= '</tr>';
}
?>

<?php include '_header.php'; ?> 

<script type="text/javascript">
var service = 'ContactsService.php';
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


 
   <h1>Contacts</h1>
	<a href="ContactsForm.php">New Contacts</a>
	<a href="TestMain.php">Back</a>

	<table width="100%" border="0">
		<tr>
			
			<th scope="col">Address</th>
			<th scope="col">City</th>
			<th scope="col">Email</th>
			<th scope="col">Id</th>
			<th scope="col">Name</th>
			<th scope="col">Phone</th>
			<th scope="col">State</th><th scope="col">Actions</th>   
		</tr>
		<?php echo $recordList; ?>
	</table>
	 
 
<?php include '_footer.php'; ?>