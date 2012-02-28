// General purpose routines for use in coaching software.
// alert("This is utilities.");

// Create, using random number generation, an objectID that has twenty
// alpha characters.  Each five tuple is separated with a hyphen.
function getObjectID()
{
	var objectID = "";
	
	for ( var i=1; i<21; i++ )
	{
		objectID += String.fromCharCode(Math.floor(Math.random()*26) + 97);
		if ( i<20 && (i % 5) == 0 )
			objectID += "-";
	}
	
	return objectID;
	
}


// Remove apostrophe's from string data.  Put &pos; in for each apostrophe
function scrub(targetStr)
{
	var pieces = targetStr.split("'");
	return pieces.join("$pos;");
}



// Remove &pos; and put an apostrophe in it's place.
function deScrub(targetStr)
{
	var pieces = targetStr.split("$pos;");
	return pieces.join("'");
}
	
	
// Look at the named contents of an object.
function viewer(obj)
{
	var names = "";
	for ( var name in obj )
		names += name + " : " + obj[name]+"\n";
	alert(names);
}

// Duplicate an object
function cloneOf(obj) {
	var newObj = {};
	for ( var name in obj ) {
		newObj[name] = obj[name];
	}
	return newObj;
}


// From Flanagan, Javascript: The Definitive Guide.  Creates closures.  Will be used for current goal protection.
function makeProperty( obj, name, predicate ) {
	var value;   // this is the property value, current goal in this application.
	
	obj["get" + name] = function() {
		return value; 
	};
	
	obj["set" + name] = function(v) {
		if ( predicate && !predicate(v))
			throw "set" + name + ": invalid value " + v;
		else	
			value = v;
	};
		
}

// Remove blanks from either end of a string
function trim( str ) {
	var len = str.length;
	var begin = 0;
	var end = len;
	while ( str.charAt(begin) == " " )
		begin++;
	while ( str.charAt(end-1) == " " )
		end--;
	return str.slice(begin, end);
}






	
	
	