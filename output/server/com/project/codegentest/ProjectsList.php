<?php 
require_once 'ProjectsService.php';
require_once 'vo/ProjectsVO.php';

$service = new ProjectsService();
$result = '';
$recordList = '';

if ( isset($_POST['save']) )
{
	unset( $_POST['save'] );
	$recordValues = $_POST;
	$result = $service->saveProjects( $recordValues );	
}

$recordsArray = $service->getAllProjects();
$recordVO = new ProjectsVO();

for ( $i = 0; $i < count( $recordsArray ); $i++ ) 
{
	$recordVO = $recordsArray[ $i ];
	$recordList .= '<tr id="'.$recordVO->.'">';

	
			$recordList .= "<td>$recordVO->created</td>";
			$recordList .= "<td>$recordVO->createddate</td>";
			$recordList .= "<td>$recordVO->date_created</td>";
			$recordList .= "<td>$recordVO->date_modified</td>";
			$recordList .= "<td>$recordVO->demo_url</td>";
			$recordList .= "<td>$recordVO->description</td>";
			$recordList .= "<td>$recordVO->developer</td>";
			$recordList .= "<td>$recordVO->live_url</td>";
			$recordList .= "<td>$recordVO->local_url</td>";
			$recordList .= "<td>$recordVO->milestones</td>";
			$recordList .= "<td>$recordVO->modified</td>";
			$recordList .= "<td>$recordVO->modifieddate</td>";
			$recordList .= "<td>$recordVO->namespace</td>";
			$recordList .= "<td>$recordVO->notes</td>";
			$recordList .= "<td>$recordVO->project</td>";
			$recordList .= "<td>$recordVO->projectid</td>";
			$recordList .= "<td>$recordVO->published</td>";
			$recordList .= "<td>$recordVO->readme</td>";
			$recordList .= "<td>$recordVO->repo_url</td>";
			$recordList .= "<td>$recordVO->status</td>";
			$recordList .= "<td>$recordVO->tasks</td>";
			$recordList .= "<td>$recordVO->technologies</td>";
			$recordList .= "<td>$recordVO->title</td>";
			$recordList .= "<td>$recordVO->type</td>";

	$recordList .= '<td class="actions">';
	$recordList .= '<button onclick="window.location=\'ProjectsForm.php?record_id='.$recordVO->.'\'">Edit</button>';
	$recordList .= '<button onclick=" remove('.$recordVO->.')">Delete</button></td>';
	$recordList .= '</tr>';
}
?>

<?php include '_header.php'; ?> 

<script type="text/javascript">
var service = 'ProjectsService.php';
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


 
   <h1>Projects</h1>
	<a href="ProjectsForm.php">New Projects</a>
	<a href="TestMain.php">Back</a>

	<table width="100%" border="0">
		<tr>
			
			<th scope="col">Created</th>
			<th scope="col">Createddate</th>
			<th scope="col">Date_created</th>
			<th scope="col">Date_modified</th>
			<th scope="col">Demo_url</th>
			<th scope="col">Description</th>
			<th scope="col">Developer</th>
			<th scope="col">Live_url</th>
			<th scope="col">Local_url</th>
			<th scope="col">Milestones</th>
			<th scope="col">Modified</th>
			<th scope="col">Modifieddate</th>
			<th scope="col">Namespace</th>
			<th scope="col">Notes</th>
			<th scope="col">Project</th>
			<th scope="col">Projectid</th>
			<th scope="col">Published</th>
			<th scope="col">Readme</th>
			<th scope="col">Repo_url</th>
			<th scope="col">Status</th>
			<th scope="col">Tasks</th>
			<th scope="col">Technologies</th>
			<th scope="col">Title</th>
			<th scope="col">Type</th><th scope="col">Actions</th>   
		</tr>
		<?php echo $recordList; ?>
	</table>
	 
 
<?php include '_footer.php'; ?>