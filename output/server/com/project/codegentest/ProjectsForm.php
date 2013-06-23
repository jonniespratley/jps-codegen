<?php 
require_once "ProjectsService.php";
require_once "vo/ProjectsVO.php";


			$created = "";
			$createddate = "";
			$date_created = "";
			$date_modified = "";
			$demo_url = "";
			$description = "";
			$developer = "";
			$live_url = "";
			$local_url = "";
			$milestones = "";
			$modified = "";
			$modifieddate = "";
			$namespace = "";
			$notes = "";
			$project = "";
			$projectid = "";
			$published = "";
			$readme = "";
			$repo_url = "";
			$status = "";
			$tasks = "";
			$technologies = "";
			$title = "";
			$type = "";
$record_id = '';
if ( isset($_GET[ '' ]) )
{
	$record_id = isset($_GET[ '' ]);
	$service = new ProjectsService();
	$recordVO = new ProjectsVO();
	$record = $service->getOneProjects( $record_id ); 
	$recordVO = $record[ 0 ];//First object in array
	
	
			$created = $recordVO->created;
			$createddate = $recordVO->createddate;
			$date_created = $recordVO->date_created;
			$date_modified = $recordVO->date_modified;
			$demo_url = $recordVO->demo_url;
			$description = $recordVO->description;
			$developer = $recordVO->developer;
			$live_url = $recordVO->live_url;
			$local_url = $recordVO->local_url;
			$milestones = $recordVO->milestones;
			$modified = $recordVO->modified;
			$modifieddate = $recordVO->modifieddate;
			$namespace = $recordVO->namespace;
			$notes = $recordVO->notes;
			$project = $recordVO->project;
			$projectid = $recordVO->projectid;
			$published = $recordVO->published;
			$readme = $recordVO->readme;
			$repo_url = $recordVO->repo_url;
			$status = $recordVO->status;
			$tasks = $recordVO->tasks;
			$technologies = $recordVO->technologies;
			$title = $recordVO->title;
			$type = $recordVO->type;	
}
?>

<?php include '_header.php'; ?>
 
   <form id="formProjects" name="formProjects" method="post" action="ProjectsList.php">

		
			<div>
		 		<label for="created">Created</label>
		 		<input type="text" name="created" value="<?php echo $created; ?>"/>
		 	</div>
			<div>
		 		<label for="createddate">Createddate</label>
		 		<input type="text" name="createddate" value="<?php echo $createddate; ?>"/>
		 	</div>
			<div>
		 		<label for="date_created">Date_created</label>
		 		<input type="text" name="date_created" value="<?php echo $date_created; ?>"/>
		 	</div>
			<div>
		 		<label for="date_modified">Date_modified</label>
		 		<input type="text" name="date_modified" value="<?php echo $date_modified; ?>"/>
		 	</div>
			<div>
		 		<label for="demo_url">Demo_url</label>
		 		<input type="text" name="demo_url" value="<?php echo $demo_url; ?>"/>
		 	</div>
			<div>
		 		<label for="description">Description</label>
		 		<input type="text" name="description" value="<?php echo $description; ?>"/>
		 	</div>
			<div>
		 		<label for="developer">Developer</label>
		 		<input type="text" name="developer" value="<?php echo $developer; ?>"/>
		 	</div>
			<div>
		 		<label for="live_url">Live_url</label>
		 		<input type="text" name="live_url" value="<?php echo $live_url; ?>"/>
		 	</div>
			<div>
		 		<label for="local_url">Local_url</label>
		 		<input type="text" name="local_url" value="<?php echo $local_url; ?>"/>
		 	</div>
			<div>
		 		<label for="milestones">Milestones</label>
		 		<input type="text" name="milestones" value="<?php echo $milestones; ?>"/>
		 	</div>
			<div>
		 		<label for="modified">Modified</label>
		 		<input type="text" name="modified" value="<?php echo $modified; ?>"/>
		 	</div>
			<div>
		 		<label for="modifieddate">Modifieddate</label>
		 		<input type="text" name="modifieddate" value="<?php echo $modifieddate; ?>"/>
		 	</div>
			<div>
		 		<label for="namespace">Namespace</label>
		 		<input type="text" name="namespace" value="<?php echo $namespace; ?>"/>
		 	</div>
			<div>
		 		<label for="notes">Notes</label>
		 		<input type="text" name="notes" value="<?php echo $notes; ?>"/>
		 	</div>
			<div>
		 		<label for="project">Project</label>
		 		<input type="text" name="project" value="<?php echo $project; ?>"/>
		 	</div>
			<div>
		 		<label for="projectid">Projectid</label>
		 		<input type="text" name="projectid" value="<?php echo $projectid; ?>"/>
		 	</div>
			<div>
		 		<label for="published">Published</label>
		 		<input type="text" name="published" value="<?php echo $published; ?>"/>
		 	</div>
			<div>
		 		<label for="readme">Readme</label>
		 		<input type="text" name="readme" value="<?php echo $readme; ?>"/>
		 	</div>
			<div>
		 		<label for="repo_url">Repo_url</label>
		 		<input type="text" name="repo_url" value="<?php echo $repo_url; ?>"/>
		 	</div>
			<div>
		 		<label for="status">Status</label>
		 		<input type="text" name="status" value="<?php echo $status; ?>"/>
		 	</div>
			<div>
		 		<label for="tasks">Tasks</label>
		 		<input type="text" name="tasks" value="<?php echo $tasks; ?>"/>
		 	</div>
			<div>
		 		<label for="technologies">Technologies</label>
		 		<input type="text" name="technologies" value="<?php echo $technologies; ?>"/>
		 	</div>
			<div>
		 		<label for="title">Title</label>
		 		<input type="text" name="title" value="<?php echo $title; ?>"/>
		 	</div>
			<div>
		 		<label for="type">Type</label>
		 		<input type="text" name="type" value="<?php echo $type; ?>"/>
		 	</div>

	    <div>
	    	<input type="hidden" name="" value="<?php echo $record_id; ?>"/>
		   <input name="save" type="submit" value="Save" />
			<input type="button" onclick="window.location='ProjectsList.php'" value="Cancel"/>
	    </div>
	</form>
	
  
<?php include '_footer.php'; ?>