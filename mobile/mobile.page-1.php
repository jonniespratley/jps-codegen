<div data-role="page" id="cg_page_1">
	<div id="cg_header" data-id="cg_header" data-role="header"> <a href="#cg_page_7" data-rel="dialog">Help</a>
		<h1> Generator</h1>
		<a href="#cg_page_6" data-rel="dialog">Settings</a>
		<div id="cg_header_navbar" data-role="navbar">
			<ul>
				<li><a href="#cg_page_0" >Dashboard</a></li>
				<li><a href="#cg_page_1" class="ui-btn-active">Generator</a></li>
				<li><a href="#cg_page_2">Templates</a></li>
				<li><a href="#cg_page_3">Manager</a></li>
				<li><a href="#cg_page_4">Utilities</a></li>
			</ul>
		</div>
	</div>
	<div data-role="content">
		<div class="container_12">
			<div class="grid_12">
				<div class="ui-content">
					<form id="cg_generator_app_form">
						<ul data-role="listview" data-inset="true">
							<li data-role="list-divider">Gen Settings</li>
							<li>
								<div data-role="fieldcontain">
									<label for="selectmenu3" class="select">Code:</label>
									<select name="selectmenu2" id="selectmenu3">
										<option value="option1">Option 1</option>
										<option value="option2">Option 2</option>
										<option value="option3">Option 3</option>
									</select>
								</div>
							</li>
							<li>
								<div data-role="fieldcontain">
									<label for="selectmenu4" class="select">Framework:</label>
									<select name="selectmenu3" id="selectmenu4">
										<option value="option1">Option 1</option>
										<option value="option2">Option 2</option>
										<option value="option3">Option 3</option>
									</select>
								</div>
							</li>
							<li>
								<div data-role="fieldcontain">
									<label for="selectmenu5" class="select">Templates:</label>
									<select name="selectmenu4" id="selectmenu5">
										<option value="option1">Option 1</option>
										<option value="option2">Option 2</option>
										<option value="option3">Option 3</option>
									</select>
								</div>
							</li>
							<li data-role="list-divider">App Settings</li>
							<li>
								<fieldset data-role="fieldcontain">
									<label for="selectmenu" class="select">Database:</label>
									<select name="selectmenu" id="selectmenu">
										<option value="option1">Option 1</option>
										<option value="option2">Option 2</option>
										<option value="option3">Option 3</option>
									</select>
								</fieldset>
							</li>
							<li>
								<div data-role="fieldcontain">
									<label for="textinput">Name:</label>
									<input type="text" name="textinput" id="textinput" value=""  />
								</div>
							</li>
							<li>
								<div data-role="fieldcontain">
									<label for="textinput2">Namespace:</label>
									<input type="text" name="textinput2" id="textinput2" value=""  />
								</div>
							</li>
							<li>
								<div data-role="fieldcontain">
									<label for="textinput3">Gateway:</label>
									<input type="text" name="textinput3" id="textinput3" value=""  />
								</div>
							</li>
							<li>
								<div data-role="fieldcontain">
									<label for="textarea">Copywrites:</label>
									<textarea cols="40" rows="8" name="textarea" id="textarea"></textarea>
								</div>
							</li>
						</ul>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div data-role="footer" data-position="fixed">
		<div data-role="navbar" data-position="inline">
			<a href="#">Submit</a>
			<a href="#">Reset</a>
		</div>
	</div>
</div>
