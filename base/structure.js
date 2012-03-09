// Dependencies: jQuery.js or jquery.min.js must be loaded before structure.js

/*+LINK::href=structureImage.html::text=Show an image for STRUCTURE*/
/*global makeProperty, $, getText, document, alert, $S:true*/
/*jsl:option explicit*/
( function () {

function STRUCTURE() {
	this.S = [];
}

$S = new STRUCTURE();
$S.fn = STRUCTURE.prototype;

// init() sets up a closure for holding the data structure.  The structure is an array
// of arrays.  The main array is associative with each element being identified by
// the name of an object type, e.g., structure("goals").  Each element of the main array
// is another array filled with objects of the identified type, e.g., goals, questions, etc.
$S.fn.init = function() {
	makeProperty(this.S, "S", function(x) { return typeof x === "object"; });
	this.S.setS([]);
};

$S.fn.getThis = function() {
	return this;
};

$S.fn.setS = function( array ) {
	this.S.setS(array);
};

$S.fn.getS = function( array ) {
	return this.S.getS();
};

// Instantiate a new structure.
$S.fn.maker = function( array ) {
	var structure = new STRUCTURE();
	structure.init();
	structure.setS(array);
	return structure;
};

// ____________________________________________________________
// COMMANDS TO QUERY THE DATABASE.  PROGRAMMER MUST 
// DETERMINE PIPE OBJECT TO BE USED.

//  Set up a many data request.  Default is the projects file for Ed.
//  Foreignkey is the name of the field to be used in the many search.
//  ForeignValue is the data value to search for. 
$S.fn.getMany = function( options ) {
	var command =  {
		"pipe" : "many",
		"tableName" : "projects",
		"queryType" : "select",
		"foreignKey" : "authoroid"
	};
	return $.extend(command, options || {});
};

// Given a tableName, a foreignKey, and a foreignValue make an option object for the many query and return it.
$S.fn.manyMaker = function( tableName, foreignKey, foreignValue ) {
	var options = {};
	options.tableName = tableName;
	options.foreignKey = foreignKey;
	options.foreignValue = foreignValue;
	return options;
};

// Create an option object when switching between authoroid and groupoid.
$S.fn.ownerOptions = function(tableName) {
	var groupoid = $("#coachData").data("groupoid");
	var options = [];
	if ( groupoid.length < 23 ) {
		options = $S.manyMaker(tableName, "authoroid", $S.findAuthor());
		options.security = 10;
	}
	else {
		options = $S.manyMaker(tableName, "groupoid", groupoid);
		options.security = $("#coachData").data("security");
	}
	
	var vieweroid = $S.getVar("viewer");
	if ( vieweroid && vieweroid === 'aaaaa-bbbbb-ccccc-vvvvv' ) {
		options.security = 8;
	}
	
	return options;	
};

// Second owner options.
$S.fn.ownerOptionsTwo = function() {
	var option = $("#coachData").data("security");
	if ( typeof option === "undefined" ) {
		option = 10;
	}
	return option;
};

// Select a single object or do 'insert', 'update', or 'delete' on a single object. 
// CRUD is performed one record at a time.  CRUD = create, read, update, delete. 
// getBASE() finds Ed's author record as a default.
$S.fn.getBase = function( options ) {
	var command = {
		"queryType" : "select",
		"pipe" : "base",
		"tableName" : "authors"
	};
	command.object_ID = $S.findAuthor();
	return $.extend(command, options || {} );
};

// Essay pipe selection.  Gets many objects for a particular author_ID and essay_ID.
// Author_ID will be changed to an oid before development is finished.
$S.fn.getEssay = function( options ) {
	var command = {
		"queryType" : "select",
		"pipe" : "essay",
		"tableName" : "questions",
		"author_ID" : 1,
		"essay_ID"  : 1
	};
	return $.extend(command, options || {} );
};

// Get the next steps pipe.  The object_ID here is an authoroid.  Given several
// sequences of actions, the next step for each sequence is the first action in
// in the sequence.  getNextSteps looks for the first steps of all sequences
// created by a particular author.
$S.fn.getNextSteps = function( options ) {
	var command = {
		"queryType" : "select",
		"tableName" : "sequenceoids",
		"pipe" : "nextsteps"
	};
	command.object_ID = $S.findAuthor();
	return $.extend(command, options || {} );	
};

// Work with the sequenceoids pipe.  Have to feed in a sequenceoid as the object_ID.
// A sequence consists of the object_IDs of all the actions in the sequence.
$S.fn.getSequenceoids = function( options ) {
	var command = {
		"queryType" : "select",
		"tableName" : "sequenceoids",
		"foreignKey" : "sequenceoid", 
		"pipe" : "sequenceoid"
	};
	command.object_ID = $S.findAuthor();
	return $.extend(command, options || {} );	
};

// Set up a search.  Search fields are added via the options object passed in.
$S.fn.getSearch = function( options ) {
	var command = {
		"queryType" : "search",
		"tableName" : "quotes",
		"pipe" : "search",
		"security" : $S.ownerOptionsTwo()
	};
	return $.extend(command, options || {} );
};

// Set up a keyword search. 
$S.fn.getKeyWords = function( options ) {
	var command = {
		"queryType" : "keyword",
		"tableName" : "quotes",
		"pipe" : "keywords",
		"security" : $S.ownerOptionsTwo()
	};
	return $.extend(command, options || {} );
};

// Set up a comments search.  You must add { "target_ID" : targetobject_ID } to the command for it to function.
$S.fn.getComments = function( options ) {
	var command = {
		"queryType" : "select",
		"tableName" : "allcomments",
		"pipe" : "comments"
	};
	return $.extend(command, options || {} );
};

// _____________________________________________________________

// Put a new element in the structure.  
$S.fn.add = function(dataObj) {

	var structure = this.getS();
	
	// Check to see if an object of this type has been added already.
	if ( !structure[dataObj.tableName] ) {
	   structure[dataObj.tableName] = [];
	}
	
	if ( this.has(dataObj) ) {
		return this.replace(dataObj);
	}
		
	var objArray = this.getType(dataObj.tableName);
	objArray[objArray.length] = dataObj;
	return objArray[objArray.length-1];
};

// Get the structure array for a dataType where dataType generally matches DB tables.
$S.fn.getType = function ( dataType ) {
	if ( typeof this.getS()[dataType] === "undefined" ) {
		this.getS()[dataType] = [];
	}
	return this.getS()[dataType];
};

// Return true if the object_ID of the dataObj is in the structure.
$S.fn.has = function(dataObj) {
	var structure = this.getType(dataObj.tableName);
	var i = 0;
	return $.grep( structure, function( o, i ) {
		return dataObj.object_ID === o.object_ID;
	}).length > 0;	
};

// If a match is located for the dataObj object_ID, replace the existing object.
$S.fn.replace = function(dataObj) {
	var structure = this.getType(dataObj.tableName);
	var i = 0;
	for( i; i<structure.length; i+=1 ) {
		if ( structure[i].object_ID === dataObj.object_ID ) {
			structure.splice( i, 1, dataObj );
		}
	}
	return dataObj;		
};

// Gives us the total length of the structure, where length is the number offscreenBuffering
// of data objects in the structure as a whole.
$S.fn.length = function() {	
	var structure = this.getS();
	var total = 0;
	var name = "";
	for ( name in structure ) {
		if ( structure.hasOwnProperty(name) ) {
			total += this.getType(name).length;
		}
	}
	return total;
};

// Find an object_ID given its type.
$S.fn.findInType = function( dataType, object_ID) {
	var structure = this.getType(dataType);
	var i = 0;
	return $.grep( structure, function( o, i ) {
		return object_ID === o.object_ID;
	})[0];
};

// If a match is located for the dataObj object_ID, remove the object from the structure.
$S.fn.remove = function(dataObj) {
	var structure = this.getType(dataObj.tableName);
	var i = 0;
	for( i; i<structure.length; i+=1 ) {
		if ( structure[i].object_ID === dataObj.object_ID ) {
			structure.splice( i, 1);
		}
	}
	return dataObj;		
};

// General purpose routine for removing an object with an object_ID from an array of objects.
// The objectID can be passed as a object ID (oid) string or as an object which has the 
// object_ID as a property.  Note that the objectID, either string or object, is passed
// back as a return value.
$S.fn.removeObject = function( dataArray, objectID ) {
	var targetID = "";
	var i = 0;
	if ( typeof objectID === "string" ) {
		targetID = objectID;
	}
	else {
		targetID = objectID.object_ID;
	}
	for ( i; i<dataArray.length; i+=1 ) {
		if ( dataArray[i].object_ID === targetID ) {
			dataArray.splice(i, 1);
		}
	}
	return objectID;	
};

// Find the many side with foreign keys matching the passed object_ID.  
// ForeignKey is the name of the field being searched.  Object_ID is the
// value searched for.  Object_ID does not literally have to be an oid.
// You can search for any value and any object field.
// Passing a dataType reduces the search space.
$S.fn.many = function ( foreignKey, object_ID, dataType ) {
	var many = [];
	var all = [];
	var name = "";
	var structure = [];
	var i = 0;
	
	if ( typeof dataType === "undefined" ) {
	
		// Look across the entire structure.
		structure = this.getS();
		for ( name in structure ) {
			if ( structure.hasOwnProperty(name) ) {
				many = $.grep( this.getType(name), function(o, i) {
						return o[foreignKey] === object_ID;
				});
			}
			all = all.concat(many);
		}
		return all;
	}
	else {
	
		// Look through a particular dataType for matches.
		structure = this.getType( dataType );
		many = $.grep( structure, function(o, i) {
			return o[foreignKey] === object_ID;
		});
		return many;
	}
};

// Find will look in the entire structure for an object_ID.
$S.fn.find = function( object_ID ) {
	var structure = this.getS();
	var obj = {};
	var name = "";
	obj.object_ID = object_ID;
	for ( name in structure ) {
		if ( structure.hasOwnProperty(name) ) {
			obj.tableName = name;
			if ( this.has(obj) ) {
				return this.findInType(name, object_ID);
			}
		}
	}
	return null;
};


// Store a name/value pair in the structure.  Can put in an unlimited number of pairs.  
// Value can be any object.  The variables are stored in a single object.
$S.fn.setVar = function( name, value ) {
    var varObj = this.findInType("variables", "varObject");
	if ( !varObj ) {
		var variables = { tableName : "variables",
	                  object_ID : "varObject"
					};
		this.add(variables);
		varObj = this.findInType("variables", "varObject");
	}
	var newObj = {};
	newObj[name] = value;
	$.extend(varObj, newObj );
	return value;
};

// Retrieve the value of a named / value pair.
$S.fn.getVar = function( name ) {
	var varObj = this.findInType("variables", "varObject");
	return typeof varObj === "undefined" ? null : varObj[name];
};

// Retrieve the author object._ID
$S.fn.findAuthor = function() {
	if ( $("#coachData").data("currentForm") === "authors" ) {
		return "";
	}
		
	var viewer = $S.getVar("viewer");
	if ( typeof viewer === "string" && viewer.length === 23 ) {
		return viewer;
	}
	else {
		var authors = this.getType("authors");
		if ( authors.length === 0 ) {
			return "";
		}	
		else {
			return authors[0].object_ID;
		}
	}
};

// Empty one of the type arrays.
$S.fn.clearType = function( dataType ) {
	var structure = this.getS();
	structure[dataType] = [];
};

// Put XML into the data structure as objects.  The php datapipes
// are set to produce table data in a standard format.  It's the
// same format mysql uses when exporting data in XML format.
// For example:
// &lt;row tableName="goals"&gt;
//     &lt;field name="object_ID"&gt;aaaaa-bbbbb-ccccc-vvvvv&lt;/field&gt;
//     &lt;field name="name"&gt;Exercise&lt;/field&gt;
//            . . .
// &lt;/row&gt;
// All data is represented with row and field tags.  The specific names
// are conveyed as attributes.
/*+LINK::href=carousel.html::text=Show the documentation for CAROUSEL*/
$S.fn.XMLtoStructure = function ( XML ) {
	
	var rows = XML.getElementsByTagName("row");
	var i = 0;
	var j = 0;
	var newObj = {};
	
	for ( i; i<rows.length; i+=1 ) {
		newObj = {};
		newObj.tableName = rows[i].getAttribute("tableName");
		var fields = rows[i].getElementsByTagName("field");
		for ( j=0; j<fields.length; j+=1 ) {
			var name = fields[j].getAttribute("name");
			var value = getText(fields[j]);
			newObj[name] = value;
		}
		newObj = this.decode(newObj);
		this.add(newObj);
	}
		
	return newObj;
	
};

// Method for looking at the contents of $S.
$S.fn.view = function () {
	var structure = this.getS();
	var viewStr = "";
	var name = "";
	for ( name in structure ) {
		if ( structure.hasOwnProperty(name) ) {
			viewStr += name + ": length = " + this.getType(name).length + "\n";
		}
	}
	alert(viewStr);
};

// Encode for XML markers, %lt; and %gt;
$S.fn.encode = function( target ) {
	var name = "";
	if ( typeof target === "string" ) {
		var lessThan = target.split("<");
		var spliced = lessThan.join("%lt;");
		var greaterThan = spliced.split(">");
		spliced = greaterThan.join("%gt;");
		var ampersand = spliced.split("&");
		return ampersand.join("%amp;");	
	}
	else {
		if ( typeof target === "object" ) {
			for ( name in target ) {
				if ( target.hasOwnProperty(name) ) {
					target[name] = this.encode(target[name]);
				}
			}			
		}
		return target;
	}
};

// Decode for XML markers, %lt; and %gt; and %amp;
$S.fn.decode = function( target ) {
	var name = "";
	if ( typeof target === "string" ) {
		var lessThan = target.split("%lt;");
		var spliced = lessThan.join("<");
		var greaterThan = spliced.split("%gt;");
		spliced = greaterThan.join(">");
		var ampersand = spliced.split("%amp;");
		return ampersand.join("&");
	}
	else {
		if ( typeof target === "object" ) {
			for ( name in target ) {
				if ( target.hasOwnProperty(name) ) {
					target[name] = this.decode(target[name]);
				}
			}			
		}
		return target;
	}
};

$S.init();	

})();

