// Dependencies: jQuery.js or jquery.min.js should be loaded first.
//                      Also requires request.js, testsuite.js
/*jsl:option explicit*/

//(function () {

function CAROUSEL() {
	this.C = [];
	this.select = "";
	this.clicksSet = false;
	this.goal = "";
}

$C = new CAROUSEL();
$C.fn = CAROUSEL.prototype;

// init() establishes an array of objects that make up the carousel.
// The carousel array need not be identical to an object array 
// from structure.  
$C.fn.init = function() {
	makeProperty(this.C, "C", function(x) { return typeof x == "object"; });
	this.C.setC(new Array());
};

$C.fn.getThis = function() {
	return this;
};

// If there is a goal, setC reduces aray to only those elements that match the goal before establishing the carousel.
// Filtering occurs as the carousel is loaded.
$C.fn.setC = function( array ) {
	if ( this.goal.length > 0 ) {
		var matches = [];
		for ( var i=0; i<array.length; i+=1 ) {
			if ( array[i].goaloid === this.goal ) {
				matches.push(array[i]);
			}
		}
		this.C.setC(matches);
		return;
	}
	this.C.setC(array);
};

$C.fn.getC = function( array ) {
	return this.C.getC();
};

// setGoal loads the goal used to filter data into the carousel "this.goal" data element.
$C.fn.setGoal = function( goaloid ) {
	this.goal = goaloid;
};

// Returns a goaloid.
$C.fn.getGoal = function() {
	return this.goal;
};

// Send an object.  See if its goaloid matches the currentGoal.
$C.fn.setGoalFlag = function( obj ) {
	var goal = this.getGoal();
	if ( goal.length > 0 ) {
		if ( obj["goaloid"] === goal ) {
			// The matching condition -- Only true result.
			return true;
		}
		else {
			return false;
		}
	}
	else {
		return true;
	}
	return false;
};

// Looks at the object shown in the form passed and then finds the next carousel object for display.
$C.fn.next = function( formName ) {

	// Do an automatic save if using next to quickly change values.
	if ( this.getDirtyFlag() == "true" ) 
		this.save( formName );
	
	var current = $F.extract(formName);
	var carousel = this.getC();
	var newCurrent;
	for ( var i=0; i<carousel.length; i+=1 ) {
		// Find the showing object in the carousel.
		if ( current.object_ID == carousel[i].object_ID ) {
			if ( i == carousel.length - 1 ) {
				newCurrent = 0;
			}
			else {
				newCurrent = i + 1;
			}
			$F.present( formName, carousel[newCurrent] );
			break;
		}
	}	
};

// Looks at the object shown in the form passed and then finds the previous carousel object for display.
$C.fn.previous = function ( formName ) {
	
	// Do an automatic save if using previous to quickly change values.
	if ( this.getDirtyFlag() == "true" ) 
		this.save( formName );

	var current = $F.extract(formName);
	var carousel = this.getC();
	var newCurrent;
	for ( var i=0; i<carousel.length; i+=1 ) {
		// Find the showing object in the carousel.
		if ( current.object_ID === carousel[i].object_ID ) {
			if ( i === 0 ) {
				newCurrent = carousel.length - 1;
			}
			else {
				newCurrent = i - 1;
			}
			$F.present( formName, carousel[newCurrent] );
			break;
		}
	}	
	
};

// Handle the save option from the carousel menu.
$C.fn.save = function( formName, dataPreparationFunction ) {

	// If we do not have changed or new data, then leave save with no action.
	if( this.getDirtyFlag() == "false" ) {
		return;
	}
	
	var current = $F.extract(formName);
	if (dataPreparationFunction) {
		dataPreparationFunction(current);
	}

	$S.setVar( "$C.save", current);
	$S.setVar( "$C.formName", formName );
	
	if ( current.object_ID === "" ) {
		
		// We are doing a new object.
		$S.clearType("success");
		$.extend(current, { queryType : "insert", 
							pipe : "base",
						    tableName : formName, 
							authoroid : 'bitxx-bitxx-bitxx-bitxx',
							groupoid : $("#coachData").data("groupoid") } );
		if ( current.tableName == "sitefeedback" ) {
			current.pipe = "sitefeedback";
		}
		current = $S.encode(current);

		HTTP.post("../php/jumpPoint.php", 
				  current,
				  this.saveInsertFollowUp, this, false );
	}
	else {

		// We are updating an existing object
		$S.clearType("success");
		$.extend(current, $S.getBase(), 
				 { queryType : "update", 
				   object_ID : current.object_ID, 
				   tableName : formName, 
				   authoroid : $S.findAuthor() });
		current = $S.encode(current);

		HTTP.post("../php/jumpPoint.php", 
				  current,
				  this.saveUpdateFollowUp, this, false );
	}
	$C.setDirtyFlag("false");
};

