// Dependencies: 
// jQuery.js or jquery.min.js must be loaded first.
// Uses structure.js and carousel.js.
// Uses getElements from utilities.js

/*+LINK::href=structure.html::text=Show the documentation for STRUCTURE*/
/*jsl:option explicit*/

( function () {

function FORMHANDLER() {
	this.F = "projects";
}

$F = new FORMHANDLER();
$F.fn = FORMHANDLER.prototype;

// "makeProperty creates a closure for this.F.  Presumably, it is encapsulated.
$F.fn.init = function() {
	makeProperty(this.F, "Form", function(x) { return typeof x == "string"; });
};

// Returns the "this" pointer for $F context.
$F.fn.getThis = function() {
	return this;
};

// Stores the form name.
$F.fn.setF = function( formName ) {
	this.F.setForm(formName);
};

// Finds the form name.
$F.fn.getF = function( ) {
	return this.F.getForm();
};

// Fill a form F with the passed object.  present() assumes that the form
// is constructed with all input elements and hidden inputs identified with
// a two element, e.g., class="formdata goal".   The first element is the keyword
// "formdata". The second element names the field.  The field names match the 
// object's name value pairs which MAY match the database table's column names.
// There may be a map in the database which translates form names to data table names.

// A key role for fn.present is establishing with $S.setVar a value for "currentObject".
$F.fn.present = function(formName, dataObj) {

	// If dataObj is undefined, display the first object in the carousel.
	if ( typeof dataObj === "undefined" ) {
		var carouselArray = $C.getC();
		if ( carouselArray.length > 0 ) {
			dataObj = carouselArray[0];
		}
		else {
			$F.clearForm(formName);
			return;
		}
	}
	
    var formElements = getElements("formdata", "*", formName);
	$(formElements).each(function(i){
		for ( name in dataObj ) {	    
			if ( $(this).hasClass(name) ) {
				$(this).val(dataObj[name]);
				if( $(this).val() == "true" ) {
					this.checked = true;
				}
				else {
					this.checked = false;
				}
			}
			
			// Place hidden oid values in the structure variables area.
			if ( name.indexOf("oid") > 0 ) {
				$S.setVar(name, dataObj[name]);
			}
		}
	});
    
    // Store the object_ID for the form's visible data.
	if ( formName != "comments" ) {
		$S.setVar("currentObject", dataObj["object_ID"]);
 	}
	
	// Alert the user to the presence of a comment.
    this.commentPresent(dataObj);
	
	// Set the goal for this piece of data.
	if ( typeof dataObj.goaloid != "undefined" && dataObj.goaloid.length === 23 ) {
		$S.setVar("goaloid", dataObj.goaloid);
	}
	
	// Determine if the form should be edited or should be disabled.
	var viewer = $S.getVar("viewer");
	if ( typeof viewer == "string" && viewer.length == 23 ) {
		if ( formName != "comments" ) {
			$F.disable(formName);
		}
	}
	else {
		$F.enable(formName);
	}
	
};

// Find the data values for a form.  Return them as an object.
// formName => the ID of the form whose data is to be returned.
// return => an object with name/value pairs where the values are form
// field contents.  The names come from the class where class names are 
// of the form class="formdata fieldName", e.g., "formdata description".
$F.fn.extract = function( formName ) {
	
	var dataObj = {},
		formElements = getElements("formdata", "*", formName);
	
	$(formElements).each(function(i){
								  
		// Pick the radio button that is checked.  Skip if not checked.						  
		if ( $(this).attr('type').indexOf("radio") > -1 ) {
			if ( this.checked ) {
				dataObj[$F.getClassName($(this))] = $(this).val();
			}
		} else {
			
			// Handle all non-radio button cases.
			dataObj[$F.getClassName($(this))] = $(this).val();
		}
		
		// Adjust if the element is a check box.
		if ($(this).attr('type').indexOf("check") > -1) {
		    if ( this.checked ) {
				dataObj[$F.getClassName($(this))] = "true";
			}
			else {
				dataObj[$F.getClassName($(this))] = "false";
			}
		}
	});
	return dataObj;
};

// Find the search fields on a form and extract their contents
$F.fn.searchExtract = function( formName ) {
	var searchObj = {};
	var dataObj = $F.extract(formName);
	var searchElements = getElements("search", "*", formName);
	$(searchElements).each(function(i) {
		var second = $F.getClassName($(this));
		var ignoreValue = (second == "quotevalue" && dataObj[second] == "none");
		if ( dataObj[second].length > 0 && !ignoreValue )
			searchObj[second] = dataObj[second];
	});
	searchObj['authoroid'] = dataObj['authoroid'];
	searchObj['groupoid'] = dataObj['groupoid'];
	searchObj['tableName'] = formName;
	$C.setDirtyFlag("false");
	return searchObj;
};

// Get the first classname after "formdata".  
// Note: el is assumed to be wrapped as a jQuery object.
$F.fn.getClassName = function ( el ) {
	if ( name = el.attr("className") ) 			
		return name.split(" ")[1];
};

// Empty form F
$F.fn.clearForm = function( formName ) {
	var formElements = getElements("formdata", "*", formName);
	var second = "";
	
	$(formElements).each(function(i){
		if( $(this).val() == "true" || $(this).val() == "false" )
			this.checked = false;
		else
			$(this).val("");
		if (this.checked) {
			this.checked = false;
		}
		
		// See if second classname has oid in it and get a value from the $S variables list.
		second = $F.getClassName($(this));
		if ( second.indexOf("oid") > 0 && second != "factoid" ) {
			if ( second == "goaloid" ) {
				$F.setGoaloid(formName);
			}
			else {
				$(this).val($S.getVar(second));
			}
		}
	});
	
	// Used as a flag to prevent comments from being attached to an empty form.
	if ( formName !== "comments") {
		$("#commentStore").css("color", "white" );
		$("#commentStoreForm").css("color", "white" );		
		$S.setVar("currentObject", null);
	}
};

// Hide a form or any other object with an ID.
$F.fn.hide = function( objName ) {
	$("#" + objName).hide();
};

// Show a form or any other object with an ID.
$F.fn.show = function( objName ) {
	$("#" + objName).show();
};

// Goaloid management is essential as everything ties to the current goal.
// fn.setGoaloid transfers the current goal, referred to as "goaloid", to
// the empty form.  This insures that new information being added will have
// the currentGoal as its goaloid.
$F.fn.setGoaloid = function ( formName ) {
	var goaloid = $("#coachData").data("currentGoal");
	var goalInput = getElements("goaloid", "*", formName);
	goalInput[0].value = goaloid;
};

// Bring in a new HTML form and put it in the right display.
$F.fn.loadNewForm = function ( htmlName ) {
	$("#rightDisplay").hide(0);
	HTTP.post(htmlName, { "blank" : "blank" }, $F.handleHTML, $S, false);
};

$F.fn.handleHTML = function(response) {
	$("#rightDisplay").empty();	
	$("#rightDisplay").html(response);
	$("#rightDisplay").show(0);
	$V.setFormDisplayHeight("#rightDisplay");	
};

// Turn all disabled form elements back on.
$F.fn.enable = function(formName) {
	var $elements =  $("#" + formName + " input:[type!=hidden], #" + formName + " textarea")
						.add("#" + formName + " select");
	$elements.css("background-color", "white")
			 .attr("enabled", "true")
	         .bind("change", function(e) {
				  $C.setDirtyFlag('true');
				})
			 .unbind("keypress")
			 .bind("keypress", function() {
			 });
	if ( formName == "members" ) {
		$GC.disable();
	}
};

// Turn all enabled form elements off.
$F.fn.disable = function(formName) {
	var $elements =  $("#" + formName + " input:[type!=hidden], #" + formName + " textarea")
						.add("#" + formName + " select");
	$elements.css("background-color", "#E5B793")
			 .attr("enabled", "false")
	         .bind("keypress", function(e) {
				  e.preventDefault();
				})
			 .unbind("change");
};

// Bring in a new display and show it.	
$F.fn.loadNewDisplay = function( htmlName ) {
	HTTP.post(htmlName, { "blank" : "blank" }, $F.displayHTML, $S, false);
};

$F.fn.displayHTML = function( response ) {
	$("#projectDisplay").empty();
	$("#projectDisplay").html(response);
};

// Filter a dataType by category and goal.
$F.fn.categorySelector = function(control, carouselSelect, formName, name ) {

	// Find the category.
	var $control = $(control);
	var categorySelected = $control.val();
	var objs = $S.getType(formName);
	var len = objs.length;
	var i = 0;
	if (!name) {
		name = "name";
	}
	$("#"+carouselSelect).empty();
	switch ( categorySelected ) {
	
		case "No Category Selected":
			for ( i=0; i<len; i+=1 ) {
			    if ( $C.setGoalFlag(objs[i]) ) {
					$("<option value=\"" + objs[i].object_ID + "\">" + objs[i][name] + "</option>").appendTo("#"+carouselSelect);
				}
			}
			$C.setC(objs);
			break;
			
		default:
			var shortList = [];
			for ( i=0; i<len; i+=1 ) {
				if ( categorySelected == objs[i].category ) {
					if ( $C.setGoalFlag(objs[i]) ) {
						$("<option value=\"" + objs[i].object_ID + "\">" + objs[i][name] + "</option>").appendTo("#"+carouselSelect);
						shortList.push(objs[i]);
					}
				}
			}
			$C.setC(shortList);
			break;
	
	}
	$F.present(formName);
	
};

// Fill the category selector control with category names.
$F.fn.fillCategorySelector = function( formName, carouselSelect, categoryName ) {
	var categories = [];
	var dataObjs = $S.getType(formName);
	var len = dataObjs.length;
	if ( typeof categoryName === "undefined" ) {
		categoryName = "category";
	}
	for ( var i=0; i<len; i+=1 ) {
		if (dataObjs[i][categoryName] !== "undefined") {
			categories.push(dataObjs[i][categoryName]);
		}
	}
	categories.sort();
	var currentCategory = "";
	var $select = $("#"+carouselSelect);
	for ( i=0; i<len; i+=1 ) {
		if ( currentCategory != categories[i] ) {
			$("<option value=\"" + categories[i] + "\">" + categories[i] + "</option>").appendTo($select);
			currentCategory = categories[i];
		}
	}
		
};

// Color the "comments/Questions" red if a comment is present.
$F.fn.commentPresent = function(dataObj) {
	if ( typeof dataObj.commentPresent == "string" ) {
		if ( dataObj.commentPresent == "false" ) {
			$("#commentStore").css("color", "white" );
			$("#commentStoreForm").css("color", "white" );
		}
		else {
			$("#commentStore").css("color", "red" );
			$("#commentStoreForm").css("color", "red" );
		}
	}    
};

$F.init();	

})();
