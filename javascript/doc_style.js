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
         
    $(".codeline, .comment, .selector, .rule")
      .click(function() { 
         $(this).toggleClass("bigcode"); 
      });
         
    $(".classDefinition")
      .click(function() { 
         $(this).toggleClass("bigcode"); 
      });
         
    $(".functionDefinition")
      .click(function() { 
         $(this).toggleClass("bigcode"); 
      });
          
    jQuery(document).ready(function() {
        jQuery(".function.body").hide();
        //toggle the component with class msg_body
        jQuery(".expandFunction").click(function() {
            jQuery(this).nextAll(".function.body").slideToggle(125);
        });
    });