//  Insert the returned dataobject in the appropriate table.
$C.fn.saveInsertFollowUp = function ( response ) {
	var success = $S.XMLtoStructure ( response );
	if ( success.result == "@true@" ) {
		var newObj = $S.getVar("$C.save");
		$.extend(newObj, { object_ID : success.object_ID } );
		$F.present( $S.getVar("$C.formName"), $S.decode(newObj));
		
		// The comments form is connected to a $S vector of "allcomments".  Done because the vector
		// contains the author's comments plus comments made by other users.
		if ( newObj.tableName == "comments" ) {
			$S.getType("allcomments").push(newObj);
		}
		else {
			$S.getType(newObj.tableName).push(newObj);
		}
		
		if ( typeof this.getThis().getC() == "object" )
		    $C.push(newObj);
		else {
			// Carousel C could be undefined.  If so, create it.  Handles first cases.
			this.getThis().setC([]);
			$C.push(newObj);			
		}
		$('img[src*=SaveData]').attr('src', '../images/SaveDataFlash.jpg');
		setTimeout(function(){ $('img[src*=SaveData]').attr('src', '../images/SaveData.jpg');}, 800);
		this.selectAdd(newObj);
	}
	else {
		alert("The attempted data save failed.");
	}
};

// Take an object out of the database.  Also must remove it from 
// the STRUCTURE and the CAROUSEL.	'delete' was a reserved word.
$C.fn.remove = function ( formName, object_ID ) {

	var removeObj = "";
	if ( typeof object_ID == "undefined" ) {
		removeObj = $F.extract(formName);
	}
	else {
		removeObj = $S.findInType("allcomments", object_ID);
	}
	
	var carousel = $C.getC();
	if ( carousel.length === 0 ) {
		$F.clearForm(formName);
		return false;
	}
	
	if ( confirm("Are you sure you want to delete this record?") ) {
		// continue delete;
		var continutedelete = true;   // documentation and lint removal only use.
	}
	else
		return false;
	
	$.extend(removeObj, $S.getBase(),
					  { queryType : "delete", 
					    object_ID : removeObj.object_ID, 
						tableName : formName } );
	$S.clearType("success");
	HTTP.post("../php/jumpPoint.php", 
			  removeObj,
			  this.removeFollowUp, this, false );
	
	// Check for successful completion.  If not successful (i.e., result == "@false@"), then do not remove from
	// carousel and structure.
	var result = $S.findInType("success", removeObj.object_ID).result;
	if ( result == "@false@" ) {
		return false;
	}
	
	
	this.next(formName);
	$S.remove(removeObj);
	this.removeFromCarousel(removeObj);
	if ( $C.getC().length === 0 ) {
		$F.clearForm(formName);
	}
	this.selectRemove(removeObj.object_ID);
	
	return true;
};


// Take an object from the carousel array.
$C.fn.removeFromCarousel = function ( dataObj ) {
	var caro = $C.getC();
	for( var i=0; i<caro.length; i+=1 ) {
		if ( caro[i].object_ID === dataObj.object_ID ) {
			caro.splice( i, 1);
		}
	}
	return dataObj;		
};

// Remove Followup changes the delete button border temprorarily.
$C.fn.removeFollowUp = function( response ) {
	var success = $S.XMLtoStructure ( response );
	if ( success.result == "@true@" ) {
		$('img[src*=DeleteData]').attr('src', '../images/DeleteDataFlash.jpg');
		setTimeout(function(){ $('img[src*=DeleteData]').attr('src', '../images/DeleteData.jpg');}, 800);
	}
	else {
		alert("The attempted data delete failed.");
	}	
};

