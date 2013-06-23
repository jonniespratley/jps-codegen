<div class="grid_3">
	<div class="cg_widget">
		<h3>Recent Applications</h3>
		<p>This is going to be a list of the recent generated applications all with links to access the demo.</p>
			<ul id="cg_history">
				<li><a href="#">Sample App</a></li>
			</ul>			
	</div>
</div>
	
<div class="grid_9">

<div class="cg_box">
	<h3 class="cg_box_header">Settings</h3>
	<div class="cg_box_content">
		<p>This is going to be the settings for the application. </p>
		
<form action="index.html" method="post" id="form_settings">
	<div class="cg_message"></div>
	<fieldset>
		<legend>Database Settings</legend>
			<ol>
				<li>
					<label for="txt_host">Host: </label>
					<input type="text" value="<?php echo $codegen->getSetting('host'); ?>" id="txt_settings_host"/>
				</li>
				<li>
					<label for="txt_user">User: </label>
					<input type="text" value="<?php echo $codegen->getSetting('user'); ?>" id="txt_settings_user"/>
				</li>
				<li>
					<label for="txt_pass">Password: </label>
					<input type="password" value="<?php echo $codegen->getSetting('pass'); ?>" id="txt_settings_pass"/>
				</li>
			
			</ol>		
	</fieldset>
	<fieldset>
    <legend>SDK Settings</legend>
			<ol>
				<li>
				<label for="txt_sdk">Flex SDK Location: </label>
				<input type="text" value="<?php echo $codegen->getSetting('sdk_path'); ?>" id="txt_settings_sdk"/>
			</li>
			<li>
				<label for="submit" class="btn_label">Press It</label>
				<input type="button" class="green" value="Save" id="btn_settings_save"/>
			</li>
		</ol>
	</fieldset>

</form>

	</div><!--/cg_box_content-->
</div><!--/cg_box-->
 </div><!--/grid-->
<div class="clear"></div>
