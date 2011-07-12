<style type="text/css">
.container_12 .grid_9 .ui-content div div div .cg-inspector-request-trace {
	height: 150px;
	border: 1px solid #ccc;
	padding: 10px;
	background-color: #fefefe;
}
</style>

<div class="container_12">
	<div class="grid_3">
		<div class="ui-content">
			<div data-role="collapsible" data-collapsed="false">
				<h3>FILE</h3>
				<div id="cg_svc_filetree"> </div>
			</div>
		</div>
	</div>
	<div class="grid_9">
		<div class="ui-content">
			<div data-role="collapsible" data-collapsed="false">
				<h3>REQUEST</h3>
				<p>This is a sample class that is....</p>
				<form>
					<div data-role="fieldcontain">
						<label for="cg_inspector_methods" class="select">Methods:</label>
						<select name="cg_inspector_methods" id="cg_inspector_methods">
							<option value="option3">Method 3</option>
						</select>
					</div>
				</form>
			</div>
			<div data-role="collapsible" data-collapsed="true" data-theme="c">
				<h3>RESPONSE</h3>
				 
					<div data-role="collapsible" data-collapsed="false">
						<h3>History</h3>
						<table width="100%" cellpadding="5">
							<thead>
								<tr>
									<th>#</th>
									<th>Method</th>
									<th>Timestamp</th>
									<th>Request Size (kb)</th>
									<th>Result Size (kb)</th>
									<th>Request Time (sec)</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>1</td>
									<td>callClassFunction</td>
									<td>Mon Jul 11</td>
									<td>75</td>
									<td> 382</td>
									<td>00:01:47</td>
								</tr>
							</tbody>
							
						</table>
					</div>
					<div data-role="collapsible" data-collapsed="false">
						<h3>Result Set</h3>
						<p>Content</p>
					</div>
					<div data-role="collapsible" data-collapsed="false">
						<h3>Trace</h3>
						<div class="cg-inspector-request-trace">Content for  class "cg-inspector-request-trace" Goes Here</div>
						<p>&nbsp;</p>
					</div>
				 
			</div>
		</div>
	</div>
</div>
