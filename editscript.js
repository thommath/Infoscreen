function showOrHide(id){
	obj = document.getElementById(id);
	if(obj.className == "hidden"){
		obj.className = "shown";
	}else if(obj.className == "shown"){
		obj.className = "hidden";
	}
}
function insertAtCursor(myField, myValue) {
	myField = document.getElementById(myField);
	//IE support
	if (document.selection) {
		myField.focus();
		sel = document.selection.createRange();
		sel.text = myValue;
	}
	//MOZILLA and others
	else if (myField.selectionStart || myField.selectionStart == '0') {
		var startPos = myField.selectionStart;
		var endPos = myField.selectionEnd;
		myField.value = myField.value.substring(0, startPos) + "<" + myValue + ">"
			+ myField.value.substring(startPos, endPos) + "</" + myValue + ">"
			+ myField.value.substring(endPos, myField.value.length);
	} else {
		myField.value += myValue;
	}
}