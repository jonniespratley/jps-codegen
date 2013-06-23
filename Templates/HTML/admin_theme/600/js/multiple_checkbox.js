// Basic javascript
function checkAll(master){
	var checked = master.checked;
	var col = document.getElementsByTagName("INPUT");
	for (var i=0;i<col.length;i++) {
		col[i].checked= checked;
	}
}