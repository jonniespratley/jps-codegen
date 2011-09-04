<div class="ui-grid-a">
	<div class="ui-block-a">
		<div class="ui-content">
			<div class="ui-block">
				<h3>Database</h3>
				<fieldset data-role="fieldcontain">
					<label for="txt_database">
						Database:
					</label>
					<select name="txt_database" id="txt_database" data-placeholder="true">
						<option>Choose a database</option>
					</select>
					<input name="txt_host" type="hidden" id="txt_host" value="<?php echo $codegen -> getSetting('host');?>"/>
					<input name="txt_user" type="hidden" id="txt_user" value="<?php echo $codegen -> getSetting('user');?>"/>
					<input name="txt_pass" type="hidden" id="txt_pass" value="<?php echo $codegen -> getSetting('pass');?>"/>
				</fieldset>
				<fieldset data-role="fieldcontain">
					<label for="cg_generator_step_2_table_name_fields_txt" class="select">
						TABLE_NAME:
					</label>
					<select multiple name="cg_generator_step_2_table_name_fields_txt" id="cg_generator_step_2_table_name_fields_txt" data-placeholder="true" data-native-menu="false">
						<option>Select fields</option>
						<option value="FIELD">FIELD</option>
						<option value="FIELD">FIELD 2</option>
						<option value="FIELD">FIELD 3</option>
					</select>
				</fieldset>
			</div>
			<div id="cg_generator_step_1_div">
				<h3>Client-Side</h3>
				<fieldset data-role="fieldcontain">
					<label for="c2_generator_form_uitype_txt">
						UI:
					</label>
					<select name="c2_generator_form_uitype_txt" id="c2_generator_form_uitype_txt">
						<option value="html">HTML/HTML5 UI</option>
						<option value="jqm">jQuery Mobile UI</option>
						<option value="wp">WordPress Plugin UI</option>
					</select>
				</fieldset>
				<fieldset data-role="fieldcontain">
					<label for="c2_generator_form_uiframework_txt">
						Framework:
					</label>
					<select name="c2_generator_form_uiframework_txt" id="c2_generator_form_uiframework_txt">
						<option value="none">None - html/php</option>
						<option value="backbone">Backbone.js - js/php</option>
						<option value="other">Other</option>
					</select>
				</fieldset>
			</div>
			<div id="cg_generator_step_2_div">
				<h3>Client-to-Server</h3>
				<fieldset data-role="fieldcontain">
					<label for="c2_generator_form_rpcconnector_txt">
						RPC:
					</label>
					<select name="c2_generator_form_rpcconnector_txt" id="c2_generator_form_rpcconnector_txt">
						<option value="restjson">REST JSON Service - php/backbone.js</option>
						<option value="restapi">REST API Service - php/backbone.js</option>
						<option value="custom">Custom Service - html/php</option>
					</select>
				</fieldset>
				<fieldset data-role="fieldcontain">
					<label for="txt_endpoint">
						Endpoint:
					</label>
					<input name="txt_endpoint" type="text" id="txt_endpoint" placeholder="<?php echo $codegen -> getSetting('app_endpoint');?>"/>
				</fieldset>
			</div>
			<div id="cg_generator_step_3_div">
				<h3>Server-Side</h3>
				<p>
					Step 1 - Database Info - The credentials for the data access layer, such as host, port, user, pass, database, etc.
				</p>
				<ul>
					<li>
						1. SQLite - path, database,
					</li>
					<li>
						2. MySQL - host, port, user, pass, database
					</li>
					<li>
						3. CouchDB - host, port, user, pass, database
					</li>
					<li>
						4. JSON File - just the path to where to save the file is needed
						<br>
					</li>
				</ul>
				<p>
					Step 2 - Language
				</p>
				<ul>
					<li>
						PHP
					</li>
					<li>
						Ruby on Rails
					</li>
					<li>
						Node.js
					</li>
					<li>
						Other
					</li>
				</ul>
			</div>
		</div>
	</div>
	<!--/ui-block-a-->
	<div class="ui-block-b">
		<div class="ui-content">
			 <a id="btn_load_databases" data-role="none" onClick="cg_loadDatabases();" href="#">cg_loadDatabases</a>
			<a id="btn_load_tables" data-role="none" onClick="cg_loadTables();" href="#">cg_loadTables</a>
			<a id="btn_load_tables" data-role="none" onClick="cg_generateConfig();" href="#">cg_generateConfig</a>
		</div>
	</div>
	<!--/ui-block-b-->
</div>
<!--/ui-grid-a-->
<div class="ui-grid-a">
	<!--
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
	-->
	<div class="ui-block">
		<div class="cg_box ui-content">
			<div class="cg_box_content">
				<form id="cg_step_2" action="none.html" method="get" class="cg_form">
					<ul id="cg_generator_appinfo_form_list" data-role="listview" data-inset="true">
						<li data-role="list-divider">
							Step 2 - Application Information
						</li>
						<li>
							<fieldset data-role="fieldcontain">
								<label for="txt_database">
									Database:
								</label>
								<select name="txt_database" id="txt_database" data-placeholder="true">
									<option>Choose a database</option>
								</select>
								<input name="txt_host" type="hidden" id="txt_host" value="<?php echo $codegen -> getSetting('host');?>"/>
								<input name="txt_user" type="hidden" id="txt_user" value="<?php echo $codegen -> getSetting('user');?>"/>
								<input name="txt_pass" type="hidden" id="txt_pass" value="<?php echo $codegen -> getSetting('pass');?>"/>
								<a id="btn_load_databases" data-role="none" onClick="cg_loadDatabases();" href="#">Load Databases</a>
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
						</li>
						<li>
							<fieldset data-role="fieldcontain">
								<label for="txt_framework">
									Code Type:
								</label>
								<select name="txt_framework" id="txt_framework">
									<option value="Cairngorm">Cairngorm Framework</option>
									<option value="AS3">HTTP Service</option>
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
	</div>
	<?php
	/**
	 */
	?>
	<div class="ui-block">
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
	</div>
</div>
