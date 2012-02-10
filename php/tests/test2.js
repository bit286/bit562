//Comment case 1 is this line

var commentCase2 = new Object(); //here is the test comment

//comment case 3 multi line comment format 1
/*
some text
more text 
last text
*/

//comment case 4 multi line comment format 2
/* some text
 * more text
 * last text */
 
//comment case 5 multi line -  various things within format 1
/*
some comment text
function something() { 
}
another /* MLComment beginner here
*/


//Function Case 1: the word function in the comment

//Function Case 2
function test1() {
    var funcCase2 = new Object();
}

//Function Case 4: var = func()
var funcCase2 = function() {
    var extraVar = new Object();
}

//comment beginner inside string for scheme://
var = "http://www.google.com";

//multi-line block
function test2() {
		var variable1 = 1;
		var variable2 = 2;
		var variable3 = variable1 + variable2;
		var funcCase3 = function() {
				var extraVar = new Object();
		}

		alert(variable3);
}

//Function declared with beginning bracket on next line
function anothertest() 
{
var something = 1;
var anotherthing = 2;
}
