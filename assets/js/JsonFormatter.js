// we need tabs as spaces and not CSS magin-left 
// in order to ratain format when coping and pasing the code
window.TAB = "  ";

function IsArray(obj){
	return obj &&
	typeof obj === 'object' &&
	typeof obj.length === 'number' &&
	!(obj.propertyIsEnumerable('length'));
}

function Process(input, output){
	var json = document.getElementById(input).value;
	var html = "";
	try {
		if (json == "") json = "\"\"";
		var obj = eval("[" + json + "]");
		html = ProcessObject(obj[0], 0, false, false, false);
		document.getElementById(output).innerHTML = "<pre class='cg_json_code'>" + html + "</pre>";
	} catch (e) {
		alert("JSON is not well formated:\n" + e.message);
		document.getElementById(output).innerHTML = "";
	}
}

function ProcessObject(obj, indent, addComma, isArray, isPropertyContent){
	var html = "";
	var comma = (addComma) ? "<span class='comma'>,</span> " : "";
	var type = typeof obj;
	
	if (IsArray(obj)) {
		if (obj.length == 0) {
			html += GetRow(indent, "<span class='arrayBrace'>[ ]</span>" + comma, isPropertyContent);
		} else {
			html += GetRow(indent, "<span class='arrayBrace'>[</span>", isPropertyContent);
			for (var i = 0; i < obj.length; i++) {
				html += ProcessObject(obj[i], indent + 1, i < (obj.length - 1), true, false);
			}
			html += GetRow(indent, "<span class='arrayBrace'>]</span>" + comma);
		}
	} else if (type == 'object' && obj == null) {
		html += FormatLiteral("null", "", comma, indent, isArray, "Null");
	} else if (type == 'object') {
		var numProps = 0;
		for (var prop in obj) 
			numProps++;
		if (numProps == 0) {
			html += GetRow(indent, "<span class='objectBrace'>{ }</span>" + comma, isPropertyContent);
		} else {
			html += GetRow(indent, "<span class='objectBrace'>{</span>", isPropertyContent);
			var j = 0;
			for (var prop in obj) {
				html += GetRow(indent + 1, "<span class='propertyName'>" + prop + "</span>: " + ProcessObject(obj[prop], indent + 1, ++j < numProps, false, true));
			}
			html += GetRow(indent, "<span class='objectBrace'>}</span>" + comma);
		}
	} else if (type == 'number') {
		html += FormatLiteral(obj, "", comma, indent, isArray, "number");
	} else if (type == 'boolean') {
		html += FormatLiteral(obj, "", comma, indent, isArray, "boolean");
	} else if (type == 'function') {
		obj = FormatFunction(indent, obj);
		html += FormatLiteral(obj, "", comma, indent, isArray, "function");
	} else if (type == 'undefined') {
		html += FormatLiteral("undefined", "", comma, indent, isArray, "null");
	} else {
		html += FormatLiteral(obj, "\"", comma, indent, isArray, "string");
	}
	return html;
}

function FormatLiteral(literal, quote, comma, indent, isArray, style){
	if (typeof literal == 'string') literal = literal.split("<").join("&lt;").split(">").join("&gt;");
	var str = "<span class='" + style + "'>" + quote + literal + quote + comma + "</span>";
	if (isArray) str = GetRow(indent, str);
	return str;
}

function FormatFunction(indent, obj){
	var tabs = "";
	for (var i = 0; i < indent; i++) 
		tabs += window.TAB;
	var funcStrArray = obj.toString().split("\n");
	var str = "";
	for (var i = 0; i < funcStrArray.length; i++) {
		str += ((i == 0) ? "" : tabs) + funcStrArray[i] + "\n";
	}
	return str;
}

function GetRow(indent, data, isPropertyContent){
	var tabs = "";
	for (var i = 0; i < indent && !isPropertyContent; i++) 
		tabs += window.TAB;
	if (data != null && data.length > 0 && data.charAt(data.length - 1) != "\n") data = data + "\n";
	return tabs + data;
}
