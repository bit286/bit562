/* 
 *   Document   : doc_style.js
 *   Created on : Mar 3, 2012, 02:23:27 PM
 *   Author     : Michael Olmstead
 *   Description:
 *       Auto-document javascript.
 */

function performTest() {
	alert($(".codeLine").size());
}

// "document" means that it is talking to the DOM (document object model).
var $f = function (id) {
	return document.getElementById(id);
};

// It hides/unhides all command key JdocPlus values,
// i.e. elements with a class of ".commandKeyJdocPlus".
function toggleExpandAll() {
	// Method "getElements" has 3 arguments: classname, tagname, root
	var i,
		expandText,
		tdArray = getElements("expandCommandJdocPlus", "TD", document);
	for (i in tdArray) {
		expandText = (tdArray[i].textContent === "+") ? "–" : "+";
		tdArray[i].textContent = expandText;
	}
	jQuery(".commandKeyJdocPlus").slideToggle(125);
}

$f("expandButtonJdocPlus").onclick = toggleExpandAll;

// Toggle text size for the elements within the elements of the named classes.
$(".commandJdocPlus, .commandKeyJdocPlus")
	.click(function () {
		$(this).toggleClass("bigcode");
	});

$(".codeline, .comment, .selector, .rule")
	.click(function () {
		$(this).toggleClass("bigcode");
	});

$(".classDefinition")
	.click(function () {
		$(this).toggleClass("bigcode");
	});

$(".functionDefinition")
	.click(function () {
		$(this).toggleClass("bigcode");
	});

// The jQuery "ready' method runs the specfied function as soon as the DOM is ready.
jQuery(document).ready(function () {
	jQuery(".function.body").hide();
	//toggle the component with class msg_body
	jQuery(".expandFunction").click(function () {
		jQuery(this).nextAll(".function.body").slideToggle(125);
	});
	jQuery(".commandKeyJdocPlus").hide();
	// Toggle appearance of the object's parent's siblings with a class of ".commandKeyJdocPlus".
	jQuery(".expandCommandJdocPlus").click(function (e) {
		var expandText = (jQuery(this)[0].textContent === "+") ? "–" : "+";
		jQuery(this)[0].textContent = expandText;
		jQuery(this).parent().nextAll(".commandKeyJdocPlus").slideToggle(125);
		// Stop the bubbling of the click event upward from the target element to the document object.
		e.stopPropagation();
	});
});
