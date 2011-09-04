
<div id="cg_message"></div>
<div class="ui-grid-a">
	<div class="ui-block-a">
		<div class="ui-content">
			<div class="cg_box" data-role="collapsible">
				<h3 class="cg_box_header">Dashboard Settings</h3>
				<div class="cg_box_content">
					<p>This is going to be the settings for the application. </p>
					<ul data-inset="true" class="form" data-role="listview">
						<li>
							<div data-role="fieldcontain">
								<label for="txt_issues_count">Issues Count:</label>
								<input type="text" value="<?php echo $codegen->getSetting('issues_count'); ?>" id="txt_issues_count"/>
							</div>
						</li>
						<li>
							<div data-role="fieldcontain">
								<label for="txt_updates_count">Updates Count:</label>
							</div>
							<input type="text" value="<?php echo $codegen->getSetting('updates_count'); ?>" id="txt_updates_count"/>
						</li>
						<li>
							<div data-role="fieldcontain">
								<label for="txt_downloads_count">Downloads Count:</label>
								<input type="text" value="<?php echo $codegen->getSetting('downloads_count'); ?>" id="txt_downloads_count"/>
							</div>
						</li>
						<li>
							<div data-role="fieldcontain">
								<label for="submit" class="btn_label">Press It</label>
							</div>
							<input type="button" value="Save" class="green btn_settings_save"/>
						</li>
					</ul>
				</div>
				<!--/cg_box_content--> 
			</div>
			<!--/cg_box--> 
		</div>
	</div>
	<div class="ui-block-b">
		<div class="ui-content">
			<div class="cg_box" data-role="collapsible">
				<h3 class="cg_box_header">Generator Settings</h3>
				<div class="cg_box_content">
					<p>This is going to be the settings for the application. </p>
					<ul data-inset="true" class="form" data-role="listview">
						<li>
							<div data-role="fieldcontain">
								<label for="txt_app_name">Name:</label>
								<input type="text" value="<?php echo $codegen->getSetting('app_name'); ?>" id="txt_app_name"/>
							</div>
						</li>
						<li>
							<div data-role="fieldcontain">
								<label for="txt_app_namespace">Namespace:</label>
								<input type="text" value="<?php echo $codegen->getSetting('app_namespace'); ?>" id="txt_app_namespace"/>
							</div>
						</li>
						<li>
							<div data-role="fieldcontain">
								<label for="txt_app_endpoint">Endpoint:</label>
								<input type="text" value="<?php echo $codegen->getSetting('app_endpoint'); ?>" id="txt_app_endpoint"/>
							</div>
						</li>
						<div>
							<li data-role="fieldcontain">
								<label for="txt_app_copywrite">Copywrite:</label>
								<textarea name="txt_app_copywrite" cols="50" rows="5" id="txt_app_copywrite"><?php echo $codegen->getSetting('app_copywrite'); ?></textarea>
							</li>
						</div>
						<li>
							<div data-role="fieldcontain">
								<label for="submit" class="btn_label">Press It</label>
								<input type="button" value="Save" class="green btn_settings_save"/>
							</div>
						</li>
					</ul>
				</div>
				<!--/cg_box_content--> 
			</div>
			<!--/cg_box--> 
		</div>
	</div>
	<div class="ui-block-a">
		<div class="ui-content">
			
			
		</div>
	</div>
	<div class="ui-block-b">
		<div class="ui-content">
			<div class="cg_box" data-role="collapsible">
				<h3 class="cg_box_header">Flex Config Settings</h3>
				<div class="cg_box_content">
					<ul data-inset="true" class="form" data-role="listview">
						<li>
							<div data-role="fieldcontain">
								<label for="txt_sdk_path">SDK Location: </label>
							</div>
							<input type="text" value="<?php echo $codegen->getSetting('sdk_path'); ?>" id="txt_sdk_path"/>
						</li>
						<li>
							<div data-role="fieldcontain">
								<label for="txt_sdk_meta_title">Meta Title:</label>
								<input type="text" value="<?php echo $codegen->getSetting('sdk_meta_title'); ?>" id="txt_sdk_meta_title"/>
							</div>
						</li>
						<li>
							<div data-role="fieldcontain">
								<label for="txt_sdk_meta_description">Meta Description: </label>
							</div>
							<input type="text" value="<?php echo $codegen->getSetting('sdk_meta_description'); ?>" id="txt_sdk_meta_description"/>
						</li>
						<li>
							<div data-role="fieldcontain">
								<label for="txt_sdk_meta_author">Meta Author: </label>
								<input type="text" value="<?php echo $codegen->getSetting('sdk_meta_author'); ?>" id="txt_sdk_meta_author"/>
							</div>
						</li>
						<li>
							<div data-role="fieldcontain">
								<label for="txt_sdk_meta_publisher">Meta Publisher: </label>
								<input type="text" value="<?php echo $codegen->getSetting('sdk_meta_publisher'); ?>" id="txt_sdk_meta_publisher"/>
							</div>
						</li>
						<li>
							<div data-role="fieldcontain">
								<label for="submit" class="btn_label">Press It</label>
								<input type="button" value="Save" class="green btn_settings_save"/>
							</div>
						</li>
					</ul>
				</div>
				<!--/cg_box_content--> 
			</div>
			<!--/cg_box--> 
		</div>
	</div>
</div>