// Update the returned dataobject in the appropriate queues.
$C.fn.saveUpdateFollowUp = function( response ) {
	var success = $S.XMLtoStructure( response );
	if ( success.result == "@true@" ) {
		var variables = $S.getType("variables");
		$S.replace($S.getVar("$C.save"));
		$('img[src*=SaveData]').attr('src', '../images/SaveDataFlash.jpg');
		setTimeout(function(){
			$('img[src*=SaveData]')
				.attr('src', '../images/SaveData.jpg');}, 800);
	}
	else {
		alert("The attempted data save failed.");
	}
};

// Prepare the form for making a new project.
$C.fn.create = function( formName ) {
	if ( this.getDirtyFlag() == "true" ) {
		if ( confirm("You have unsaved data.  Do you want to continue clearing the form?") ) {
			// continue;
			var continueClear = true;  // Documentation and lint removal are only use.
		}
		else
			return false;
	}

	$F.clearForm(formName);
	return continueClear;
};

// Leave the form you are presently viewing.  Leaves the carousel cleaned up.
$C.fn.exit = function( callBack ) {
	if ( this.getDirtyFlag() == "true" ) {
		var saveDirty = confirm("Do you want to save your data?");
		if ( saveDirty ) {
			this.save();
		}
		this.setDirtyFlag("false");
	}
	callBack();
	return;
};

// Hook up the dataControl (carousel) icons with appropriate events.
// Icons hooked up: prevArrow, SaveData, NewData, DeleteData, ExitData, nextArrow, SearchOff, KeyWord
// Parameters:
//  controlID => Name of the carousel control.
//  formName => Name of the form being controlled by the carousel.
//  bailout => How to shut down the form.
//  searchDisplay => After selecting from the keyword list, display the results with this function.  It's a callback.
$C.fn.makeEventHandlers = function( controlID, formName, bailout, searchDisplay ) {
	var $control = $('#' + controlID);
	var $this = this;
	// if ( this.clicksSet )
		// return;
	$($control)
		.find('img[src*=prevArrow]')
			.click( function(e) {
				$this.previous(formName);  		// Previous
			}).end()
		.find('img[src*=SaveData]')				
			.click( function(e) {
				$this.save(formName);			// Save
			}).end()
		.find('img[src*=NewData]')
			.click( function(e) {
				$this.create(formName);			// New data / create
			}).end()
		.find('img[src*=DeleteData]')
			.click( function(e) {
				$this.remove(formName);			// Remove / delete
			}).end()
		.find('img[src*=ExitData]')
			.click( function(e) {
				$this.exit(bailout);			// Exit form, bailout is a callback function
			}).end()
		.find('img[src*=nextArrow]')			// Next
			.click( function(e) {
				$this.next(formName);
			}).end()
		.find('img[src*=SearchOff]')			// Search set up
			.addClass('searchImage')
			.click( function(e) {
				$this.search(formName, controlID, searchDisplay);
			}).end()
		.find('img[src*=KeyWord]')				// Keyword search image
			.addClass('keywordImage')
			.click( function(e) {
				$this.keywordSearch(formName, controlID, searchDisplay);
			});
            
            $C.setUpDirtyFlags(formName);

	this.clicksSet = true;
	
};

//----------------------------------------------- SETUPDIRTYFLAGS
// Attach on change dirty flag events to visible elements marked "formdata".
$C.fn.setUpDirtyFlags = function (formName) {
	var elements = getElements("formdata", "*", formName);
	$(elements).each( function() {
		if ( !(this.type == "hidden") )
		    $(this).change( function(e) {
				$C.setDirtyFlag("true");
			});
	});	
};

// Set up the select control to work with navigation.
// selectName represents the id of the select control.  objArray contains the options content,
// and optionName is the object name corresponding to the data displayed in the dropdown.
// Most times name will be the object member used.
$C.fn.setSelect = function( selectName, objArray, formName, optionName ) {
	if ( objArray.length === 0 )
		$("#" + selectName + " option").remove();
	if ( typeof optionName === "undefined" )
		optionName = "name";
	
	// Load the options in the carousel dropdown.
	for ( var i=0; i<objArray.length; i+=1 ) {
		$('<option />')
			.attr('value', objArray[i].object_ID)
			.text(objArray[i][optionName])
			.appendTo("#"+selectName);
	}

	// Set the change event on the drop down.
	var $select = $("#"+selectName);
	var $this = this;
	$select.change( function() {
		var chosen_ID = $select.val();
		$.each($this.getC(), function() {
			if ( this['object_ID'] == chosen_ID ) {
				$F.present(formName, this);
				return false;
			}
			return true;
		});
	});
	$this.select = selectName;
};

