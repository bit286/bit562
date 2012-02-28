// From Resig, Secrets of the Javascript Ninja

// Place the following html in any page you would like to do testing on.
// <div id="resultsOfTests">
//	<h4 align="left">Assert Test Results</h4>
//	<ul id="resultsList"></ul>
//</div>
// Along with an appropriate CSS for resultsOfTests, the assert will display information in a box on screen
// usually placed to the far right of the screen.

// The assert could be changed to DataPipe to the test table in the database.  I could do onscreen asserts,
// test table inserts, both, or none with a few simple switches.  Good data collection for analytics.

// I should set up an automatic page for measuring how much code I've written, how many tests I've
// written and how many tests I've run.  These metrics would be a good way to track my programming progress.

// I can test database integrity by getting oids from the masterid table and then looking up each of the oids.

// Asserts can be turned on and off by changing assertOn.
var assertOn = true;
var blockAssert = true;

function assert( value, desc ) {
	if (assertOn) {
		document.getElementById("resultsOfTests").style.visibility = "visible";
		var li = document.createElement("li");
		li.className = value ? "pass" : "fail";
		blockAssert = value ? blockAssert : false;
		li.appendChild ( document.createTextNode( desc ));
		document.getElementById("resultsList").appendChild(li);
	}
	else {
		document.getElementById("resultsOfTests").style.visibility = "hidden";
		
	}	
}

// Returns true if the two objects match.  Match means the tested object has
// the properties of the test object and the same values.
// Used extensively in testing the DataPipe objects.
function objCompare(obj1, obj2 ) {
	for ( var name in obj1 ) {
		if ( name == "queryType" || name == "foreignKey" )
			continue;
		if ( name != "queryType" && (obj1[name] !== obj2[name]) ) {
			return false;
		}
	}

	return true;
}

// Methods used to set up a test queue.  Permits a large number of tests to be run as a suite.
// From Resig.  Secrets of the Javascriipt Ninja, chapter 2.
(function() {
	var queue = [], paused = false;
	
	// "this" refers to the global object context.  Creates test(testfunction); option in code.
	this.test = function(fn) {
		queue.push( fn );
		runTest();
	};
	
	// Allows for finish of tests in a function before moving to the next test function.
	this.pause = function() {
		paused = true;
	}
	
	this.resume = function() {
		paused = false;
		setTimeout(runTest, 1);
	};
	
	function runTest() {
		if ( !paused && queue.length ) {
			// The extra parenthesis executes the function coming off the queue.
			queue.shift()();
			if ( !paused ) {
				resume();
			}
		}
	}
})();   // Executes the function when it loads.  Creates the test, pause, resume global methods.
	
	


