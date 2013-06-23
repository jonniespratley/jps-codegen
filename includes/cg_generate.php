<div class="grid_3">
	<div class="cg_widget">
		<h3>Recent Applications</h3>

<?php
				
	$appArray = $codegen->getApps();
	
	foreach( $appArray as $app )
	{
		$time = strtotime($app["app_timestamp"]);
		#
		$date = date('F j, Y, g:i a', $time);
		echo '
		<p>
		<span><a class="cg_preview" href="'.$app["app_url"].'">'.$app["app_name"].'</a> Built on '.$date.'</span>
		<a href="#" class="btn_app_remove" rel="'.$app["id"].'">remove</a>
		</p>';
	}
	
	?>
	
	</div>
</div>
	
<div class="grid_9">
 
<div class="cg_box">
	<h3 class="cg_box_header">Code Generator</h3> 
	<div class="cg_box_content">


<!-- ############################ Step 1 ############################ -->
<fieldset class="cg_step_1">
	<legend>Database Information</legend>
<form id="cg_step_1" action="none.html" method="get" class="cg_form">
<ol>
	<li>
		<label for="txt_host">Host: </label>
		<input name="txt_host" type="text" id="txt_host" value="<?php echo $codegen->getSetting('host'); ?>"/>
	</li>
	<li>
		<label for="txt_user">User: </label>
		<input name="txt_user" type="text" id="txt_user" value="<?php echo  $codegen->getSetting('user'); ?>"/>
	</li>
	<li>
		<label for="txt_pass">Password: </label>
		<input name="txt_pass" type="password" id="txt_pass" value="<?php echo  $codegen->getSetting('pass'); ?>"/>
	</li>
	<li>
		<label for="txt_database">Database: </label>
		<select name="txt_database" id="txt_database" class="input"></select>
	</li>
</ol>
</form>
</fieldset>


<!-- ############################ Step 2 ############################ -->
<fieldset class="cg_step_2">
	<legend>Application Information</legend>
	<form id="cg_step_2" action="none.html" method="get" class="cg_form">
<ol>
<li>
	<label for="txt_application">Name: </label>
	<input name="txt_application" type="text" id="txt_application" onfocus="this.value = ''" value="CodeGenTest" maxlength="255"/>
</li>
<li>
	<label for="txt_namespace">Namespace: </label>
	<input name="txt_namespace" type="text" id="txt_namespace" value="com.project.codegentest" onfocus="this.value = ''"/>
</li>
<li>
	<label for="txt_endpoint">Service Endpoint: </label>
	<input name="txt_endpoint" type="text" id="txt_endpoint" onfocus="this.value = ''" value="http://localhost/project/services" maxlength="255"/>
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
<textarea name="txt_copywrite" cols="50" rows="5" id="txt_copywrite" onfocus="this.value = ''">Your Copywrite information</textarea>
</li>
<li>
	<label for="btn_generateConfig" class="btn_label">Press It!</label>
<input name="btn_generateConfig" type="button" id="btn_generateConfig" value="Create Config" />
</li>
</ol>
</form>
</fieldset>

<!-- ############################ Step 3 ############################ -->
<fieldset class="cg_step_3">
	<legend>Application Review</legend>
	<form id="cg_step_3" action="none.html" method="get" class="cg_form">
		<ol>
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



</div><!--/cg_box_content-->
</div><!--/cg_box-->
 
</div><!--/grid-->
<div class="clear"></div>