// Remove the event handlers from one control prior to assigning them the another.
// INCOMPLETE
$C.fn.removeEvents = function ( controlName ) {
	$("#"+controlName+" img").unbind("click");
};

// Add a new option to the select control.
// Note: You can enter the optionName through $S.getVar.  It can, in other words, be preset.
$C.fn.selectAdd = function ( obj, optionName ) {
	
	var select = "#" + this.getSelect();
	var okFlag = true;
	
	if ( typeof optionName != "string" ) {
		optionName = $S.getVar("name");
		if ( !optionName )
			optionName = "name";
	}
	
	// Double check to be sure an option doesn't get entered twice.	
	$(select + " option")
		.each(function() {
			if ( $(this).attr('value') === obj.object_ID ) {
				okFlag = false;
			}
			return okFlag;
		});
		
	if ( okFlag ) {
		$('<option />')
			.attr('value', obj.object_ID)
			.text(obj[optionName])
			.appendTo(select);
	}
	
};

// Remove an option from the select control.
$C.fn.selectRemove = function ( object_ID ) {
	var select = "#" + this.getSelect();
	$(select).find('option').each(function() {
		if ( object_ID == $(this).val() ) {
			$(this).remove();
			return false;
		}
		return true;
	});
};

// Set up a search using the form
$C.fn.search = function( formName, controlID, searchDisplay ) {
	$('#keyword').hide();
	$('#cancelButton').css("display", "inline");
	$S.setVar("onScreenBeforeSearch", $F.extract(formName));
	$('#'+formName +' .search').css('color', 'red');
	$('#'+ controlID + ' .searchImage').get(0).src = "/images/SearchOn.jpg";
	$F.clearForm(formName);
	$('#'+ controlID + ' .searchImage').unbind('click').click( function(e) {
	    $C.fn.submitSearch(formName, controlID, searchDisplay);
	});
	$('#' + controlID + ' .cancel').show();
	$('#cancelButton').unbind('click').click( function(e) {
		$C.cleanUpSearchStart(formName, controlID, searchDisplay);
	});
};

// When the search is ready, process the post and get the data back.  Set up for the next search.
$C.fn.submitSearch = function ( formName, controlID, searchDisplay ) {
	$("#searchWait").show();
	var searchObj = $F.searchExtract(formName);
	searchObj = $S.getSearch(searchObj);
	$S.clearType(formName + "Search");
	post(searchObj);
	$('#'+formName +' .search').css('color', 'black');
	$('#'+ controlID + ' .searchImage').get(0).src = "/images/SearchOff.jpg";
	$('#'+ controlID + ' .searchImage').unbind('click').click( function(e) {
	    $C.fn.search(formName, controlID, searchDisplay);
	});
	searchDisplay();
	$("#searchWait").hide(); 
	$("#cancelButton").hide();
	$('#keyword').css("display", "inline");
};

