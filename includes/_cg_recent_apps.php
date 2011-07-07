<div class="cg_widget">
	<h3>Recent Applications</h3>
	<?php 
	$appArray = $codegen->getApps();
	foreach ($appArray as $app)
	{
					$time = strtotime($app["app_timestamp"]);
					#
					$date = date('F j, Y, g:i a', $time);
					echo '
			<p>
			<span><a target="_blank" href="'.$app["app_url"].'">'.$app["app_name"].'</a>'.$date.'</span>
			<a href="#" class="btn_app_remove" rel="'.$app["id"].'">x</a>
			</p>';
	}
	
	?>
</div>
