<div class="grid_3">
	<?php include 'includes/_cg_recent_apps.php'; ?>
</div><!--/grid_3-->



<div class="grid_9">
	
<div class="cg_box ui-corner-all">
	<h3 class="cg_box_header">Recent Issues</h3>
	<div class="cg_box_content">
		<p>This is the most recent news on the CodeGen</p>	 
	<?php
		$html1 = '';
		$entries = CodeGen::googlecode_Get('http://pipes.yahoo.com/pipes/pipe.run?_id=dfeada51803196b5a18b2a9d0e7bfcee&_render=json', $codegen->getSetting('issues_count'));
		foreach ($entries as $entry) {
			$html1 .= '<dl>';
			$html1 .= '<dt>';
			$html1 .= $entry['date'];
			$html1 .= '<dt>';
			$html1 .= '<dd>';
			$html1 .= $entry['content'];
			$html1 .= '</dd>';
			$html1 .= '</dl>';
		}
		echo $html1;
	?>		 
	</div><!--/cg_box_content-->
</div><!--/cg_box-->

	
<div class="cg_box">
	<h3 class="cg_box_header">Recent Updates</h3>
	<div class="cg_box_content">
		<p>This is the most recent changes to the source code.</p>
		<?php
		$html2 = '';
		$entries = CodeGen::googlecode_Get('http://pipes.yahoo.com/pipes/pipe.run?_id=050f25c6bdacec1c5b48ced60edb73e0&_render=json', $codegen->getSetting('updates_count'));
		foreach ($entries as $entry) {
		    $html2 .= '<dl>';
			$html2 .= '<dt>';
			$html2 .= $entry['date'];
			$html2 .= '<dt>';
			$html2 .= '<dd>';
			$html2 .= $entry['content'];
			$html2 .= '</dd>';
			$html2 .= '</dl>';
		}
		echo $html2;
		?>
	</div>
	<!--/cg_box_content-->
</div>
<!--/cg_box-->
<div class="cg_box">
	<h3 class="cg_box_header">Recent Downloads</h3>
	<div class="cg_box_content">
		<p>This is the most recent downloads for CodeGen, as well as fixes and docs</p>
		<?php
		$html3 = '';
		$entries = CodeGen::googlecode_Get('http://pipes.yahoo.com/pipes/pipe.run?_id=8af3c292000ac1eb663291826412a9c9&_render=json', $codegen->getSetting('downloads_count'));
		foreach ($entries as $entry) {
		    $html3 .= '<dl>';
			$html3 .= '<dt>';
			$html3 .= $entry['date'];
			$html3 .= '<dt>';
			$html3 .= '<dd>';
			$html3 .= $entry['content'];
			$html3 .= '</dd>';
			$html3 .= '</dl>';
		}
		echo $html3;
		?>
	</div>
	<!--/cg_box_content-->
</div>
<!--/cg_box-->

	
</div>
<div class="clear"></div>
 