// Use the keywords field to get a list of possible keywords for a particular table.
$C.fn.keywordSearch = function ( formName, controlID, searchDisplay ) {
	
	var i = 0;
	var j = 0;
	
	$("#searchWait").show();
	$S.clearType("keywords");
	var seekConsolidation = $F.extract(formName);
	var keywords = { tableName : formName, authoroid : $S.findAuthor(), 
					 consolidation : seekConsolidation.consolidation,
					 groupoid : $("#coachData").data("groupoid") };
	post( $S.getKeyWords(keywords) );
	var KeyWords = $S.getType("keywords");
	var wordCounts = new Array();
	for ( i=0; i<KeyWords.length; i+=1 ) {
		var words = KeyWords[i].keywords;
		var pieces = words.split(",");
		for ( var k=0; k<pieces.length; k+=1 ) {
			wordCounts.push(trim(pieces[k]));
		}
	}
	wordCounts.sort( function( word1, word2 ) {
		var first = word1.toLowerCase();
		var second = word2.toLowerCase();
		if ( first < second ) return -1;
		if ( second < first ) return 1;
		return 0;
	});
	
	var oldWord = { name : wordCounts[0], value : 1 };
	var condensed = new Array();
	for ( i=1; i<wordCounts.length; i+=1 ) {
		if ( wordCounts[i] != oldWord.name ) {
			condensed.push(oldWord);
			oldWord = { name : wordCounts[i], value : 1 };
		}
		else {
			oldWord.value += 1;
		}
	}
	
	$CC.emptyProjectDisplay();
	keywords = $S.getType("keywords");
	if ( keywords.length === 0 ) {
		alert("No keywords are available for display.");
		return;
	}
	$("<div>").html('<p class="headerLabel">' 
	       + "Keywords" + '</p>').appendTo("#projectDisplay");
		   
	var html = "<table border=\"2\" cellpadding=\"2\" cellspacing=\"0\">";
	html += "<tbody id=\"keywordTable\">";
	
	// Determine the length of the table
	var numberOfTableRows = parseInt(condensed.length / 4);
	if ( condensed.length % 4 !== 0 )
		numberOfTableRows += 1;
		

	for ( i=0; i<numberOfTableRows; i+=1) {
		html += "<tr>";
		for ( j=0; j<4; j+=1 ) {
			var ndx = i + j*numberOfTableRows;
			if ( ndx < condensed.length ) 
				html += "<td>" + condensed[ndx].name + " (" + condensed[ndx].value + ")</td>";
		}
		html += "</tr>";
	}
	html += "</tbody></table>";
	$("<div>").html(html).appendTo("#projectDisplay");
	$V.setDisplayHeight("#projectDisplay");
	
	$("#searchWait").hide();
	
	$("#keywordTable").click( function(e) {
		$("#searchWait").show();
		var keyword = $(e.target).text();
		keyword = keyword.substr(0, keyword.indexOf("(")-1);
		$("#keywordTable").unbind("click");
		$(document).scrollTop(0);
		var seekConsolidation = $F.extract(formName);
		var searchObj = { keywords : keyword, authoroid : $S.findAuthor(),
						  consolidation : seekConsolidation.consolidation,
						  groupoid : $("#coachData").data("groupoid"),
						  key : "true" };
		searchObj = $S.getSearch(searchObj);
		$S.clearType(formName + "Search");
		searchObj.tableName = formName;
		post(searchObj);
		searchDisplay();
		$('<p><strong>Keyword</strong> = <u>'+keyword+'</u></p>').appendTo("div div:first");
		$("#searchWait").hide();
	});
};

// Clean up the screen when search is not finished.
$C.fn.cleanUpSearchStart = function( formName, controlID, searchDisplay ) {
	$F.present(formName, $S.getVar("onScreenBeforeSearch"));
	$('#'+formName +' .search').css('color', 'black');
	$('#'+ controlID + ' .searchImage').get(0).src = "../images/SearchOff.jpg";
	$('#'+ controlID + ' .searchImage').unbind('click').click( function(e) {
	    $C.fn.search(formName, controlID, searchDisplay);
	});
	this.setDirtyFlag("false");
	$("#cancelButton").hide();
	$('#keyword').css("display", "inline");	
};

// Get the name of the select associated with the carousel control.
$C.fn.getSelect = function() {
	return this.getThis().select;
};

// Carousel works with the form that is showing on screen.  The datacontrol that is active
// is the one showing.  Different forms can have different datacontrols (apprearance wise).
// All of the datacontrols will have a dirtyFlag embedded.  Note: "true" and "false" are in text.
$C.fn.getDirtyFlag = function() {
	return $(".dirtyFlag").val();
};

// Establish the value of the dirty flag.  Reads as $C.setDirtyFlag("true");
$C.fn.setDirtyFlag = function( flag ) {
	$(".dirtyFlag").val(flag);
};

// Avoid adding an object to carousel twice.  If newObj not in carousel, add it.
$C.fn.push = function( newObj ) {
	var carousel = $C.getC();
	for ( var i=0; i<carousel.length; i+=1 ) {
		if ( carousel[i].object_ID == newObj.object_ID ) {
			return newObj;
		}
	}
	carousel.push(newObj);
	return carousel;
};

$C.init();

//})();
