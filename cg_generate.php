
		
	
			 <a id="btn_load_databases" data-role="none" onClick="cg_loadDatabases();" href="#">cg_loadDatabases</a>
			<a id="btn_load_tables" data-role="none" onClick="cg_loadTables();" href="#">cg_loadTables</a>
			<a id="btn_load_tables" data-role="none" onClick="cg_generateConfig();" href="#">cg_generateConfig</a>

 
	<div class="ui-block">
	<div class="cg_box ui-content">
	<div class="cg_box_content">
	<form id="cg_step_1" action="none.html" method="get" class="cg_form">
	<ul id="cg_generator_database_form_list" data-role="listview" data-inset="true">
	<li data-role="list-divider">Step 1 - Database Information</li>
	<li>
	<fieldset data-role="fieldcontain">
	<label for="txt_host" class="btn_label">Host: </label>
	<input name="txt_host" type="text" id="txt_host" value="<?php echo $codegen->getSetting('host'); ?>"/>
	</fieldset>
	</li>
	<li>
	<fieldset data-role="fieldcontain">
	<label for="txt_user" class="btn_label">User: </label>
	<input name="txt_user" type="text" id="txt_user" value="<?php echo  $codegen->getSetting('user'); ?>"/>
	</fieldset>
	</li>
	<li>
	<fieldset data-role="fieldcontain">
	<label for="txt_pass" class="btn_label">Password: </label>
	<input name="txt_pass" type="password" id="txt_pass" value="<?php echo  $codegen->getSetting('pass'); ?>"/>
	</fieldset>
	</li>
	<li>
	<fieldset data-role="fieldcontainer">
	</fieldset>
	</li>
	</ul>
	</form>
	</div>
	</div>
	</div>
 

		<div class="cg_box ui-content">
			<div class="cg_box_content">
				<form id="cg_step_2" action="none.html" method="get" class="cg_form">
					<ul id="cg_generator_appinfo_form_list" data-role="listview" data-inset="true">
						<li data-role="list-divider">
							App Info
						</li>
						<li>
							<fieldset data-role="fieldcontain">
								<label for="txt_databases">
									Database:
								</label>
								<select name="database" id="txt_databases" data-placeholder="true" data-native-menu="true">
									<option>Choose a database</option>
								</select>
								<input name="txt_host" type="hidden" id="txt_host" value="<?php echo $codegen -> getSetting('host');?>"/>
								<input name="txt_user" type="hidden" id="txt_user" value="<?php echo $codegen -> getSetting('user');?>"/>
								<input name="txt_pass" type="hidden" id="txt_pass" value="<?php echo $codegen -> getSetting('pass');?>"/>
							</fieldset>
						</li>
						<li>
							<fieldset data-role="fieldcontain">
								<label for="txt_tables" class="select">
									Tables:
								</label>
								
								<select multiple name="tables" data-role="none" id="txt_tables" data-placeholder="true" data-native-menu="true" multiple="multiple">
									<option>Select Tables</option>
									 
								</select>
							</fieldset>
						</li>
						
						<li>
							<fieldset data-role="fieldcontain">
								<label for="txt_application">
									Name:
								</label>
								<input name="txt_application" type="text" id="txt_application" placeholder="<?php echo $codegen -> getSetting('app_name');?>"/>
							</fieldset>
						</li>
						<li>
							<fieldset data-role="fieldcontain">
								<label for="txt_namespace">
									Namespace:
								</label>
								<input name="txt_namespace" type="text" id="txt_namespace" placeholder="<?php echo $codegen -> getSetting('app_namespace');?>"/>
							</fieldset>
						</li>
						<li>
								<fieldset data-role="fieldcontain">
									<label for="txt_endpoint">
										Endpoint:
									</label>
									<input name="txt_endpoint" type="text" id="txt_endpoint" placeholder="<?php echo $codegen -> getSetting('app_endpoint');?>"/>
								</fieldset>
						</li>
						<li>
							<fieldset data-role="fieldcontain">
								<label for="txt_framework">
									Code Type:
								</label>
								<select name="txt_framework" id="txt_framework">
									<option value="Titanium">Titanium Framework</option>
									<option value="Backbone">Backbone.js Framework</option>
									<option value="jqm">Jquery Mobile Framework</option>
									<option value="Cairngorm">Flex/Cairngorm Framework</option>
									<option value="AS3">AS3/Flex</option>
								</select>
							</fieldset>
						</li>
						<li>
							<fieldset data-role="fieldcontain">
								<label for="txt_copywrite">
									Copywrite:
								</label>
								<textarea name="txt_copywrite" cols="50" rows="5" id="txt_copywrite">
									<?php echo $codegen -> getSetting('app_copywrite');?>
								</textarea>
							</fieldset>
						</li>
						
						<li>
							<fieldset data-role="fieldcontain">
								<a id="btn_generateApp" data-role="button" data-theme="c" href="#" onClick="cg_createApplication()">Create Application</a>
							</fieldset>
						</li>
					</ul>
				</form>
			</div>
		</div>
		<!--/cg_box-->

	<?php
	/**
	 */
	?>

		<!-- ############################ Step 3 ############################ -->
		<div class="cg_box ui-content" data-role=" ">
			<div class="cg_box_content" >
				<form id="cg_step_3" action="none.html" method="get" class="cg_form">
					<ul id="cg_generator_appreview_form_list" data-role="listview" data-inset="true">
						<li data-role="list-divider">
							Step 3 - Application Review
						</li>
						<li>
							<fieldset data-role="fieldcontain">
								<label for="txt_configLocation">
									Config Path:
								</label>
								<input name="txt_configLocation" type="text" id="txt_configLocation" value="" />
							</fieldset>
						</li>
						<li>
							<fieldset data-role="fieldcontain">
								<a href="#" data-role="button" data-theme="c" id="btn_generateSchema" onClick="cg_createSchema()">Create Schema File</a>
							</fieldset>
						</li>
						<li>
							<fieldset data-role="fieldcontain">
								<label for="txt_schemaLocation" >
									Schema Path:
								</label>
								<input name="txt_schemaLocation" type="text" id="txt_schemaLocation" value="" />
							</fieldset>
						</li>
						<li>
							<fieldset data-role="fieldcontain">
								<a href="#" data-role="button" data-theme="c" id="btn_generateApp" onClick="cg_saveApplication()">Save Application</a>
							</fieldset>
						</li>
					</ul>
				</form>
			</div>
	
</div>
