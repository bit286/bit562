// Contains an object with methods for manipulating DOM elements.

var DOM = {

EL : function ( elementType ) {
	return document.createElement(elementType);
},

// Return a table cell with width set if width was passed.
TD : function (width) {
	var td = this.EL("td");
	if ( typeof width == "number" ) {
		td.setAttribute("width", width);
	}
	return td;
},

// Takes each name in the arguments array and turns it into an element stored as an object property
ELs : function ( ) {
	var obj = {};
	for ( var i=0; i<arguments.length; i+=1) {
		obj[arguments[i]] = this.EL(arguments[i]);
	}
	return obj;
},

// Place text in a text node.  Surround with emphasis if present.
TXT : function ( text, emphasis ) {
	var txt = document.createTextNode(text);
	if ( typeof emphasis == "string") {
		var el = this.EL(emphasis);
		this.AC(el, txt);
		return el;
	}
	return txt;
},

// Support an append child operation.  Appending goes from right to left.  At least two arguments are required.
AC : function () {
	if ( arguments.length < 2 )
		return;
	for ( var i=arguments.length-1; i>0; i-=1 ) {
		arguments[i-1].appendChild(arguments[i]);
	}
}

};