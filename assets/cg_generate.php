<div class="grid_3">
	<?php include 'includes/_cg_recent_apps.php'; ?>
</div>
	
<div class="grid_9">

<!-- ############################ Step 1 ############################ -->
<div class="cg_box" style="display:none;">
	<h3 class="cg_box_header">Step 1</h3> 
	<div class="cg_box_content">

<fieldset class="cg_step_1">
	<legend>Database Information</legend>
<form id="cg_step_1" action="none.html" method="get" class="cg_form">
<ol class="form">
	<li class="hide">
		<label for="txt_host" class="btn_label">Host: </label>
		</li>
	<li class="hide">
		<label for="txt_user" class="btn_label">User: </label>
		
	</li>
	<li class="hide">
		<label for="txt_pass" class="btn_label">Password: </label>
		
	</li>
</ol>
</form>
</fieldset>
</div>
</div>


<div class="cg_box">
	<h3 class="cg_box_header">Only Step</h3> 
	<div class="cg_box_content">
		<fieldset class="cg_step_2">
			<legend>Application Information</legend>
			<form id="cg_step_2" action="none.html" method="get" class="cg_form">
				<ol class="form">
					<li>
						<label for="txt_database">Database: </label>
						<input name="txt_host" type="hidden" id="txt_host" value="<?php echo $codegen->getSetting('host'); ?>"/>
						<input name="txt_user" type="hidden" id="txt_user" value="<?php echo  $codegen->getSetting('user'); ?>"/>
						<input name="txt_pass" type="hidden" id="txt_pass" value="<?php echo  $codegen->getSetting('pass'); ?>"/>
						<select name="txt_database" id="txt_database" class="input"></select>
						<input type="button" id="btn_load_databases" class="green" value="Load"/>
					</li>
					<li>
						<label for="txt_application">Name: </label>
						<input name="txt_application" type="text" id="txt_application" value="<?php echo $codegen->getSetting('app_name'); ?>"/>
					</li>
					<li>
						<label for="txt_namespace">Namespace: </label>
						<input name="txt_namespace" type="text" id="txt_namespace" value="<?php echo $codegen->getSetting('app_namespace'); ?>"/>
						<span>The reverse domain name of your application. This is for folder structuring.</span>
					</li>
					<li>
						<label for="txt_endpoint">Service Endpoint: </label>
						<input name="txt_endpoint" type="text" id="txt_endpoint" value="<?php echo $codegen->getSetting('app_endpoint'); ?>"/>
						<span>The path from the root of the application folder to the services folder. ex: /services</span>
					</li>
					<li>
						<label for="txt_framework">Code Type: </label>
						<select name="txt_framework" id="txt_framework">
							<option value="Cairngorm">Cairngorm Framework</option>
							<option value="AS3">HTTP Service</option>
						</select>
					</li>
					<li>
						<label for="txt_copywrite">Copywrite: </label>
						<textarea name="txt_copywrite" cols="50" rows="5" id="txt_copywrite"><?php echo $codegen->getSetting('app_copywrite'); ?></textarea>
					</li>
					<li>
						<label for="btn_generateApp" class="btn_label">Press It!</label>
						<input name="btn_generateApp" type="button" id="btn_generateApp" value="Create Application"  class="green" />
					</li>
				</ol>
			</form>
		</fieldset>
	</div>
</div><!--/cg_box-->

<?php


/**
<!-- ############################ Step 3 ############################ -->
<div class="cg_box hide">
	<h3 class="cg_box_header">Step 3</h3> 
	<div class="cg_box_content" style="display:none;">
<fieldset class="cg_step_3">
	<legend>Application Review</legend>
	<form id="cg_step_3" action="none.html" method="get" class="cg_form">
		<ol class="form">
			<li>
				<label for="txt_configLocation">Config Path:</label>
				<input name="txt_configLocation" type="text" id="txt_configLocation" value="" readonly="readonly" />
			</li>
			
			<li>
				<label for="btn_generateSchema" class="btn_label">Press It!</label>
				<input name="btn_generateSchema" type="button" id="btn_generateSchema" value="Create Schema" />
			</li>
			
			<li>
				<label for="txt_schemaLocation" >Schema Path:</label>
				<input name="txt_schemaLocation" type="text" id="txt_schemaLocation" value="" readonly="readonly" />
			</li>
			<li>
				<label for="btn_generateApp" class="btn_label">Press It!</label>
				<input class="green" name="btn_generateApp" type="button" id="btn_generateApp" value="Create Application" />
			</li>
		</ol>
	</form>
</fieldset>
</div>
</div>
*/
?>
 
</div><!--/grid-->
<div class="clear"></div>
