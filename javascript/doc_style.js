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

$(".codeline").click(function() {
    $(this).toggleClass("bigcode");
});

$(".classDefinition").click(function() {
    $(this).toggleClass("bigcode");
});

$(".functionDefinition").click(function() {
    $(this).toggleClass("bigcode");
});

$(".selector").click(function() {
    $(this).toggleClass("bigcode");
});

$(".rule").click(function() {
    $(this).toggleClass("bigcode");
});

$(".cssatributes").click(function() {
    $(this).toggleClass("bigcode");
});

$(".cssindividual").click(function() {
    $(this).toggleClass("bigcode");
});

jQuery(document).ready(function() {
    jQuery(".collapse").hide();
    //toggle the component with class msg_body
    jQuery(".expandFunction").click(function() {
        jQuery(this).nextAll(".collapse").slideToggle(125);
    });
});

