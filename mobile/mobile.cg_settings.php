<div class="grid_3">
	<?php include 'includes/_cg_recent_apps.php'; ?>
</div>
	
<div class="grid_9">

<div id="cg_message"></div>

<div class="cg_box">
	<h3 class="cg_box_header">Dashboard Settings</h3>
	<div class="cg_box_content">
		<p>This is going to be the settings for the application. </p>		

	<ol class="form">
			<li>
				<label for="txt_issues_count">Issues Count:</label>
				<input type="text" value="<?php echo $codegen->getSetting('issues_count'); ?>" id="txt_issues_count"/>
			</li>
			<li>
				<label for="txt_updates_count">Updates Count:</label>
				<input type="text" value="<?php echo $codegen->getSetting('updates_count'); ?>" id="txt_updates_count"/>
			</li>
			<li>
				<label for="txt_downloads_count">Downloads Count:</label>
				<input type="text" value="<?php echo $codegen->getSetting('downloads_count'); ?>" id="txt_downloads_count"/>
			</li>
			<li>
				<label for="submit" class="btn_label">Press It</label>
				<input type="button" value="Save" class="green btn_settings_save"/>
			</li>

		</ol>
	
</div><!--/cg_box_content-->
</div><!--/cg_box-->

<div class="cg_box">
	<h3 class="cg_box_header">Generator Settings</h3> 
	<div class="cg_box_content" style="display:none;">
	
		<ol class="form">
			<li>
				<label for="txt_app_name">Name:</label>
				<input type="text" value="<?php echo $codegen->getSetting('app_name'); ?>" id="txt_app_name"/>
			</li>
			<li>
				<label for="txt_app_namespace">Namespace:</label>
				<input type="text" value="<?php echo $codegen->getSetting('app_namespace'); ?>" id="txt_app_namespace"/>
			</li>
			<li>
				<label for="txt_app_endpoint">Endpoint:</label>
				<input type="text" value="<?php echo $codegen->getSetting('app_endpoint'); ?>" id="txt_app_endpoint"/>
			</li>
			<li>
				<label for="txt_app_copywrite">Copywrite:</label>
				<textarea name="txt_app_copywrite" cols="50" rows="5" id="txt_app_copywrite"><?php echo $codegen->getSetting('app_copywrite'); ?></textarea>
			</li>
			<li>
				<label for="submit" class="btn_label">Press It</label>
					<input type="button" value="Save" class="green btn_settings_save"/>
			</li>
		</ol>
	
	</div><!--/cg_box_content-->
</div><!--/cg_box-->
	
<div class="cg_box">
	<h3 class="cg_box_header">Database Settings</h3> 
	<div class="cg_box_content" style="display:none;">
	<ol class="form">
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
		<li>
			<label for="submit" class="btn_label">Press It</label>
				<input type="button" value="Save" class="green btn_settings_save"/>
		</li>
	
	</ol>		
	
</div><!--/cg_box_content-->
</div><!--/cg_box-->

<div class="cg_box">
	<h3 class="cg_box_header">Flex Config Settings</h3> 
	<div class="cg_box_content" style="display:none;">

	<ol class="form">
	<li>
		<label for="txt_sdk_path">SDK Location: </label>
		<input type="text" value="<?php echo $codegen->getSetting('sdk_path'); ?>" id="txt_sdk_path"/>
	</li>
	<li>
		<label for="txt_sdk_meta_title">Meta Title:</label>
		<input type="text" value="<?php echo $codegen->getSetting('sdk_meta_title'); ?>" id="txt_sdk_meta_title"/>
	</li>
	<li>
		<label for="txt_sdk_meta_description">Meta Description: </label>
		<input type="text" value="<?php echo $codegen->getSetting('sdk_meta_description'); ?>" id="txt_sdk_meta_description"/>
	</li>
	<li>
		<label for="txt_sdk_meta_author">Meta Author: </label>
		<input type="text" value="<?php echo $codegen->getSetting('sdk_meta_author'); ?>" id="txt_sdk_meta_author"/>
	</li>
	<li>
		<label for="txt_sdk_meta_publisher">Meta Publisher: </label>
		<input type="text" value="<?php echo $codegen->getSetting('sdk_meta_publisher'); ?>" id="txt_sdk_meta_publisher"/>
	</li>
	<li>
		<label for="submit" class="btn_label">Press It</label>
			<input type="button" value="Save" class="green btn_settings_save"/>
	</li>
</ol>
	
</div><!--/cg_box_content-->
</div><!--/cg_box-->
	
 </div><!--/grid-->
<div class="clear"></div>
