<div class="grid_3">
	 
</div><!--/grid_3-->



<div class="grid_9">
	
<div class="cg_box" data-role="collapsible">
	<h3>Recent Issues</h3>
	<div class="cg_box_content">
		<p>This is the most recent news on the CodeGen</p>	 
	<?php
		$html1 = '';
		$entries = CodeGen::googlecode_Get('http://pipes.yahoo.com/pipes/pipe.run?_id=dfeada51803196b5a18b2a9d0e7bfcee&_render=json', $codegen->getSetting('issues_count'));
		$html1 .= '<ul data-role="listview">';
		foreach ($entries as $entry) {
			$html1 .= '<a href="#">';
			$html1 .= $entry['content'];
			$html1 .= '<p class="ui-li-aside">';
			$html1 .= $entry['date'];
			$html1 .= '</p>';
			$html1 .= '</a></li>';
		}
		$html1 .= '</ul>';
		echo $html1;
	?>		 
	</div><!--/cg_box_content-->
</div><!--/cg_box-->

	
<div class="cg_box" data-role="collapsible">
	<h3>Recent Updates</h3>
	<div class="cg_box_content">
		<p>This is the most recent changes to the source code.</p>
		<?php
		$html2 = '';
		$entries = CodeGen::googlecode_Get('http://pipes.yahoo.com/pipes/pipe.run?_id=050f25c6bdacec1c5b48ced60edb73e0&_render=json', $codegen->getSetting('updates_count'));
		$html2 .= '<ul data-role="listview">';
		foreach ($entries as $entry) {
			$html2 .= '<a href="#">';
			$html2 .= $entry['content'];
			$html2 .= '<p class="ui-li-aside">';
			$html2 .= $entry['date'];
			$html2 .= '</p>';
			$html2 .= '</a></li>';
		}
		$html2 .= '</ul>';
		echo $html2;
		?>
	</div>
	<!--/cg_box_content-->
</div>
<!--/cg_box-->
<div class="cg_box" data-role="collapsible">
	<h3>Recent Downloads</h3>
	<div class="cg_box_content">
		<p>This is the most recent downloads for CodeGen, as well as fixes and docs</p>
		<?php
		$html3 = '';
		$entries = CodeGen::googlecode_Get('http://pipes.yahoo.com/pipes/pipe.run?_id=8af3c292000ac1eb663291826412a9c9&_render=json', $codegen->getSetting('downloads_count'));
		$html3 .= '<ul data-role="listview">';
		foreach ($entries as $entry) {
			$html3 .= '<a href="#">';
			$html3 .= $entry['content'];
			$html3 .= '<p class="ui-li-aside">';
			$html3 .= $entry['date'];
			$html3 .= '</p>';
			$html3 .= '</a></li>';
		}
		$html3 .= '</ul>';
		echo $html3;
		?>
	</div>
	<!--/cg_box_content-->
</div>
<!--/cg_box-->

	
</div>

 